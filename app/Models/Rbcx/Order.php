<?php

namespace App\Models\Rbcx;

use App\Traits\Model\LogInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rbcx\FreezeLog;
use App\Services\HttpClient;
use DB;

class Order extends Model implements LogInterface
{

    protected $connection = 'mysql_rbcx';
    public $timestamps = false;
    /**
     * 限制读取字段
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 设置模型表名
     *
     * @var string
     */
    protected $table = "order";

    function expiredInstallmentById($id)
    {
        //整张表被锁住
        return $this->installment()
            ->where('id', $id)
            ->where('order_id', $this->id)
            ->where('opertiontime', '<=', date('Y-m-d H:i:s'))
            ->where('status','=', 0)
            ->lockForUpdate()
            ->get();
    }

    function expiredInstallments()
    {
        //整张表被锁住
        return $this->installment()
            //->lockForUpdate()
            ->where('order_id', $this->id)
            ->where('opertiontime', '<=', date('Y-m-d H:i:s'))
            ->where('status','=', 0)
            ->lockForUpdate()
            ->get();
       /* return DB::connection('mysql_rbcx')->table('installment')
            ->where('order_id', $this->id)
            ->where('opertiontime', '<=', date('Y-m-d H:i:s'))->where('status','!=', 2)
            ->lockForUpdate()->get();*/
    }

    function markError($errorCode)
    {
        $this->error = $errorCode;
        return $this->save();
    }

    public function isInstallmentTest()
    {
        return config('Rbcx.installmentTest');
    }

    public function isTest()
    {
        return config('Rbcx.test');
    }

    public function getPreFreezeUrl()
    {
        return config('Rbcx.pay.createFreeze');
    }

    public function getChargeUrl()
    {
        return config('carInsurance.pay.charge');
    }

    public function getCancelUrl()
    {
        return config('carInsurance.pay.cancelFreeze');
    }

    public function getProjectNo()
    {
        return config('Rbcx.projectNo', '');
    }

    public function errorCount()
    {
        $this->error ++;
        $this->save();
        $firstInstallment = $this->getFirstInstallment();
        $firstInstallment->error_count++;
        $firstInstallment->save();
    }

    public function getLogger()
    {
        return new FreezeLog();
    }

    public function getFreeze()
    {
        $freeze = Freeze::where('order_id', $this->id)->first();
        //$freeze = Freeze::find($this->id);
        if(!$freeze) {
            $freeze = new Freeze();
            $freeze->order_id = $this->id;
            $freeze->save();
            return $freeze;
        }
        return $freeze;
        //return new Freeze();
    }

    public function role()
    {
        return Role::find($this->role_id);
    }

    public function cardInfo()
    {
        return $this->hasOne('App\Models\Rbcx\CardInfo');
    }
    public function installments()
    {
        return $this->hasMany('App\Models\Rbcx\Installment');
    }

    public function installment()
    {
        //return Order::lockForUpdate()->where('order_id', $this->id);
        return $this->hasMany('App\Models\Rbcx\Installment');
    }

    public function freeze()
    {
        return $this->hasMany('App\Models\Rbcx\Freeze');
    }

    public function freezeLogs()
    {
        return $this->freezeLog()->orderBy('id');
    }

    public function freezeLog()
    {
        return $this->hasMany('App\Models\Rbcx\FreezeLog');
    }

    public function makeFirstPayDone()
    {
        $this->first_charge = 1;
        $this->save();
    }

    /**
     * 根据模板发送指定模板的消息格式
     * @param string $templateId
     */
    public function sendTemplateMsg($templateId='')
    {
        try{
            $data = ['is_delay'=>0, 'opertion_time'=>time()];
            $data['templateId'] = $templateId=='' ? 'f6YWvN1M_dQcUHGE6AA794dva1nNrDqg-al6-qphWAI': $templateId;
            $data['openId'] = $this->role()->wx_openid;
            $firstInstallment = $this->getFirstInstallment();
            $data['data'] = json_encode(['first'=>'您的人保车险保单已完成初次扣款', 'name'=>'人保车险分期', 'price'=> $firstInstallment->money / 100 . "元"]);
            $client = new HttpClient(config('Rbcx.message.template'));
            $ret = $client->config($data)->doRequest();
            if(!$ret['ret_msg'] == 'ok')
                throw new \Exception($ret['ret_msg']);
        }catch(\Exception $e) {
            throw $e;
        }
    }

    public function getFirstInstallment()
    {
        $is = $this->installment()->orderBy('opertiontime', 'asc')->take(1)->get();
        return $is[0];
    }

    public function sendMobileMsg()
    {
        try {
            $date = strtotime('Y-m-d H:i:s', time());
            $order = $this;
            $firstInstallment = $this->getFirstInstallment();
            $amount = $this->amount -1;
            $total = $firstInstallment->money / 100;
            $money = $amount * $firstInstallment->money / 100;
            $data = [
                'mobiles' => $this->cardInfo->phone_number,
                'content' => "尊敬的车险分期客户，{$date}已经完成对浙{$order->license_plate}车辆保险分期的第1期扣费操作，本次扣款金额{$total}元，剩余{$amount}期，共计{$money}金额已被预授权冻结。下次扣款将在28个自然日后自动完成。如有疑问，请拨打0571-28881000咨询。 ",
                'opertion_time' => date('Y-m-d H:i:s')
            ];
            $client = new HttpClient(config('Rbcx.message.mobile'));
            $ret = $client->config($data)->doRequest();
            if($ret['code']!=200)
                throw new \Exception("消息发送失败");
        }catch(\Exception $e) {
            throw $e;
        }
    }

    /**
     * 通过卡号来获取使用次数,不得多于2次
     * @param $card
     * @return mixed
     */
    private function carInsuranceCardSevenMonthsLimit($card)
    {
        //$card = $this->cardInfo->card;

        $count = DB::connection('mysql_car_insurance')
            ->select('select count(*) as `count` from orders where id in 
                      (select order_id from card_info where card="'.$card. '")
                      and `status` >= 5
                      and created_at >= (select date_sub(current_timestamp(), interval 7 month))
                     ');
        $carInsuranceCount = $count[0]->count;
        return $carInsuranceCount;
    }

    /**
     * 使用次数不得多于 1 次
     * @param $card string
     * @return int
     */
    public function sevenMonthsLimit($card)
    {
        $carInsuranceCount = $this->carInsuranceCardSevenMonthsLimit($card);

        //$card = $this->cardInfo->card;
        $rbcxCount = DB::connection('mysql_rbcx')
            ->select('select count(*) as `count` from `order` where id in 
                      (select order_id from card_info where card='.$card. ')
                      and `status` >=2 
                      and `datetime` >= (select date_sub(current_timestamp(), interval 7 month))
                     ');;

        $total = $carInsuranceCount + $rbcxCount[0]->count;
        return $total;
    }

    public static function chargedValidOrder()
    {
        return Order::where('first_charge', 1)
            ->where('error', 0)
            ->where('enable', 1)
            ->where('is_delete', 0)
            ->where('status', ">=", 2) //由2变更>=2
           // ->lockForUpdate()
            ->get();
    }
}

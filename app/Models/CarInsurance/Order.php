<?php

namespace App\Models\CarInsurance;

use App\Services\ImageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Model\LogInterface;
use App\Models\CarInsurance\PaymentLog;
use DB;

class Order extends Model implements LogInterface
{
    use SoftDeletes;
    //
    protected $connection = 'mysql_car_insurance';

    // protected $table = "orders";
    /**
     * [$guarded description]
     *
     * @var array
     */
    protected $guarded = [];

    /**
     *  应被转换为日期的属性。
     *
     * @var array
     */
    protected $dates = ['policy_start_date', 'policy_end_date', 'car_register_date', 'car_certificate_date', 'car_Inspection_record', 'created_at', 'updated_at', 'deleted_at'];

    public function expiredInstallmentById($id)
    {
        return $this->installment()
            ->where('id', $id)
            ->where('order_id', $this->id)
            ->where('opertiontime', '<=', date('Y-m-d H:i:s'))
            ->where('status',0)
            ->lockForUpdate()
            ->get();
        // TODO: Implement expiredInstallmentById() method.
    }

    public function expiredInstallments()
    {
        //整张表被锁住
        return $this->installment()
            ->where('order_id', $this->id)
            ->where('opertiontime', '<=', date('Y-m-d H:i:s'))
            ->where('status',0)
            ->lockForUpdate()
            ->get();
    }

    /**
     * 什么都不做就好
     * @param $errorCode
     */
    public function markError($errorCode)
    {
        $this->error = $errorCode;
        return $this->save();
    }

    public function isTest()
    {
        return config('carInsurance.test');
    }

    public function isInstallmentTest()
    {
        return config('carInsurance.installmentTest');
    }

    public function getPreFreezeUrl()
    {
        return config('carInsurance.pay.createFreeze');
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
        return config('carInsurance.projectNo');
    }

    public function getFreeze()
    {
        $freeze = Freeze::where('order_id', $this->id)->first();
        if(!$freeze) {
            $freeze = new Freeze();
            $freeze->order_id = $this->id;
            $freeze->save();
            return $freeze;
        }
        return $freeze;
    }

    public function getLogger()
    {
        return new PaymentLog();
    }

    /**
     * 当 Eloquent 尝试获取 status 的值时，将会自动调用此访问器
     * @param $value
     * @return string
     */
    /*public function getStatusAttribute($value)
    {

        $status = config('carInsurance.status');
        if (isset($status[$value])) {
            return $status[$value];
        } else {
            return '未知';
        }

    }*/

    public function getPolicyTypeAttribute($value)
    {
        $status = config('carInsurance.policyType');
        if (isset($status[$value])) {
            return $status[$value];
        } else {
            return '未知';
        }

    }

    public function getDrivingLicenseFileAttribute($value)
    {

        if(empty($value)){
            return '/static/car-insurance/not-upload.jpg';
        }
        return config('carInsurance.store.domain'). $value;

    }


    public function getIdentityCardFileAttribute($value)
    {
        if(empty($value)){
            return '/static/car-insurance/not-upload.jpg';
        }
        return config('carInsurance.store.domain'). $value;
    }

    public function getBusinessMoneyImageAttribute($value)
    {
        if(empty($value)){
            return '/static/car-insurance/not-upload.jpg';
        }
        return config('carInsurance.store.domain'). $value;
    }

    public function getForceMoneyImageAttribute($value)
    {
        if(empty($value)){
            return '/static/car-insurance/not-upload.jpg';
        }
        return config('carInsurance.store.domain'). $value;
    }

    public function getOtherImageAttribute($value)
    {
        if(empty($value)){
            return '/static/car-insurance/not-upload.jpg';
        }
        return config('carInsurance.store.domain'). $value;
    }

    public function cardInfo()
    {
        return $this->hasOne('App\Models\CarInsurance\CardInfo');
    }

    public function installment()
    {
        return $this->hasMany('App\Models\CarInsurance\Installment');
    }

    public function policy()
    {
        return $this->hasOne('App\Models\CarInsurance\Policy');
    }

    public function paymentLog()
    {
        return $this->hasMany('App\Models\CarInsurance\PaymentLog');
    }

    public function freeze()
    {
        return $this->hasMany('App\Models\CarInsurance\Freeze');
    }


    /**
     * 删除订单相关的分期，卡信息
     * @param $order Order
     */
    public static function deleteRelations(Order $order)
    {
        if($order->installment != null) {
            foreach($order->installment as $installment) {
                $installment->delete();
            }
        }
        if($order->cardInfo != null) {
            foreach($order->cardInfo as $card) {
                $card->delete();
            }
        }
    }

    public function errorCount()
    {
        //什么都不用干，暂时!
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
                      (select order_id from card_info where card="'.$card. '")
                      and `status` >=2 
                      and `datetime` >= (select date_sub(current_timestamp(), interval 7 month))
                     ');;

        return $carInsuranceCount + $rbcxCount[0]->count;
    }

    public static function chargedValidOrder()
    {
        return Order::where('is_first_charge', 1)
            ->where('is_complete', 1)
            ->where('is_delete', 0)
            ->where('status', 5)
           // ->lockForUpdate()
            ->get();
    }
}

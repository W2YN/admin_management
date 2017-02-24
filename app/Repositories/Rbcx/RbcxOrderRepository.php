<?php

namespace App\Repositories\Rbcx;

use App\Facades\HelpFacades;

use App\Models\Rbcx\Order;
use App\Repositories\CommonRepository;

use App\Services\HttpClient;
use Illuminate\Http\Request;

class RbcxOrderRepository extends CommonRepository
{
    public static $accessor = 'order_repository';

    /**
     *
     * @return RbcxOrderRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor(self::$accessor);
    }

    /**
     * storePicture保存图片
     */
    public function storePicture(Request $request)
    {
        $file = $request->file('file');
        $type = $request->get('type_id');
        $data = Order::find($request->get('id'));

        $dataid = $data->id;
        if ($file->isValid()) {
            $clientName = $file->getClientOriginalName();
            $tmpName = $file->getFileName();
            $realPath = $file->getRealPath();
            $entension = $file->getClientOriginalExtension();
            $mimeTye = $file->getMimeType();
            $newName = md5(date('ymdhis') . $clientName.$type). "." . $entension;
            $movepath = $file->move('storage/rbcx/' . date('Y-m-d') . '/' . $dataid . '/', $newName);
            $path = $movepath;

        }
        $img_src = asset($path);
        if ($type == 0) {
            $old_path = strstr($data->firstpicture, 'storage');
            !file_exists($old_path)? :unlink($old_path);
            $data->firstpicture = $img_src;
        }
        if ($type == 1) {
            $old_path = strstr($data->secondpicture, 'storage');
            !file_exists($old_path)? :unlink($old_path);
            $data->secondpicture = $img_src;
        }
        if ($type == 2) {
            $old_path = strstr($data->thirdpicture, 'storage');
            !file_exists($old_path)? :unlink($old_path);
            $data->thirdpicture = $img_src;
        }
        if ($data->update()) {
            return $img_src;
        } else {
            return false;
        }
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
            $data['openId'] = $this->model->owner_wxopenid;
            $firstInstallment = $this->getFirstInstallment();
            $data['data'] = ['first'=>'您的人保车险保单已完成初次扣款', 'name'=>'人保车险分期', 'price'=> $firstInstallment->money];
            $client = new HttpClient(config('Rbcx.message.template'));
            $client->config($data)->doRequest();
        }catch(\Exception $e) {
            throw $e;
        }
    }

    public function getFirstInstallment()
    {
        $is = $this->model->installment()->orderBy('opertiontime', 'asc')->take(1)->get();
        return $is[0];
    }

    public function sendMobileMsg()
    {
        try {
            $date = strtotime('Y-m-d H:i:s', time());
            $order = $this->model;
            $firstInstallment = $this->getFirstInstallment();
            $amount = $this->model->amount -1;
            $total = $firstInstallment->money;
            $money = $amount * $firstInstallment->money;
            $data = [
                'mobiles' => '18357136394',//$this->model->cardInfo->phone_number,
                'content' => "尊敬的车险分期客户，{$date}已经完成对浙{$order->license_plate}车辆保险分期的第1期扣费操作，本次扣款金额{$total}元，剩余{$amount}期，共计{$money}金额已被预授权冻结。下次扣款将在28个自然日后自动完成。如有疑问，请拨打0571-28881000咨询。 ",
                'opertion_time' => date('Y-m-d H:i:s')
            ];
            $client = new HttpClient(config('Rbcx.message.mobile'));
            $client->config($data)->doRequest();
        }catch(\Exception $e) {
            throw $e;
        }
    }

    public function paginateWhereWithOrder($where, $limit, $columns = ['*'])
    {
        $old = $this->model;
        $this->model = $this->model->orderBy('datetime', 'desc');
        $data = $this->paginateWhere($where, $limit, $columns);
        $this->model = $old;
        return $data;
    }
}

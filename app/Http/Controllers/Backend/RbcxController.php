<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/10
 * Time: 15:38
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;


use App\Models\Rbcx\CardInfo;
use App\Models\Rbcx\Installment;
use App\Models\Rbcx\Order;
use App\Repositories\FreezeLogRepository;
use App\Repositories\MenuRepository;
use App\Repositories\Rbcx\RbcxCardInfoRepository;
use App\Repositories\Rbcx\RbcxOrderRepository;
use App\Services\PayService;
use App\Services\UploadService;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Services\HttpClient;
use App\Services\ImageService;



class RbcxController extends Controller
{
    public function __construct()
    {
        $this->middleware('search', ['only' => ['chargeLog', 'index', 'paymentCheck', 'payConfirm']]);

    }


    public function chargeLog(Request $request)
    {
        $where = $request->get('where');
        if (!$where) {
            $where = [];
        }
        $where[] = array('type', '=', 3);
        $where[] = array('retCode', '=', '0000');

        $data = FreezeLogRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));
        //var_dump($data);exit;
//
//        foreach( $data as $item ){
//            $order = $item->order;
//            if($order){
//                $item->license_plate = $order->license_plate;
//                $item->car_owner = $order->car_owner;
//            }
//        }
        return view('backend.rbcx.chargeLog', compact('data'));
    }

    public function index(Request $request)
    {

        $where = $request->get('where');

        if (is_array($where)) {
            array_push($where, ['is_delete', '=', 0]);
        } else {
            $where[] = ['is_delete', '=', 0];
        }
        $data = RbcxOrderRepository::getInstance()->paginateWhereWithOrder($where, config('repository.page-limit'));


//        $topMenus = MenuRepository::getAllTopMenus();

        return view('backend.rbcx.index', compact('data'));
    }

    public function show($id)
    {
        $arr = [];
        $arr['data'] = RbcxOrderRepository::getInstance()->find($id);

        $arr['cardinfo'] = $arr['data']->cardInfo;

        $arr['installments'] = $arr['data']->installments;

        if($arr['data']->freeze->isEmpty())
            $arr['freeze'] = false;
        else
            $arr['freeze'] = $arr['data']->freeze[0];
        //exit($arr['freeze']['order_id']);

        $arr['freezeLog'] = $arr['data']->freezeLogs;
        //$data = RbcxOrderRepository::getInstance()->find($id);
        //exit($id);
        //$cardinfo = $data->cardInfo()->first();
        //$installments = $data->installments()->get();
       // $check = $data->first_charge==1?false:true;
       // $done = $data->status==2? true:false;
        //if($data->status>=1 && $data->first_charge==1){ //冻结表及日志信息获取

        //}

        return view('backend.rbcx.show', $arr);
    }


    public function getImgWithSignature($id, $signature_id)
    {

        header('Content-type:image/png');
        echo RbcxCardInfoRepository::getInstance()->getSignature($id, $signature_id);
        exit;
    }

    public function picture(Request $request)
    {
        $save_path = RbcxOrderRepository::getInstance()->storePicture($request);
        $type_id = $request->get('type_id');
        if ($save_path) {
            return $this->responseJson([
                'success' => true,
                'avatar' => $save_path,
                'type_id' => $type_id,
            ]);
        } else {
            return $this->responseJson([
                'success' => false,
            ]);
        }


    }


    public function export()
    {
        RbcxCardInfoRepository::getInstance()->exportExcell(true);
    }
    /**
     * 只用到了type=2的类型
     * @param Request $request
     * @return mixed
     */
    public function pureSignatureImg(Request $request)
    {
        $cardInfo = CardInfo::find($request->id);
        $type = $request->type;
        try {
            if ($type == 2) { //签字
                return ImageService::getSignatureResponse($cardInfo ? $cardInfo->signature : '');
            } else if ($type == 4) { //tab1
                return ImageService::getTab('tab1', $cardInfo ? $cardInfo->signature : '');
            } else if ($type == 5) { //tab2
                return ImageService::getTab('tab2', $cardInfo ? $cardInfo->signature : '');
            } else if ($type == 6) { //tab3
                return ImageService::getTab('tab3', $cardInfo ? $cardInfo->signature : '');
            } else if ($type == 7) { //tab4
                return ImageService::getTab('tab4', $cardInfo ? $cardInfo->signature : '');
            } else { //没办法
                return ImageService::getTab('tab5', $cardInfo ? $cardInfo->signature : '');
            }
        } catch (\Exception $e) {
            return ImageService::noSuchImage();
        }
    }

    /**
     * 分页扣款审核页面
     * @param Request $request
     */
    public function signatureCheck(Request $request)
    {
        $where = $request->get('where');

        if (is_array($where)) {
            array_push($where, ['is_delete', '=', 0]);
        } else {
            $where[] = ['is_delete', '=', 0];
        }
        $where[] = ['status', '=', 1]; //未扣款
        $where[] = ['first_charge', '=', 0]; //首付未扣
        $where[] = ['enable', '=', 1]; //必须是有效订单
        $where[] = ['is_signature', '=', 1]; //签名必须ok

        $data = RbcxOrderRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));


        return view('backend.rbcx.signatureCheck', compact('data'));
    }

    /**
     * 发起支付请求
     * @param Request $request
     */
    public function startPay(Request $request)
    {
        $id = $request->get('id', 0);
        try {
            if($id < 1)
                throw new \Exception("参数错误");
            $order = Order::find($id);
            if($order->frist_charge == 1)
                throw new \Exception("错误:保单已完成首次付款");
            if($order->status > 1)
                throw new \Exception("保单状态异常");
            $installment = $order->installment()->orderBy('opertiontime', 'asc')->take(1)->get();
            if($installment->isEmpty()) {
                throw new \Exception("获取分期支付信息出错，错误!");
            }
            if(!$order->isTest()) { //如果不是测试，需要验证卡的使用次数限制
                if($order->sevenMonthsLimit($order->cardInfo->card) > 1){
                    $card = $order->cardInfo->card;
                    throw new \Exception("此卡号{{ $card }}已被使用过一次，请更换信用卡");
                }
            }

            $ret = PayService::startPay($order, null);

            if($ret != '支付成功')
                return $ret;

            //都成功了，处理后面的事情
            //$installment[0]->status = 2;
            //\Log::info("问题杵在外面了");
            //$installment[0]->debit_money = $installment[0]->money;
            //list($installment->status, $installment->debit_money) = [2, $installment->money]; //新的赋值方式好吧
            //$installment[0]->save();
            $installment[0]->makeDone();
            $order->makeFirstPayDone();
            $order->sendTemplateMsg();
            $order->sendMobileMsg();
            //$order->first_charge = 1;
            //$order->save();
            //RbcxOrderRepository::getInstance()->sendTemplateMsg();
            //RbcxOrderRepository::getInstance()->sendMobileMsg();
            return $ret;
        }catch(\Exception $e){ //异常处理
            return $e->getMessage();
        }
    }

    /**
     * 确认扣款成功页面
     * @param Request $request
     */
    public function payConfirm(Request $request)
    {
        $where = $request->get('where');

        if (is_array($where)) {
            array_push($where, ['is_delete', '=', 0]);
        } else {
            $where[] = ['is_delete', '=', 0];
        }
        $where[] = ['status', '=', 1]; //未扣款
        $where[] = ['first_charge', '=', 1]; //首付已扣
        $where[] = ['enable', '=', 1]; //必须是有效订单
        $where[] = ['is_signature', '=', 1]; //签名必须ok

        $data = RbcxOrderRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));


        return view('backend.rbcx.signatureCheck', compact('data'));
    }

    /**
     * 确认扣款成功
     * @param Request $request
     */
    public function payConfirmAction(Request $request)
    {
        $id = $request->get('id');
        try{
            if($id<1)
                throw new \Exception("请求参数异常");
            $order = Order::find($id);
            $order->status = 2 ;
            $order->save();
        }catch(\Exception $e){
            return ['error' => $e->getMessage()];
        }
        return "操作完成";
    }

    /**
     * 异常订单列表
     * @param Request $request
     */
    public function errorList(Request $request)
    {
        $where = $request->get('where');

        if (is_array($where)) {
            array_push($where, ['is_delete', '=', 0]);
        } else {
            $where[] = ['is_delete', '=', 0];
        }
        $where[] = ['enable', '=', 1]; //必须是有效订单
        $where[] = ['error', '>', 0];

        $data = RbcxOrderRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));


        return view('backend.rbcx.signatureCheck', compact('data'));
    }

    public function pureTest()
    {
        /*$client = new HttpClient('http://mp2.jojin.com/api/sms/send');
        $data = [
            'mobiles' => '18357136394',
            'content' => '你好，你个傻逼',
            'opertion_time' => date('Y-m-d H:i:s')
        ];
        $ret = $client->config($data)->doRequest();
        //print_r($)
        if($ret['code'] != 200)
            echo "Undone";
        else
            echo "done";*/

       /* $data = ['is_delay'=>0, 'opertion_time'=> date('Y-m-d H:i:s')];
        $data['templateId'] = 'f6YWvN1M_dQcUHGE6AA794dva1nNrDqg-al6-qphWAI';
        $data['openId'] = 'o2VsywFXQu9YM70ywl6WzHZ3tB24';
        //$firstInstallment = $this->getFirstInstallment();
        $data['data'] = json_encode(['first'=>'您的人保车险保单已完成初次扣款', 'name'=>'人保车险分期', 'price'=>  50]);
        $client = new HttpClient(config('Rbcx.message.template'));
        $url = config('Rbcx.message.template');
        echo $url;
        $ret = $client->config($data)->doRequest();
        print_r($ret);exit;*/

       /* 周期性扣款测试 */
        $this->scheduledPay();
       /*  结束 */
       exit;
    }

    /**
     * 周期性扣款
     */
    public function scheduledPay()
    {
        $orders = Order::chargedValidOrder();

        \Log::info("【人保车险代扣 后台扣款】找到到期订单 ". count($orders) ." 张");

        foreach($orders as $order) {
            if($order instanceof Order) {
                $orderId = $order->id;
                \Log::info("【人保车险代扣 后台扣款】==============处理订单： $orderId"  . "==============");
                try{ //开始扣款
                    PayService::scheduledPay($order);
                }catch(\Exception $e){
                    $order->markError(1); //1-> | 2->
                    \Log::info("【人保车险代扣 后台扣款】异常:订单{{$orderId}}扣款失败， 错误信息:". $e->getMessage());
                }
            }
        }
        \Log::info("【人保车险代扣 后台扣款】订单扣款结束=================");
    }

    /**
     * 让一个订单变为正常状态
     * @param Request $request
     */
    public function correctError(Request $request)
    {
        $order = Order::find($request->id);
        try{
            if(!$order) {
                throw new \Exception("异常：无此订单");
            }
            $order->error = 0;
            $order->save();
            return $this->responseJson(['retCode'=> 200, 'desc'=>"恢复订单成功"]);
        }catch(\Exception $e){
            return $this->responseJson(['retCode'=>500, 'desc'=>$e->getMessage()]);
        }
    }

    /**
     * 对过期的未扣款的分期进行手动扣款
     * @param Request $request
     */
    public function chargeInstallment(Request $request)
    {
        try{
            $installment = Installment::find($request->id);
            if(!$installment) {
                return $this->responseJson(['code'=>500, 'msg'=> '未找到对应的分期信息']);
            }
            $order = $installment->order;
            if(!$order) {
                return $this->responseJson(['code'=>500, 'msg'=>'未找到此分期对应的订单']);
            }
            PayService::chargeInstallment($installment->id, $order);
            return $this->responseJson(['code'=>200, 'msg'=>'扣款成功']);
        }catch(\Exception $e){
            return $this->responseJson(['code'=>500, 'msg'=>'扣款失败，原因:'. $e->getMessage()]);
        }
    }

    public function recoverFreeze(Request $request)
    {
        try{
            //$orderId =
            $order = Order::find($request->id);
            if(!$order){
                return $this->responseJson(['code'=>500, 'msg'=>'未找到此订单']);
            }
            PayService::recoverFreeze($order);
            return $this->responseJson(['code'=>200, 'msg'=>'恢复预冻结成功']);
        }catch(\Exception $e){
            return $this->responseJson(['code'=>500, 'msg'=>'恢复预冻结时发生错误,信息:'. $e->getMessage()]);
        }
    }
}
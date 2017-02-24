<?php
/**
 * PayService.php
 * Date: 2016/11/30
 */

namespace App\Services;

use App\Models\CarInsurance\Freeze;
use App\Models\CarInsurance\Installment;
use App\Models\CarInsurance\Order;
use App\Models\CarInsurance\PaymentLog;
use App\Traits\Model\LogInterface;
use Log;
use DB;

class PayService
{
    //static $supsendTime = config('carInsurance.suspendTime');
    /**
     * 发起支付请求，顺便把返回值包装成需要插入的log数组
     * @param $order Order
     * @param $installment Installment
     * @return array
     */
    public static function startPay($order, $installment)
    {
        try{
            $createRet = self::createFreezeForPay($order);
            if($createRet['retCode']!='0000'){ //预冻结生成失败
                return "预冻结生成失败,请重试";
            }

            //生成预冻结表数据,被提前到了这里
            $params = ['order_id'=>$order->id, 'money'=>$createRet['amount'], 'freeze_queryid'=> $createRet['queryId'], 'datetime'=>date('Y-m-d h:i:s', time())];

            $order->getFreeze()->store($params);
            $chargeRet = self::realTimeCharge($order);
            if($chargeRet['retCode']!='0000') { //扣款失败
                \Log::info("订单: {{ $order->id }} 支付请求失败了!");
                self::cancelFreezeForPay($order, $createRet['queryId']); //取消预冻结生成操作
                $order->getFreeze()->clear();
                $order->errorCount();
                return "扣款失败，请重试";
            }

            //生成预冻结表数据,被提前了...
            //$params = ['order_id'=>$order->id, 'money'=>$createRet['amount'], 'freeze_queryid'=> $createRet['queryId'], 'datetime'=>date('Y-m-d h:i:s', time())];
            //Freeze::store($params);
        }catch (\Exception $e){
            //todo 到了这步该怎么办 ?
            return $e->getMessage();
        }

        return "支付成功";
    }

    /**
     * @param $type array
     * @param $orderId integer
     * @param $ret array
     */
    public static function createLogParams($type, $orderId, $ret,$reqData=null, $installmentId=null)
    {
        $ret['order_id'] = $orderId;
        $ret['order_num'] = $ret['orderNum'] = $reqData['project_orderNo'];
        $ret['processTime'] = isset($ret['processDate']) ? $ret['processDate']: date('Y-m-d h:i:s', time());
        $ret['request_data'] = json_encode($reqData);
        if($ret['retCode']!='0000'){
            $ret['orderStatus']= 3; //失败了
        }
        if(in_array($type, ['createFreeze', 'cancelFreeze'])){
            $ret['freeze_time'] = $ret['processTime'];
            $ret['freeze_money'] = $reqData['amount']; //以分为单位，无需转换为元
            $ret['freeze_queryId'] = isset($ret['queryId']) ? $ret['queryId']: '';
           // unset($ret['order_num']); //非扣款操作是否需要订单号，应该不需要! Add 看来还是需要的
        }
        if($type=='createFreeze') {
            $ret['status'] = 0;
            if($ret['retCode']=='0000'){
                $ret['retDesc'] = '预冻结生成成功';
            }
        }
        if($type == 'realTimeCharge') {
            $ret['freeze_time'] = $ret['processTime']; //这个也需要记录
            $ret['freeze_money'] = $reqData['amount']; //以分为单位，无需转换为元

            $ret['status'] = 3;
            $ret['installment_id'] = $installmentId;
            if($ret['retCode']== '0000') {
                $ret['retDesc'] = "支付完成";
            }
        }
        if($type == 'cancelFreeze') {
            $ret['status'] = 2;
            if($ret['retCode']=='0000') {
                $ret['retDesc'] = "取消预冻结成功";
            }
        }
        unset($ret['processDate'], $ret['project_orderNo']); //有没有都去除了
        return $ret;
    }

    /**
     * 生成相应的请求参数
     * @param $type string
     * @param $order Order
     * @param $queryid string
     */
    public static function createData($type, $order, $queryid=null, $projectNo='')
    {
        $data = ['projectNo'=> $projectNo];
        $data['project_orderNo'] = guid();
        $isTest = $order->isTest();//config('carInsurance.test');
       // $cardNo= '';
        //$accName = '';
        //$cvv = '';
       // $expire = '';
        if($isTest) {
            $data['istest'] = 1; //测试
            $data['cardNo'] = '5309900599078556';
            $data['accName'] = "王武";
            $cvv = '214';
            $expire = '1502';
        } else {
            if($order->cardInfo==null) {
                throw new \Exception("用户银行卡信息未填写,错误!");
            }
            $data['istest'] = 0;// 正式
            $data['cardNo'] = $order->cardInfo->card;
            $data['accName'] = $order->cardInfo->name;
            $arr = explode("/",$order->cardInfo->card_validity); //'02/16'
           // throw new \Exception($order->cardInfo->cvn_number);
            //if(!isset($arr[1]))
            $expire = $arr[1].$arr[0];//explode("/",$order->cardInfo->cvn_number); //'02/16'
            $cvv = $order->cardInfo->cvn_number;
            $data['mobile'] = $order->cardInfo->phone_number;
            $data['accId'] = $order->cardInfo->id_number;
            //$cvv =
        }
        //$data['cardNo'] = $order->cardInfo ? $order->cardInfo->card: '5309900599078556';
        //$data['accName'] = $order->cardInfo? $order->cardInfo->name: "王武";
        //if(emp$order->installment)
        $installment = $order->installment()->orderBy('opertiontime', 'asc')->take(1)->get();
        if($installment->isEmpty()) {
            throw new \Exception("未获取到分期信息,错误!");
        }
        $first = $installment[0]; //获取一个分期以操作

        $data['cvv'] = $cvv;
        $data['expire'] = $expire;
        //$dat
        if($type=='realTimeCharge'){
            $data['amount'] = $first->money;// 就是以分为单位，没问题

        }else if($type=='createFreeze'){
            $data['amount'] = ($order->amount-1) * $first->money; //无需转换，就是以分为单位

        }else if($type=='cancelFreeze') {
            $data['amount'] = ($order->amount-1) * $first->money; //无需转换，就是以分为单位
            $data['queryId'] = $queryid;
            unset($data['cvv'], $data['expire'], $data['accId'], $data['mobile']);

        }
        return $data;
    }
    /**
     * 发起预冻结生成请求
     * @param $order Order
     * @return  array
     */
    public static function createFreezeForPay($order)
    {
        $url = $order->getPreFreezeUrl();
        //$url = config('carInsurance.pay.createFreeze');
        //$url = "http://pay.local.jojin.com/api/v1/JieLan/PreFreeze";
        $data = self::createData('createFreeze', $order, '', $order->getProjectNo());
        $ret = self::doRequest($url, $data);
        $logParam = self::createLogParams('createFreeze', $order->id, $ret, $data);
        $order->getLogger()->store($logParam); //无论成功失败，存储这条数据
        //PaymentLog::store($logParam);
        $ret['amount'] = $data['amount']; //就是分,无需其他操作
        return $ret;
    }

    /**
     * @param $order Order
     * @return array
     */
    public static function realTimeCharge($order)
    {
        $uri = $order->getChargeUrl();
       // $uri = config('carInsurance.pay.charge');
        //$uri = "http://pay.local.jojin.com/api/v1/JieLan/RealtimeCharge";
        $data = self::createData('realTimeCharge', $order, '', $order->getProjectNo());
        $ret = self::doRequest($uri, $data);
        $installment = $order->installment()->orderBy('opertiontime', 'asc')->take(1)->get()[0];
        //$installmentId = $installment->id;
        $logParam = self::createLogParams('realTimeCharge', $order->id, $ret, $data, $installment->id);
        $order->getLogger()->store($logParam);
        //PaymentLog::store($logParam);
        return $ret;
    }

    /**
     * @param $order Order
     * @param $queryId int
     * @return array
     */
    public static function cancelFreezeForPay($order, $queryId)
    {
        $url = $order->getCancelUrl();
        //$url = config('carInsurance.pay.cancelFreeze');
        //$url = "http://pay.local.jojin.com/api/v1/JieLan/PreFreezeCancel";
        $data = self::createData('cancelFreeze', $order, $queryId, $order->getProjectNo());
        $ret = self::doRequest($url, $data);
        //$ret['queryId'] = $queryId;//需要的冻结流水id参数
        $logParam = self::createLogParams('cancelFreeze', $order->id, $ret, $data);
        $order->getLogger()->store($logParam);
        //PaymentLog::store($logParam);
        return $ret;
    }

    /**
     * 发起url请求
     * @param $url string
     * @param $data array
     * @return array
     */
    public static function doRequest($url, $data)
    {
        //添加请求间隔时间
        $delayTime = config('carInsurance.delay');
        sleep($delayTime); //以秒为单位的延迟
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $ret = curl_exec($curl);
        curl_close($curl);
        return json_decode($ret, true);
    }

    /**
     * 生成扣款请求数据
     * @param $money float
     * @param $order
     */
    private static function generateChargeData($money, LogInterface $order)
    {
        $orderId = $order->id; //用于异常标示
       // if($projectNo == '') {
        //    throw new \Exception("异常: 订单{{ $orderId }}projectNo 为空 !");
     //   }
        $data = ['projectNo' => $order->getProjectNo()];
        $data['project_orderNo'] = guid();
        $isTest = $order->isTest();
        if($isTest) { //如果是测试，赋值测试数据
            $data['istest'] = 1; //测试
            $data['cardNo'] = '5309900599078556';
            $data['accName'] = "王武";
            $cvv = '214';
            $expire = '1502';
        } else { //从数据库获取数据
            if($order->cardInfo == null) {
                throw new \Exception("异常: 订单{{$orderId}} 没有有效的银行信用卡信息 !");
            }
            $data['istest'] = 0;// 正式
            $data['cardNo'] = $order->cardInfo->card;
            $data['accName'] = $order->cardInfo->name;
            $arr = explode("/",$order->cardInfo->card_validity); //'02/16' => '1602'
            $expire = $arr[1].$arr[0];
            $cvv = $order->cardInfo->cvn_number;
            $data['mobile'] = $order->cardInfo->phone_number; // 正式数据多出来的参数
            $data['accId'] = $order->cardInfo->id_number; // 正式数据多出来的参数
        }
//        if(!$installment) {
//            throw new \Exception("异常: 创建扣款请求时传入了null分期");
//        }
        $data['cvv'] = $cvv;
        $data['expire'] = $expire;

        $data['amount'] = $money;
//        $data['']
        return $data;
    }

    /**
     * 对单个分期进行扣款...
     * @param  $installmentId integer 分期id
     * @param $order LogInterface
     */
    public static function chargeInstallment($installmentId, LogInterface $order)
    {
        /*$orderId = $order->id;
        $freeze = $order->getFreeze();
        \Log::info("===========对订单:{{$orderId}}=>分期{{$installmentId}}进行扣款==============");*/
        return self::innerPay($order, $installmentId);
//
    }

    public static function recoverFreeze($order)
    {
        return self::innerPay($order, null, true);
    }

    /**
     * 如果没传$installmentId，那就是对整张订单进行扣款,否则对单张订单扣款
     * @param $order
     * @param null $installmentId
     * @param $recoverFreeze boolean
     */
    private static function innerPay(LogInterface $order, $installmentId=null, $recoverFreeze=false)
    {
        $orderId = $order->id;
        $freeze = $order->getFreeze(); //一定会获取到一个已付过首款的Freeze
        if($installmentId and $recoverFreeze) {
            \Log::error('==========innerPay调用只能installment和recoverFreeze二选一 ==============');
            throw new \Exception("参数installmentId和recoverFreeze只能二选一");
        }
        if($installmentId) {
            \Log::info("==========尝试为订单{{$orderId}}=>分期{{$installmentId}}进行单独扣款 =========");
        }
        else if($recoverFreeze) {
            \Log::info("==========尝试为订单{{$orderId}}恢复预冻结信息================");
        } else {
            \Log::info("==========尝试为订单{{$orderId}}进行扣款===================");
        }

        DB::beginTransaction();
        if($installmentId){
            $expiredRows = $order->expiredInstallmentById($installmentId);
        } else if($recoverFreeze){
            $expiredRows = [];
        } else {
            $expiredRows = $order->expiredInstallments();
        }
        try{
            foreach( $expiredRows as $installment ){
                $installment->changeStatus(1);
            }
            DB::commit();
        }catch ( \Exception $e ){
            DB::rollBack();
            throw $e;
        }
        DB::commit(); //这个commit !

        //\Log::info("=========订单:{{$orderId}}结束获取过期分期时间:". date('Y-m-d H:i:s'). "============");
        //$expiredRows = $order->expiredInstallments();
        if(count($expiredRows) <= 0) {
            //$oId = $order->id;
            if($installmentId) {
                \Log::error("===========未找到订单{{$orderId}}的分期{{$installmentId}}===========");
                throw new \Exception("===========尝试为订单{{$orderId}}=>分期{{$installmentId}}进行单独扣款时未查找到此分期=========");
            } else if($recoverFreeze){
                \Log::info("============尝试为订单{{$orderId}}恢复预冻结信息================");
            } else {
                \Log::info("===========订单{{$orderId}}没有需要分期的数据================");
                return true;
            }
        }
        //进行优先方案扣款
        try {
            self::chargeExpiredInstallments($expiredRows, $order);
            try{
                //如果取消预冻结出错，日志记录就好，不打断整个扣款流程
                self::cancelFreeze($freeze, $order);
            }catch(\Exception $e){
                \Log::info("===========订单{{$orderId}}取消预冻结出错, 原因:". $e->getMessage());
            }
            self::updateFreeze($freeze, $order);
            $order->markError(0);
            //$order->error = 0;
            //$order->save();
            return true;
        }catch(\Exception $e) {
            throw $e;
            //\Log::error("【分期模块】优先方案扣款失败了，" . $e->getMessage());
        }
        //到了这里说明扣款时出现了错误，需要进行一分钱测试
        $one = null;
        //$expiredRows = self::expiredInstallmentByOrder($order);
        // if(!count($expiredRows) > 0) {
        //    throw new \Exception("异常: 订单{{$orderId}}没有可扣款的分期");
        //}

        //寻找一个可用的测试分期
        foreach($expiredRows as $installment) {
            if($installment->money - $installment->debit_money > 1) { //注意: 这里表明数据库中是以分为单位的
                $one = $installment; //使用最后一个可用的分期进行测试
                //break;
            }
        }
        //再次检查$one是否可用
        if(!$one) {
            //$order->error = 2; //这个标志位还不是特别明白
            $order->markError(2);
            //$order->save();
            throw new \Exception("异常：订单{{$orderId}}扣款失败了，未找到可扣款分期" );
        }

        //这里1分钱测试有未知问题，我不确定expiredInstallments()里面的悲观锁是否已经解除!!!
        $oneId = $one->id;
        try {
            self::charge(1, $one, $order);
            \Log::info("【分期模块】订单{{$orderId}}分期{{$oneId}}1分钱测试成功");
        }catch(\Exception $e){
            \Log::info("【分期模块】订单{{$orderId}}分期{{$oneId}}1分钱测试失败");
            $order->markError(1);
            //$order->error = 1;
            //$order->save();
            throw new \Exception("异常:{{$orderId}}分期{{$oneId}}1分钱测试失败");
        }

        //到了这里说明1分钱测试成功了，再次尝试扣款
        try {
            self::cancelFreeze($freeze, $order); //存在1分钱误差
            self::chargeExpiredInstallments($expiredRows, $order);
            self::updateFreeze($freeze, $order);
            $order->markError(0);
            //$order->error = 0;
            //$order->save();
            return true;
        }catch(\Exception $e){
            $order->markError(2);
            //$order->error = 2;
            //$order->save();
            throw new \Exception("异常:订单{{$orderId}}分期扣款再次失败，异常信息：". $e->getMessage());
        }

    }

    /**
     * 周期性付款
     * @param $order LogInterface
     */
    public static function scheduledPay(LogInterface $order)
    {
        return self::innerPay($order);
        /*$orderId = $order->id;
        $freeze = $order->getFreeze(); //一定会获取到一个已付过首款的Freeze
        \Log::info("=========订单:{{$orderId}}开始获取过期分期时间:". date('Y-m-d H:i:s'). "============");

        DB::beginTransaction();
        $expiredRows = $order->expiredInstallments();
        try{
            //$expiredRows = $order->expiredInstallments();
            foreach( $expiredRows as $installment ){
                $installment->changeStatus(1);
            }
            DB::commit();
        }catch ( \Exception $e ){
            DB::rollBack();
        }
        DB::commit();

        \Log::info("=========订单:{{$orderId}}结束获取过期分期时间:". date('Y-m-d H:i:s'). "============");
        //$expiredRows = $order->expiredInstallments();
        if(count($expiredRows) <= 0) {
            $oId = $order->id;
            \Log::info("===========订单{{$oId}}没有需要分期的数据================");
            return true;
        }
        //进行优先方案扣款
        try {
            self::chargeExpiredInstallments($expiredRows, $order);
            try{
                //如果取消预冻结出错，日志记录就好，不打断整个扣款流程
                self::cancelFreeze($freeze, $order);
            }catch(\Exception $e){
                \Log::info("===========订单{{$orderId}}取消预冻结出错, 原因:". $e->getMessage());
            }
            self::updateFreeze($freeze, $order);
            $order->markError(0);
            //$order->error = 0;
            //$order->save();
            return true;
        }catch(\Exception $e) {
            throw $e;
            //\Log::error("【分期模块】优先方案扣款失败了，" . $e->getMessage());
        }
        //到了这里说明扣款时出现了错误，需要进行一分钱测试
        $one = null;
        //$expiredRows = self::expiredInstallmentByOrder($order);
       // if(!count($expiredRows) > 0) {
        //    throw new \Exception("异常: 订单{{$orderId}}没有可扣款的分期");
        //}

        //寻找一个可用的测试分期
        foreach($expiredRows as $installment) {
            if($installment->money - $installment->debit_money > 1) { //注意: 这里表明数据库中是以分为单位的
                $one = $installment; //使用最后一个可用的分期进行测试
                //break;
            }
        }
        //再次检查$one是否可用
        if(!$one) {
            //$order->error = 2; //这个标志位还不是特别明白
            $order->markError(2);
            //$order->save();
            throw new \Exception("异常：订单{{$orderId}}扣款失败了，未找到可扣款分期" );
        }

        //这里1分钱测试有未知问题，我不确定expiredInstallments()里面的悲观锁是否已经解除!!!
        $oneId = $one->id;
        try {
            self::charge(1, $one, $order);
            \Log::info("【分期模块】订单{{$orderId}}分期{{$oneId}}1分钱测试成功");
        }catch(\Exception $e){
            \Log::info("【分期模块】订单{{$orderId}}分期{{$oneId}}1分钱测试失败");
            $order->markError(1);
            //$order->error = 1;
            //$order->save();
            throw new \Exception("异常:{{$orderId}}分期{{$oneId}}1分钱测试失败");
        }

        //到了这里说明1分钱测试成功了，再次尝试扣款
        try {
            self::cancelFreeze($freeze, $order); //存在1分钱误差
            self::chargeExpiredInstallments($expiredRows, $order);
            self::updateFreeze($freeze, $order);
            $order->markError(0);
            //$order->error = 0;
            //$order->save();
            return true;
        }catch(\Exception $e){
            $order->markError(2);
            //$order->error = 2;
            //$order->save();
            throw new \Exception("异常:订单{{$orderId}}分期扣款再次失败，异常信息：". $e->getMessage());
        }*/

    }

    public static function chargeExpiredInstallments($expiredRows, $order)
    {
       // \Log::info("=========开始获取过期分期时间:". date('Y-m-d H:i:s'). "============");
        //$expiredRows = $order->expiredInstallments();
       // \Log::info("=========结束获取过期分期时间:". date('Y-m-d H:i:s'). "============");
        //if(count($expiredRows) <= 0) { //这是干嘛?
          //  $order->markError(0);
            //return true;
        //}

        $doneCount = 0;
        $errCount = 0;
        foreach($expiredRows as $installment) {
            $installmentId = $installment->id;
            \Log::info("========== 分期{{$installmentId}}开始============");
            try {
                //处于再次扣款的考虑
                //if($installment->status == 2) {
              // //     \Log::info("===========分期{{$installmentId}}已经扣过款项============");
                 //   continue;
              //  }
                $money = $installment->money - $installment->debit_money;
                \Log::info("========交易金额: $money ============");
                self::charge($money, $installment, $order);
                $doneCount++;
            }catch(\Exception $e){
                \Log::error("异常：分期{{$installmentId}} 扣款失败，信息:". $e->getMessage());
                $errCount++;
            }
            \Log::info("========== 分期{{$installmentId}}结束============");
        }
        //$successCount = count($doneArr);
        \Log::info("【分期模块】分期结果：成功{$doneCount}条，失败{$errCount}条");
        if(count($expiredRows) > 0) {
            if($errCount > 0 && $errCount < count($expiredRows)) {
                throw new \Exception( "有部分或者全部款项扣款失败，请联系客服解决", -1 );
            }else if($errCount == count($expiredRows)) {
                $orderId = $order->id;
                throw new \Exception("异常：订单{{$orderId}}扣款失败", -2);
            }
        }
    }

    /**
     * 对$order分期$installment进行$money的扣款
     * @param $money
     * @param $installment
     * @param $order
     */
    public static function charge($money, $installment, LogInterface $order)
    {
        $installmentId = $installment->id;
        $orderId = $order->id;
        if($money + $installment->debit_money > $installment->money) { //这不可能的
            throw new \Exception("异常：订单{{$orderId}} 分期{{$installmentId}}: 扣款总金额大于此分期扣款额");
        }
        if($money == 0) {
            throw new \Exception("异常：订单{{$orderId}} 分期{{$installmentId}}: 扣款金额为0 ！");
        }
        $uri = $order->getChargeUrl();
        $data = self::generateChargeData($money, $order);
        \Log::info("===========扣款请求数据:". unescaped_json_encode($data). ", 请求url: $uri=================");
        $ret = self::doRequest($order->getChargeUrl(), $data);
        \Log::info("===========扣款返回数据:". unescaped_json_encode($ret). ", 请求url: $uri=================");
        //无论失败情况，均存储
        $params = self::createLogParams('realTimeCharge', $order->id, $ret, $data, $installment->id);
        $order->getLogger()->store($params);

        if($ret['retCode'] != '0000') {//失败了
            $installment->error_count ++;
            $installment->status = 0; //不处于再次扣款的考虑，如果此分期出错，直接status=0,error++，直到最后此订单被打上错误标签
            $installment->save();
            throw new \Exception("异常:订单{{$orderId}} 分期{{$installmentId}} 扣款失败，原因:". unescaped_json_encode($ret));
        }
        $installment->debit_money += $money;
        if($installment->debit_money == $installment->money) { //扣完了
            //if(!$installment instanceof Installment)
             //   \Log::info("==========分期不是Installment对象=============");
            $installment->makeCharged(); //标记为已完成扣款
        } else {
            $installment->save(); //保存就好
        }
        return true;
    }

    /**
     * 取消freeze
     * @param $money
     * @param $freeze
     */
    public static function cancelFreeze(/*$money, */$freeze, LogInterface $order)
    {
        $freezeId = $freeze->id;
        $orderId = $order->id;
        $data = self::generateChargeData($freeze->money, $order);
        //一些额外参数和一些不需要参数的去除
        if($freeze->freeze_queryid == '') { //原预冻结不存在
            throw new \Exception("异常: {{$freezeId}} 冻结的流水id不存在");
        }
        //$data['amount'] = $freeze->money;
        $data['queryId'] = $freeze->freeze_queryid;
        unset($data['cvv'], $data['expire'], $data['accId'], $data['mobile']);

        \Log::info("========取消预冻结请求数据：". unescaped_json_encode($data). "==============");
        $ret = self::doRequest($order->getCancelUrl(), $data);
        \Log::info("========取消预冻结返回数据：". unescaped_json_encode($ret). "=================");
        //无论失败与否, 存储Log
        $params = self::createLogParams('cancelFreeze', $order->id, $ret, $data);
        \Log::info("========取消预冻结生成日志数据:". unescaped_json_encode($params)."=================");
        $order->getLogger()->store($params);

        if($ret['retCode'] != '0000') { //失败了
            throw new \Exception("异常: 订单{{$orderId}} 冻结{{$freezeId}} 取消冻结失败,原因:". unescaped_json_encode($ret));
        }
        //存储结果
        $freeze->clear();
        //$freeze->datetime = date('Y-m-d H:i:s');
        //$freeze->freeze_queryid = '';
        //$freeze->money = 0;
        //$freeze->save();
        return $ret;
    }

    /**
     * 更新freeze
     * @param $freeze
     * @param $order
     */
    public static function updateFreeze(/*$money, */$freeze, LogInterface $order)
    {
        $amount = self::unchargedMoneyByOrder($order); //以分为单位，无需转换
        $freezeId = $freeze->id;
        $orderId = $order->id;
        $data = self::generateChargeData($amount, $order);
        if($amount <= 0) {//整个分期结束了
            \Log::info("==========订单->{{$orderId}}预冻结金额为0元，无需进行预冻结操作==============");
            return true;
        }

        \Log::info("=======更新预冻结请求数据:". unescaped_json_encode($data). "=============");
        $ret = self::doRequest($order->getPreFreezeUrl(), $data);
        \Log::info("=======更新预冻结返回数据:". unescaped_json_encode($ret). "=============");
        //无论失败与否, 存储Log
        $params = self::createLogParams('createFreeze', $order->id, $ret, $data);
        $order->getLogger()->store($params);

        if($ret['retCode'] != '0000') { //失败了
            throw new \Exception("异常: 订单{{$orderId}} 冻结{{$freezeId}} 预冻结失败，原因:". unescaped_json_encode($ret));
        }
        //更新冻结表
        $freeze->update(['money'=>$amount, 'freeze_queryid'=>$ret['queryId'], 'datetime'=>date('Y-m-d H:i:s')]);
        //$freeze->money = $amount;
        //$freeze->freeze_queryid = $ret['queryId'];
        //$freeze->datetime = date('Y-m-d H:i:s');
        //$freeze->save();
        return true;
    }

    /**
     * 获取未扣款的总额用以生成freeze
     * @param $order
     */
    public static function unchargedMoneyByOrder($order)
    {
        if(!$order) {
            throw new \Exception("异常: 获取未扣款分期时传递的是null订单引用");
        }
        $money = 0;
        foreach($order->installment as $installment){
            if($installment->status !=2 ) {
                $money += $installment->money - $installment->debit_money;
            }
        }
        return $money;
    }

    /**
     * 不需要了
     * @deprecated
     * @param $order
     * @return array
     * @throws \Exception
     */
    public static function unchargedInstallmentByOrder($order)
    {
        if(!$order) {
            throw new \Exception("异常: order引用null");
        }
        $rows = [];
        foreach($order->installment as $row){
            if($row->status != 2) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    /**
     * 已经不需要了
     * @deprecated
     * @param $order
     * @return array
     * @throws \Exception
     */
    public static function expiredInstallmentByOrder($order)
    {
        if(!$order) {
            throw new \Exception("异常: Order引用null");
        }
        $rows = [];
        foreach($order->installment as $row) {
            $operationTime = strtotime($row->opertiontime);
            if($operationTime <= time() && $row->status !=2) { //过期判断标志
                $rows[] = $row;
            }
        }
        return $rows;
    }

    //public static function
}
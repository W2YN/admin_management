<?php

namespace App\Http\Controllers\Backend\CarInsurance;

use App\Events\Log\OperationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Form\CarInsurance\orderCreate;
use App\Http\Requests\Form\CarInsurance\orderCreateUpdate;
use App\Http\Requests\Form\WaterSaleCreateForm;
use App\Models\CarInsurance\CardInfo;
use App\Models\CarInsurance\Installment;
use App\Models\CarInsurance\Order;
use App\Models\CarInsurance\Policy;
use App\Models\CarInsurance\Recommends;
use App\Models\User;
use App\Presenters\CarInsuranceOrderPresenter;
use App\Repositories\CarInsurance\OrderRepository;
use App\Repositories\WxActivityStatRepository;
use App\Services\ImageService;
use App\Services\PayService;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Tools\StoreTool;

class OrderController extends Controller
{
    protected $listRows = 20;
    protected $orderRepository;
    const NEW_ORDER_ID = "_new_order_id_";

    public function __construct()
    {
        $this->middleware('search', ['only' => ['index', 'installments', 'pendingOrder', 'myOrder', 'chargeBackFail']]);
        $this->middleware('logger.operation'); //添加操作日志记录功能中间件
        $this->orderRepository = OrderRepository::getInstance();

        StoreTool::setDir(config("carInsurance.store.basePath"), config("carInsurance.store.subPath"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return OrderRepository::getInstance()->all();
        //
        $where = $request->get('where');
        //filterSearchCondition自动做了去除判断，下面的可以***
        /* if (!$where) {
             $where[] = ['status', '=', 1];
         }*/
        //if(is_array($where)) {

        // }
        // $where[] = ['status', '>', 0]; //添加一个这个条件
        $where[] = ['is_complete', '=', 1];
        $where[] = ['is_delete', '=', 0];
        /*if (is_array($where)) {
            array_push($where, ['is_delete', '=', 0]);
        } else {
            $where[] = ['is_delete', '=', 0];
        }*/
        //$where[] = ['status','>', 0]; //添加一个这个条件
        //修改搜查条件
        foreach ($where as &$value) {
            if ($value[0] == 'policy_type') {
                $value[2] = '%新客户%' == $value[2] ? 0 : 1;
                $value[1] = '=';
            }
        }

        //$data = $this->orderRepository->paginateWhere($where, config('repository.page-limit'));
        $data = $this->orderRepository->paginateWithOrder($where, config('repository.page-limit'));

        foreach ($data as &$order) {
            $user = User::find($order->to_user_id);
            if ($user) $order->user_name = $user->name;
            else $order->user_name = '';
        }

        return view('backend.carInsurance.index', compact('data'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $arr['status'] = config('carInsurance.status');

        $arr['policyType'] = config('carInsurance.policyType');

        $arr['carType'] = config('carInsurance.carType');

        $arr['carUseProperty'] = config('carInsurance.carUseProperty');

        $arr['carBrand'] = config('carInsurance.carBrand');

        $arr['carPlateColor'] = config('carInsurance.carPlateColor');

        $arr['amountOptions'] = $this->orderRepository->amountOptions();
        return view('backend.carInsurance.create', $arr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WaterSaleCreateForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(orderCreate $request)
    {

        // $data = $request->all();
        $carInfo = ['name', 'card', 'id_number', 'phone_number', 'last_check'];
        $carInfoData = $request->only($carInfo);
        $carInfo[] = '_token';
        $orderData = $request->except($carInfo);
        $orderData['num'] = $this->orderRepository->uuid();
        $orderData['is_complete'] = 1; //添加完成字段
        $orderData['to_user_id'] = Auth::user()->id; //添加订单归属
        $orderData['status'] = 1;//添加订单初始属性

        DB::beginTransaction();
        try {
            //把钱由元转为分为单位
            $orderData['business_money'] = $orderData['business_money'] * 100;
            $orderData['force_money'] = $orderData['force_money'] * 100;
            $orderData['travel_tax'] = $orderData['travel_tax'] * 100;
            //$orderData['']
            $orderId = session(self::NEW_ORDER_ID, false);
            if ($orderId) { //存在则更新
                $res = $this->orderRepository->updateById($orderId, $orderData);
            } else { //否则创建
                $res = $this->orderRepository->create($orderData);
            }
            $carInfoData['order_id'] = $res['attributes']['id'];
            CardInfo::create($carInfoData);
            //再创建默认的Policy
            Policy::createDefaultPolicy($res['attributes']['id']);
            \Event::fire(new OperationEvent("创建订单"));
            \Event::fire(new OperationEvent("创建信用卡"));
            DB::commit();
            \Session::forget(self::NEW_ORDER_ID); //把session忘了，必须重新创建出错

            return $this->successRoutTo('backend.carInsurance.create', '订单创建成功');
            /*return $this->successRoutTo('backend.carInsurance.create', '订单创建成功');

            DB::commit();*/
        } catch (\Exception $e) {
            //接收异常处理并回滚
            DB::rollBack();
            \Event::fire(new OperationEvent("创建订单错误:" . $e->getMessage()));
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return $id;
        // $data =order::findOrfail($id);
        try {
            $arr['data'] = $this->orderRepository->findOrfail($id);
            // if($arr['data']->cardInfo == null or $arr['data']->installment == null) {
            //     throw new \Exception("cardInfo或者installment获取失败");
            //  }
            if ($arr['data']->recommend_id == 0 and $arr['data']->to_user_id == 0) { //提供待领取按钮标示
                $arr['data']->waitGet = true;
            }

            $arr['cardInfo'] = $arr['data']->cardInfo;
            //$arr['cardInfo']->signature = route('backend.carInsurance.order.pureImg', ['id'=>1]);
            $arr['installment'] = $arr['data']->installment;

            $arr['paymentLog'] = $arr['data']->paymentLog;

            //

            $arr['policy'] = $arr['data']->policy;

            $arr['freeze'] = $arr['data']->freeze;

            $arr['data']['business_money'] = $arr['data']['business_money'] / 100;
            $arr['data']['force_money'] = $arr['data']['force_money'] / 100;
            $arr['data']['travel_tax'] = $arr['data']['travel_tax'] / 100;

        } catch (\Exception $e) {
            return response(view('backend.errors.404', ['previousUrl' => url('backend/carInsurance/order')]), 404);
        }
        if($arr['data']['error'] > 0) {
            return view('backend.carInsurance.failOrderDetail', $arr);
        }
        return view('backend.carInsurance.show', $arr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        //var_dump( $request->session()->getOldInput());
        $waitEditOrder = $this->orderRepository->findOrfail($id);
        //稍后需要更新的页面
        if (!$waitEditOrder || ($waitEditOrder && $waitEditOrder->status != 2)) {
            return view('backend.carInsurance.editNotAllowed');
        }
        $arr['status'] = config('carInsurance.status');
        $arr['policyType'] = config('carInsurance.policyType');
        $arr['carType'] = config('carInsurance.carType');
        $arr['carUseProperty'] = config('carInsurance.carUseProperty');
        $arr['carBrand'] = config('carInsurance.carBrand');
        $arr['carPlateColor'] = config('carInsurance.carPlateColor');
        $arr['amountOptions'] = $this->orderRepository->amountOptions();
        $arr['id'] = $id;
        $arr['data'] = $waitEditOrder;//$this->orderRepository->findOrfail($id);
        $arr['policy'] = $arr['data']->policy;
//var_dump($arr['policy']);
        $arr['drivers_insurance_money'] = [];
        for ($i = 1; $i <= 20; $i++) {
            $key = $i * 10000;
            $arr['drivers_insurance_money'][$key] = $i . '万';
        }
        $arr['third_insurance_money'] = ['50000' => '5万','100000' => '10万','150000' => '15万', '200000' => '20万', '3000000' => '30万', '500000' => '50万', '1000000' => '100万','1500000' => '150万','2000000' => '200万'];
        $arr['passenger_insurance_money'] = $arr['drivers_insurance_money'];
        for ($i = 1; $i <= 7; $i++) {
            $arr['passenger_insurance_amount'][$i] = $i . '座';
        }

        $arr['data']['business_money'] = $arr['data']['business_money'] / 100;
        $arr['data']['force_money'] = $arr['data']['force_money'] / 100;
        $arr['data']['travel_tax'] = $arr['data']['travel_tax'] / 100;
        return view('backend.carInsurance.edit', $arr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(orderCreateUpdate $request, $id)
    {

        $defulatPolicy = [
            'damage_insurance' => 0,
            'third_insurance' => 0,
            'drivers_insurance' => 0,
            'passenger_insurance' => 0,
            'theft_insurance' => 0,
            'glass_insurance' => 0,
            'selfcombustion_insurance' => 0,
            'engine_insurance' => 0,
            'nd_damage_insurance' => 0,
            'nd_third_insurance' => 0,
            'nd_drivers_insurance' => 0,
            'nd_passenger_insurance' => 0,
            'nd_theft_insurance' => 0,
            'nd_engine_insurance' => 0
        ];

        //var_dump($request->get('policy'));exit;

        $policy = array_merge($defulatPolicy, $request->get('policy'));

        try {
            $data = $this->orderRepository->findOrfail($id);
            if ($data->status != 2) { //当处于3状态及之上时，订单无法修改
                return $this->errorBackTo(['error' => "当前订单状态禁止修改"]);
            }
            $exData = $request->except('policy'); //修正图片存储路径问题
            unset($exData['driving_license_file'], $exData['identity_card_file']);
            //把钱由元转为分,相应的分期扣款时也需要更改
            $exData['business_money'] = $exData['business_money'] * 100;
            $exData['force_money'] = $exData['force_money'] * 100;
            $exData['travel_tax'] = $exData['travel_tax'] * 100;
            $data->update($exData);

            policy::where('order_id', $id)->update($policy);
            //  return redirect('/backend/carInsurance/order/' . $id);
            \Event::fire(new OperationEvent("更新订单"));
            //$request->session()->removeFromOldFlashData();
            return view('backend.carInsurance.store');
        } catch (\Exception $e) {
            \Event::fire(new OperationEvent("更新订单失败:" . $e->getMessage()));
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }

    }

    /**
     * 删除订单
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = Order::findOrfail($id);
            if ($data->status == 5) { //未扣款的订单，可以删除
                return response("不能删除已生效的订单");
            }
            $data->update(['is_delete' => 1]);
            Order::deleteRelations($data); //删除分期及卡信息
            //$data->deleteRelations();
            $data->delete();

            //  return redirect('/backend/carInsurance/order/' . $id);
            \Event::fire(new OperationEvent("删除订单"));
            return response("删除成功");
            // return view('backend.carInsurance.store');
        } catch (\Exception $e) {
            \Event::fire(new OperationEvent("删除订单失败:" . $e->getMessage()));
            return response("删除失败，请重试");
            //return $this->errorBackTo(['error' => $e->getMessage()]);
        }

    }


    /**
     * installents获取分期信息
     * @param $request \Illuminate\Http\Request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function installments(Request $request)
    {

        $where = $request->get('where');

        $data = $this->orderRepository->joinInstallmentPaginateWhere($where, config('repository.page-limit'));

        //InstallmentRepository::getInstance()->paginateWhere($where, config());
        return view('backend.carInsurance.installments', compact('data'));
    }


    /**
     * 统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wxActivityStat(Request $request)
    {

        return view('backend.carInsurance.wxActivityStat', ['actType' => 2]);
    }


    public function ajaxWxStat(Request $request)
    {
        $mode = $request->get('mode', 'day');
        $actType = (int)$request->get('actType', 1);
        $start_date = $request->get('start_date');

        $start_date = $start_date ? strtotime($start_date) : strtotime('-7 day');
        $end_date = $request->get('end_date');

        $end_date = $end_date ? strtotime($end_date) : time();

        switch ($mode) {
            case "day":
                $data = WxActivityStatRepository::getInstance()->dayData($actType, $start_date, $end_date);
                break;
            case "week":
                $data = WxActivityStatRepository::getInstance()->weekData($actType, $start_date, $end_date);
                break;
            case "month":
                $data = WxActivityStatRepository::getInstance()->monthData($actType, $start_date, $end_date);
                break;
            default:
                $data = ['code' => 100];
                break;
        }

        return $data;
        //   return json_encode($data,JSON_UNESCAPED_UNICODE);
        return response()->json($data);
    }


    /**
     * 扣款失败管理
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chargeBackFail(Request $request)
    {
        $where = $request->get('where');

        //$mustWhere = [['error', '>', 0]];
        if (!$where) {
            $where = [['error', '>', 0]];//$mustWhere;
        } else {
            $where[] = ['error', '>', 0];//$mustWhere;
            //array_push($where, $mustWhere);
        }

        //$data = $this->orderRepository->joinInstallmentPaginateWhere($where, config('repository.page-limit'));
        $data = $this->orderRepository->paginateWithOrder($where, config('repository.page-limit'));
        //InstallmentRepository::getInstance()->paginateWhere($where, config());
        return view('backend.carInsurance.failOrder', compact('data'));
    }


    public function ajaxUpload(Request $request)
    {
        $file = $request->file('imgFile');
        $allowed_extensions = ["png", "jpg", "jpeg", "gif"];
        $extension = strtolower($file->getClientOriginalExtension());
        if ($extension && !in_array($extension, $allowed_extensions)) {
            return ['errors' => ['只能上传以下图片格式： png, jpg, gif.']];
        }

        $fileToStore = $_FILES['imgFile'];
        $fileName = $request->filed. "." . $extension;
        try {
            $data = $this->orderRepository->findOrCreate($request->id);
            //获取存储路径
            $path = StoreTool::storeFileWithExt($data->id, $fileName, $fileToStore['tmp_name']);
            $data->update([$request->filed => $path]);
            session(self::NEW_ORDER_ID, $data->id);
            \Event::fire(new OperationEvent("上传图片,存储订单id:" . $data->id));
            return ["code" => "200", "msg" => "", "data" => $path];

        } catch (\Exception $e) {
            \Event::fire(new OperationEvent("上传图片出错:" . $e->getMessage()));
            return '{"code":"100","msg":"' . $e->getMessage() . '","data":""}';
        }
    }

    function showFile(Request $request)
    {

        $mimeTypes = array(
            'gif' => 'image/gif',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'jpe' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf',
        );


        $reqAll = $request->all();
        $filePath = $reqAll['path'];
        if (!Storage::exists($filePath))
            return response('', 404);

        $pathinfo = pathinfo($filePath);
        $ext = strtolower($pathinfo['extension']);

        if (!isset($mimeTypes[$ext]))
            return response('', 404);


        $type = $mimeTypes[$ext];

        $files = Storage::get($reqAll['path']);


        return response($files)->header('Content-Type', $type);

    }

    //没用
    public function ajaxPage()
    {
        $carInsuranceOrderPresenter = new CarInsuranceOrderPresenter();
        //  dd($carInsuranceOrderPresenter->getTableParams());
        $method = $_GET['method'];
        $data = OrderRepository::getInstance()->findOrfail(1)->$method()->paginate($this->listRows);

        //dd($data);
        $method = 'get' . $method . 'TableParams';
        return view('backend.carInsurance.showTable', ['table' => $carInsuranceOrderPresenter->$method(), 'data' => $data]);

    }

    /**
     * 这个cell是单个页面的数据
     * @param $arr array
     */
    private function createCells($objPHPExcel, $arr)
    {
        $keyArr = [];
        if (isset($arr[0])) {//多维数组，需要额外操作
            $keyArr = array_keys($arr[0]);
        } else {
            $keyArr = array_keys($arr);
        }
        $beforeA = 64;//ascii值
        $count = 1;
        $index = 1;
        foreach ($keyArr as $key) { //A1,B1,C1等等
            $cell = $beforeA + $count;
            $objPHPExcel->setCellValue(chr($cell) . $index, $key);
            $count++;
        }
        $count = 1;
        foreach ($arr as $value) {
            $index++;
            if (is_array($value)) {
                foreach ($value as $item) {
                    $cell = $beforeA + $count;
                    $objPHPExcel->setCellValue(chr($cell) . $index, $item);
                    $count++;
                }
            } else {
                $cell = $beforeA + $count;
                $objPHPExcel->setCellValue(chr($cell), "2", $value);
                $count++;
            }
        }
    }

    /**
     * @param $obj
     * @param $arr array
     */
    private function order($obj, $arr)
    {
        return [
            ['商业险', '交强险', '车船税', '期数', '车主姓名', '车主手机号', '保单类型', '身份证号', '详细地址', '保险开始时间', '保险结束时间', '车牌号码', '机动车种类', '行驶证图片', '身份证图片'],
            [
                $arr['business_money'],
                $arr['force_money'],
                $arr['travel_tax'],
                $arr['amount'],
                $arr['car_owner'],
                $arr['owner_mobile'],
                $arr['policy_type'],
                $arr['owner_id_number'],
                $arr['owner_address'],
                $arr['policy_start_date'],
                $arr['policy_end_date'],
                $arr['car_license_plate'],
                $arr['car_type'],
                $arr['driving_license_file'],
                $arr['identity_card_file']
            ]
        ];
    }

    private function cardInfo($obj, $arr)
    {
        if (empty($arr)) {
            return [['卡号', '持卡人姓名', '身份证信息', '预留手机号码', '信用卡有效期', '最后一次有效期']];
        }
        return [
            ['卡号', '持卡人姓名', '身份证信息', '预留手机号码', '信用卡有效期', '最后一次有效期'],
            [
                $arr['card'],
                $arr['name'],
                $arr['id_number'],
                $arr['phone_number'],
                $arr['card_validity'],
                $arr['last_check']
            ]
        ];
    }

    private function policy($obj, $arr)
    {
        if (empty($arr)) {
            return [['机动车损失险', '新车购置价', '第三者责任险', '第三者责任险价格', '车上人员责任险(司机)', '相应价格', '机动车盗抢险']];
        }
        return [
            ['机动车损失险', '新车购置价', '第三者责任险', '第三者责任险价格', '车上人员责任险(司机)', '相应价格', '机动车盗抢险'],
            [
                $arr['damage_insurance'] == 1 ? "是" : "否",
                $arr['new_car_price'],
                $arr['third_insurance'] == 1 ? "是" : "否",
                $arr['third_insurance_money'],
                $arr['drivers_insurance'] == 1 ? "是" : "否",
                $arr['drivers_insurance_money'],
                $arr['theft_insurance'] == 1 ? "是" : "否"
            ]
        ];
    }

    private function installment($obj, $arr)
    {
        //if($)
        $v = [
            ['扣款时间', '扣款金额', '已扣金额', '状态', '类型', '备注']
        ];
        if (empty($arr)) {
            return $v;
        }
        if (!empty($arr)) {
            foreach ($arr as $value) {
                $i = [$value['opertiontime'], $value['money'], $value['debit_money'], $value['status'] == 0 ? '未扣款' : ($value['status'] = 1 ? "扣款中" : "已扣款"), $value['type'] == 1 ? "商业险" : ($value['type'] == 2 ? "强制险" : "车船税"), $value['remark']];
                $v[] = $i;
            }
        }
        return $v;
    }

    /**
     * 下载此订单的所有关联信息
     */
    public function download(Request $request)
    {
        $id = $request->id;
        $order = OrderRepository::getInstance()->find($id);//->toArray();

        //拼装成一个xls
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        /*$objPHPExcel->setActiveSheetIndex(0);
        $orderArr = $this->order(null, $order->toArray());
        $objPHPExcel->getActiveSheet()->setTitle("订单信息");
        $objPHPExcel->getActiveSheet()->fromArray($orderArr);*/
        $this->createSheet(0, '订单信息', $objPHPExcel, 'order', $order);
        $this->createSheet(1, '信用卡信息', $objPHPExcel, 'cardInfo', $order);
        $this->createSheet(2, '险种具体信息', $objPHPExcel, 'policy', $order);
        $this->createSheet(3, '分期信息', $objPHPExcel, 'installment', $order);

        /*$cardInfoSheet = new \PHPExcel_Worksheet($objPHPExcel, '信用卡信息'); //创建一个工作表
        $objPHPExcel->addSheet($cardInfoSheet); //插入工作表
        $objPHPExcel->setActiveSheetIndex(1); //切换到新创建的工作表
        $cardArr = $this->cardInfo(null, $order->cardInfo==null?[]: $order->cardInfo->toArray());
        $objPHPExcel->getActiveSheet()->fromArray($cardArr);

        $policySheet = new \PHPExcel_Worksheet($objPHPExcel, '险种具体信息');
        $objPHPExcel->addSheet($policySheet);
        $objPHPExcel->setActiveSheetIndex(2);
        $policyArr = $this->policy(null, $order->policy==null?[]:$order->policy->toArray());
        $objPHPExcel->getActiveSheet()->fromArray($policyArr);

        $installSheet = new \PHPExcel_Worksheet($objPHPExcel, '分期信息');
        $objPHPExcel->addSheet($installSheet);
        $objPHPExcel->setActiveSheetIndex(3);
        $installArr = $this->installment(null, $order->installment==null?[]: $order->installment->toArray());
        $objPHPExcel->getActiveSheet()->fromArray($installArr);*/

// Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="doc.xls"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_clean(); //清理缓存
        $objWriter->save('php://output');
        exit;

        // Order::creating();

    }

    //todo
    /**
     * @param $index
     * @param $title
     * @param $objPHPExcel
     * @param $ref
     */
    private function createSheet($index, $title, $objPHPExcel, $ref, $val)
    {
        if ($index != 0) {
            $sheet = new \PHPExcel_Worksheet($objPHPExcel, $title);
            $objPHPExcel->addSheet($sheet);
        }
        $objPHPExcel->setActiveSheetIndex($index);
        $objPHPExcel->getActiveSheet()->setTitle($title);

        if ($ref == 'order') {
            $arr = $this->$ref(null, $val->toArray());
        } else {
            $arr = $this->$ref(null, $val->$ref == null ? [] : $val->$ref->toArray());
        }

        $objPHPExcel->getActiveSheet()->fromArray($arr);
    }

    /**
     * 从base64解码出来的字符串，直接输出图片
     * @param $cardInfoId
     */
    public function pureImg(Request $request)
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

    public function pendingOrder(Request $request)
    {
        $where = $request->get('where');

        if (!$where) {
            $where[] = ['status', '=', 1];
        }
        $where[] = ['is_complete', '=', 1];
        $where[] = ['is_delete', '=', 0];

        $where[] = ['to_user_id', '=', 0];
        $where[] = ['recommend_id', '=', 0];

        $data = $this->orderRepository->paginateWithOrder($where, config('repository.page-limit'));
        //$data = $this->orderRepository->paginateWhere($where, config('repository.page-limit'));

        // foreach($data as &$row){
        //     $row->waitGet = true;
        //  }
        $waitGet = true;
        return view('backend.carInsurance.pendingOrder', compact('data'));
    }

    public function myOrder(Request $request)
    {
        $where = $request->get('where');
        //if (!$where) {
        //    $where[] = ['status', '=', 1];
        // }
        $where[] = ['is_complete', '=', 1];
        $where[] = ['is_delete', '=', 0];


        $data = $this->orderRepository->myOrderPaginateWhere($where, config('repository.page-limit'));


        return view('backend.carInsurance.myOrder', compact('data'));
    }

    /**
     * 领取订单
     * @param Request $request
     */
    public function takeOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            $order = Order::find($request->id);
            if ($order->to_user_id != 0) {
                return 0;
            }
            $order->to_user_id = \Auth::id();
            $order->save();
            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return 0;
        }
    }

    /**
     * @param Request $request
     */
    public function setStatus(Request $request)
    {
        try {
            $order = Order::find($request->id);
            $order->status = $request->status;
            if ($order->status == 3) { //生成分期,如何判断分期类型
                $isTest = $order->isTest();
                //$isTest = config('carInsurance.test');
                $total = $order->business_money + $order->force_money + $order->travel_tax; //无需任何操作
                //if($isTest){
                $before = $total;
                $total = $total == 0 ? 1200 : $total; //不应该为0，但测试阶段是可能的，所以这里给个随意的值
                $amount = $order->amount == 0 ? 12 : $order->amount; //同理

                if (!$isTest) {
                    if ($before == 0 or $order->amount == 0) {
                        return "订单分期数或者保单总额未填写,请填写后重试"; //错误,不应该为0
                    }
                    //  $amount = $order->amount;
                }

                //$amount = $order->amount==0? 12: $order->amount; //同理
                $isInstallmentTest = config('carInsurance.installmentTest');
                $money = (int)floor($total / $amount); //向下取整

                if ($isInstallmentTest) {
                    $money = 1; //以分为单位，统一标示
                }
                $params = ['order_id' => $order->id, 'opertiontime' => time(), 'money' => $money, 'debit_money' => 0, 'status' => 0, 'type' => 1, 'error_count' => 0];//一律为商业险
                for ($i = 0; $i < $amount; $i++) {
                    if($i+1 == $amount) { //最后一期，要做余额调整
                        $params['money'] = $total - ($amount-1) * $params['money'];
                    }
                    $params['opertiontime'] = date('Y-m-d h:i:s', time() + $i * 28 * 24 * 3600);
                    Installment::store($params); //存储
                }
            }
            $order->save();
            return "设置成功";
        } catch (\Exception $e) {
            return "出现错误，请重试";
        }
    }

    /**
     * 返回status
     * @param Request $request
     * @return mixed
     */
    public function checkStatus(Request $request)
    {
        $order = Order::find($request->id);
        return $order->status;

    }

    /**
     * 开始支付
     * @param Request $request
     */
    public function startPay(Request $request)
    {
        //$money = 1500;
        $order = Order::find($request->id);
        if ($order->is_first_charge == 1) {
            return "首次支付已经完成，错误!!!";
        }
        if(!$order->isTest()){ //如果是test，跳过card限制问题
            if($order->sevenMonthsLimit($order->cardInfo->card) > 1){
                $card = $order->cardInfo->card;
                return "此卡号{{ $card }}已被使用过一次，请更换信用卡";
            }
        }

        $installment = $order->installment()->orderBy('opertiontime', 'asc')->take(1)->get();
        if ($installment->isEmpty()) {
            return "未获取到分期支付信息，错误!";
        }
        $installment = $installment[0];
        $ret = PayService::startPay($order, $installment);
        if ($ret != '支付成功') {
            return $ret;
        }
        //return $ret;
        /*$logParams = PayService::startPay($order, $installment);
        PaymentLog::store($logParams);*/
        //if($logParams['orderStatus']==2) { //完成，更新installment表
        $installment->status = 2; //更新分期表
        $installment->debit_money = $installment->money;
        $installment->save();
        //}
        $order->is_first_charge = 1; //更新订单表状态
        $order->status = 5;
        $order->save();
        return "支付成功";
    }


    public function getRecommendId()
    {

        $data['user_id'] = \Auth::id();

        $findRole = Recommends::where($data)->first();

        if (is_null($findRole))
            $id = Recommends::create($data)->id;
        else
            $id = $findRole->id;


        $id = sprintf('%05s', $id);

        return view('backend.carInsurance.recommends', compact('id'));


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
                    \Log::info("【人保车险代扣 后台扣款】异常:订单{{$orderId}}扣款失败， 错误信息:". $e->getMessage());
                }
            }
        }
        \Log::info("【人保车险代扣 后台扣款】订单扣款结束=================");
    }

    /**
     * 重置订单的异常状态
     * @param Request $request
     */
    public function correctError(Request $request)
    {
        $order = Order::find($request->id);
        $order->error = 0;
        $order->save();
        return $this->responseJson(['code'=>200, 'msg'=>'恢复订单成功']);
    }
}
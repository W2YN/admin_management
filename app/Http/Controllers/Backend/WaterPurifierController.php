<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\WaterPurifier\DeviceRepository;
use App\Repositories\WaterPurifier\InstallmentRepository;
use App\Repositories\WaterPurifier\MaintainRepository;
use App\Repositories\WaterPurifierRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WaterPurifierController extends Controller
{
    public function __construct()
    {
        $this->middleware('search', ['only' => ['index', 'eventSource', 'failDetail', 'installments']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = $request->get('where');
        //为is_complete设定默认值
        $find = false;
        if ($where)
            foreach ($where as $key => $value) {
                if ($value[0] == 'is_complete') {
                    $find = true;
                }
            }
        if ($find == false) {
            return redirect(route('backend.waterPurifier.index', ['is_complete' => 1]));
        }


        $data = WaterPurifierRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));
        return view('backend.water.purifier.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = WaterPurifierRepository::getInstance()->find($id);
        if (empty($data)) {
            return view('backend.errors.404', ['previousUrl' => route('backend.waterPurifier.index')]);
        }
        $installments = $data->installments()->orderBy('opertion_time', 'asc')->get();
        $devices = $data->devices()->get();

        return view('backend.water.purifier.show', compact('data', 'installments', 'devices'));
    }

    public function setInstalled(Request $request, $id)
    {
        if ($request->ajax()) {
            $res = WaterPurifierRepository::getInstance()->updateById($id, ['is_install' => 2]);

            if (empty($res)) {
                $ret_data = ['errorCode' => 1, 'msg' => '设置失败，请稍后重试...'];
            } else {
                $ret_data = ['errorCode' => 0, 'msg' => '设置成功'];
            }

            return response()->json($ret_data);
        }
    }

    /**
     * 设定厂商约定上面安装时间
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function updateInstallTime(Request $request, $id)
    {
        try {
            $install_time = $request->get('install_time');
            if ($install_time == '') {
                throw new \Exception('安装时间不能为空');
            }
            WaterPurifierRepository::getInstance()->updateById($id, ['install_time' => $install_time]);
            return response('保存成功');
        } catch (\Exception $e) {
            return response('保存失败,' . $e->getMessage(), 500);
        }
    }

    /**
     * 设定设备维护状态
     * @param Request $request
     */
    public function maintainComplete(Request $request)
    {
        try {
            $id = $request->get('id');
            $is_complete = $request->get('is_complete', 0);

            MaintainRepository::getInstance()->updateById($id, ['is_complete' => $is_complete]);
            return response('保存成功');
        } catch (\Exception $e) {
            return response('保存失败,' . $e->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax()) {
            $ret_data = [];

            $water_purifer_model = WaterPurifierRepository::getInstance()->find($id);
            if (empty($water_purifer_model)) {
                $ret_data = ['errorCode' => 1, 'msg' => '不存在的订单'];
            } else {
                WaterPurifierRepository::getInstance()->delOrder($water_purifer_model);
                $ret_data = ['errorCode' => 0, 'msg' => '删除成功'];
            }

            return response()->json($ret_data);
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
        if (!$where) {
            $where = [['is_complete', 'like', '%1%']];
        } else {
            //$where = [];
            array_push($where, ['is_complete', 'like', '%1%']);
        }
        //var_dump($where);exit;
        //array_push($where, ['is_complete', 'like', '%1%']);
        $data = InstallmentRepository::getInstance()->specificPaginateWhere($where, config('repository.page-limit'), ["*"]);
        //InstallmentRepository::getInstance()->paginateWhere($where, config());
        return view('backend.water.purifier.installments', compact('data'));
    }

    /**
     * chargeBackFail用于渲染分期信息中扣款失败信息
     * @param $request \Illuminate\Http\Request
     * @return mixed
     */
    public function chargeBackFail(Request $request)
    {
        $where = $request->get('where');

        if (!$where) {
            $where = [['error', '=', 1]];
        } else {
            array_push($where, ['error', '=', 1]);
        }
        $data = WaterPurifierRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));
        return view('backend.water.purifier.index', compact('data'));
    }

    /**
     * @param $request \Illuminate\Http\Request
     * return mixed
     */
    public function deviceInfo(Request $request)
    {
        $where = $request->get('where');
        // 下面的是什么样子的呢，需要观察一下数据库
        if (!$where) {
            $where = [['status', '=', 2]];
        } else {
            array_push($where, ['status', '=', '2']);
        }
        $data = MaintainRepository::getInstance()->specificPaginateWhere($where, config('repository.page-limit'), ["*"]);
        foreach ($data as $key => $field) { //额外添加一个状态显示
            if ($data[$key]['is_complete'] == 1) {
                $data[$key]['operation'] = '';
            } else {
                $data[$key]['operation'] = '设为已执行';
            }
        }
        return view('backend.water.purifier.deviceInfo', compact('data'));
    }

    /**
     * @param $request \Illuminate\Http\Request
     * @return mixed
     */
    public function installmentCollect(Request $request)
    {
        return view('backend.water.purifier.installmentCollect');
    }

    /**
     * 汇总三者信息
     * @param $water_purifier_data  mixed
     * @param $installData  mixed
     * @param $maintainData   mixed
     * @return array
     */
    private function collectInfo($water_purifier_data, $installData, $maintainData)
    {
        //三个数组的created_at都需要调整一下格式
        for ($i = 0; $i < count($water_purifier_data); $i++) {
            $created_at = explode(" ", $water_purifier_data[$i]['created_at'])[0];
            $water_purifier_data[$i]['created_at_'] = $created_at;
        }
        for ($i = 0; $i < count($installData); $i++) {
            $created_at = explode(" ", $installData[$i]['opertion_time'])[0];
            $installData[$i]['created_at_'] = $created_at;
        }
        for ($i = 0; $i < count($maintainData); $i++) {
            $created_at = explode(" ", $maintainData[$i]['datetime'])[0];
            $maintainData[$i]['created_at_'] = $created_at;
        }
        $collect = [];
        $water_visited = [];
        for ($i = 0; $i < count($water_purifier_data); $i++) {
            $start = $water_purifier_data[$i]["created_at_"];
            if (!in_array($start, $water_visited)) { //省下一个continue语句就好
                array_push($water_visited, $start);
                $count = 0;
                $status_count = 0; //用于标示生效个数
                $debit_count = 0;//用于标示已扣款个数
                for ($j = $i; $j < count($water_purifier_data); $j++) {
                    if ($start == $water_purifier_data[$j]['created_at_']) {
                        $count += 1;
                        if ($water_purifier_data[$i]['status'] == 2) {//已生效的订单
                            $status_count += 1;
                        }
                        if ($water_purifier_data[$i]['is_debit'] == 1) { //已扣款的订单
                            $debit_count += 1;
                        }
                    }
                }
                //$fixed_start = explode(" ", $start)[0];// 截断比如2017-09-09 09:09:09 => 2017-09-09
                $title = ["generate" => $count, "valid" => $status_count, "done" => $debit_count, "description" => "dingdan"];
                $info = ["title" => json_encode($title), 'start' => $start, 'className' => 'event_style', 'description' => 'dingdan'];
                array_push($collect, $info);
            }
        }
        $install_visited = [];
        for ($i = 0; $i < count($installData); $i++) {
            $start = $installData[$i]['created_at_'];
            if (!in_array($start, $install_visited)) {
                array_push($install_visited, $start);
                $count = 0;
                $error_count = 0; //失败个数
                $status_count = 0;//已扣款个数
                for ($j = $i; $j < count($installData); $j++) {
                    if ($start == $installData[$j]['created_at_']) {
                        $count += 1;
                        if (/*$installData[$j]['error_count'] > 0 and */
                            $installData[$j]['status'] != 2
                        ) {//失败标志
                            $error_count += 1;
                        }
                        if ($installData[$j]['status'] == 2) { //已扣款标志
                            $status_count += 1;
                        }
                    }
                }
                //$fixed_start = explode(" ", $start)[0];
                $title = ["generate" => $count, "done" => $status_count, "fail" => $error_count, 'fail_create_at' => $error_count == 0 ? 0 : strtotime($installData[$i]['opertion_time']), "description" => "fenqi"];
                $info = ['title' => json_encode($title), 'start' => $start, 'className' => 'event_style', 'description' => 'fenqi'];
                array_push($collect, $info);
            }
        }
        $maintain_visited = [];
        for ($i = 0; $i < count($maintainData); $i++) {
            $start = $maintainData[$i]['created_at_'];
            if (!in_array($start, $maintain_visited)) {
                array_push($maintain_visited, $start);
                $count = 0; //维护任务
                $complete_count = 0; //已完成维护任务
                $uncomplete_count = 0;
                for ($j = $i; $j < count($maintainData); $j++) {
                    if ($start == $maintainData[$j]['created_at_']) {
                        $count += 1;
                        if ($maintainData[$j]['is_complete'] == 1) {
                            $complete_count += 1;
                        } else {
                            $uncomplete_count += 1;
                        }
                    }
                }
                //$fixed_start = explode(" ", $start)[0];
                $title = ["generate" => $count, "done" => $complete_count, "description" => "weihu", 'undone' => $uncomplete_count];
                $info = ['title' => json_encode($title), 'start' => $start, 'className' => 'event_style', 'description' => 'weihu'];
                array_push($collect, $info);
            }
        }
        return $collect;
    }

    /**
     * Look at the stars, look at how they shine for you
     * @param $request \Illuminate\Http\Request
     */
    public function eventSource(Request $request)
    {
        $where = $request->get("where");
        $start = (trim($where[0][2], "%")) . " 00:00:00";
        $to = (trim($where[1][2], "%")) . " 23:59:59";
        $water_purifier_where = [['created_at', 'between', [$start, $to]]];
        $water_purifier_columns = ['id', 'num', 'created_at', 'status', 'is_debit', 'is_complete'];
        $water_purifier_data = WaterPurifierRepository::getInstance()->getByWhere($water_purifier_where, $water_purifier_columns);
        $installment_where = [['opertion_time', 'between', [$start, $to]]];
        $installment_columns = ['water_purifier_id', 'opertion_time', 'money', 'debit_money', 'status', 'error_count', 'remark'];
        $installment_data = InstallmentRepository::getInstance()->getByWhere($installment_where, $installment_columns);
        $maintain_where = [['datetime', 'between', [$start, $to]]];
        $maintain_columns = ['water_purifier_id', 'device_id', 'datetime', 'is_complete'];
        $maintain_data = MaintainRepository::getInstance()->getByWhere($maintain_where, $maintain_columns);
        $data = $this->collectInfo($water_purifier_data->toArray(), $installment_data->toArray(), $maintain_data->toArray());
        return json_encode($data);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function failDetail(Request $request)
    {
        $where = $request->get('where');
        $operation_time = explode(" ", date("Y-m-d H:i:s", $where[0][2][0]))[0];
        $where = [['installments.opertion_time', 'between', [$operation_time . " 00:00:00", $operation_time . " 23:59:59"]], ['installments.status', '<', 2]];

        $failData = InstallmentRepository::getInstance()->getForFailDetail($where);
        return json_encode($failData->toArray());
    }


    /**
     * 统计
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function wxActivityStat(Request $request)
    {

        return view('backend.carInsurance.wxActivityStat', ['actType' => 1]);
    }

    /**
     * 净水器后台生成订单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function orderCreate()
    {
        $amounts = array(
            '1' => '1台',
            '2' => '2台',
            '3' => '3台',
            '4' => '4台',
            '5' => '5台',
            '6' => '6台',
            '7' => '7台',
            '8' => '8台',
            '9' => '9台',
            '10' => '10台',
        );
        return view('backend.water.purifier.orderCreate', compact('amounts'));
    }

    /**
     * 净水器订单保存.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function orderStore(Requests\Form\Water\WaterPurifierRequest $request)
    {
        $data = $request->all();
        $data['num'] = WaterPurifierRepository::getInstance()->uuid();
        $data['is_complete'] = 1;
        $data['is_debit'] = 1;
        $data['is_install'] = 2;
        $data['status'] = 2;
        $data['backend_order'] = 1;
        $insert = WaterPurifierRepository::getInstance()->create($data);
        $device = DeviceRepository::getInstance()->createDevices($insert);

        return $this->successRoutTo('backend.waterPurifier.order.create', '订单创建成功');

    }
}
<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Form\Contract\ContractCreateForm;
use App\Http\Requests\Form\Contract\ContractCreateUpdate;
use App\Repositories\Contract\ContractInstallmentRepository;
use App\Repositories\Contract\ContractRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/**
 * 金融合同管理
 * Class ContractController
 * @package App\Http\Controllers\Backend
 */
class ContractController extends Controller
{
    public function __construct()
    {
        $this->middleware('search', ['only' => ['index','payment','export','exportRemittance', 'capitalBills'/*, 'dimensionCount'*/]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = ContractRepository::getInstance()->paginateWhere($request->get('where'), config('repository.page-limit'));

        return view('backend.contract.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //设置期数
        $countOptions = ContractRepository::getInstance()->countOptions();
        //设置利息
        $interestOptions = config('contract.interestOptions');
        //设置来源
        $sourceOptions = config('contract.sourceOptions');
        //银行代码
        $bankCodes = config('contract.bankCodes');
        //银行账户类型
        $bankTypes = config('contract.bankTypes');


        return view('backend.contract.create', compact('countOptions','interestOptions', 'sourceOptions','bankCodes','bankTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContractCreateForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractCreateForm $request)
    {
        try {
            $data = $request->except(['_token', '_method']);
            $data['amount'] = $data['amount'] * 100;
            ContractRepository::getInstance()->create($data);
            return $this->successRoutTo('backend.contract.create','合同保存成功');
            //return view('backend.contract.store');
        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ContractRepository::getInstance()->find($id);
        $installments = $data->installments()->orderBy('opertion_time','asc')->get();
//        $devices = $data->devices()->get();

        return view('backend.contract.show', compact('data', 'installments'));
    }

    /**
     * 对合同信息进行确认
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function confirm(Request $request, $id){
        try {
            //进行分期吧
            ContractInstallmentRepository::getInstance()->createInstallments( $id );
            //确认合同
            ContractRepository::getInstance()->updateById( $id, ['is_confirm'=>1] );
            
            return response('确认成功');
        }
        catch (\Exception $e) {
            return response('确认失败，' . $e->getMessage(),500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //设置期数
        $countOptions = ContractRepository::getInstance()->countOptions();
        //设置利息
        $interestOptions = config('contract.interestOptions');
        //设置来源
        $sourceOptions = config('contract.sourceOptions');
        //银行代码
        $bankCodes = config('contract.bankCodes');
        //银行账户类型
        $bankTypes = config('contract.bankTypes');

        $data = ContractRepository::getInstance()->find($id);

        return view('backend.contract.edit', compact('data', 'countOptions','interestOptions', 'sourceOptions','bankCodes','bankTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContractCreateUpdate $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContractCreateUpdate $request, $id)
    {
        try {
            $data = $request->except(['_token', '_method']);
            $data['amount'] = $data['amount'] * 100;
            ContractRepository::getInstance()->updateById($id, $data);
            return view('backend.contract.store');
        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function receipt($id)
    {
        //收据
        $data = ContractRepository::getInstance()->find($id);
        return view('backend.contract.receipt',compact('data'));
    }

    public function confirmation($id)
    {
        //确认函
        $data = ContractRepository::getInstance()->find($id);
        return view('backend.contract.confirmation',compact('data'));
    }


    /**
     * 利息支付管理
     */
    public function payment( Request $request )
    {
        $data = ContractInstallmentRepository::getInstance()->paginateWhere($request->get('where'), config('repository.page-limit'));

        return view('backend.contract.payment', compact('data'));
    }

    /**
     * 利息支付管理
     */
    public function payed( Request $request, $id )
    {
        try {
            $id = intval($id);
            $installment = ContractInstallmentRepository::getInstance()->find( $id );
            if( !$installment ){
                throw new \Exception('支付信息不存在');
            }
            $contract = ContractRepository::getInstance()->find( $installment->contract_id );
            if( !$contract ){
                throw new \Exception('合同不存在');
            }

            ContractInstallmentRepository::getInstance()->updateById( $installment->id, ['status'=>2]);

            //*
            //发送短信通知
            $opertiontime = time();
            $opertiontime = date('m月d日',$opertiontime);
            $cardNumber = substr( $contract->bank_card, -4 );
            //初始化
            $curl = curl_init();
            //设置抓取的url
            curl_setopt($curl, CURLOPT_URL, env('API_SMS_URL'));
            //设置头文件的信息作为数据流输出
            //curl_setopt($curl, CURLOPT_HEADER, 1);
            //设置获取的信息以文件流的形式返回，而不是直接输出。
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            //设置post方式提交
            curl_setopt($curl, CURLOPT_POST, 1);
            //设置post数据
            $post_data = [
                'mobiles' => $contract->mobile,
                'content' => "尊敬的车险宝客户，车险宝本期收益将于{$opertiontime}23：00前汇款至尾号{$cardNumber}的银行卡中，请注意查收。如有疑问，请拨打0571-28881000咨询。--热讯公司",
                'opertion_time' => date('Y-m-d H:i:s')
            ];
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
            //执行命令
            $data = curl_exec($curl);
            //关闭URL请求
            curl_close($curl);
            //显示获得的数据
            $data = json_decode($data, true);
            if( $data['code'] != 200 ){
                Log::error("【合同管理】利息支付 发送短信失败 合同ID：" . $contract->id . " 手机号码：" . $contract->mobile ); // . //json_encode(, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) );

            }
            //*/

            return response('保存成功');
        } catch (\Exception $e) {
            return response('保存失败,' . $e->getMessage(), 401);
        }
    }

    public function export(Request $request)
    {
        $where = $request->get('where');
        $data = ContractInstallmentRepository::getInstance()->getByWhere(($where ? $where : array()));
        ContractInstallmentRepository::getInstance()->exportExcel( $data->toArray() );
        exit;
    }

    public function exportRemittance(Request $request)
    {
        $where = $request->get('where');
        $data = ContractInstallmentRepository::getInstance()->getByWhere(($where ? $where : array()));
        ContractInstallmentRepository::getInstance()->exportRemittance( $data->toArray() );
        exit;
    }

    private function dimension_count($type, $data)
    {
        $value = (object)['checked'=> 0, 'unchecked'=>0 , 'total'=>0];
        $value->type = $type==0? '利息': '本金';
        foreach($data as $item){
            if($type == $item->type){
                if($item->status == 1){//未支付
                    $value->unchecked += $item->money;
                }else if($item->status == 2){//已支付
                    $value->checked += $item->money;
                } //其他状态的忽略不计
            }
        }
        $value->total = $value->checked + $value->unchecked;

        $value->unchecked = $value->unchecked / 100;
        $value->checked = $value->checked / 100;
        $value->total = $value->total / 100;
        return $value;
    }
    /**
     * dimensionCount对合同的本金，利息，状态进行三个维度的统计，展示在页面上
     * @param Request $request
     * @return View
     */
    public function dimensionCount(Request $request)
    {
        $request->flash(); //先存储旧的request
        $where = [];
        $min = $request->get('opertion_timeMin');
        $max = $request->get('opertion_timeMax');
        if($min!='' && $max!='') {
            $where = [['opertion_time', 'between', [$min, $max]]];
        }
        $data = ContractInstallmentRepository::getInstance()->getByWhere($where);
        $money = $this->dimension_count(1, $data);
        $interest = $this->dimension_count(0, $data);
        $total = (object)[
            'type'=>'总共', 'checked'=> $money->checked + $interest->checked,
            'unchecked'=>$money->unchecked + $interest->unchecked, 'total'=> $money->total + $interest->total];

        if(empty($where)) {
            $between = '全时段';
        } else{
            $between = $where[0][2][0]."--". $where[0][2][1];
        }
        $v['installment'] = [
            (object)['type'=>$money->type, 'checked'=>"¥". number_format($money->checked,2), 'unchecked'=>'¥'.number_format($money->unchecked,2), 'total'=>'¥'.number_format($money->total,2), 'between'=>$between],
            (object)['type'=>$interest->type, 'checked'=>"¥". number_format($interest->checked, 2), 'unchecked'=>'¥'.number_format($interest->unchecked,2), 'total'=>'¥'.number_format($interest->total,2), 'between'=>$between],
            (object)['type'=>$total->type, 'checked'=>"¥". number_format($total->checked, 2), 'unchecked'=>'¥'.number_format($total->unchecked,2), 'total'=>'¥'.number_format($total->total,2), 'between'=>$between],
        ];
        $v['_money'] = $money;
        $v['_interest'] = $interest;
        $v['_between'] = $between;

        return view('backend.contract.dimensionCount', $v);
    }

    //利息支付明细单
    public function interestBills(Request $request)
    {
        $where = $request->all();
        //再次添加时间段判断
        $diff = ceil((strtotime($where['opertion_timeMax']) - strtotime($where['opertion_timeMin'])) / 86400);
        if($diff > 31) { //暂时不用
            return $this->errorBackTo("相差天数超过31天，请调整支付时间段");
        }
        $result = ContractRepository::getInstance()->pureGetByWhere($where);
        ContractInstallmentRepository::getInstance()->exportInterestBills($result);
        //var_dump($result);
        exit;
    }

    /**
     * 本金明细单
     */
    public function capitalBills(Request $request)
    {
        $where = $request->get('where');
        //$data = ContractRepository::getInstance()->getByWhere($where ?: []);
        $data = ContractInstallmentRepository::getInstance()->getByWhereWithMany($where ?: []);
        ContractInstallmentRepository::getInstance()->exportCapitalBills( $data->toArray() );
        exit;
    }
}

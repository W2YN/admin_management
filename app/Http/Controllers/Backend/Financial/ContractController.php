<?php

namespace App\Http\Controllers\Backend\Financial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Financial\ContractRepository;

class ContractController extends Controller
{
	
	public function __construct()
	{
		$this->middleware('search', ['only' => 'index']);
	}
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$where = $request->input('where', []);
    	foreach ($where as &$val) {
    		if ($val[0] == 'datetime'){
    			$val[0] = 'sign_time';
    		}
    		
    		if ($val[0] == 'status') {
    			$val[0] = 'financial_contract.status';
    		}
    	}
    	
    	$request->replace($_GET);
    	$request->flash();
    	
    	$data = ContractRepository::getInstance()->getContractList($where, config('repository.page-limit'));
    	
    	return view('backend.financial.contract.index', compact('data'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contract = ContractRepository::getInstance()->find($id);
        $user = $contract->user;
        $express = $contract->express;
        $exception_status = config('financial.contract_exception_status');
        unset($exception_status['1']);
        
    	return view('backend.financial.contract.show', compact('contract', 'user', 'express', 'exception_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	if (mb_strlen($request->input('exception_info'), 'utf-8') > 255) {
    		return response()->json(['errorCode' => 1, 'msg' => '异常说明不能大于255']);
    	}
    	
    	$keys = array_keys(config('financial.contract_status'));
        ContractRepository::getInstance()->saveById($id, [
                                               'status' => end($keys),
                                               'exception_status' => $request->input('exception_status'),
                                               'exception_info' => $request->input('exception_info'),
                                                         ]);
        return response()->json(['errorCode' => 0, 'msg' => '设置异常成功']);
    }
	
    /**
     * 合同设为回邮已收到状态
     * @param Request $request
     * @param unknown $id
     * @return Ambigous <\Symfony\Component\HttpFoundation\Response, \Illuminate\Contracts\Routing\ResponseFactory, mixed, \Illuminate\Foundation\Application, \Illuminate\Container\static>
     */
    public function expressBack(Request $request, $id)
    {
    	$contract = ContractRepository::getInstance()->find($id);
    	if ($contract->status != 4) {
    		return response()->json(['errorCode' => 1, 'msg' => '只有在回邮中的状态下才能设置回邮已收到']);
    	}
    	
    	$contract->status = 5;
    	$contract->save();
    	
    	return response()->json(['errorCode' => 0, 'msg' => '设置成功']);
    }
    
    /**
     * 将合同设为存档状态
     * @param unknown $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function keepInTheArchives($id)
    {
    	$contract = ContractRepository::getInstance()->find($id);
    	if ($contract->status != 5) {
    		return response()->json(['errorCode' => 1, 'msg' => '只有在回邮已收到的状态下才能设为存档']);
    	}
    	 
    	$contract->status = 6;
    	$contract->save();
    	
    	return response()->json(['errorCode' => 0, 'msg' => '设置成功']);
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
}

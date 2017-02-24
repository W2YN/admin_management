<?php

namespace App\Http\Controllers\Backend\Financial;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Financial\ExpressRepository;
use App\Repositories\Financial\UserRepository;
use Auth;
use App\Http\Requests\Form\Financial\StoreExpressRequest;

class ExpressController extends Controller
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
        		$val[0] = 'send_time';
        	}
        	
        	if ($val[0] == 'status'){
        		$val[0] = 'financial_express.status';
        	}
        	
        	if ($val[0] == 'express_company_id'){
        		$val[0] = 'financial_express.express_company_id';
        	}
        }
    	
        $request->replace($_GET);
        $request->flash();
        
    	$data = ExpressRepository::getInstance()->getExpressList($where, config('repository.page-limit'));
    	
        return view('backend.financial.express.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$user = Auth::user();
    	$all_express_company = config('financial.express');
    	$all_contract_type = config('financial.contract');
    	$sale_users = UserRepository::getInstance()->all(['id', 'name']);
    	
    	return view('backend.financial.express.create', compact('all_express_company', 'all_contract_type', 'user', 'sale_users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreExpressRequest $request)
    {
        $res = ExpressRepository::getInstance()->saveExrpessAndContract($request);
        
        if ($res) {
        	return redirect()->route('backend.financial.express')->with('success', '保存成功');
        } else {
        	return back()->withInput()->withErrors(['保存出错，请稍后重试...']);
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
        $express = ExpressRepository::getInstance()->find($id);
        $user = $express->user;
        $contracts = $express->contract;
        
        return view('backend.financial.express.show', compact('express', 'user','contracts'));
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
        //
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

<?php

namespace App\Http\Controllers\Backend\WaterPurifier;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\WaterPurifier\ChannelRepository;

class ChannelController extends Controller
{
	public function __construct()
	{
		$this->middleware('search', ['only' => ['index']]);
	}
	
    /**
     * 渠道列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$where = $request->get('where', []);
    	$data = ChannelRepository::getInstance()->paginateWhere($where, config('repository.page-limit'));
    	
    	return view('backend.channel.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.channel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'username' => 'required|regex:/^\w{4,12}$/|unique:mysql_water_purifier.channels,username',
        	'password' => 'required|regex:/\d{1,20}/|regex:/[a-z]{1,20}/|regex:/^[\w]{6,20}$/',
        	'from_type' => 'required|regex:/^\w{4,12}$/|unique:mysql_water_purifier.channels,from_type',
        	'intro' => 'max:200',
        ], [
			'username.required' => '渠道的用户名必填',
        	'username.regex' => '用户名不符合规则',
        	'username.unique' => '用户名已存在',
        	'password.required' => '密码必填',
        	'password.regex' => '密码不符合规则',
        	'from_type.required' => '来源类型必填',
        	'from_type.regex' => '来源类型不符合规则',
        	'from_type.unique' => '来源类型已存在',
        	'intro.max' => '渠道简介最大不能超过200个字符',
        ]);
        
        $all = $request->except('_token');
        $all['password'] = gt_encode($all['password']); //密码加密
        ChannelRepository::getInstance()->create($all);
        
        return back()->with(['success' => '新增渠道成功']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
    	$data = ChannelRepository::getInstance()->find($id);
    	
    	return view('backend.channel.show', compact('data')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$data = ChannelRepository::getInstance()->find($id);
    	
    	return view('backend.channel.edit', compact('data'));
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
    	$this->validate($request, [
    		'username' => 'required|regex:/^\w{4,12}$/|unique:mysql_water_purifier.channels,username,' . $id,
    		'password' => 'required|regex:/\d{1,20}/|regex:/[a-z]{1,20}/|regex:/^[\w]{6,20}$/',
    		'from_type' => 'required|regex:/^\w{4,12}$/|unique:mysql_water_purifier.channels,from_type,' . $id,
    		'intro' => 'max:200',
    	], [
    		'username.required' => '渠道的用户名必填',
    		'username.regex' => '用户名不符合规则',
    		'username.unique' => '用户名已存在',
    		'password.required' => '密码必填',
    		'password.regex' => '密码不符合规则',
    		'from_type.required' => '来源类型必填',
    		'from_type.regex' => '来源类型不符合规则',
    		'from_type.unique' => '来源类型已存在',
    		'intro.max' => '渠道简介最大不能超过200个字符',
    	]);
    	
    	$all = $request->except(['_token', '_method']);
    	$all['password'] = gt_encode($all['password']);
    	ChannelRepository::getInstance()->saveById($id, $all);
    	
    	return back()->with(['success' => '编辑成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
    	if($request->ajax()){
    		ChannelRepository::getInstance()->destroy($id);
    		return response('删除成功');
    	}
    }
    
}

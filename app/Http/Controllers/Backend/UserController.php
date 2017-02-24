<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Facades\RoleRepository;
use App\Facades\UserRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Form\UserCreateForm;
use App\Http\Requests\Form\UserUpdateForm;
use Auth;

/**
 * 用户管理控制器
 *
 * @package App\Http\Controllers\Backend
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = UserRepository::paginate(config('repository.page-limit'));

        return view("backend.user.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = RoleRepository::all();

        return view("backend.user.create", compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Form\UserCreateForm $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateForm $request)
    {
        $data = [
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => bcrypt($request['password']),
        ];

        try {
            $roles = RoleRepository::getByWhereIn('id', $request['role_id']);

            if (empty($roles->toArray())) {
                return $this->errorBackTo("用户角色不存在,请刷新页面并选择其他用户角色");
            }

            $user = UserRepository::create($data);
            if ($user) {

                foreach ($roles as $role) {
                    $user->attachRole($role);
                }

                return $this->successRoutTo('backend.user.index', '新增用户成功');
            }

        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = UserRepository::find($id);
        $roles = RoleRepository::all();
        $userRoles = $user->roles->toArray();
        $displayNames = array_map(function ($value) {
            return $value['display_name'];
        }, $userRoles);

        return view('backend.user.edit', compact('user', 'roles', 'userRoles', 'displayNames'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Form\UserUpdateForm $request
     * @param  int                                    $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateForm $request, $id)
    {
        if ($id != Auth::user()->id && Auth::user()->is_super_admin == 0) {
            return $this->errorBackTo("只允许编辑自身资料");
        }

        $user = UserRepository::find($id);
        $user->name = $request['name'];
        $user->email = $request['email'];

        if ($request['password']) {
            $user->password = bcrypt($request['password']);
        }

        try {
            $roles = RoleRepository::getByWhereIn('id', $request['role_id']);

            if (empty($roles->toArray())) {
                return $this->errorBackTo("用户角色不存在,请刷新页面并选择其他用户角色");
            }

            if ($user->save()) {
                $user->roles()->sync([]);
                foreach ($roles as $role) {
                    $user->attachRole($role);
                }

                return $this->successRoutTo('backend.user.index', "编辑用户成功");
            }
        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if (UserRepository::destroy($id)) {
                return $this->successBackTo('删除用户成功');
            }
        }
        catch (\Exception $e) {
            return $this->errorBackTo(['error' => $e->getMessage()]);
        }
    }
    
    /**
     * 用户信息
     * 
     * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory, mixed, \Illuminate\Foundation\Application, \Illuminate\Container\static>
     */
    public function myInfo()
    {
    	$data = Auth::user();
    	$roles = $data->roles;
    	return view('backend.user.myInfo', compact('data', 'roles'));
    }
    
    /**
     * 修改密码视图
     * 
     * @param Request $request
     * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory, mixed, \Illuminate\Foundation\Application, \Illuminate\Container\static>
     */
    public function editPwd(Request $request)
    {
    	$from = $request->has('from') ? ('?from=' . $request->input('from')) : '';
    	return view('backend.user.editPwd', compact('from'));
    }
    
    /**
     * 修改密码处理
     * 
     * @param Request $request
     * @return Ambigous <\Illuminate\Http\$this, \Illuminate\Http\RedirectResponse>|Ambigous <\Illuminate\Http\RedirectResponse, \Illuminate\Http\RedirectResponse>
     */
    public function editPwdHandler(Request $request)
    {
    	$validator  = \Validator::make($request->all(), [
    		'old_pwd' => 'required',
    		'new_pwd' => 'required|regex:/\d{1,20}/|regex:/[a-z]{1,20}/|regex:/^[\w]{6,20}$/',
    		'new_pwd2' => 'required|same:new_pwd',
    	], [
			'old_pwd.required' => '原始密码必填',
    		'new_pwd.required' => '新密码必填',
    		'new_pwd.regex' => '新密码不符合规则',
    		'new_pwd2.required' => '确认密码必填',
    		'new_pwd2.same' => '确认密码不一致',
    	]);
    	
    	$user = Auth::user();
    	
    	$validator->after(function($validator) use ($request, $user){
    		if($request->input('old_pwd') == $request->input('new_pwd')){
    			$validator->errors()->add('new_pwd', '新密码不能和原始密码一致');
    		}
    		if(!\Hash::check($request->input('old_pwd'), $user->password)){
    			$validator->errors()->add('old_pwd', '原始密码输入错误');
    		}
    	});
    	
    	if ($validator->fails()) {
    		return back()->withInput()->withErrors($validator);
    	}

    	$user->password = \Hash::make($request->input('new_pwd'));
    	$user->save();
    	
    	if($request->has('from')){
    		$request->session()->flash('exec', 'frameClose');
    	}
    	return back()->with('success', '修改成功');
    }
    
    /**
     * 绑定管理员openid二维码页面
     * 
     * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory, mixed, \Illuminate\Foundation\Application, \Illuminate\Container\static>
     */
    public function bindOpenID ()
    {
    	$user = Auth::user();
    	if(!empty($user->openid)){
    		$hasBind = true;
    	}else{
    		$hasBind = false;
    	}
    	
    	$url = route('backend.userCenter.bindOpenIDHandler');
    	$url .= '?muid=' . \Crypt::encrypt($user->id);
    	
    	return view('backend.user.bindopenid', compact('url', 'hasBind'));
    }
    
    /**
     * 解除绑定管理员openid
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeBind(Request $request)
    {
    	if($request->ajax()){
    		$user = Auth::user();
    		$user->openid = '';
    		$user->save();
    		
    		return response()->json(['errorCode' => 0, 'msg' => '解绑成功']);
    	}
    }
    
}

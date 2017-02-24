@extends('backend.layout.frame')
@inject('UserPresenter', 'App\Presenters\UserPresenter')
@section('content')
	<style>.btn-group{margin-bottom:5px;}</style>
    <div class="page-container">
    	<div class="btn-group">
            <button class="btn btn-danger radius editPwd" type="button">修改密码</button>
        </div>
        <form class="form form-horizontal" id="form-article-add">
            <div id="tab_demo" class="HuiTab">
                <div class="tabBar cl"><span>基本信息</span><span>角色信息</span></div>
                
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">编号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['id'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">用户名：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['name'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">邮箱：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['email'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">是否为超级管理员：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $UserPresenter->showIsSuperAdminFormat($data['is_super_admin']) }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">创建时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['created_at'] }}
                        </div>
                    </div>
                </div>
                
                <div class="tabCon">
					<div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="200px">角色名称</th>
                            <th width="200px">角色描述</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($roles as $role)
                            <tr class="text-c">
                                <td>{{ $role['display_name'] }}</td>
                                <td>{{ $role['description'] }}</td>
                            </tr>
                        @empty
						暂无角色
						@endforelse
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('after.js')
    <script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript">
        $(function () {
            $.Huitab("#tab_demo .tabBar span", "#tab_demo .tabCon", "current", "click", "0");

			$('button.editPwd').click(function (){
				layer_show("修改密码", "{{route('backend.userCenter.editPwd')}}?from=frame", "", "");
			});
        });
    </script>
@endsection

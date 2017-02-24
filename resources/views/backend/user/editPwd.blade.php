@extends('backend.layout.frame')

@section('content')
    <div class="page-container">
    	<form class="form form-horizontal" method="post" action="{{route('backend.userCenter.editPwdHandler') . $from}}">
        	{{csrf_field()}}
            {{method_field('PUT')}}
        	<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">原始密码：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="password" class="input-text" id="old_pwd" name="old_pwd" placeholder="原始密码" value="{{old('old_pwd')}}">
				</div>
			</div>
			
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">新 密 码：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="password" class="input-text" id="new_pwd" name="new_pwd" placeholder="新密码[数字字母下划线(必须包含数字和小写字母)，6-20位]" value="{{old('new_pwd')}}">
				</div>
			</div>
			
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">确认密码：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="password" class="input-text" id="new_pwd2" name="new_pwd2" placeholder="确认密码" value="{{old('new_pwd2')}}">
				</div>
			</div>
			
			<div class="row cl">
				<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
					<button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 修改密码</button>
				</div>
			</div>
        </form>
    </div>
@endsection

@section('after.js')
<script type="text/javascript">
var exec = "{{Session::get('exec')}}";
if(exec == 'frameClose'){
	setTimeout(function (){
		var index = parent.layer.getFrameIndex(window.name);
		parent.layer.close(index);
	}, 3000);
}
</script>
@endsection
@extends('backend.layout.frame')
@section('content')
<div class="page-container">
	<center>
		<div class="row cl">
			@if(!$hasBind)
				{!! QrCode::size(213)->generate($url) !!}
				<br/>打开微信扫一扫，绑定我的微信号
			@else
				您已经绑定过了，无需再次绑定&nbsp;
				<button class="btn btn-primary radius cancelBind" type="button">解绑</button>
			@endif
		</div>
	</center>	
</div>
@endsection

@section('after.js')
<script>
$(function (){
	$('button.cancelBind').click(function (){
		layer.confirm('确定要解绑吗?', {
			btn: ['是的', '不了'],
		}, function (){
			$('button.cancelBind').prop('disabled', 'disabled');
			$.ajax({
				url: "{{route('backend.userCenter.removeBind')}}",
				type: 'post',
				data: {_method: 'PUT', _token: '{{ csrf_token() }}'},
				dataType: 'json',
				success: function (data){
					if(data.errorCode == 0){ //解除绑定成功的动作
						layer.msg(data.msg, {icon:1,time:2000});
						setTimeout(function (){
							location.reload();
						},1900);
					}else{
						layer.msg('其他错误', {icon:2,time:2000});
						$('button.cancelBind').removeProp('disabled');
					}
				}
			});
		}, function (){});
	});
});
</script>
@endsection

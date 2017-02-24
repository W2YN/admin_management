@if(Session::has('errors'))
	<div class="Huialert Huialert-error">
		<i class="icon Hui-iconfont icon-remove">&#xe6a6;</i>
		@foreach($errors->all() as $error)
			{{$error}}!&nbsp;&nbsp;&nbsp;&nbsp;
		@endforeach
	</div>
@endif

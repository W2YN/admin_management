@extends('backend.layout.frame')

@section('content')
    <div class="page-container">
    	<form class="form form-horizontal" method="post" action="{{route('backend.financial.express.store')}}">
        	{{csrf_field()}}
        	
        	<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">建立合同人：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="hidden" name="manager_id" value="{{$user->id}}" />
					<input readonly type="text" class="input-text" id="manager_name" name="manager_name" value="{{$user->name}}">
				</div>
			</div>
			
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">销售方名称：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<select class="select" name="financial_user_id">
						@foreach ($sale_users as $s_u)
						    @if ($s_u->id == old('financial_user_id'))
						    <option value="{{$s_u->id}}" selected="selected">{{$s_u->name}}</option>
						    @else
						    <option value="{{$s_u->id}}">{{$s_u->name}}</option>
						    @endif
						@endforeach
					</select>
				</div>
			</div>
			
        	<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">快递单号：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" id="number" name="number" placeholder="快递单号" value="{{old('number')}}">
				</div>
			</div>
			
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">快递公司：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<select class="select" name="express_company_id">
						@foreach ($all_express_company as $k => $v)
						    @if ($k == old('express_company_id'))
						    <option value="{{$k}}" selected="selected">{{$v}}</option>
						    @else
						    <option value="{{$k}}">{{$v}}</option>
						    @endif
						@endforeach
					</select>
				</div>
			</div>
			
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">快递发送时间：</label>
				<div class="formControls col-xs-8 col-sm-9">
				    <input type="text"
                           onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true,readOnly:true})"
                           id="send_time" name="send_time" value="{{old('send_time')}}"
                           class="input-text Wdate" />
				</div>
			</div>
			
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">合同份数：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" name="contract_num" placeholder="合同份数" value="{{old('contract_num')}}" pattern="[1-9][0-9]*" title="合同份数必须为正整数">
				</div>
			</div>
			
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-2">合同类型：</label>
				<div class="formControls col-xs-8 col-sm-9">
				    <select class="select" name="type_id">
						@foreach ($all_contract_type as $k => $v)
						<option value="{{$k}}">{{$v}}</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div class="row cl">
				<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
					<button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 发送快递</button>
				</div>
			</div>
        </form>
    </div>
@endsection

@section('after.js')
<script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
</script>
@endsection
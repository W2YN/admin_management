@extends('backend.layout.frame')
@inject('contractPresenter', 'App\Presenters\Financial\ContractPresenter')
@inject('expressPresenter', 'App\Presenters\Financial\ExpressPresenter')
@section('content')
	<style>.btn-group{margin-bottom:5px;}</style>
    <div class="page-container">
        <form class="form form-horizontal" id="form-article-add">
            <div id="tab_demo" class="HuiTab">
                <div class="tabBar cl"><span>合同详情</span><span>合同快递信息</span></div>
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">编号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $contract['id'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">合同编号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $contract['serial_number'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">合同类型：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $contractPresenter->formatType($contract['type_id']) }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">建立合同人名称：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $contract['manager_name'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">接收合同人名称：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $user['name'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">合同状态：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $contractPresenter->formatStatus($contract['status']) }}
                            @if ($contract['status'] != 7)
                            <button class="btn btn-warning radius" data-toggle="modal" data-target="#myModal" type="button">
                                <i class="Hui-iconfont">&#xe632;</i> 设为异常
                            </button>
                            @endif
                        </div>
                    </div>
                    
                    @if ($contract['status'] == 7)
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">异常状态：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$contractPresenter->formatExceptionStatus($contract['exception_status'])}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">异常说明：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $contract['exception_info'] }}
                        </div>
                    </div>
                    @endif
                    
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">回邮快递公司：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            @if ($contract['express_company_id'] != 0)
                                {{$expressPresenter->formatCompany($contract['express_company_id'])}}
                            @endif
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">回邮快递单号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$contract['express_number']}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">回邮快递发件时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$contract['express_send_time']}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">回邮快递收件时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$contract['express_arrive_time']}}
                        </div>
                    </div>
                    
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">合同签订日期：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$contract['sign_time']}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">客户姓名：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$contract['customer_name']}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">客户联系电话：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$contract['customer_mobile']}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">开户行：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$contract['bank']}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">利息支付账号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$contract['bank_account']}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">投资期限(月)：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$contract['invest_amount']}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">投资金额：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$contract['invest_money']/100}}元
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">投资收益：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$contract['invest_earning']/100}}元
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">身份证正面照：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            @if (!empty($contract['idCard_front']))
                            <img src="{{$contract['idCard_front']}}" style="border:1px solid black;">
                            @endif
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">身份证反面照：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            @if (!empty($contract['idCard_backend']))
                            <img src="{{$contract['idCard_backend']}}" style="border:1px solid black;">
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">编号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$express['id']}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">快递单号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$express['number']}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">快递公司：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$expressPresenter->formatCompany($express['express_company_id'])}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">快递状态：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$expressPresenter->formatStatus($express['status'])}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">快递发送日期：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$express['send_time']}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">快递收到日期：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$express['arrive_time']}}
                        </div>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
    
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
		    <div class="modal-content">
			    <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					    &times;
				    </button>
				    <h4 class="modal-title" id="myModalLabel">
						设为异常
				    </h4>
			    </div>
				<div class="modal-body">
				    <form action="{{route('backend.financial.contract.update', $contract->id)}}" class="set_exception_form">
				    {!! csrf_field() !!}
				    {!! method_field('put') !!}
					异常状态: <select name="exception_status">
					        @foreach ($exception_status as $key => $val)
					        <option value="{{$key}}">{{$val}}</option>
					        @endforeach
					        </select>
					<br/><br/>
					异常说明: <textarea name="exception_info"></textarea>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">关闭
					</button>
					<button type="button" class="btn btn-primary set_exception">
						提交
					</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after.js')
<script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/lib/bootstrap-modal/2.2.4/bootstrap-modal.js"></script>
<script type="text/javascript" src="/lib/bootstrap-modal/2.2.4/bootstrap-modalmanager.js"></script>
<script type="text/javascript">
$(function () {

$.Huitab("#tab_demo .tabBar span", "#tab_demo .tabCon", "current", "click", "0");

$('.modal-footer .set_exception').click(function (){
	$.ajax({
		type: 'POST',
		url: $(this).parent().prev().children('form').attr('action'),
		data: $('.set_exception_form').serialize(),
		dataType: 'json',
		success: function (data){
			layer.msg(data.msg);
			
			if (data.errorCode == 0) {				
	            location.reload();
			}
		}
	});
});


});

</script>
@endsection

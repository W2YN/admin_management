@extends('backend.layout.frame')
@inject('waterPurifierPresenter', 'App\Presenters\WaterPurifierPresenter')
@section('content')
	<style>.btn-group{margin-bottom:5px;}</style>
    <div class="page-container">
    	<div class="btn-group">
        	@if($data['status'] == 0)
            	<button class="btn btn-danger radius delOrder" type="button">删除订单</button>
            @endif
            @if($data['is_install'] == 1)
            	<button class="btn btn-success radius setInstalled" type="button">设为已安装</button>
            @endif
        </div>
        <form class="form form-horizontal" id="form-article-add">
            <div id="tab_demo" class="HuiTab">
                <div class="tabBar cl"><span>基本信息</span><span>支付信息</span><span>分期信息</span><span>设备维护</span></div>
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">编号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['id'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">订单号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['num'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">生成途径：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $waterPurifierPresenter->createType($data['backend_order']) }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">名字：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['name'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">手机号码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['mobile'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">省份：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['province'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">城市：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['city'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">地区：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['area'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">安装台数：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['amount'] }}台
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">详细地址：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['address'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">销售代码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['sale_code'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">微信openID：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['wx_openid'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">客户预约安装时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['booking_time'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">厂商安装时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['install_time'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">是否安装：</label>
                        <div class="formControls col-xs-8 col-sm-9 installStatus">
                        	{{ $waterPurifierPresenter->formatIsInstall($data['is_install']) }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">订单创建：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['created_at'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">最后更新：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['updated_at'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">设置厂商安装时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text"
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true,readOnly:true})"
                                   id="set_install_time" name="set_install_time"
                                   value=""
                                   class="input-text Wdate" style="width:200px;">
                            <button onClick="install_time_save_submit();" class="btn btn-primary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 确定</button>
                        </div>
                    </div>
                </div>
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">安装台数：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['amount'] }}台
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">期数：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['payment_amount'] }}期
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">总金额/台：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ round($data['payment_money']/100, 2) }}元
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">金额/期/台：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ round($data['payment_price']/100, 2) }}元
                        </div>
                    </div>
                    @if($data['payment_deposit']>0)
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">押金：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['payment_deposit'] }}期
                        </div>
                    </div>
                    @endif
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">订单总金额：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ round(($data['payment_money'] * $data['amount'])/100, 2) }}元
                        </div>
                    </div>
                </div>
                <div class="tabCon">
                    <div class="mt-20">

                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="200px">扣款时间</th>
                            <th width="200px">扣款金额</th>
                            <th width="200px">已扣金额</th>
                            <th width="200px">状态(0:未扣款;1:扣款中;2:已扣款)</th>

                            <th>备注</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $installments as $installment)
                            <tr class="text-c">
                                <td >{{date('Y-m-d',strtotime($installment->opertion_time))}}</td>
                                <td>¥ {{ round($installment->money/100, 2) }}</td>
                                <td>¥ {{ round($installment->debit_money/100, 2) }}</td>
                                <td>{{$waterPurifierPresenter->formatErrorInstallmentStatus($installment->opertion_time,$installment->status)}}</td>
                                <td>{{$installment->remark}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                    </div>
                </div>
                <div class="tabCon">

                        @foreach( $devices as $device)
                        <div class="mt-20">
                            <table class="table table-border table-bordered table-hover table-bg table-sort">
                                <thead>
                                <tr>
                                    <th colspan="3" scope="col">设备编号：{{$device->id}}</th>
                                </tr>
                                <tr class="text-c">
                                    <th width="200">维护日期</th>
                                    <th width="200">是否完成维护</th>
                                    <th width="70">操作</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $device->maintains()->get() as $maintain )
                                    <tr class="text-c">
                                        <td >{{date('Y-m-d',strtotime($maintain->datetime))}}</td>
                                        <td class="td-complete">{{$maintain->is_complete == 1 ? '已执行' : '未执行'}}</td>
                                        <td class="f-14" class="td-manage">
                                            @if( $maintain->is_complete != 1 )
                                            <a title="设为已执行" href="javascript:;" onclick="maintain_complete(this,'{{$maintain->id}}')" style="text-decoration:none">设为已执行</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endforeach
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

			//点击`设为已安装`按钮的动作
			$('button.setInstalled').click(function (){
				layer.confirm('确定要设为已安装吗', {
					btn: ['是的', '不了'],
				}, function (){
					$('button.setInstalled').prop('disabled', 'disabled');
					$.ajax({
						url: "{{ route('backend.waterPurifier.setInstalled', ['id' => $data->id]) }}",
						type: 'post',
						data: {_method: 'PUT', _token: '{{ csrf_token() }}'},
						dataType: 'json',
						success: function (data){
							if(data.errorCode == 0){
								layer.msg(data.msg, {icon:1,time:2000});
								$('button.setInstalled').remove();
								$('div.installStatus').empty().text('已安装')
							}else{
								$('button.setInstalled').removeProp('disabled');
								layer.msg(data.msg, {icon:2,time:2000});
							}
						}
					});
				}, function (){});
			});

			//点击`删除订单`按钮的动作
			$('button.delOrder').click(function (){
				layer.confirm('确定要删除订单吗', {
					btn: ['是的', '不了'],
				}, function (){
					$('button.setInstalled').prop('disabled', 'disabled');
					$.ajax({
						url: "{{ route('backend.waterPurifier.destroy', ['id' => $data->id]) }}",
						type: 'post',
						data: {_method: 'DELETE', _token: '{{ csrf_token() }}'},
						dataType: 'json',
						success: function (data){
							if(data.errorCode == 0){
								layer.msg(data.msg, {icon:1,time:2000});
								setTimeout(function (){
									removeIframe();
								}, 2000);
							}else{
								$('button.setInstalled').removeProp('disabled');
								layer.msg(data.msg, {icon:2,time:2000});
							}
						}
					});
				}, function (){});
			});

        });

        function install_time_save_submit()
        {
            var set_install_time = $dp.$('set_install_time').value;
            if( set_install_time == '' ){
                layer.msg("请先选择厂商安装时间",{icon:2,time:2000});
                return ;
            }

            layer.confirm('确定要提交吗？',function(index){
                install_time_post( set_install_time );
            });
//            layer.msg('确定要提交吗？', {
//                time: 0 //不自动关闭
//                ,btn: ['确定','取消']
//                ,yes: function(index){
//                    install_time_post( set_install_time )
//                }
//            });
        }

        function install_time_post( set_install_time )
        {
            var url = '{{route('backend.waterPurifier.updateInstallTime',['id'=>$data['id']])}}';
            var data = "_token={{ csrf_token() }}&install_time=" + set_install_time;
            $.ajax({
                //cache: true,
                type: 'post',
                url: url,
                data: data,
                error: function(request) {
                    //console.debug(request);
                    //_alert('与服务器连接异常');
                    //_alert('<xmp>'+request.responseText+'</xmp>');
                    layer.msg(request.responseText,{icon:2,time:2000});
                },
                success: function(data) {
                    //console.debug( data );
                    layer.msg(data, {
                        time: 0 //不自动关闭
                        ,btn: ['确定']
                        ,yes: function(index){
                            layer.close(index);
                            location.reload();
                        }
                    });
                }
            });
        }


        /*管理员-启用*/
        function maintain_complete(obj,id){
            layer.confirm('确认要设为已执行吗？',function(index){
                //此处请求后台程序，下方是成功后的前台处理……
                maintain_complete_post( id, 1, obj );
            });
        }

        function maintain_complete_post( id, is_complete, obj )
        {
            var url = '{{route('backend.waterPurifier.maintainComplete')}}';
            var data = "_token={{ csrf_token() }}&id=" + id + "&is_complete=" + is_complete;
            console.debug( data );
            $.ajax({
                //cache: true,
                type: 'post',
                url: url,
                data: data,
                error: function(request) {
                    layer.msg(request.responseText,{icon:2,time:0,btn: ['关闭']});
                },
                success: function(data) {
                    //console.debug( data );
                    //$(obj).parents("tr").find(".td-manage").prepend('');
                    $(obj).parents("tr").find(".td-complete").html('已执行');
                    $(obj).remove();
                    layer.msg('已设为已执行!', {icon: 6,time:1000});
                }
            });
        }

    </script>
@endsection

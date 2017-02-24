@extends('backend.layout.window')
@inject('contractPresenter','App\Presenters\ContractPresenter')
@section('content')
    <div class="page-container">
        <form class="form form-horizontal" id="form-article-add">
            <div id="tab_demo" class="HuiTab">
                <div class="tabBar cl"><span>基本信息</span><span>支付信息</span></div>
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">编号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['id'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">姓名：</label>
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
                        <label class="form-label col-xs-4 col-sm-2">合同编号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['number'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">金额：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $contractPresenter->formatAmount($data['amount']) }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">期数：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['count'] }}期
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">年华利率：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $contractPresenter->formatInterest($data['interest']) }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">购买日期：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['buy_date'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">利息支付日：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            @if($data['payment_day']>0){{ $data['payment_day'] }}日@endif
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">来源：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $contractPresenter->formatSource($data['source']) }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">到期日期：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['expiry_date'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">银行账户：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['bank_card'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">银行账户类型：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $contractPresenter->formatBankType($data['bank_type']) }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">银行代码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $contractPresenter->formatBankCode($data['bank_code']) }}({{ $data['bank_code'] }})
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">银行地区：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['bank_province'] }} {{ $data['bank_city'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">银行名称：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['bank_name'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">确认：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $contractPresenter->formatIsConfirm($data['is_confirm']) }}
                        </div>
                    </div>
                    @if( $data['is_confirm'] != 1 )
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2"></label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <button onClick="javascript:confirm_submit();" class="btn btn-primary radius" type="button"><i class="Hui-iconfont">&#xe632;</i> 确定</button>
                            确认以上信息无误，请点击“确认”按钮，确认后将生成支付信息
                        </div>
                    </div>
                    @endif
                </div>

                <div class="tabCon">
                    <div class="mt-20">

                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="200px">支付时间</th>
                            <th width="200px">支付金额</th>
                            {{--<th width="200px">状态(0:未扣款;1:扣款中;2:已扣款)</th>--}}
                            <th>备注</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $installments as $installment)
                            <tr class="text-c">
                                <td >{{date('Y-m-d',strtotime($installment->opertion_time))}}</td>
                                <td>¥ {{ $contractPresenter->formatAmount($installment->money) }}</td>
                                {{--<td>{{$installment->status}}</td>--}}
                                <td>{{$installment->remark}}</td>
                            </tr>
                        @endforeach
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
        });

        function confirm_submit()
        {
            layer.confirm('确认核实合同信息了吗？',function(index){
                var url = '{{route('backend.contract.confirm',['id'=>$data['id']])}}';
                var data = "_token={{ csrf_token() }}";
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
                                //parent.location.reload();
                            }
                        });
                    }
                });
            });

        }


    </script>
@endsection

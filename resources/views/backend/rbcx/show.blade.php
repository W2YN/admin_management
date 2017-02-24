@extends('backend.layout.window')
@inject('rbcxPresenter','App\Presenters\RbcxOrderPresenter')
@section('after.css')
    <style>
        .card_tabBar {
            border-bottom: 2px solid #222
        }

        .card_tabBar span {
            background-color: #e8e8e8;
            cursor: pointer;
            display: inline-block;
            float: left;
            font-weight: bold;
            height: 30px;
            line-height: 30px;
            padding: 0 15px
        }

        .card_tabBar span.current {
            background-color: #222;
            color: #fff;
        }

        .card_tabCon {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="page-container">
        <div class="btn-group" style="padding: 10px 0;">
            <a title="刷新" href="javascript:;" onclick="refresh_status()"
               data-formid="del-from-1"
               class="btn btn-default radius">
                刷新
            </a>
            @if($data->status==1 && $data->first_charge==0 && $data->error==0)
                <a title="删除" href="javascript:;" onclick="Do()" style="margin-left:10px;"
                   data-formid="del-from-1"
                   class="btn btn-default radius">
                    通过审核并尝试扣款
                </a>
                @endif
            @if($data->status==1 && $data->first_charge==1 && $data->error==0)
                <a title="设为已扣款" href="javascript:;" onclick="Do()" style="margin-left:10px;"
                   data-formid="del-from-1"
                   class="btn btn-default radius">
                    设为已扣款
                </a>
            @endif
            @if($data->status==2 && $data->first_charge==1 && $data->error==0)
                <a title="设为已扣款" href="javascript:;"  style="margin-left:10px;"
                   data-formid="del-from-1"
                   class="btn btn-default radius">
                    已扣款
                </a>
            @endif
            @if($data->error != 0)
                <a title="恢复订单" href="javascript:;" onclick="Do()" style="margin-left:10px;"
                data-formid="del-from-1"
                class="btn btn-default radius">
                    重置异常
                </a>
            @endif
        </div>

        <div class="form form-horizontal" id="form-article-add">
            <div id="tab_demo" class="HuiTab">
                <div class="tabBar cl">
                    <span>基本信息</span><span>卡片信息</span><span>签字信息</span><span>合同信息</span><span>分期信息</span><span>保单上传</span>

                    <span>分期扣款日志</span><span>预冻结表信息</span>

                </div>
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
                        <label class="form-label col-xs-4 col-sm-2">车主：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['car_owner'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">手机号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['mobile'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车牌号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['license_plate'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">商业险：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            ¥ {{ $rbcxPresenter->formatAmount($data['business_money'])}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">交强险：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            ¥ {{ $rbcxPresenter->formatAmount($data['force_money'])}}

                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车船税：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            ¥ {{ $rbcxPresenter->formatAmount($data['travel_tax'])}}

                        </div>
                    </div>


                </div>

                <div class="tabCon">
                    <div class="mt-20">
                        @if($cardinfo)

                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">卡号：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    {{$cardinfo->card}}
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">持卡人姓名：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    {{$cardinfo->name}}
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">持卡人身份证信息：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    {{$cardinfo->id_number}}
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">预留手机号：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    {{$cardinfo->phone_number}}
                                </div>
                            </div>

                        @else
                            <label class="form-label col-xs-4 col-sm-2">暂无卡片信息</label>
                        @endif

                    </div>
                </div>

                <!-- 签字信息 -->
                <div class="tabCon">
                    <div class="row cl">
                        <!--<label class="form-label col-xs-4 col-sm-2">订单号：</label>-->
                        <div class="formControls col-xs-8 col-sm-9">
                            <img src="{{ $cardinfo? route('backend.rbcx.signatureImg', ['id' => $cardinfo->id, 'type' => 2]): '/static/car-insurance/not-upload.jpg'}}"/>
                        </div>
                    </div>
                </div>


                <div class="tabCon">
                    @if($cardinfo&&$cardinfo->signature)
                        <div class="mt-20">
                            <span style="color: red">提示:点击鼠标右键将图片保存</span>
                        </div>
                        <div id="card_demo" class="HuiTab">
                            <div class="card_tabBar cl">
                                <span>机动车辆保险分期付款协议</span><span>车辆保险缴纳委托协议</span><span>车险退保业务委托协议</span><span>车辆保险代购及借款服务合同</span>
                            </div>
                            <div class="card_tabCon">
                                <div class="mt-20">
                                    <img width="1000" height="1500"
                                         src="{{route('backend.rbcx.img.signature',['id'=>$cardinfo->id,'signature_id'=>1])}}">
                                </div>
                            </div>
                            <div class="card_tabCon">

                                <div class="mt-20">
                                    <img width="1000" height="1500"
                                         src="{{route('backend.rbcx.img.signature',['id'=>$cardinfo->id,'signature_id'=>2])}}">
                                </div>

                            </div>
                            <div class="card_tabCon">

                                <div class="mt-20">
                                    <img width="1000" height="1500"
                                         src="{{route('backend.rbcx.img.signature',['id'=>$cardinfo->id,'signature_id'=>3])}}">
                                </div>

                            </div>
                            <div class="card_tabCon">

                                <div class="mt-20">
                                    <img width="1000" height="1500"
                                         src="{{route('backend.rbcx.img.signature',['id'=>$cardinfo->id,'signature_id'=>4])}}">
                                </div>

                                <hr>
                                <div class="mt-20">
                                    <img width="1000" height="1500"
                                         src="{{route('backend.rbcx.img.signature',['id'=>$cardinfo->id,'signature_id'=>5])}}">
                                </div>
                            </div>
                        </div>
                    @else
                        <span style="color: red">**该用户未签名**</span>
                    @endif
                </div>

                <div class="tabCon">
                    <div class="mt-20">

                        <table class="table table-border table-bordered table-hover table-bg table-sort">
                            <thead>
                            <tr class="text-c">
                                <th width="150px">创建时间</th>
                                <th width="150px">扣款时间</th>
                                <th width="150px">扣款金额</th>
                                <th width="200px">已扣金额</th>
                                <th width="200px">扣款状态</th>
                                <th width="150px">失败次数</th>
                                <th width="200px">类型</th>
                                {{--<th width="200px">状态(0:未扣款;1:扣款中;2:已扣款)</th>--}}
                                <th width="150px">备注</th>
                                <th width="200px">操作</th>
                                <!--<th width="200px">类型</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            @if($installments)
                                @foreach( $installments as $installment)
                                    <tr class="text-c">
                                        <td>{{date('Y-m-d',strtotime($installment->createtime))}}</td>
                                        <td>{{date('Y-m-d',strtotime($installment->opertiontime))}}</td>
                                        <td>¥ {{ $rbcxPresenter->formatAmount($installment->money)}}</td>
                                        <td>¥ {{ $rbcxPresenter->formatAmount($installment->debit_money)}}</td>
                                        <td>{{$rbcxPresenter->formatInstallmentStatus($installment->status)}}</td>
                                        <td>{{ $installment->error_count }}</td>
                                        <td>{{$rbcxPresenter->showType($installment->type)}}</td>
                                        {{--<td>{{$installment->status}}</td>--}}
                                        <td>{{$installment->remark}}</td>
                                        <td>{!! $rbcxPresenter->showAction($installment) !!} </td>
                                    </tr>
                                @endforeach
                            @else
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tabCon ">
                    <div class="mt-20 row cl  col-xs-offset-3">

                        <a id="apic1"
                           href="{{$data->firstpicture!="" ? $data->firstpicture : 'javascript:return false;'}}"
                           title="文字说明" target="_blank"> <img alt="图片1未上传" id="pic1"
                                                              width="450" height="300" class="col-xs-offset-1"
                                                              src="{{$data->firstpicture}}"></a>

                    </div>
                    <div class="mt-20 row cl col-xs-offset-5">
                        {!! Form::open(['url'=>'backend/rbcx/picture','files'=>true,'id'=>'avatar']) !!}
                        {!! Form::hidden('id',$data->id)!!}
                        {!! Form::hidden('type_id',0)!!}
                        <span>商业险保单</span>
                        <span class="btn-upload">
  <div class="btn btn-primary radius"><i class="iconfont">&#xf0020;</i> 浏览文件</div>
                            {!! Form::file('file',['class'=>'input-file','id'=>'image']) !!}
          </span>
                        {!! Form::close() !!}
                    </div>
                    <div class="mt-20 row cl col-xs-offset-3">
                        <a id="apic2"
                           href="{{$data->secondpicture!="" ? $data->secondpicture : 'javascript:return false;'}}"
                           title="文字说明" target="_blank">
                            <img alt="图片2未上传" id="pic2" width="450" height="300" class="col-xs-offset-1"
                                 src="{{$data->secondpicture}}">
                        </a>
                    </div>
                    <div class="mt-20 row cl col-xs-offset-5">
                        {!! Form::open(['url'=>'backend/rbcx/picture','files'=>true,'id'=>'avatar1']) !!}
                        {!! Form::hidden('id',$data->id)!!}
                        {!! Form::hidden('type_id',1)!!}
                        <span>交强险保单</span>
                        <span class="btn-upload">
                        <div class="btn btn-primary radius"><i class="iconfont">&#xf0020;</i> 浏览文件</div>
                            {!! Form::file('file',['class'=>'input-file ','id'=>'image1']) !!}
                        </span>
                        {!! Form::close() !!}
                    </div>

                    <div class="mt-20 row cl col-xs-offset-3">
                        <a id="apic3"
                           href="{{$data->thirdpicture!="" ? $data->thirdpicture : 'javascript:return false;'}}"
                           title="文字说明" target="_blank">
                            <img alt="图片3未上传" id="pic3" width="450" height="300" class="col-xs-offset-1"
                                 src="{{$data->thirdpicture}}">
                        </a>
                    </div>
                    <div class="mt-20 row cl col-xs-offset-5">
                        {!! Form::open(['url'=>'backend/rbcx/picture','files'=>true,'id'=>'avatar2']) !!}
                        {!! Form::hidden('id',$data->id)!!}
                        {!! Form::hidden('type_id',2)!!}
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;其他保单</span>
                        <span class="btn-upload">
  <div class="btn btn-primary radius"><i class="iconfont">&#xf0020;</i> 浏览文件</div>
                            {!! Form::file('file',['class'=>'input-file ','id'=>'image2']) !!}
          </span>
                        {!! Form::close() !!}
                    </div>
                </div>


                <!-- 分期扣款日志 -->
                <div class="tabCon">
                    @include('backend.rbcx.showTable',  ['table' => $rbcxPresenter->getFreezeLogTableParams(),'data'=>$freezeLog])
                </div>
                <!-- end -->

                <!-- 预冻结表信息 -->
                <div class="tabCon">
                    <div class="mt-20">
                        @if($freeze)

                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">订单ID：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    {{$freeze->order_id}}
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">冻结金额(元)：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    ¥{{number_format($freeze->money /100, 2)}}
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">冻结流水号：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    {{$freeze->freeze_queryid}}
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">冻结时间：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    {{$freeze->datetime}}
                                </div>
                            </div>

                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-2">重置预冻结:</label>
                                <a class="btn btn-default" href="javascript:void(0)" onclick="recoverFreeze({{$data['id']}})" style="margin-left: 10px;">点击重置</a>
                            </div>

                        @else
                            <label class="form-label col-xs-4 col-sm-2">暂无预冻结信息</label>
                        @endif

                    </div>

                </div>
                <!-- end -->
             
            </div>
        </div>
    </div>
@endsection

@section('after.js')

    <script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript">
        $(function () {
            $.Huitab("#tab_demo .tabBar span", "#tab_demo .tabCon", "current", "click", "0");
        });
        $(function () {
            $.Huitab("#card_demo .card_tabBar span", "#card_demo .card_tabCon", "current", "click", "0");
        });
    </script>
    <script>
        $(document).ready(function () {
            var options = {
                beforeSubmit: showRequest,
                success: showResponse,
                dataType: 'json'
            };
            $('#image').on('change', function () {
                $('#avatar').ajaxForm(options).submit();
            });
            $('#image1').on('change', function () {
                $('#avatar1').ajaxForm(options).submit();

            });
            $('#image2').on('change', function () {
                $('#avatar2').ajaxForm(options).submit();
            });
        });
        function showRequest() {
            $("#validation-errors").hide().empty();
            $("#output").css('display', 'none');
            return true;
        }
        function showResponse(response) {
            console.log(response);
            if (response.success == false) {
                var responseErrors = response.errors;
                $.each(responseErrors, function (index, value) {
                    if (value.length != 0) {
                        $("#validation-errors").append('<div class="alert alert-error"><strong>' + value + '</strong><div>');
                    }
                });
                $("#validation-errors").show();
            } else {
                if (response.type_id == 0) {
                    $('#pic1').attr('src', response.avatar);
                    $('#apic1').attr('href', response.avatar);
                }
                if (response.type_id == 1) {
                    $('#pic2').attr('src', response.avatar);
                    $('#apic2').attr('href', response.avatar);
                }
                if (response.type_id == 2) {
                    console.log('asd');
                    $('#pic3').attr('src', response.avatar);
                    $('#apic3').attr('href', response.avatar);
                }
            }
        }
    </script>

    <script src="http://cdn.bootcss.com/jquery.form/3.51/jquery.form.min.js"></script>
    <script>
        function refresh_status(){
            window.location.href = '{{route('backend.rbcx.show', ['id'=>$data->id])}}';
            //window.
        }

            function callback(){
                parent.location.reload();
                //window.parent.location.href = "{{route('backend.carInsurance.order.pendingOrder')}}";
                //parent.$("#parent_refresh").click();
                var index = parent.layer.getFrameIndex(window.name); //获取当前index
                parent.layer.close(index);//这就成功了
        }
        function Do() {
            var r = confirm("确定发起请求?");
            if (r==true)
            {
                var index = layer.open({type:3});
                $.ajax({
                    @if($data->status==1 && $data->first_charge==0)
                    url: '{{route('backend.rbcx.startPay', ['id'=>$data->id])}}',
                    @endif
                    @if($data->status==1 && $data->first_charge==1)
                    url: '{{route('backend.rbcx.payConfirmAction', ['id'=>$data->id])}}',
                    @endif
                    @if($data->error!=0)
                    url:'{{ route('backend.rbcx.correctError', ['id'=>$data->id]) }}',
                    @endif
                    type: 'get',
                    success: function (data) {
                        @if($data->status==1 && $data->first_charge==0)
                                layer.close(index);
                        layer.msg(data);
                        if(data=='支付成功'){
                            setTimeout(callback, 2000);
                        } else {
                            setTimeout(refresh_status, 2000);
                        }
                        @endif
                        @if($data->status==1 && $data->first_charge==1)
                        layer.close(index);
                        layer.msg(data);
//                        layer.close(index);
//                        layer.msg(data);
                        setTimeout(refresh_status, 2000);
                        @endif
                        @if($data->error != 0)
                            layer.close(index);
                        layer.msg(data.desc);
                        setTimeout(callback, 2000);
                        //if(data.retCode==200){
                          //  layer.msg(data.desc);
                        //}else {

                        //}
                        //layer.msg(data);
                        @endif
                    }
                });
            }
            else
            {
                //取消了发起请求
                //layer.msg("");
            }
        }

        /** @deprecated **/
        function startPay() {
            var r = confirm("确定发起请求?");
            if (r==true)
            {
                var index = layer.open({type:3});
                $.ajax({
                    url: '{{route('backend.rbcx.startPay', ['id'=>$data->id])}}',
                    type: 'get',
                    success: function (data) {
                        layer.close(index);
                        layer.msg(data);
                        setTimeout(refresh_status, 2000);
                    }
                });
            }
            else
            {
                //取消了发起请求
                //layer.msg("");
            }
        }
        function chargeExpired(installmentId){
            var r = confirm('确定发起请求?');
            if(r==true){
                var index = layer.open({type: 3});
                $.ajax({
                    url: '/backend/rbcx/chargeInstallment?id=' + installmentId,
                    type:'get',
                    success:function(data){
                        layer.close(index);
                        layer.msg(data.msg);
                        setTimeout(refresh_status, 2000);
                    }
                });
            }
        }

        function recoverFreeze(orderId){
            var r = confirm('确定发起请求?');
            if(r==true) {
                var index = layer.open({type:3});
                $.ajax({
                    url:'/backend/rbcx/recoverFreeze?id='+orderId,
                    type:'get',
                    success:function(data){
                        layer.close(index);
                        layer.msg(data.msg);
                        setTimeout(refresh_status, 2000);
                    }
                });
            }
        }

    </script>
@endsection

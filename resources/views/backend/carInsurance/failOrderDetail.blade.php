@extends('backend.layout.window')
@inject('carInsuranceOrderPresenter','App\Presenters\CarInsuranceOrderPresenter')
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
        .text-li{text-align:left!important}
    </style>
@endsection
@section('content')


    <div class="page-container">

        <div class="btn-group" style="padding: 10px 0;">

            <a title="删除" href="javascript:;" onclick="table_del(this,'{{$data->id}}')"
               data-url="{{url(route('backend.carInsurance.order.destroy',['id'=>$data->id]))}}"
               data-formid="del-from-1"
               class="btn btn-primary radius">
                删除订单
            </a>
            <a title="领取" href="javascript:;" onclick="setOk({{$data->id}})" style="margin-left: 10px;"
               data-formid="del-from-1"
               class="btn btn-default radius">
                重置异常
            </a>
            <-- 下面是更多的可以添加的按钮 -->
            <!--<span class="btn btn-default radius">中间按钮</span>
            <span class="btn btn-default radius">中间按钮</span>
            <span class="btn btn-default radius">右边按钮</span>-->

        </div>


        <form class="form form-horizontal" id="form-article-add">
            <div id="tab_demo" class="HuiTab">
                <div class="tabBar cl">
                    <span>基本信息</span>
                    <span>车主信息</span>
                    <span>车辆信息</span>
                    <span>其他信息</span>
                    <span>信用卡信息</span>
                    <span>分期信息</span>
                    <span>签字下载</span>
                    <!--<span>分期协议下载</span>--> <!-- 这个其实不需要了 -->
                    <span>合同信息</span> <!-- 若干子tab -->
                    <span>保单上传</span> <!--  若干保单图片上传  -->
                    <span>分期扣款日志</span>
                    <span>参保险种</span>
                    <span>预冻结表信息</span>
                </div>

                <!--------基本信息START--------->
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">订单号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->num }}
                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">保单类型：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->policy_type }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">延续上年险种：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->is_continue==0? "否" : "是" }}
                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">商业险：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->business_money }}元
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">交强险：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->force_money }}元
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车船税：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->travel_tax }}元
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">期数：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->amount }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">保险期间开始时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->policy_start_date }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">保险期间结束时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->policy_end_date }}
                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">注册日期：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->car_register_date }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">发证日期：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->car_certificate_date }}
                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">检验记录：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->car_Inspection_record }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">创建时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->created_at }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">状态：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            @if($data->status==1 or $data->status==0)
                                已录入
                            @elseif($data->status==2)
                                处理中
                            @elseif($data->status==3)
                                等待用户填写支付信息
                            @elseif($data->status==4)
                                可发起支付请求
                            @elseif($data->status==5)
                                首次扣款已完成
                            @endif

                        </div>
                    </div>

                    <!--<div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">保单金额：</label>
                        <div class="formControls col-xs-8 col-sm-9">

                            暂无
                        </div>
                    </div>-->

                </div>
                <!--------基本信息END----------->

                <!--------车主信息START--------->
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车主姓名：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->car_owner }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">手机号码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->owner_mobile }}
                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车主身份证：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->owner_id_number }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">地区：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->owner_province}}
                            {{$data->owner_city}}
                            {{$data->owner_area }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">详细地址：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->owner_address != "  默认值" ? $data->owner_address: "" }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">微信OpenID：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->weixinOpenId }}
                        </div>
                    </div>

                </div>
                <!--------车主信息END----------->

                <!----------车辆信息START--------->
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车牌号码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            @if(preg_match('/[\x{4e00}-\x{9fa5}]\w\x{672a}\x{4e0a}\x{724c}/u', $data->car_license_plate))
                                未上牌
                            @else
                                {{  $data->car_license_plate }}
                            @endif
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">机动车种类：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            @if($data->car_type!=0)
                                {{ config('carInsurance.carType.'.$data->car_type) }}
                            @endif
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">使用性质：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            @if($data->car_use_property!=0)
                                {{ config('carInsurance.carUseProperty.'.$data->car_use_property) }}
                            @endif
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车辆品牌：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            @if($data->car_brand!=0)
                                {{ config('carInsurance.carBrand.'.$data->car_brand) }}
                            @endif
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">号牌颜色：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            @if($data->car_plate_color!=0)
                                {{ config('carInsurance.carPlateColor.'.$data->car_plate_color) }}
                            @endif
                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车辆型号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <!-- 下面的都要进行!=0判断 -->
                            {{ $data->car_model }}
                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">发动机号码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->car_engine_num }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车辆识别代码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->car_vin_code }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">核定载客：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            @if($data->car_rated_passenger!=0)
                                {{ $data->car_rated_passenger }}
                            @endif
                        </div>
                    </div>

                </div>

                <!----------车辆信息END---------->

                <!----------其他信息START--------->
                <div class="tabCon">


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">来源类型：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->ft }}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">来源ID：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->fid }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">行驶证图片：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <img src="{{ $data->driving_license_file }}"
                                 alt="" width="200px" height="200px">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">身份证图片：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <img src="{{ $data->identity_card_file }}"
                                 alt="" width="200px" height="200px">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">备注：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data->remark }}
                        </div>
                    </div>


                </div>
                <!----------其他信息END---------->


                <!----------信用卡信息START--------->
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">持卡人姓名：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$cardInfo ? $cardInfo->name : ""}}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">卡号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$cardInfo ? $cardInfo->card:""}}
                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">持卡人身份证信息：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$cardInfo ? $cardInfo->id_number:""}}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">预留手机号码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$cardInfo ? $cardInfo->phone_number:""}}
                        </div>
                    </div>

                <!--<div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">最后一次有效性：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$cardInfo ? $cardInfo->last_check: ""}}
                        </div>
                    </div>-->
                </div>
                <!----------信用卡信息END---------->


                <!----------分期信息START--------->
                <div class="tabCon">
                    @include('backend.carInsurance.showTable',  ['table' => $carInsuranceOrderPresenter->getInstallmentTableParams(),'data'=>$installment])

                </div>
                <!----------分期信息END---------->

                <!-- 签字下载START　-->
                <div class="tabCon">
                    <div class="row cl">
                        <!--<label class="form-label col-xs-4 col-sm-2">订单号：</label>-->
                        <div class="formControls col-xs-8 col-sm-9">
                            <img src="{{ $cardInfo? route('backend.carInsurance.order.pureImg', ['id' => $cardInfo->id, 'type' => 2]): '/static/car-insurance/not-upload.jpg'}}"/>
                        </div>
                    </div>
                </div>
                <!-- END -->
                <!-- 合成分期协议下载START　!!  暂时不需要了 !!-->
                <!--<div class="tabCon">
                    <div class="row cl">
                        <div class="formControls col-xs-8 col-sm-9">
                            <img src=""/>
                        </div>
                    </div>
                </div>-->

                <!-- 四份样式合同START　-->
                <div class="tabCon">
                    <div class="mt-20">
                        <span style="color: red;margin-bottom: 5px;">提示:点击鼠标右键将图片保存,保存为以.png为后缀的图片即可</span>
                    </div>
                    <div id="card_demo" class="HuiTab">
                        <div class="card_tabBar cl">
                            <span>机动车辆保险分期付款协议</span>
                            <span>车辆保险缴费委托协议</span>
                            <span>车险退保业务委托协议</span>
                            <span>车辆保险代购及借款服务合同</span>
                        </div>

                        <!--------基本信息START--------->
                        <div class="card_tabCon">
                            <div class="row cl">
                                <div class="formControls col-xs-8 col-sm-9">
                                    <img width="1000" height="1500" src="{{ $cardInfo? route('backend.carInsurance.order.pureImg', ['id' =>$cardInfo->id, 'type' => 4]): '/static/car-insurance/not-upload.jpg'}}"/>
                                </div>
                            </div>
                        </div>
                        <!--------基本信息START--------->
                        <div class="card_tabCon">
                            <div class="row cl">
                                <div class="formControls col-xs-8 col-sm-9">
                                    <img width="1000" height="1500" src="{{ $cardInfo? route('backend.carInsurance.order.pureImg', ['id' => $cardInfo->id, 'type' => 5]): '/static/car-insurance/not-upload.jpg'}}"/>
                                </div>
                            </div>
                        </div>

                        <!--------基本信息START--------->
                        <div class="card_tabCon">
                            <div class="row cl">
                                <div class="formControls col-xs-8 col-sm-9">
                                    <img width="1000" height="1500" src="{{ $cardInfo? route('backend.carInsurance.order.pureImg', ['id' => $cardInfo->id, 'type' => 6]): '/static/car-insurance/not-upload.jpg'}}"/>
                                </div>
                            </div>
                        </div>
                        <!--------基本信息START--------->
                        <div class="card_tabCon">
                            <div class="row cl">
                                <div class="formControls col-xs-8 col-sm-9">
                                    <img width="1000" height="1500" src="{{ $cardInfo? route('backend.carInsurance.order.pureImg', ['id' => $cardInfo->id, 'type' => 7]):'/static/car-insurance/not-upload.jpg'}}"/>
                                    <hr>
                                    <img width="1000" height="1500" src="{{ $cardInfo? route('backend.carInsurance.order.pureImg', ['id' => $cardInfo->id, 'type' => 8]):'/static/car-insurance/not-upload.jpg'}}"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 三张待上传的协议样式START　-->
                <div class="tabCon">
                    <div class="mt-20 row cl  col-xs-offset-3">

                        <a id="apic1"
                           href="http://mp2.local.jojin.com/storage/rbcx/2016-11-17/1081/5084e7015d42eb61a93978236fdebb45.png"
                           title="文字说明" target="_blank"> <img alt="图片1未上传" id="pic1"
                                                              width="450" height="300" class="col-xs-offset-1"
                                                              src="{{$data->business_money_image}}"/></a>
                        <!--src="http://mp2.local.jojin.com/storage/rbcx/2016-11-17/1081/5084e7015d42eb61a93978236fdebb45.png"></a>-->

                    </div>
                    <div class="mt-20 row cl col-xs-offset-5">
                        <form method="POST" action="{{route('ajaxUpload')}}" accept-charset="UTF-8" id="avatar"
                              enctype="multipart/form-data">
                            <span>商业险保单</span>
                            <span class="btn-upload">
                                <div class="btn btn-primary radius"><i class="iconfont">&#xf0020;</i> 浏览文件</div>
                                <input class="input-file" id="image" name="imgFile" type="file"
                                       onchange="ajaxUpload(this, 'business_money_image')">
                            </span>
                        </form>
                    </div>
                    <div class="mt-20 row cl col-xs-offset-3">
                        <a id="apic2"
                           href="http://mp2.local.jojin.com/storage/rbcx/2016-11-22/1531/d5c99ff232520d35cf9761bdb3c01c7b.png"
                           title="文字说明" target="_blank">
                            <img alt="图片2未上传" id="pic2" width="450" height="300" class="col-xs-offset-1"
                                 src="{{$data->force_money_image}}"/>
                            <!--src="http://mp2.local.jojin.com/storage/rbcx/2016-11-22/1531/d5c99ff232520d35cf9761bdb3c01c7b.png">-->
                        </a>
                    </div>
                    <div class="mt-20 row cl col-xs-offset-5">
                        <form method="POST" action="{{route('ajaxUpload')}}" accept-charset="UTF-8" id="avatar1"
                              enctype="multipart/form-data">
                            <span>交强险保单</span>
                            <span class="btn-upload">
                        <div class="btn btn-primary radius"><i class="iconfont">&#xf0020;</i> 浏览文件</div>
                            <input class="input-file " id="image1" name="imgFile" type="file"
                                   onchange="ajaxUpload(this, 'force_money_image')">
                        </span>
                        </form>
                    </div>

                    <div class="mt-20 row cl col-xs-offset-3">
                        <a id="apic3"
                           href="http://mp2.local.jojin.com/storage/rbcx/2016-11-22/1531/821597a330b2c5497127f27c423a963a.png"
                           title="文字说明" target="_blank">
                            <img alt="图片3未上传" id="pic3" width="450" height="300" class="col-xs-offset-1"
                                 src="{{$data->other_image}}">
                            <!--src="http://mp2.local.jojin.com/storage/rbcx/2016-11-22/1531/821597a330b2c5497127f27c423a963a.png"-->
                        </a>
                    </div>
                    <div class="mt-20 row cl col-xs-offset-5">
                        <form method="POST" action="{{route('ajaxUpload')}}" accept-charset="UTF-8" id="avatar2"
                              enctype="multipart/form-data">
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;其他保单</span>
                            <span class="btn-upload">
                                <div class="btn btn-primary radius"><i class="iconfont">&#xf0020;</i> 浏览文件</div>
                            <input class="input-file " id="image2" name="imgFile" type="file"
                                   onchange="ajaxUpload(this,'other_image')">
                            </span>
                        </form>
                    </div>
                </div>

                <div class="tabCon">
                    @include('backend.carInsurance.showTable',  ['table' => $carInsuranceOrderPresenter->getPaymentLogTableParams(),'data'=>$paymentLog])

                </div>


                <!-------------------参保险种start----------------------------->

            @include('backend.carInsurance.showPolicy')



            <!-------------------参保险种end----------------------------->

                <!--  预冻结表信息 -->
                <!----------分期信息START--------->
                <div class="tabCon">
                    @include('backend.carInsurance.showTable',  ['table' => $carInsuranceOrderPresenter->getFreezeTableParams(),'data'=>$freeze])
                </div>
                <!-- end -->
            </div>
        </form>
    </div>
@endsection

@section('after.js')
    <script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
    <script src="/lib/jquery/jquery.form.js"></script>


    <script type="application/javascript">
        function ajaxUpload(obj, image_name) {
            var formdata = new FormData();
            var v_this = $(obj);
            $('#upfileDetail').value = v_this.val();
            var fileObj = v_this.get(0).files;
            var target = v_this.attr('target');
            url = '{{route('ajaxUpload')}}';
//var fileObj=document.getElementById("fileToUpload").files;
            formdata.append("imgFile", fileObj[0]);
            formdata.append("_token", '{{csrf_token()}}');
            formdata.append('filed', image_name);
            formdata.append('id', '{{$data->id}}');
            $.ajax({
                url: url,
                type: 'post',
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function (xmlhttp) {
                    $('#' + target).attr('src', '/static/car-insurance/loading.gif');
                },
                success: function (res) {
                    //alert(res.data);
                    if (res.code == 200) {
                        if (image_name == 'business_money_image') {
                            $('#pic1').attr('src', '{{config('carInsurance.store.domain')}}' + res.data+"?"+ Math.random());
                            $('#apic1').attr('href', '{{config('carInsurance.store.domain')}}' + res.data +"?"+Math.random());
                        }
                        if (image_name == 'force_money_image') {
                            $('#pic2').attr('src', '{{config('carInsurance.store.domain')}}' + res.data +"?"+Math.random());
                            $('#apic2').attr('href', '{{config('carInsurance.store.domain')}}' + res.data +"?"+Math.random());
                        }
                        if (image_name == 'other_image') {
                            $('#pic3').attr('src', '{{config('carInsurance.store.domain')}}' + res.data +"?"+Math.random());
                            $('#apic3').attr('href', '{{config('carInsurance.store.domain')}}' + res.data +"?"+Math.random());
                        }
                        //$('#' + target).attr('src', '{{url('backend/carInsurance/showFile?path=')}}' + res.data);
                        //$('input[name="' + target + '"]').val(res.data);
                    } else {
                        layer.msg(res.msg);
                        //alert(res.msg);
                    }
                }
            });
        }

    </script>




    <script type="text/javascript">
        $(function () {
            $.Huitab("#tab_demo .tabBar span", "#tab_demo .tabCon", "current", "click", "0");
        });
        $(function () {
            $.Huitab("#card_demo .card_tabBar span", "#card_demo .card_tabCon", "current", "click", "0");
        });

        $(document).ready(function () {


            var options = {
                beforeSubmit: showRequest,
                success: showResponse,
                dataType: 'json'
            };
            /*
             $('#image').on('change', function () {
             console.log("试着提交image");
             console.log($("#avatar").serialize());

             /!*                $.ajax({
             url: "",
             type: "post",
             dataType: "json",
             data: $('#avatar').serialize(),
             sucess: function (res) {
             alert(res)
             },
             error: function (err) {
             alert('no');
             }

             });*!/


             // $('#avatar').ajaxForm(options).submit();
             });
             */


            /* $('#image1').on('change', function () {
             console.log("试着提交image1");
             console.log($('#avatar1').ajaxForm(options))
             ;

             });
             $('#image2').on('change', function () {
             console.log("试着提交image2");
             $('#avatar2').ajaxForm(options).submit();
             });*/
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

        function table_reload(){
            parent.location.reload();
        }
        function submit_table_delete_from(obj) {
            $.ajax({
                url: obj.dataset.url,

                data: {
                    _method: 'delete',
                    _token: '{{csrf_token()}}'
                },
                type: "POST",
                //    dataType: 'json',
                beforeSend: function (xmlhttp) {
                },
                success: function (data) {
                    if(data=='不能删除已生效的订单' || data=="删除失败，请重试") {
                        layer.msg(data);
                    } else {
                        layer.msg(data);
                        setTimeout(table_reload, 2000);
                        //parent.location.reload();
                    }
                    //   layer_close();
                },
                error: function (er) {

                }

            });

        }
        function callback(){
            parent.location.reload();
            //window.parent.location.href = "{{route('backend.carInsurance.order.pendingOrder')}}";
            //parent.$("#parent_refresh").click();
            var index = parent.layer.getFrameIndex(window.name); //获取当前index
            parent.layer.close(index);//这就成功了
        }
        function takeOrder(self, id) {
            $.ajax({
                url: '{{route('backend.carInsurance.order.takeOrder', ['id'=>$data->id])}}',
                type: 'get',
                success: function (data) {
                    if (data == 1) {
                        layer.msg("领取成功");
                        setTimeout(callback, 2000);
                        //window.parent.location.href = "{{route('backend.carInsurance.order.pendingOrder')}}";
                        //parent.$("#parent_refresh").click();
                        //var index = parent.layer.getFrameIndex(window.name); //获取当前index
                        //parent.layer.close(index);//这就成功了
                        //setTimeOut();

                        //window.location.href = "{{route('backend.carInsurance.order.pendingOrder')}}";
                    }
                    if (data == 0) {
                        layer.msg("领取失败，请重试");
                    }

                    //window.opener = null;
                    //window.close();
                }
            });
        }
        function refresh_status(){
            window.location.href = '{{route('backend.carInsurance.order.show', ['id'=>$data->id])}}';
            //window.
        }
        function setStatus(status) {
            $.ajax({
                url: '{{route('backend.carInsurance.order.setStatus', ['id'=>$data->id])}}' + "&status=" + status,
                type:'get',
                success: function(data){
                    layer.msg(data);
                    setTimeout(refresh_status, 2000);
                    //backend.carInsurance.order.takeOrder
                    /*if(data==1){
                     layer.msg("设置状态成功");
                     } else {
                     layer.msg("设置状态失败，请重试");
                     }*/
                }
            });
        }
        function startPay() {
            var r = confirm("确定发起支付请求?");
            if (r==true)
            {
                var index = layer.open({type:3});
                $.ajax({
                    url: '{{route('backend.carInsurance.order.charge', ['id'=>$data->id])}}',
                    type: 'get',
                    success: function (data) {
                        layer.close(index);
                        layer.msg(data);
                        setTimeout(refresh_status, 2000);
                    }
                });
            }
        }

        function setOk(id){
            var r = confirm('确定重置异常？');
            if(r==true){
                var index = layer.open({type:3});
                $.ajax({
                    url: '/backend/carInsurance/correctError?id='+id,
                    type:'get',
                    success: function(data){
                        layer.close(index);
                        layer.msg(data.msg);
                        setTimeout(callback, 2000);
                    }
                });
            }
        }
    </script>

@endsection
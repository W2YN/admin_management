@extends('backend.layout.window')
@inject('CarInsuranceOrderPresenter','App\Presenters\CarInsuranceOrderPresenter')
@section('content')
    <div class="page-container">
        <form class="form form-horizontal" id="form-article-add" method="post"
              action="{{url('backend/carInsurance/order/'.$data->id)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}
            <div id="tab_demo" class="HuiTab">
                <div class="tabBar cl">
                    <span>基本信息</span>
                    <span>车主信息</span>
                    <span>车辆信息</span>
                    <span>其他信息</span>
                </div>

                <!--------基本信息START--------->
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">订单号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" value="{{old('num', $data->num)}}" placeholder=""
                                   id="num" name="num" disabled>

                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">保单类型：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <select class="select" name="policy_type" id="policy_type" style="width: 200px;">
                                @forelse($policyType as $key=>$value)
                                    <option
                                            value="{{$key}}"
                                            @if($key == old('policy_type', $data->policy_type))
                                            selected
                                            @endif
                                    >
                                        {{trans($value)}}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">期数：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <select class="select" name="amount" id="amount" style="width: 200px;">
                                @forelse ($amountOptions as $key => $value)
                                    <option
                                            value="{{$key}}"
                                            @if($key == old('amount', $data->amount))
                                            selected
                                            @endif
                                    >
                                        {{trans($value)}}
                                    </option>
                                @empty
                                @endforelse
                            </select>

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">商业险：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text"
                                   value="{{old('business_money', $data->business_money)}}" placeholder=""
                                   id="business_money" name="business_money">

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">交强险：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" value="{{old('force_money', $data->force_money)}}"
                                   placeholder=""
                                   id="force_money" name="force_money">

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车船税：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" value="{{old('travel_tax', $data->travel_tax)}}"
                                   placeholder=""
                                   id="travel_tax" name="travel_tax">

                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">保险期间开始时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text"
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true,readOnly:false})"
                                   id="policy_start_date" name="policy_start_date"
                                   value="{{old('policy_start_date', $data->policy_start_date)}}"
                                   class="input-text Wdate" style="width:200px;">

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">保险期间结束时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text"
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true,readOnly:false})"
                                   id="policy_end_date" name="policy_end_date"
                                   value="{{old('policy_end_date', $data->policy_end_date)}}"
                                   class="input-text Wdate" style="width:200px;">


                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">创建时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text"
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true,readOnly:false})"
                                   id="create_time" name="create_time"
                                   value="{{old('create_time', $data->create_time)}}"
                                   class="input-text Wdate" style="width:200px;">

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">状态：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <select class="select" name="status" id="status" style="width: 200px;">
                                @forelse ($status as $key => $value)
                                    <option
                                            value="{{$key}}"
                                            @if($key == old('status', $data->status))
                                            selected
                                            @endif
                                    >
                                        {{trans($value)}}
                                    </option>
                                @empty
                                @endforelse
                            </select>

                        </div>
                    </div>

                </div>
                <!--------基本信息END----------->

                <!--------车主信息START--------->
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车主姓名：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" name="car_owner" id="car_owner" class="input-text"
                                   value="{{ $data->car_owner }}">

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">手机号码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text"
                                   value="{{old('owner_mobile', $data->owner_mobile)}}"
                                   placeholder=""
                                   id="owner_mobile" name="owner_mobile">


                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车主身份证：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text"
                                   value="{{old('owner_id_number', $data->owner_id_number)}}"
                                   placeholder=""
                                   id="owner_id_number" name="owner_id_number">


                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">地　　区：</label>
                        <div class="formControls col-xs-8 col-sm-9">

                            <select class="select" name="owner_province" id="owner_province"
                                    value="{{old('owner_province', $data->owner_province)}}"
                                    style="width: 180px;"></select>
                            <select class="select" name="owner_city" id="owner_city"
                                    value="{{old('owner_city', $data->owner_city)}}"
                                    style="width: 180px;"></select>

                            <select class="select" name="owner_area" id="owner_area"
                                    value="{{old('owner_area', $data->owner_area)}}"
                                    style="width: 180px;"></select>

                            {{--{{ $data->owner_province.$data->owner_city.$data->owner_area.$data->owner_address }}--}}
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">详细地址：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text"
                                   value="{{old('owner_address', $data->owner_address)}}"
                                   placeholder=""
                                   id="owner_address" name="owner_address">

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">微信OpenID：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text"
                                   value="{{old('weixinOpenId', $data->weixinOpenId)}}"
                                   placeholder=""
                                   id="weixinOpenId" name="weixinOpenId" disabled>

                        </div>
                    </div>

                </div>
                <!--------车主信息END----------->

                <!----------车辆信息START--------->
                <div class="tabCon">

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">机动车种类：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <select class="select" name="car_type" id="car_type" style="width: 200px;">
                                @forelse ($carType as $key => $value)
                                    <option
                                            value="{{$key}}"
                                            @if($key == old('car_type',$data->car_type ))
                                            selected
                                            @endif
                                    >
                                        {{trans($value)}}
                                    </option>
                                @empty
                                @endforelse
                            </select>

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">使用性质：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <select class="select" name="car_use_property" id="car_use_property" style="width: 200px;">
                                @forelse ($carUseProperty as $key => $value)
                                    <option
                                            value="{{$key}}"
                                            @if($key == old('car_use_property',$data->car_use_property ))
                                            selected
                                            @endif
                                    >
                                        {{trans($value)}}
                                    </option>
                                @empty
                                @endforelse
                            </select>

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车辆品牌：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <select class="select" name="car_brand" id="car_brand" style="width: 200px;">
                                @forelse ($carBrand as $key => $value)
                                    <option
                                            value="{{$key}}"
                                            @if($key == old('car_brand',$data->car_brand ))
                                            selected
                                            @endif
                                    >
                                        {{trans($value)}}
                                    </option>
                                @empty
                                @endforelse
                            </select>

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">号牌颜色：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <select class="select" name="car_plate_color" id="car_plate_color" style="width: 200px;">
                                @forelse ($carPlateColor as $key => $value)
                                    <option
                                            value="{{$key}}"
                                            @if($key == old('car_plate_color',$data->car_plate_color ))
                                            selected
                                            @endif
                                    >
                                        {{trans($value)}}
                                    </option>
                                @empty
                                @endforelse
                            </select>

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车辆型号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" id="car_model" name="car_model"
                                   value="{{old('car_model', $data->car_model)}}" placeholder="">

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">发动机号码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" id="car_engine_num" name="car_engine_num"
                                   value="{{old('car_engine_num', $data->car_engine_num)}}" placeholder="">

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">车辆识别代码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" id="car_vin_code" name="car_vin_code"
                                   value="{{old('car_vin_code', $data->car_vin_code)}}" placeholder="">

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">核定载客：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" id="car_rated_passenger" name="car_rated_passenger"
                                   value="{{old('car_rated_passenger', $data->car_rated_passenger)}}" placeholder="">

                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">注册日期：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text"
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true,readOnly:false})"
                                   id="car_register_date" name="car_register_date"
                                   value="{{old('car_register_date', $data->car_register_date)}}"
                                   class="input-text Wdate" style="width:200px;">


                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">发证日期：</label>
                        <div class="formControls col-xs-8 col-sm-9">

                            <input type="text"
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true,readOnly:false})"
                                   id="car_certificate_date" name="car_certificate_date"
                                   value="{{old('car_certificate_date', $data->car_certificate_date)}}"
                                   class="input-text Wdate" style="width:200px;">


                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">检验记录：</label>
                        <div class="formControls col-xs-8 col-sm-9">

                            <input type="text"
                                   onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true,readOnly:false})"
                                   id="car_Inspection_record" name="car_Inspection_record"
                                   value="{{old('car_Inspection_record', $data->car_Inspection_record)}}"
                                   class="input-text Wdate" style="width:200px;">

                        </div>
                    </div>


                </div>

                <!----------车辆信息END---------->

                <!----------其他信息START--------->
                <div class="tabCon">


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">来源类型：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" id="ft" name="ft"
                                   value="{{old('ft', $data->ft)}}" placeholder="" disabled>

                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">来源iP：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" class="input-text" id="fid" name="fid"
                                   value="{{old('fid', $data->fid)}}" placeholder="" disabled>
                        </div>
                    </div>


                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">行驶证图片：</label>
                        <input type="hidden" name="driving_license_file"
                               value="{{old('driving_license_file',$data->driving_license_file)}}">

                        <div class="formControls col-xs-8 col-sm-9">
                            <img src="{{ $data->driving_license_file ? url('backend/carInsurance/showFile?path='.$data->driving_license_file): '/static/car-insurance/not-upload.jpg' }}"
                                 alt="" onclick="uploadButton(this)" id="driving_license_file"
                                 class="driving_license_file" width="200px" height="200px">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">身份证图片：</label>
                        <input type="hidden" name="identity_card_file"
                               value="{{old('identity_card_file',$data->identity_card_file)}}">
                        <div class="formControls col-xs-8 col-sm-9">
                            <img src="{{$data->identity_card_file?
                            url('backend/carInsurance/showFile?path='.$data->identity_card_file):'/static/car-insurance/not-upload.jpg' }}"
                                 alt="" onclick="uploadButton(this)" id="identity_card_file"
                                 class="identity_card_file" width="200px" height="200px">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">备注：</label>
                        <div class="formControls col-xs-8 col-sm-9">

                            <textarea name="remark" cols="" rows="" class="textarea valid"
                                      placeholder="说点什么...最少输入10个字符"
                                      onkeyup="textarealength(this,255)">{{ $data->remark }}</textarea>
                            {{--<p class="textarea-numberbar"><em class="textarea-length">0</em>/255</p>--}}
                        </div>
                    </div>


                </div>
                <!----------其他信息END---------->

            </div>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>


        <input id="pathDetail" target="" type="file" multiple="true" name="pathDetail" accept="image/*"
               onchange="ajaxUpload(this)" style="display:none;">
    </div>
@endsection

@section('after.js')
    <script type="text/javascript" src="/lib/PCASClass/PCASClass.js"></script>
    <script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript">
        new PCAS("owner_province={{old('owner_province',$data->owner_province)}}", "owner_city={{old('owner_city',$data->owner_city)}}", "owner_area=>{{old('owner_area',$data->owner_area)}}");

        $(function () {
            $.Huitab("#tab_demo .tabBar span", "#tab_demo .tabCon", "current", "click", "0");
        });


        function uploadButton(obj) {
            var pathDetail = $('#pathDetail');
            pathDetail.attr('target', $(obj).attr('id'));
            pathDetail.click()
        }

        function ajaxUpload(obj) {
            var formdata = new FormData();
            var v_this = $(obj);
            $('#upfileDetail').value = v_this.val();
            var fileObj = v_this.get(0).files;
            var target = v_this.attr('target');
            url = '{{route('ajaxUpload')}}';
//var fileObj=document.getElementById("fileToUpload").files;
            formdata.append("imgFile", fileObj[0]);
            formdata.append("_token", '{{csrf_token()}}');
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
                    if (res.code == 200) {
                        $('#' + target).attr('src', '{{url('backend/carInsurance/showFile?path=')}}' + res.data);
                        $('input[name="' + target + '"]').val(res.data);
                    } else {
                        alert(res.msg);
                    }
                }
            });
        }
    </script>
@endsection
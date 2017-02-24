<div id="tab_demo" class="HuiTab">
    <div class="tabBar cl">
        <span>基本信息</span>
        <span>车主信息</span>
        <span>车辆信息</span>
        <span>其他信息</span>
        @if($formType == 'create')
            <span>信用卡信息</span>
            @else
           <span>参保险种</span>
        @endif
    </div>

    <!--------基本信息START--------->
    <div class="tabCon">

        @if($formType == 'update')
            <div class="row cl">
                {!! Form::label('num','订单号：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

                <div class="formControls col-xs-8 col-sm-9">

                    {!! Form::text('num',null,['class'=>"input-text",'disabled']) !!}

                </div>
            </div>
        @endif

        <div class="row cl">
            {!! Form::label('policy_type','保单类型：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::select('policy_type',$policyType,null,['class'=>"select"]) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('amount','期数：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::select('amount',$amountOptions,null,['class'=>"select"]) !!}

            </div>
        </div>


        <div class="row cl">
            {!! Form::label('business_money','商业险：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('business_money',null,['class'=>"input-text"]) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('force_money','交强险：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('force_money',null,['class'=>"input-text"]) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('travel_tax','车船税：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('travel_tax',null,['class'=>"input-text"]) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('policy_start_date','保险开始时间：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('policy_start_date', isset($data)?$data['policy_start_date']:"",['class'=>"input-text Wdate",'style'=>'width:200px;','onfocus'=>'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss",alwaysUseStartDate:true,readOnly:true})']) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('policy_end_date','保险结束时间：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('policy_end_date', isset($data)?$data['policy_end_date']:"",['class'=>"input-text Wdate",'style'=>'width:200px;','onfocus'=>'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss",alwaysUseStartDate:true,readOnly:true})']) !!}

            </div>
        </div>

        @if($formType == 'update')
            <div class="row cl">
                {!! Form::label('created_at','创建时间：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

                <div class="formControls col-xs-8 col-sm-9">

                    {!! Form::text('created_at',null,['class'=>"input-text",'style'=>'width:200px;','disabled']) !!}

                </div>
            </div>
        @endif

        <div class="row cl">
            {!! Form::label('status','状态：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::select('status',$status,null,['class'=>"select",'style'=>'width:200px;','disabled']) !!}

            </div>
        </div>


    </div>
    <!--------基本信息END----------->

    <!--------车主信息START--------->
    <div class="tabCon">

        <div class="row cl">
            {!! Form::label('car_owner','车主姓名：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('car_owner',null,['class'=>"input-text"]) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('owner_mobile','手机号码：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('owner_mobile',null,['class'=>"input-text"]) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('owner_id_number','车主身份证：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('owner_id_number',null,['class'=>"input-text"]) !!}

            </div>
        </div>


        <div class="row cl">
            {!! Form::label('owner_province','地区：',['class'=>'form-label col-xs-4 col-sm-2']) !!}
            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::select('owner_province',[],null,['class'=>'select' ,'style'=>'width: 180px;']) !!}
                {!! Form::select('owner_city',[],null,['class'=>'select' ,'style'=>'width: 180px;']) !!}
                {!! Form::select('owner_area',[],null,['class'=>'select' ,'style'=>'width: 180px;']) !!}



                {{--{{ $data->owner_province.$data->owner_city.$data->owner_area.$data->owner_address }}--}}
            </div>
        </div>

        <div class="row cl">
            {!! Form::label('owner_address','详细地址：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('owner_address',null,['class'=>"input-text"]) !!}

            </div>
        </div>

        @if($formType == 'update')
            <div class="row cl">
                {!! Form::label('weixinOpenId','微信OpenID：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

                <div class="formControls col-xs-8 col-sm-9">

                    {!! Form::text('weixinOpenId',null,['class'=>"input-text",'disabled']) !!}

                </div>
            </div>
        @endif

    </div>
    <!--------车主信息END----------->

    <!----------车辆信息START--------->
    <div class="tabCon">


        <div class="row cl">
            {!! Form::label('car_type','机动车种类：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::select('car_type',$carType,null,['class'=>"select",'style'=>'width:200px;']) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('car_use_property','使用性质：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::select('car_use_property',$carUseProperty,null,['class'=>"select",'style'=>'width:200px;']) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('car_brand','车辆品牌：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::select('car_brand',$carBrand,null,['class'=>"select",'style'=>'width:200px;']) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('car_plate_color','号牌颜色：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::select('car_plate_color',$carPlateColor,null,['class'=>"select",'style'=>'width:200px;']) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('car_model','车辆型号：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('car_model',null,['class'=>"input-text"]) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('car_engine_num','发动机号码：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('car_engine_num',null,['class'=>"input-text"]) !!}

            </div>
        </div>


        <div class="row cl">
            {!! Form::label('car_vin_code','车辆识别代码：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('car_vin_code',null,['class'=>"input-text"]) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('car_rated_passenger','核定载客：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::number('car_rated_passenger',null,['class'=>"input-text"]) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('car_register_date','注册日期：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('car_register_date',null,['class'=>"input-text Wdate",'style'=>'width:200px;','onfocus'=>'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss",alwaysUseStartDate:true,readOnly:true})']) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('car_certificate_date','发证日期：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('car_certificate_date',null,['class'=>"input-text Wdate",'style'=>'width:200px;','onfocus'=>'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss",alwaysUseStartDate:true,readOnly:true})']) !!}

            </div>
        </div>


        <div class="row cl">
            {!! Form::label('car_Inspection_record','检验记录：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('car_Inspection_record',null,['class'=>"input-text Wdate",'style'=>'width:200px;','onfocus'=>'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss",alwaysUseStartDate:true,readOnly:true})']) !!}

            </div>
        </div>


    </div>

    <!----------车辆信息END---------->

    <!----------其他信息START--------->
    <div class="tabCon">


        <div class="row cl">
            {!! Form::label('ft','来源类型：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('ft',null,['class'=>"input-text", 'disabled']) !!}

            </div>
        </div>

        <div class="row cl">
            {!! Form::label('fid','来源ID：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

            <div class="formControls col-xs-8 col-sm-9">

                {!! Form::text('fid',null,['class'=>"input-text", 'disabled']) !!}

            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">行驶证图片：</label>

            {!! Form::hidden('driving_license_file') !!}

            <div class="formControls col-xs-8 col-sm-9">
                <img src="{{ isset($data) ? $data->driving_license_file: '/static/car-insurance/not-upload.jpg'}}"
                     alt="" onclick="uploadButton(this)" id="driving_license_file"
                     class="driving_license_file" width="200px" height="200px">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">身份证图片：</label>

            {!! Form::hidden('identity_card_file') !!}

            <div class="formControls col-xs-8 col-sm-9">
                <img src="{{ isset($data)? $data->identity_card_file: '/static/car-insurance/not-upload.jpg'}}"
                     alt="" onclick="uploadButton(this)" id="identity_card_file"
                     class="identity_card_file" width="200px" height="200px">
            </div>
        </div>
        <div class="row cl">
            {!! Form::label('remark','备注：',['class'=>'form-label col-xs-4 col-sm-2']) !!}
            <div class="formControls col-xs-8 col-sm-9">

                {!!  Form::textarea('remark',null,['class'=>"textarea valid",'placeholder'=>'说点什么...最多可输入255个字符','onkeyup'=>'textarealength(this,255)'])  !!}
                {{--<p class="textarea-numberbar"><em class="textarea-length">0</em>/255</p>--}}
            </div>
        </div>


    </div>
    <!----------其他信息END---------->

@if($formType == 'create')
    <!----------信用卡信息START--------->
        <div class="tabCon">
            <div class="row cl">
                <div class="row cl">
                    {!! Form::label('name','持卡人姓名：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

                    <div class="formControls col-xs-8 col-sm-9">

                        {!! Form::text('name',null,['class'=>"input-text"]) !!}

                    </div>
                </div>

            </div>

            <div class="row cl">

                <div class="row cl">
                    {!! Form::label('card','卡号：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

                    <div class="formControls col-xs-8 col-sm-9">

                        {!! Form::text('card',null,['class'=>"input-text"]) !!}

                    </div>
                </div>


            </div>


            <div class="row cl">
                <div class="row cl">
                    {!! Form::label('id_number','持卡人身份证信息：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

                    <div class="formControls col-xs-8 col-sm-9">

                        {!! Form::text('id_number',null,['class'=>"input-text"]) !!}

                    </div>
                </div>


            </div>

            <div class="row cl">
                <div class="row cl">
                    {!! Form::label('phone_number','预留手机号码：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

                    <div class="formControls col-xs-8 col-sm-9">

                        {!! Form::text('phone_number',null,['class'=>"input-text"]) !!}

                    </div>
                </div>

            </div>

            <!--
            <div class="row cl">
                <div class="row cl">
                    {!! Form::label('last_check','最后一次有效性：',['class'=>'form-label col-xs-4 col-sm-2']) !!}

                    <div class="formControls col-xs-8 col-sm-9">

                        {!! Form::text('last_check',null,['class'=>"input-text Wdate",'style'=>'width:200px;','onfocus'=>'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss",alwaysUseStartDate:true,readOnly:true})']) !!}

                    </div>
                </div>

            </div>-->
        </div>
        <!----------信用卡信息END---------->

    @else
     @include('backend.carInsurance.editPolicy')
    @endif

</div>

<div class="row cl">
    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
        {!! Form::submit('&nbsp;&nbsp;保存&nbsp;&nbsp;',['class'=>'btn btn-primary radius'])!!}
    </div>
</div>

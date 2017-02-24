@extends('backend.layout.window')
{{--@inject('CarInsuranceOrderPresenter','App\Presenters\CarInsuranceOrderPresenter')--}}
@section('content')
    <div class="page-container">
        {!! Form::open(['url' => 'backend/waterPurifier/order', 'method' => 'post','class'=>'form form-horizontal', 'id'=>'form-article-add' ]) !!}
        <div class="row cl">
            {!! Form::label('name','申请人姓名：',['class'=>'form-label col-xs-4 col-sm-2']) !!}
            <div class="formControls col-xs-8 col-sm-9">
                {!! Form::text('name',null,['class'=>"input-text"]) !!}
            </div>
        </div>
        <div class="row cl">
            {!! Form::label('mobile','手机号：',['class'=>'form-label col-xs-4 col-sm-2']) !!}
            <div class="formControls col-xs-8 col-sm-9">
                {!! Form::text('mobile',null,['class'=>"input-text"]) !!}
            </div>
        </div>
        <div class="row cl">
            {!! Form::label('id_number','身份证号：',['class'=>'form-label col-xs-4 col-sm-2']) !!}
            <div class="formControls col-xs-8 col-sm-9">
                {!! Form::text('id_number',null,['class'=>"input-text"]) !!}
            </div>
        </div>
        <div class="row cl">
            {!! Form::label('location','所在地区：',['class'=>'form-label col-xs-4 col-sm-2']) !!}
            <div class="formControls col-xs-8 col-sm-9">
                {!! Form::select('province',[],null,['class'=>'select' ,'style'=>'width: 180px;']) !!}
                {!! Form::select('city',[],null,['class'=>'select' ,'style'=>'width: 180px;']) !!}
                {!! Form::select('area',[],null,['class'=>'select' ,'style'=>'width: 180px;']) !!}
            </div>
        </div>
        <div class="row cl">
            {!! Form::label('amount','安装数量：',['class'=>'form-label col-xs-4 col-sm-2']) !!}
            <div class="formControls col-xs-8 col-sm-9">
                {!! Form::select('amount',$amounts,null,['class'=>"select",'style'=>'width:200px;']) !!}
            </div>
        </div>
        <div class="row cl">
            {!! Form::label('install_time','安装时间：',['class'=>'form-label col-xs-4 col-sm-2']) !!}
            <div class="formControls col-xs-8 col-sm-9">
                {!! Form::text('install_time', null,['class'=>"input-text Wdate",'style'=>'width:200px;','onfocus'=>'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss",alwaysUseStartDate:true,readOnly:true})']) !!}
                注:滤芯维护时间根据安装时间进行推算
            </div>

        </div>

        <div class="row cl">
            {!! Form::label('address','详细安装地址：',['class'=>'form-label col-xs-4 col-sm-2']) !!}
            <div class="formControls col-xs-8 col-sm-9">
                {!! Form::text('address',null,['class'=>"input-text",'style'=>'width:200px;']) !!}
            </div>
        </div>

        <div class="row cl">
            {!! Form::label('sale_code','推荐人ID：',['class'=>'form-label col-xs-4 col-sm-2']) !!}
            <div class="formControls col-xs-8 col-sm-9">
                {!! Form::text('sale_code',null,['class'=>"input-text",'style'=>'width:200px;']) !!}
            </div>
        </div>


        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                {!! Form::submit('&nbsp;&nbsp;保存&nbsp;&nbsp;',['class'=>'btn btn-primary radius'])!!}
            </div>
        </div>
        {!! Form::close() !!}

    </div>

@endsection
@section('after.js')
    <script type="text/javascript" src="/lib/PCASClass/PCASClass.js"></script>
    <script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript">
        new PCAS("province=''", "city=''", "area=>''");
    </script>

@endsection
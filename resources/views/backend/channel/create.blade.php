@extends('backend.layout.window')
@section('content')
    <article class="page-container">
        <form action="{{route('backend.channel.store')}}" method="post" class="form form-horizontal" id="form-member-add">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{old('username')}}" placeholder="数字字母下划线,4-12位" id="username" name="username">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{old('password')}}" placeholder="数字字母下划线,6-20位(必须包含数字与小写字母)" id="password" name="password">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>来源类型：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{old('from_type')}}" placeholder="数字字母下划线,4-12位" id="from_type" name="from_type">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">简介：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{old('intro')}}" placeholder="渠道简介" id="intro" name="intro">
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection

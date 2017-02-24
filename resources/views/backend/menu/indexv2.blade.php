@extends('backend.layout.frame')
@inject('menuPresenter','App\Presenters\MenuPresenter')
@section('content')
    <!-- 搜索栏 开始 -->
    {{--<script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>--}}

    <div class="page-container">
        {{--<form class="form-inline" action="{{route('backend.menu.search')}}" method="GET">--}}
            {{--<div class="text-c">--}}
                {{--<span class="select-box inline">--}}
                {{--<select class="select" name="parent_id">--}}
                    {{--@forelse ($topMenus as $value => $title)--}}
                        {{--<option--}}
                                {{--value="{{$value}}"--}}
                                {{--@if($value == old('parent_id'))--}}
                                {{--selected--}}
                                {{--@endif--}}
                        {{-->--}}
                            {{--{{trans($title)}}--}}
                        {{--</option>--}}
                    {{--@empty--}}
                    {{--@endforelse--}}
                {{--</select>--}}
                {{--</span>--}}
                {{--<input type="text" name="name" id="name" placeholder=" 菜单名称" style="width:250px" class="input-text">--}}
                {{--日期范围：--}}
                {{--<input type="text"--}}
                       {{--onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'datetimeMax\')||\'%y-%M-%d\'}',dateFmt:'yyyy-MM-dd 00:00:00'})"--}}
                       {{--id="datetimeMin"--}}
                       {{--class="input-text Wdate" style="width:120px;">--}}
                {{-----}}
                {{--<input type="text"--}}
                       {{--onfocus="WdatePicker({minDate:'#F{$dp.$D(\'datetimeMin\')}',maxDate:'%y-%M-%d',dateFmt:'yyyy-MM-dd 23:59:59'})"--}}
                       {{--id="datetimeMax"--}}
                       {{--class="input-text Wdate" style="width:120px;">--}}
                {{--<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 筛选--}}
                {{--</button>--}}
            {{--</div>--}}
        {{--</form>--}}
        <!-- 搜索栏 结束 -->
        @include('backend.components.searchv2',  ['search' => $menuPresenter->getSearchParams()])
        <!-- 按钮栏 开始 -->
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            {{--<span class="l">--}}
                {{--<a class="btn btn-primary radius" href="javascript:;"--}}
                   {{--onclick="admin_role_add('添加菜单','{{route('backend.menu.create')}}','800')">--}}
                    {{--<i class="Hui-iconfont">&#xe600;</i>--}}
                    {{--添加菜单--}}
                {{--</a>--}}
            {{--</span>--}}
            @include('backend.components.handlev2',  ['handle' => $menuPresenter->getHandleParams()])
            <span class="r">共有数据：<strong>{{$data->total()}}</strong> 条</span>
        </div>
        <!-- 按钮栏 结束 -->

        @include('backend.components.table',  ['table' => $menuPresenter->getTableParams()])
    </div>
@endsection

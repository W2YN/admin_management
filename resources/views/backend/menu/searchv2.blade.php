@extends('backend.layout.frame')
@inject('menuPresenter','App\Presenters\MenuPresenter')
@section('content')


    <div class="page-container">
        @include('backend.components.searchv2',  ['search' => $menuPresenter->getSearchParams()])
        <!-- 按钮栏 开始 -->
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            @include('backend.components.handlev2',  ['handle' => $menuPresenter->getHandleParams()])
            <span class="r">共有数据：<strong>{{$data->total()}}</strong> 条</span>
        </div>
        <!-- 按钮栏 结束 -->
        @include('backend.components.table',  ['table' => $menuPresenter->getTableParams()])
    </div>
@endsection

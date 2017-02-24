@extends('backend.layout.frame')
@inject('financialExpressPresenter','App\Presenters\Financial\ExpressPresenter')
@section('content')
    <div class="page-container">
        @include('backend.components.searchv2',  ['search' => $financialExpressPresenter->getSearchParams()])
                <!-- 按钮栏 开始 -->
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            @include('backend.components.handlev2',  ['handle' => $financialExpressPresenter->getHandleParams()])
            <span class="r">共有数据：<strong>{{$data->total()}}</strong> 条</span>
        </div>
        <!-- 按钮栏 结束 -->

        @include('backend.components.tablev2',  ['table' => $financialExpressPresenter->getTableParams()])
    </div>
@endsection

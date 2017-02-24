@extends('backend.layout.frame')
@inject('contractPresenter','App\Presenters\ContractPresenter')
@section('content')
    <div class="page-container">
        @include('backend.components.searchv2',  ['search' => $contractPresenter->getSearchParams()])
                <!-- 按钮栏 开始 -->
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            @include('backend.components.handlev2',  ['handle' => $contractPresenter->getHandleParams()])
            <span class="r">共有数据：<strong>{{$data->total()}}</strong> 条</span>
        </div>
        <!-- 按钮栏 结束 -->

        @include('backend.components.tablev2',  ['table' => $contractPresenter->getTableParams()])
    </div>
@endsection

@section('after.js')
    <script type="text/javascript">

        function openUrl( obj, url )
        {
            url = url.replace('id', $(obj).data('id'));
            //console.debug(url);
            window.open (url);
        }

    </script>
@endsection
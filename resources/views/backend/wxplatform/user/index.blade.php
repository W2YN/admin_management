@extends('backend.layout.frame')
@inject('wxplatformPresenter','App\Presenters\WxPlatformUserPresenter')
@section('content')
    <div class="page-container">
{{--    @include('backend.components.searchv2',  ['search' => $wxplatformPresenter->getSearchParams()])--}}
    <!-- 按钮栏 开始 -->
        <div class="cl pd-5 bg-1 bk-gray mt-20">
{{--            @include('backend.components.handlev2',  ['handle' => $wxplatformPresenter->getHandleParams()])--}}
            <span class="r">共有数据：<strong>{{$data->total()}}</strong> 条</span>
        </div>
        <!-- 按钮栏 结束 -->

        @include('backend.components.tablev2',  ['table' => $wxplatformPresenter->getTableParams()])
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
    <script type="text/javascript">

        function frame_window_open(title,url,w,h){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
    </script>
@endsection
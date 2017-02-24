@extends('backend.layout.frame')
@inject('channelPresenter','App\Presenters\ChannelPresenter')
@section('content')
    <div class="page-container">
        @include('backend.components.searchv2',  ['search' => $channelPresenter->getSearchParams()])
                <!-- 按钮栏 开始 -->
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            @include('backend.components.handlev2',  ['handle' => $channelPresenter->getHandleParams()])
            <span class="r">共有数据：<strong>{{$data->total()}}</strong> 条</span>
        </div>
        <!-- 按钮栏 结束 -->

        @include('backend.components.tablev2',  ['table' => $channelPresenter->getTableParams()])
    </div>
@endsection

@section('after.js')
<script>
function show(uri, _this){
	var open_url = uri + '/' + $(_this).attr('data-id');
	frame_window_open('渠道详细', open_url, 800, 500);
}
</script>
@endsection
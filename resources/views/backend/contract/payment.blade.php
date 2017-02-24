@extends('backend.layout.frame')
@inject('contractPaymentPresenter','App\Presenters\ContractPaymentPresenter')
@section('content')
    <div class="page-container">
        @include('backend.components.searchv2',  ['search' => $contractPaymentPresenter->getSearchParams()])
                <!-- 按钮栏 开始 -->
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            @include('backend.components.handlev2',  ['handle' => $contractPaymentPresenter->getHandleParams()])
            <span class="r">共有数据：<strong>{{$data->total()}}</strong> 条</span>
        </div>
        <!-- 按钮栏 结束 -->

        @include('backend.components.tablev2',  ['table' => $contractPaymentPresenter->getTableParams()])
    </div>



@endsection

@section('after.js')
    <script type="text/javascript">

        function contractExport( exportUrl )
        {
            var new_url = exportUrl;
            var url = window.location.href;
            if( url.split("?").length > 1 ){
                new_url = exportUrl + '?' + url.split("?")[1];
            }
            //需要做对应的类型判断
            var p;
            if(new_url.indexOf("capitalBills") > 0 || new_url.indexOf('interestBills') > 0){
                var rp = /\d+-\d+-\d+/g;
                p = url.match(rp);
                if(p==null || p[0]==null || p[1]==null){
                    layer.msg("请选择时间段");
                    return;
                }
            }
            if(new_url.indexOf('interestBills') > 0) {
                var minArr = p[0].split("-");
                var min = (new Date).setFullYear(minArr[0], minArr[1], minArr[2]);
                var maxArr = p[1].split("-");
                var max = (new Date).setFullYear(maxArr[0], maxArr[1], maxArr[2]);
                var diff_days = (max-min) / 86400000;
                if(parseInt(diff_days) > 31) {
                    layer.msg("相差天数为" + diff_days + ",已经大于31，请缩小时间跨度");
                    return;
                }
            }

            //判断结束
            //console.debug( '[' , new_url, ']' );
            //frame_window_open('导出',new_url, 500, 500);
            window.location = new_url;
        }

        function payPost( obj, url )
        {
            url = url.replace('id', $(obj).data('id'));
            console.debug(url);
            layer.confirm('确认要设为已支付吗？',function(index){
                //此处请求后台程序，下方是成功后的前台处理……
                payPostSubmit( url, obj );
            });
        }

        function payPostSubmit( url, obj )
        {
            var data = "_token={{ csrf_token() }}";
            $.ajax({
                //cache: true,
                type: 'post',
                url: url,
                data: data,
                error: function(request) {
                    layer.msg(request.responseText,{icon:2,time:0,btn: ['关闭']});
                },
                success: function(data) {
                    $(obj).parents("tr").find(".td_status").html('已支付');
                    layer.msg('已设为已支付!', {icon: 6,time:1000});
                }
            });
        }
    </script>
@endsection

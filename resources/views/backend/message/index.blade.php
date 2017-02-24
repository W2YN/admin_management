@extends('backend.layout.frame')
@inject('MessagePresenter','App\Presenters\MessagePresenter')
@section('content')

    <div class="page-container">
        <div class="btn-group" style="padding: 10px 0;">

            <a title="设为已读" href="javascript:;" onclick="markAllRead()"
               data-formid="del-from-1"
               class="btn btn-primary radius">
                全部设为已读
            </a>
        </div>

    @include('backend.components.searchv2',  ['search' => $MessagePresenter->searchParams()])
    <!-- 按钮栏 开始 -->
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            @include('backend.components.handlev2',  ['handle' => $MessagePresenter->handleParams()])
            <span class="r">共有消息：<strong>{{ $data->total() }}</strong> 条</span>
        </div>
        <!-- 按钮栏 结束 -->

        @include('backend.components.tablev2',  ['table' => $MessagePresenter->tableParams()])
    </div>
@endsection

@section("after.js")
    <script>
        function to_read(title,level,content, id){
            //示范一个公告层
            layer.open({
                type: 1
                ,title: false //不显示标题栏
                ,closeBtn: false
                ,area: '300px;'
                ,shade: 0.8
                ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
                ,btn: [ '关闭']
                ,moveType: 1 //拖拽模式，0或者1
                ,content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">' +
                //'你知道吗？亲！<br>' +
                '' + title + "<br><br>" +
                '' + level + "<br><br>" +
                content + "<br></div>"
                ,success: function(layero){
                    var btn = layero.find('.layui-layer-btn');
                    btn.css('text-align', 'center');
                    //btn.find('.layui-layer-btn0').css('display', 'none');
                    btn.find('.layui-layer-btn0').css('margin-left', '40%');
                    btn.find('.layui-layer-btn0').click(function(){
                        $.ajax({
                            url: '{{route("backend.message.read")}}' + "?id="+id,
                            type:'get',
                            success: function(data){
                                //alert(data);
                                if(parseInt(data) != 1){//并没有成功
                                    layer.msg("警告: 已读设置失败");
                                } else {
                                    //影响体验的东西....
                                    var count = $("#_message_holder", parent.document).html();
                                    if(count != "") {
                                        count = parseInt(count);
                                        $("#_message_holder", parent.document).html(--count!=0? count: "");
                                    }else{
                                        $("#_message_holder", parent.document).html("");
                                    }

                                    window.location.href = "{{route("backend.message.index")}}";
                                }
                            }
                        });
                    });
                    /*btn.find('.layui-layer-btn1').click(function(){
                        $.ajax({
                            url: '{{route("backend.message.read")}}' + "?id="+id,
                            type:'get',
                            success: function(data){
                                if(parseInt(data) != 1){//并没有成功
                                    layer.msg("警告: 已读设置失败");
                                } else {
                                    //影响体验的东西....
                                    window.location.href = "{{route("backend.message.index")}}";
                                }
                            }
                        });
                    });*/
                }
            });
        }
        function have_read_mark(){
            $.ajax({
                url: '{{route("backend.message.read")}}' + "?id="+id,
                type:'get',
                success: function(data){
                    //alert(data);
                    if(parseInt(data) != 1){//并没有成功
                        layer.msg("设置为已读失败，请重试");
                    } else {
                        //影响体验的东西....
                        window.location.href = "{{route("backend.message.index")}}";
                    }
                }
            });
        }
        function markAllRead() {
            $.ajax({
                url: '{{route("backend.message.readAll")}}',
                type:'get',
                success: function(data){
                    //alert(data);
                    if(parseInt(data) != 1){//并没有成功
                        layer.msg("设置为已读失败，请重试");
                    } else {
                        //layer_close();
                        //window.location.reload();
                        parent.location.reload();
                        var index = parent.layer.getFrameIndex(window.name); //获取当前index
                        parent.layer.close(index);//这就成功了
                    }
                }
            });
        }
    </script>
@endsection
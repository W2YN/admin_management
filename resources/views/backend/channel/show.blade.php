@extends('backend.layout.frame')
@inject('waterPurifierPresenter', 'App\Presenters\WaterPurifierPresenter')
@section('content')
    <div class="page-container">
        <form class="form form-horizontal" id="form-article-add">
            <div id="tab_demo" class="HuiTab">
                <div class="tabBar cl"><span>基本信息</span></div>
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">编号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['id'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">用户名：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['username'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">密码：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ gt_encode($data['password'], true) }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">来源类型：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['from_type'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">简介：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['intro'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">创建时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['created_at'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">最后更新：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['updated_at'] }}
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endsection

@section('after.js')
    <script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript">
        $(function () {
            $.Huitab("#tab_demo .tabBar span", "#tab_demo .tabCon", "current", "click", "0");
        });

        function install_time_save_submit()
        {
            var set_install_time = $dp.$('set_install_time').value;
            if( set_install_time == '' ){
                layer.msg("请先选择厂商安装时间",{icon:2,time:2000});
                return ;
            }

            layer.confirm('确定要提交吗？',function(index){
                install_time_post( set_install_time );
            });
//            layer.msg('确定要提交吗？', {
//                time: 0 //不自动关闭
//                ,btn: ['确定','取消']
//                ,yes: function(index){
//                    install_time_post( set_install_time )
//                }
//            });
        }

        function install_time_post( set_install_time )
        {
            var url = '{{route('backend.waterPurifier.updateInstallTime',['id'=>$data['id']])}}';
            var data = "_token={{ csrf_token() }}&install_time=" + set_install_time;
            $.ajax({
                //cache: true,
                type: 'post',
                url: url,
                data: data,
                error: function(request) {
                    //console.debug(request);
                    //_alert('与服务器连接异常');
                    //_alert('<xmp>'+request.responseText+'</xmp>');
                    layer.msg(request.responseText,{icon:2,time:2000});
                },
                success: function(data) {
                    //console.debug( data );
                    layer.msg(data, {
                        time: 0 //不自动关闭
                        ,btn: ['确定']
                        ,yes: function(index){
                            layer.close(index);
                            location.reload();
                        }
                    });
                }
            });
        }


        /*管理员-启用*/
        function maintain_complete(obj,id){
            layer.confirm('确认要设为已执行吗？',function(index){
                //此处请求后台程序，下方是成功后的前台处理……
                maintain_complete_post( id, 1, obj );
            });
        }

        function maintain_complete_post( id, is_complete, obj )
        {
            var url = '{{route('backend.waterPurifier.maintainComplete')}}';
            var data = "_token={{ csrf_token() }}&id=" + id + "&is_complete=" + is_complete;
            console.debug( data );
            $.ajax({
                //cache: true,
                type: 'post',
                url: url,
                data: data,
                error: function(request) {
                    layer.msg(request.responseText,{icon:2,time:0,btn: ['关闭']});
                },
                success: function(data) {
                    //console.debug( data );
                    //$(obj).parents("tr").find(".td-manage").prepend('');
                    $(obj).parents("tr").find(".td-complete").html('已执行');
                    $(obj).remove();
                    layer.msg('已设为已执行!', {icon: 6,time:1000});
                }
            });
        }

    </script>
@endsection

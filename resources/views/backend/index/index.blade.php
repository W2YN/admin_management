@extends("backend.layout.index")
@inject('mainPresenter','App\Presenters\MainPresenter')
@section('after.css')
@endsection

@section("navbar")
    <header class="navbar-wrapper">
        <div class="navbar navbar-fixed-top">
            <div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="#">热讯综合管理平台</a> <span class="logo navbar-slogan f-l mr-10 hidden-xs">v0.1</span> <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
                <nav class="nav navbar-nav">
                    <ul class="cl">
                        <li class="dropDown dropDown_hover"><a href="javascript:;" class="dropDown_A"><i class="Hui-iconfont">&#xe600;</i> 新增 <i class="Hui-iconfont">&#xe6d5;</i></a>
                            <ul class="dropDown-menu menu radius box-shadow">
                                <li><a href="javascript:;" onclick="alert('测试');"><i class="Hui-iconfont">&#xe616;</i> 测试</a></li>
                                {{--<li><a href="javascript:;" onclick="article_add('添加资讯','article-add.html')"><i class="Hui-iconfont">&#xe616;</i> 资讯</a></li>--}}
                                {{--<li><a href="javascript:;" onclick="picture_add('添加资讯','picture-add.html')"><i class="Hui-iconfont">&#xe613;</i> 图片</a></li>--}}
                                {{--<li><a href="javascript:;" onclick="product_add('添加资讯','product-add.html')"><i class="Hui-iconfont">&#xe620;</i> 产品</a></li>--}}
                                {{--<li><a href="javascript:;" onclick="member_add('添加用户','member-add.html','','510')"><i class="Hui-iconfont">&#xe60d;</i> 用户</a></li>--}}
                            </ul>
                        </li>
                    </ul>
                </nav>
                <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                    <ul class="cl">
                        @if(count( $userRoleDisplayNames ) == 1)
                            <li><a href="#">{{$userRoleDisplayNames[0]}}</a></li>
                        @elseif( count( $userRoleDisplayNames ) > 1 )
                            <li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A">{{array_shift( $userRoleDisplayNames )}} <i class="Hui-iconfont">&#xe6d5;</i></a>
                                <ul class="dropDown-menu menu radius box-shadow">
                                    @forelse ($userRoleDisplayNames as $displayName )
                                        <li><a href="#">{{$displayName}}</a></li>
                                    @empty
                                    @endforelse
                                </ul>
                            </li>
                        @else
                            没有加入角色
                        @endif
                        <li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A">{{$userInfo['name']}} <i class="Hui-iconfont">&#xe6d5;</i></a>
                            <ul class="dropDown-menu menu radius box-shadow">
                                {{--<li><a href="#">个人信息</a></li>--}}
                                {{--<li><a href="#">切换账户</a></li>--}}
                                <li><a href="/auth/logout">退出</a></li>
                            </ul>
                        </li>
                        <li id="Hui-msg"> <a href="javascript:;" title="消息" id="message_to_click"><span class="badge badge-danger"  id="_message_holder">{{ $messageCount==0? "": $messageCount  }}</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>
                        <li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                            <ul class="dropDown-menu menu radius box-shadow">
                                <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                                <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                                <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                                <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                                <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                                <li><a href="javascript:;" data-val="orange" title="绿色">橙色</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
@endsection

@section("aside")
<aside class="Hui-aside">
    <input runat="server" id="divScrollValue" type="hidden" value="" />
    <div class="menu_dropdown bk_2">
        {!! $mainPresenter->renderSidebar($menus,$route) !!}

        {{--<dl id="menu-article1">--}}
            {{--<dt><i class="Hui-iconfont">&#xe616;</i> 以下为测试菜单--><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>--}}
        {{--</dl>--}}

        {{--<dl id="menu-system">--}}
            {{--<dt><i class="Hui-iconfont">&#xe62e;</i> 系统管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>--}}
            {{--<dd>--}}
                {{--<ul>--}}
                    {{--<li><a _href="system-base.html" data-title="系统设置" href="javascript:void(0)">系统设置</a></li>--}}
                    {{--<li><a _href="system-category.html" data-title="栏目管理" href="javascript:void(0)">栏目管理</a></li>--}}
                    {{--<li><a _href="system-data.html" data-title="数据字典" href="javascript:void(0)">数据字典</a></li>--}}
                    {{--<li><a _href="system-shielding.html" data-title="屏蔽词" href="javascript:void(0)">屏蔽词</a></li>--}}
                    {{--<li><a _href="system-log.html" data-title="系统日志" href="javascript:void(0)">系统日志</a></li>--}}
                {{--</ul>--}}
            {{--</dd>--}}
        {{--</dl>--}}

    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
@endsection

@section("content")
    <section class="Hui-article-box">
        <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
            <div class="Hui-tabNav-wp">
                <ul id="min_title_list" class="acrossTab cl">
                    <li class="active"><span title="我的桌面" data-href="welcome.html">我的桌面</span><em></em></li>
                </ul>
            </div>
            <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
        </div>
        <div id="iframe_box" class="Hui-article">
            <div class="show_iframe">
                <div style="display:none" class="loading"></div>
                <iframe scrolling="yes" frameborder="0" src="/backend/welcome"></iframe>
            </div>
            <!--<div class="show_iframe" style="display: block">
                <div style="display: none" class="loading"></div>
                <iframe scrolling="yes" src="{{route("backend.message.index")}}"></iframe>
            </div>-->
        </div>
    </section>
@endsection

@section('after.js')
    <script type="text/javascript">
        /*资讯-添加*/
        function article_add(title,url){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        /*图片-添加*/
        function picture_add(title,url){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        /*产品-添加*/
        function product_add(title,url){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        /*用户-添加*/
        function member_add(title,url,w,h){
            layer_show(title,url,w,h);
        }

        //var already = false;
        var url = "{{ route("backend.message.index") }}";
        /* 变相点击操作 */
        $("#message_to_click").click(function(){
            layer.open({
                type: 2,
                title: '消息',
                area: ['80%', '80%'],
                fix: false, //不固定
                maxmin: true,
                content: url
            });

        });
        //轮训ajax，用以判断是否有消息到来
        function ask(){
            $.ajax({
                url: '{{route("backend.message.ask", ['_token'=>csrf_token()])}}',
                type:'get',
                //data: {'_token': '{{csrf_token()}}'},
                success: function(data){
                    if(parseInt(data) > 0) { //有消息
                        $("#_message_holder").html(data);
                        layer.msg("有消息未读取", {offset:['80px', '90%']});
                    }else if(data.status==0){
                        //这个提示可以去除了，因为是没权限操作
                        //layer.msg('暂无消息', {offset: ['80px', '90%']});
                        //$("#_message_holder").html("");
                        //layer.msg("暂无权限以操作消息管理");
                    } else {
                        $("#_message_holder").html("");
                    }
                }
            });
            //多久轮训一次,默认为10分钟
            var timeout = 60 * 10;
            setTimeout(ask, 1000 * timeout);
        }
        (function(){
            //延迟两秒执行
            setTimeout(ask, 1000 * 2);
        }());

    </script>
@endsection

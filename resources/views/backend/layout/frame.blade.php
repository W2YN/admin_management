@inject('mainPresenter','App\Presenters\MainPresenter')<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <LINK rel="Bookmark" href="/favicon.ico" >
    <LINK rel="Shortcut Icon" href="/favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/lib/html5.js"></script>
    <script type="text/javascript" src="/lib/respond.min.js"></script>
    <script type="text/javascript" src="/lib/PIE_IE678.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/lib/laypage/1.2/laypage.js"></script>
    @yield('before.css')
    <link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui-iconfont/1.0.7/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/lib/icheck/icheck.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css" />
    @yield('after.css')
    <!--[if IE 6]>
    <script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>{{ $page_title or "Admin Dashboard" }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 首页
    {!! $mainPresenter->renderBreadcrumbsV2($menus,$route) !!}
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" id="parent_refresh">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>

@include('backend.layout.successv2')
@include('backend.layout.errorsv2')
@yield('content')

@yield('before.js')

<script type="text/javascript" src="/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script>

@yield('after.js')
<footer class="footer mt-20">
    <div class="container-fluid">
        {{--<nav> <a href="#" target="_blank">关于我们</a> <span class="pipe">|</span> <a href="#" target="_blank">联系我们</a> <span class="pipe">|</span> <a href="#" target="_blank">法律声明</a> </nav>--}}
        <p>Copyright &copy;2016 Ourplus.com All Rights Reserved. <br>
            {{--<a href="http://www.miitbeian.gov.cn/" target="_blank" rel="nofollow">京ICP备xxxxxx号</a><br>--}}
        </p>
    </div>
</footer>
</body>
</html>
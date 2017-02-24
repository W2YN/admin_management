@extends('backend.layout.main')

@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> 操作错误</h3>

            <p>
                对不起，该页面不存在！
            </p>
            <p>
                如有疑问，请与系统管理员联系。
            </p>
            <a href="/" class="btn btn-warning btn-block">跳转首页</a>
            <a href="{{ $previousUrl }}" class="btn btn-default btn-block">点击返回</a>
        </div>
    </div>
@endsection
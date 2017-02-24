<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>{{ $page_title or "Cowcat Dashboard" }}</title>
    @yield('before.css')
    <link rel="stylesheet" type="text/css" href="/assets/backend/plugins/pace/pace.min.css">
    <link rel="stylesheet" type="text/css" href="{{ elixir('assets/backend/css/app.min.css') }}">
    @yield('after.css')
</head>

<body class="skin-black fixed">
@inject('mainPresenter','App\Presenters\MainPresenter')
<div class="wrapper">
    @inject('mainPresenter','App\Presenters\MainPresenter')
    <div class="content-wrapper" style="margin-left:0px">
        <section class="content-header">
            @include('backend.layout.breadcrumbs')
            @include('backend.layout.errors')
            @include('backend.layout.success')
        </section>
        <section class="content">
            @yield('content')
        </section>
    </div>
</div>

@yield('before.js')
<script type="text/javascript" src="{{ elixir('assets/backend/js/app.min.js') }}"></script>
<script type="text/javascript" src="/assets/backend/plugins/pace/pace.min.js"></script>
<script type="text/javascript" src="/assets/backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('.select2').select2();
        $('#created_at').daterangepicker({timePickerIncrement: 30, format: 'YYYY/MM/DD HH:mm:ss'});
    });
</script>
@yield('after.js')
</body>
</html>

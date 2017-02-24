@if(Session::has('success'))
    <div class="Huialert Huialert-success">
        <i class="icon Hui-iconfont icon-remove">&#xe6a6;</i>
        {{Session::get('success')}}
    </div>
@endif

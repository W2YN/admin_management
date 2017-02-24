@extends('backend.layout.window')
@section('content')
    <div class="page-container">
        <form class="form form-horizontal" id="form-article-add">
            <div id="tab_demo" class="HuiTab">
                <div class="tabBar cl"><span>日志信息</span></div>
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">编号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['id'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">操作者id：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['user_id'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">操作者：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['user_name'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">操作类型：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['type'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">操作url：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['url'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">http方法：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['method'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">提交参数：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['params'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">操作描述：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['desc'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">创建于：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $data['created_at'] }}
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection

@section('after.js')
    <script>
        $(function () {
            $.Huitab("#tab_demo .tabBar span", "#tab_demo .tabCon", "current", "click", "0");
        });
    </script>
@endsection

@extends('backend.layout.window')
@inject('wxplatformPresenter','App\Presenters\WxPlatformTemplateMessagePresenter')
@section('content')
    <div class="page-container">
        <form class="form form-horizontal" id="form-article-add">
            <div id="tab_demo" class="HuiTab">
                <div class="tabBar cl">
                    <span>模板信息</span>

                </div>


                <div class="tabCon">
                    <div class="mt-20">
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">模板ID：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                {{$data->templateId}}
                            </div>
                        </div>
                    </div>
                    <div class="mt-20">
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">模板标题：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                {{$data->title}}
                            </div>
                        </div>
                    </div>

                    <div class="mt-20">
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">模板内容：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                {{$data->content}}
                            </div>
                        </div>
                    </div>
                    {{--<div class="mt-20">--}}
                        {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-4 col-sm-2">订单状态：</label>--}}
                            {{--<div class="formControls col-xs-8 col-sm-9">--}}

                                {{--{{ $payPresenter->showStatus($data['orderStatus'])}}--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                </div>


                <div class="tabCon">
                    <div class="mt-20">
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">消息id：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                {{$data->msgid}}
                            </div>
                        </div>
                    </div>

                    <div class="mt-20">
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">返回码：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                {{$data->errcode}}
                            </div>
                        </div>
                    </div>
                    <div class="mt-20">
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">返回文本：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                {{$data->errmsg}}
                            </div>
                        </div>
                    </div>
                    <div class="mt-20">
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-2">发送结果：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                {{$data->return_status}}
                            </div>
                        </div>
                    </div>

                    {{--<div class="mt-20">--}}
                    {{--<div class="row cl">--}}
                    {{--<label class="form-label col-xs-4 col-sm-2">订单状态：</label>--}}
                    {{--<div class="formControls col-xs-8 col-sm-9">--}}

                    {{--{{ $payPresenter->showStatus($data['orderStatus'])}}--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}

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
    </script>
@endsection

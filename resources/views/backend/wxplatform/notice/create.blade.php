@extends('backend.layout.window')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <form method="post" enctype="multipart/form-data" class="form form-horizontal"
                  action="{{route('backend.wxnotice.store')}}"
                  id="demoform-1">
                <div class="box">
                    {{csrf_field()}}
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">通知名称：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input class="input-text" name="notice_name" autocomplete="off" placeholder="通知名称"
                                   type="text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">通知类型：</label>
                        <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
							<select class="select" size="1" name="return_id" id="wx_message_return">
							  <option selected="selected" value="1">文本</option>
                                <option value="2">图文信息</option>
                                <option value="3">跳转处理</option>
							</select>
							</span></div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">文本描述：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <textarea class="textarea" placeholder="说点什么..." rows="" cols=""
                                      name="description"></textarea>
                        </div>
                    </div>

                    <div class="wxpicture" style="display: none">
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">图片标题：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input class="input-text" name="title" autocomplete="off" placeholder="图片标题"
                                       type="text">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">图文链接：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input class="input-text" name="content_url" autocomplete="off" placeholder="图文链接"
                                       type="text">
                            </div>
                        </div>

                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">图片：</label>
                            <div class="formControls col-xs-8 col-sm-9"> <span class="btn-upload form-group">
							<input class="input-text upload-url" name="filename" id="uploadfile-2" readonly=""
                                   type="text">
							<a href="javascript:void();" class="btn btn-primary upload-btn"><i
                                        class="Hui-iconfont"></i> 浏览文件</a>
							<input multiple="" name="file" class="input-file" type="file">
							</span></div>
                        </div>
                    </div>
                    <div class="wxaction" style="display: none">
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">处理链接：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input class="input-text" name="action" autocomplete="off" placeholder="处理链接"
                                       type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row cl">
                        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                            <input class="btn btn-primary radius" value="提交" type="submit">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('after.js')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#wx_message_return").change(function () {

                var selected = $(this).children('option:selected').val()
                if (selected == 2) {
                    $('.wxpicture').css('display', 'block');
                }
                else {
                    $('.wxpicture').css('display', 'none');
                }

                if (selected == 3) {
                    $('.wxaction').css('display', 'block');
                }
                else {
                    $('.wxaction').css('display', 'none');
                }

            });
        });
    </script>
@endsection

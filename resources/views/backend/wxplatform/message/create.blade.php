@extends('backend.layout.window')

@section('content')
    <script src="//cdn.bootcss.com/vue/2.1.4/vue.min.js"></script>
    <script src="//cdn.bootcss.com/vue-resource/1.0.3/vue-resource.min.js"></script>
    <div class="row">
        <div class="col-md-10">
            <form method="post" enctype="multipart/form-data" class="form form-horizontal"
                  action="{{route('backend.wxmessage.store')}}"
                  id="demoform-1">
                <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
                <div class="box">

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">用户消息内容：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input class="input-text" name="message_name" autocomplete="off" placeholder="用户消息内容"
                                   type="text">
                            <input type="hidden" class="form-control" name="type_id" value="1">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">回复类型：</label>
                        <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
							<select class="select" size="1" name="return_id" id="wx_message_return">
							  <option selected="selected" value="1">回复文本</option>
                                <option value="2">回复图文信息</option>
                                 <option value="3">回复多图文信息</option>
                                <option value="4">跳转处理</option>
							</select>
							</span></div>
                    </div>
                    <div class="row cl wxtext">
                        <label class="form-label col-xs-4 col-sm-3">回复文本描述：</label>
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

                    <div id="mulit" class="wxmulitmessage" style="display: none">
                        <div class="row cl col-xs-9 col-sm-11 col-xs-offset-3 col-sm-offset-2"
                             style="margin-bottom: 20px">
                            <input @click='addMoreMessage()' class="btn btn-success radius" value="增加图文" type="button">
                            <input type="hidden" v-model="messagecount" name="messagecount">
                        </div>

                        <div v-for="message in messages">
                            <div class="row cl">

                                <label class="form-label col-xs-4 col-sm-3">图片标题：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    <input class="input-text" :name="message.title" autocomplete="off" value=""
                                           type="text">
                                </div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-3">图文链接：</label>
                                <div class="formControls col-xs-8 col-sm-9">
                                    <input class="input-text" :name="message.content_url" autocomplete="off"
                                           value=""
                                           type="text">
                                </div>
                            </div>
                        </div>
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
                    $('.wxtext').css('display', 'none');
                    $('.wxmulitmessage').css('display', 'block');
                }
                else {
                    $('.wxtext').css('display', 'block');
                    $('.wxmulitmessage').css('display', 'none');
                }
                if (selected == 4) {
                    $('.wxaction').css('display', 'block');
                }
                else {
                    $('.wxaction').css('display', 'none');
                }

            });
        });

        Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementById('token').value;
        new Vue({
            el: '#mulit',
            data: {
                messages: [],
                messagecount: 0,
            },
            methods: {
                addMoreMessage: function (e) {
                    var title = 'title' + this.messagecount;
                    var content_url = 'content_url' + this.messagecount;
                    var description = 'description' + this.messagecount;
                    var message = {
                        title: title,
                        content_url: content_url,
                        description: description
                    };
                    this.messages.push(message);
                    this.messagecount++;
                }
            }
        });
    </script>
@endsection

@extends('backend.layout.window')

@section('content')
    <script src="//cdn.bootcss.com/vue/2.1.4/vue.min.js"></script>
    <script src="//cdn.bootcss.com/vue-resource/1.0.3/vue-resource.min.js"></script>
    <style>
        .del-row {
            height: 40px;
        }

        .wxdelete-btn {

            transition: all 0.6s;
            cursor: pointer;
            font-size: 20px;
            margin-left: 20px
        }

        .wxdelete-btn:hover {
            /*transform: scale(1.4);*/
            font-size: 25px;
        }
    </style>
    <div class="row">
        <div class="col-md-10">
            <form enctype="multipart/form-data" class="form form-horizontal"
                  action="{{route('backend.wxmessage.update',['id'=>$message->id])}}" method="post">
                <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
                <div class="box">

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">用户消息内容：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input class="input-text" name="message_name" autocomplete="off"
                                   value="{{$message->message_name}}"
                                   type="text">
                            <input type="hidden" class="form-control" name="type_id" value="1">
                            <input type="hidden" id="messageid" value="{{$message->id}}">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">回复类型：</label>
                        <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
							<select class="select" size="1" name="return_id" id="wx_message_return">
							  <option @if($message['return_id'] == 1) selected="selected" @endif value="1">回复文本</option>
                                    <option @if($message['return_id'] == 2) selected="selected"
                                            @endif value="2">回复图文信息</option>
                                    <option @if($message['return_id'] == 3) selected="selected"
                                            @endif value="3">回复多图文消息</option>
<option @if($message['return_id'] == 4) selected="selected" @endif value="4">跳转处理</option>
							</select>
							</span></div>
                    </div>

                    <div  class="row cl wxtext" @if($message['return_id'] == 3)style="display: none"
                         @else style="display: block" @endif>
                        <label class="form-label col-xs-4 col-sm-3">回复文本描述：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <textarea class="textarea" rows="" cols=""
                                      name="description">{{$message->description}}</textarea>
                        </div>
                    </div>
                    <div class="wxpicture" @if($message['return_id'] == 2)style="display: block"
                         @else style="display: none" @endif >
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">图片标题：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input class="input-text" name="title" autocomplete="off" value="{{$message->title}}"
                                       type="text">
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">图文链接：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input class="input-text" name="content_url" autocomplete="off"
                                       value="{{$message->content_url}}"
                                       type="text">
                            </div>
                        </div>

                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">图片：</label>
                            <div class="formControls col-xs-8 col-sm-9"> <span class="btn-upload form-group">
							<input class="input-text upload-url" name="filename" id="uploadfile-2" readonly=""
                                   value="{{$message->image}}" type="text">
							<a href="javascript:void();" class="btn btn-primary upload-btn"><i
                                        class="Hui-iconfont"></i> 浏览文件</a>
							<input multiple="" name="file" class="input-file" type="file">
							</span></div>
                        </div>
                    </div>

                    {{--<.........................................................>--}}
                    <div id="mulit" class="wxmulitmessage row cl" @if($message['return_id'] == 3)style="display: block"
                         @else style="display: none" @endif >
                        @foreach($message->mulitmessage as $key=>$item)
                            <div class="mulititem" id="mulititem{{$item->id}}">

                                <div class="row cl del-row">
                                    <div
                                            class=" form-label col-xs-offset-2 col-xs-1 col-sm-offset-1 col-sm-1">
                                        <i @click='deleteMessage({{$item->id}})' class="wxdelete-btn Hui-iconfont">
                                        &#xe60b;</i>
                                    </div>

                                    <label class="form-label col-xs-1 col-sm-1">图片标题：</label>
                                    <div class="formControls col-xs-8 col-sm-9">
                                        <input class="input-text" name="title{{$key}}" autocomplete="off"
                                               value="{{$item->title}}"
                                               type="text">
                                        <input class="input-text" name="mulitid{{$key}}" autocomplete="off"
                                               value="{{$item->id}}"
                                               type="hidden">
                                    </div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-3">图文链接：</label>
                                    <div class="formControls col-xs-8 col-sm-9">
                                        <input class="input-text" name="content_url{{$key}}" autocomplete="off"
                                               value="{{$item->content_url}}"
                                               type="text">
                                    </div>
                                </div>
                                {{--<div class="row cl">--}}
                                {{--<label class="form-label col-xs-4 col-sm-3">描述：</label>--}}
                                {{--<div class="formControls col-xs-8 col-sm-9">--}}
                                {{--<input class="input-text" name="description{{$key}}" autocomplete="off"--}}
                                {{--value="{{$item->description}}"--}}
                                {{--type="text">--}}
                                {{--</div>--}}
                                {{--</div>--}}
                            </div>
                        @endforeach

                        <div class="row cl col-xs-9 col-sm-11 col-xs-offset-3 col-sm-offset-2"
                             style="margin-bottom: 20px">
                            <input @click='addMoreMessage()' class="btn btn-success radius" value="增加图文" type="button">
                            <input type="hidden" id="basecount" value="{{$message->mulitmessage->count()}}">

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

                            {{--<div class="row cl">--}}
                            {{--<label class="form-label col-xs-4 col-sm-3">描述：</label>--}}
                            {{--<div class="formControls col-xs-8 col-sm-9">--}}
                            {{--<input class="input-text" :name="message.description" autocomplete="off"--}}
                            {{--value=""--}}
                            {{--type="text">--}}
                            {{--</div>--}}
                            {{--</div>--}}

                        </div>

                    </div>
                    {{--<.........................................................>--}}
                    <div class="wxaction" @if($message['return_id'] == 4)style="display: block"
                         @else style="display: none" @endif >
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">处理链接：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input class="input-text" name="action" autocomplete="off" value="{{$message->action}}"
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
        var basecount = document.getElementById('basecount').value;
        var messageid = document.getElementById('messageid').value;


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
                    $('.wxmulitmessage').css('display', 'block');
                    $('.wxtext').css('display', 'none');
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
                messagecount: basecount,
                checkMessage: {
                    messageId: messageid,
                    mulitId: ''
                }
            },
            methods: {
                addMoreMessage: function (e) {
                    console.log(basecount);
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
                },
                deleteMessage: function (index) {

                    this.checkMessage.mulitId = index;
                    let checkMessage = this.checkMessage;
                    let Vue = this;
                    let deleteitem = 'mulititem' + index;
                    layer.confirm('删除须谨慎，确认要删除吗？', function (index) {
                        Vue.$http.post('/backend/wechat/deletemulit', checkMessage).then(function (response) {
                            // 響應成功回調
                            console.log(response);
                            document.getElementById(deleteitem).style.display = 'none';
                            layer.msg('删除成功', {icon: 1, time: 1000});
                        }, function (response) {
                            console.log(response);
                            layer.msg(response.responseText, {icon: 1, time: 1000});
                            // 響應錯誤回調
                        });

                    });


                }
            }
        });

    </script>
@endsection



@extends('backend.layout.window')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <form method="post" enctype="multipart/form-data" class="form form-horizontal"
                  action="{{route('backend.wxmenu.store')}}"
                  id="demoform-1">
                <div class="box">

                    <div class="row cl">

                        <div class="formControls col-xs-8 col-sm-9">
                            <input class="input-text" name="type" value="view"
                                   type="hidden">
                            <input type="hidden" id="token" name="_token" value="{{csrf_token()}}">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">父级菜单：</label>
                        <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
                    <select class="select" size="1" name="level_id">
                    <option selected="selected" value="0">顶级菜单</option>
                        @foreach($levelmenus as $key => $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach


                    </select>
                    </span></div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">菜单序号：</label>
                        <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
                    <select class="select" size="1" name="order">
                        <option selected="selected" value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                    </span></div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">菜单名称：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input class="input-text" name="name" autocomplete="off" placeholder="菜单名称"
                                   type="text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-3">菜单链接：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input class="input-text" name="url" autocomplete="off" placeholder="图文链接"
                                   type="text">
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

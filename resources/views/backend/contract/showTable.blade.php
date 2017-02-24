<!-- 按钮栏 结束 -->
<div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
        @if(!empty($table['fields']) && is_array($table['fields']))
            <tr class="text-c">
                @foreach($table['fields'] as $key =>$field)
                    <th
                            @if(isset($table['fieldWidth'][$key])) width="{{$table['fieldWidth'][$key]}}" @endif
                    >{{!is_array($field)? $field: $field[0]}}</th>
                @endforeach
                @if(isset($table['handle']))
                    <th width="{{$table['handleWidth']}}">管理操作</th>
                @endif
            </tr>
        @endif
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr class="text-c">
                @foreach($table['fields'] as $key =>$field)
                    <td
                            @if(isset($table['fieldWidth'][$key])) width="{{$table['fieldWidth'][$key]}}" @endif
                    >
                        {{!is_array($field)? $item->$key: $field[1]($item->$key)}}
                    </td>
                @endforeach
                @if(isset($table['handle']))
                    <td class="td-manage">
                        @foreach($table['handle'] as $button)
                            @if($button['type'] == 'edit')
                                <a title="{{$button['title']}}" href="javascript:;"
                                   onclick="frame_window_open('{{$button['title']}}','{{route($button['route'],['id'=>$item->id])}}','{{$button['width']}}','{{$button['height']}}')"
                                   style="text-decoration:none">
                                    <i class="Hui-iconfont">&#xe6df;</i>
                                </a>&nbsp;
                            @endif
                            @if($button['type'] == 'delete')
                                <form class="form-horizontal" method="post" enctype="multipart/form-data"
                                      style="display:none;" id="del-from-{{$item->id}}" action="handlev2.blade.php">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                                <a title="删除" href="javascript:;" onclick="table_del(this,'1')"
                                   data-url="{{route($button['route'],['id'=>$item->id])}}"
                                   data-formid="del-from-{{$item->id}}" class="ml-5" style="text-decoration:none">
                                    <i class="Hui-iconfont">&#xe6e2;</i>
                                </a>&nbsp;
                            @endif
                            @if($button['type'] == 'show')
                                <a title="{{$button['title']}}" href="javascript:;"
                                   onclick="frame_window_open_full('{{$button['title']}}','{{route($button['route'],['id'=>$item->id])}}')"
                                   style="text-decoration:none">
                                    {{$button['text']}}
                                </a>&nbsp;
                            @endif
                            @if($button['type'] == 'admin_tab')
                                <a _href="{{route($button['route'],['id'=>$item->id])}}"
                                   data-title="{{$button['title']}}" onClick="Hui_admin_tab(this)"
                                   style="text-decoration:none">
                                    {{$button['text']}}
                                </a>&nbsp;
                            @endif
                        @endforeach
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>


    @if(  method_exists($data,'render') && $data->render())
        <div class="box-footer clearfix">
            <div id="pageDiv_{{$table['pageId']}}" style="margin-top:5px; text-align:left;"></div>
        </div>
        <script type="text/javascript">
            laypage({
                cont: 'pageDiv_{{$table['pageId']}}',
                pages: '{!! $data->lastPage() !!}', //可以叫服务端把总页数放在某一个隐藏域，再获取。假设我们获取到的是18
                curr: function () { //通过url获取当前页，也可以同上（pages）方式获取
                    return '{{ $data->currentPage() }}';
                    var page = location.search.match(/page=(\d+)/);
                    return page ? page[1] : 1;
                }(),
                jump: function (e, first) { //触发分页后的回调
                    if (!first) { //一定要加此判断，否则初始时会无限刷新

                        $htmlObj = $('.tabCon').eq($('.tabBar>.current').index());
                        $htmlObj.html('');


                        $.ajax({
                            url: '{{url('backend/carInsurance/ajaxPage')}}',
                            data: {
                                'page': e.curr,
                                'method': '{{$table['pageId']}}',
                              //  "_token":'{{csrf_token()}}'
                            },
                            type: 'get',
                            dataType: 'html',
                            success: function (data) {
                                $htmlObj.html(data);
                            },
                            error: function () {

                            }
                        });




//                        var url = window.location.href;
//                        //url = 'http://managementplatformv2/backend/waterPurifier';
//                        var new_url = "";
//                        var par = "";
//                        if (url.split("page").length > 1) {
//                            var temp = url.split("page");
//                            par = temp[1];
//                            if (par.split("&").length > 1) {
//                                var par2 = par.split("&")[0]+"&";
//                                par = par.replace(par2, "");
//                            }else{
//                                par = "";
//                            }
//                            new_url = temp[0] + par;
//                        }else{
//                            new_url = url;
//                        }
//                        if (url.split("?").length > 1){
//                            new_url = new_url + '&page='+e.curr;
//                        }
//                        else{
//                            new_url = new_url + '?page='+e.curr;
//                        }
                        //console.debug( new_url );
                        // location.href = new_url;
                    }
                }
            })

        </script>
    @endif


</div>
<script>
    function table_del(obj, id) {
        console.debug(obj);
        console.debug(obj.dataset.url);
        /*if(confirm("删除须谨慎，确定要删除吗"))
        {
            var url = obj.dataset.url;
            var formid = obj.dataset.formid;

            submit_table_delete_from(obj);
        }*/
        layer.confirm('删除须谨慎，确认要删除吗？', function (index) {
            //此处请求后台程序，下方是成功后的前台处理……
            var url = obj.dataset.url;
            var formid = obj.dataset.formid;

            submit_table_delete_from(obj);

            //layer.msg('已删除!',{icon:1,time:1000});
        });
    }
    function submit_table_delete_from(obj) {
        var url = obj.dataset.url;
        var formid = obj.dataset.formid;
        var options = {
            url: url,
            type: 'post',
            //dataType: 'text',
            data: $("#" + formid).serialize(),
            success: function (data) {
//                if (data.length > 0)
//                    $("#responseText").text(data);
                $(obj).parents("tr").remove();
                layer.msg(data, {icon: 1, time: 1000});
            },
            error: function (request) {
                layer.msg(request.responseText, {icon: 1, time: 1000});
            }
        };
        $.ajax(options);
    }
</script>
<!-- 表格数据 结束 -->

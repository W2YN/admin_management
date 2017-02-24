@extends('backend.layout.frame')
{{--@inject('waterPurifierPresenter','App\Presenters\WaterPurifierPresenter') --}}
@section('after.css')
    <link rel="stylesheet" type="text/css" href="/lib/fullcalendar-3.0.1/fullcalendar.min.css" />
    <style>
        .event_style {
            height: 22px;
            /*color: black;*/
            font-size: 11px;
            padding-top: 4px;
            margin-bottom: 5px;
        }
        .event_total{
            margin-left: 3px;
        }
        .event_done{
            margin-left:3px;
            color: darkblue;
        }
        .event_green{
            margin-left: 3px;
            color: green;
        }
        .event_fail{
            margin-left:3px;
            color: red;
        }
        .detail{
            margin-left: 3px;
        }
    </style>
@endsection
@section('content')
    <div class="page-container">
        <div id="calendar"></div>
    {{--@include('backend.components.searchv2',  ['search' => $waterPurifierPresenter->getDeviceInfoSearchParams()])
    <!-- 按钮栏 开始 -->
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            @include('backend.components.handlev2',  ['handle' => $waterPurifierPresenter->getHandleParams()])
            <span class="r">共有数据：<strong>{{$data->total()}}</strong> 条</span>
        </div>
        <!-- 按钮栏 结束 -->

        @include('backend.components.tablev2',  ['table' => $waterPurifierPresenter->getDeviceInfoTableParams()])--}}
    </div>
@endsection

@section('after.js')
    <script type="text/javascript" src="/lib/fullcalendar-3.0.1/lib/moment.min.js"></script>
    <script type="text/javascript" src="/lib/fullcalendar-3.0.1/fullcalendar.min.js"></script>
    <script type="text/javascript" src="/lib/fullcalendar-3.0.1/locale/zh-cn.js"></script>
    <script>
       function append(className, html, parentDiv){
           var span = $(("<span></span>"));
           span.addClass(className);
           span.html(html);
           span.appendTo(parentDiv);
       }

        $(document).ready(function(){
            $("#calendar").fullCalendar({ //这个看起来不错的样子，不要辜负我啊
                header: {
                    left: '',
                    center: 'title',
                    right: 'prev today basicWeek month next'
                },
                locale: 'zh-cn',
                timezone: 'Asia/Shanghai',
                height: 800,
                handleWindowResize: true,

                navLinks: true,
                events: '/backend/waterPurifier/eventSource',
                backgroundColor: 'white',

                eventClick: function(calEvent, jsEvent, view) {
                    return false;
                },
                dayClick: function(date, jsEvent, view){
                    return false;
                },
                eventRender: function(event, element) {
                    var info = $.parseJSON(event.title);
                    var tdDiv = $("<div></div>");
                    if(info.description == "dingdan"){
                        append("event_total", "生成订单(" + info.generate+")", tdDiv);
                        append('event_done', '生效('+ info.valid+")", tdDiv);
                        append('event_green', "扣款(" + info.done+")", tdDiv );
                    } else if(info.description == "fenqi"){
                        append("event_total", "今日有分期("+ info.generate+")", tdDiv);
                        append("event_green", "完成扣款(" + info.done+")", tdDiv);
                        append("event_fail", '<a onclick="show(' + info.fail_create_at + ')" class="event_fail">还未扣款(' + info.fail + ")</a>", tdDiv);
                    } else if(info.description == "weihu"){
                        append('event_total', '今日有维护任务('+ info.generate+")", tdDiv);
                        append('event_done', '完成维护任务(' + info.done+")", tdDiv);
                        append('event_green', '未完成维护任务(' + info.undone+")", tdDiv);
                    } else {
                        console.log("category" + info.description);
                    }
                    return tdDiv;
                },
                textColor: 'black',
                eventLimit: false,
                views: {
                    agendaOneWeek: {
                        type: 'agenda',
                        duration: { days: 7},
                        buttonText: '7 day'
                    },
                    basicWeek:{
                        buttonText: "一周"
                    },
                    basicDay: {
                        buttonText: "当日"
                    },
                    month: {
                        buttonText: '一个月'
                    }
                }
            });
        });
        function show(create_at){//
            if(create_at==0){
                layer.open({
                    content: "尚无需要显示的内容",
                    btn: '关闭',
                    shadeClose: false
                });
                //alert('尚无需要显示的内容');
            } else {
                $.ajax({
                    url:'/backend/waterPurifier/failDetail',
                    type: 'post',
                    data: {created_at: create_at, _token: '{{csrf_token()}}'},
                    success: function(data){
                        var finalData = $.parseJSON(data);
                        var html = "";
                        for(var i=0;i<finalData.length; i++){
                            var item = "<div><span class='detail'><a _href=/backend/waterPurifier/"+finalData[i].water_purifier_id+"' data-title='净水器:订单详情' onClick='Hui_admin_tab(this)' style='text-decoration:none'>【查看订单详情】</a> </span>" +
                                    "<span class='detail'>涉及净水器订单号:" + finalData[i].num+ " </span>" +
                                    "<span class='detail'>备注:" + finalData[i].remark+ " </span></div>";

                            html = html + item;
                        }
                        layer.open({
                            content: html,
                            btn: '关闭',
                            area: ['700px', 'auto'],
                            shadeClose: false
                        });
                    }
                });
            }
        }
    </script>
@endsection
@extends('backend.layout.window')
@section('content')


    <div class="page-container">

        <div class="col-md-9">
            <div class="col-md-2">
                模式：
                <select class="input-text" name="btn-mode" id="btn-mode" style="width: 120px">
                    <option value="day">天</option>
                    <option value="week">周</option>
                    <option value="month">月</option>
                </select>
            </div>
            <div class="col-md-3">
                开始时间：

                <span id="start_date">

                                <input type="text"
                                       onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true,readOnly:false})"
                                       value="{{date('Y-m-d',strtotime('-7 day'))}}"
                                       class="input-text Wdate" style="width:200px;">

                </span>
            </div>
            <div class="col-md-3">
                结束时间：

                <span id="end_date">
                                <input type="text"
                                       onfocus="WdatePicker({dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true,readOnly:false})"
                                       id="end_date"
                                       value="{{date('Y-m-d')}}"
                                       class="input-text Wdate" style="width:200px;">
                </span>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary radius" id='submit' type="submit">提交</button>
            </div>
        </div>

        <div id="container" style="min-width:700px;height:500px"></div>

        <div class="mt-50">
            <table class="table table-border table-bordered table-hover table-bg table-sort" id="wxStatTable">

            </table>
        </div>

    </div>


    <script type="text/javascript">

        function wdateFormat() {

            $this = $('#btn-mode');
            $val = $this.val();

            startDateHtmlObj = $('#start_date');
            endDateHtmlObj = $('#end_date');
            startDate = startDateHtmlObj.children('input').val();
            endDate = endDateHtmlObj.children('input').val();

            console.log(endDate + '===' + startDate);


            $('#start_date').html('');
            $('#end_date').html('');
            switch ($val) {
                case "day":
                    startDateInput = '<input type="text" onfocus="WdatePicker({dateFmt: \'yyyy-MM-dd\',alwaysUseStartDate: true,readOnly: true,firstDayOfWeek: 1});" class="input-text Wdate" style="width:200px;" value="' + startDate + '">';

                    endDateInput = '<input type="text" onfocus="WdatePicker({dateFmt: \'yyyy-MM-dd\',alwaysUseStartDate: true,readOnly: true,firstDayOfWeek: 1});" class="input-text Wdate" style="width:200px;"  value="' + endDate + '">';
                    break;
                case "week":
                    startDateInput = '<input type="text" onfocus="WdatePicker({dateFmt: \'yyyy-MM-dd\',alwaysUseStartDate: true,readOnly: true,firstDayOfWeek: 1,disabledDays: [1, 2, 3, 4, 5,6]});" class="input-text Wdate" style="width:200px;"  value="' + startDate + '">';

                    endDateInput = '<input type="text" onfocus="WdatePicker({dateFmt: \'yyyy-MM-dd\',alwaysUseStartDate: true,readOnly: true,firstDayOfWeek: 1,disabledDays: [0,1, 2, 3, 4, 5]});" class="input-text Wdate" style="width:200px;"  value="' + endDate + '">';

                    break;
                case "month":
                    startDateInput = '<input type="text" onfocus="WdatePicker({alwaysUseStartDate:true,readOnly:true,dateFmt:\'yyyy-MM\'});" class="input-text Wdate" style="width:200px;"  value="' + startDate + '">';

                    endDateInput = '<input type="text" onfocus="WdatePicker({alwaysUseStartDate:true,readOnly:true,dateFmt:\'yyyy-MM\'});" class="input-text Wdate" style="width:200px;"   value="' + endDate + '">';

                    break;
                default:

                    break;

            }
            startDateHtmlObj.html(startDateInput);
            endDateHtmlObj.html(endDateInput);
        }


        $(function () {

            wdateFormat();
            ajaxLoad();
            $(document).on('click', '#submit', function () {
                ajaxLoad();
            });


            $(document).on('change', '#btn-mode', function () {
                wdateFormat();
            });


            function ajaxLoad() {

                var $data = {};
                $data.actType = "{{$actType}}";
                $data.start_date = $('#start_date').children('input').val();
                $data.end_date = $('#end_date').children('input').val();
                $data.mode = $('#btn-mode').val();



                var oDate1 = new Date($data.start_date);
                var oDate2 = new Date($data.end_date);
                if (oDate1.getTime() > oDate2.getTime()) {
                    alert('开始时间不能比结束时间晚');
                    return false;
                } else {
                    console.log('end_date大');
                }


                $.ajax({
                    url: "{{route('backend.carInsurance.ajaxWxStat')}}",
                    data: $data,
                    type: "get",
                    dataType: 'json',
                    beforeSend: function (xmlhttp) {
                        $('#hide').show();
                    },
                    success: function (res) {
                        $('#hide').hide();
                        highcharts(res);
                        createTable(res);
                    },
                    error: function (er) {
                        alert('错误');
                        $('#hide').hide();
                    }

                });
            }


            function highcharts(data) {
                $('#container').highcharts({
                    title: {
                        text: data.title,
                        x: -20 //center
                    },
                    subtitle: {
                        text: data.subtitle,
                        x: -20
                    },
                    xAxis: {
                        categories: data.categories
                    },
                    yAxis: {
                        allowDecimals: false,
                        title: {
                            text: ''//Y轴说明
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        valueSuffix: ''//单位
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: data.series

                });


            }

            function createTable(data) {


                $html = '<thead><tr class="text-c"><th>时间</th>';
                for (i in data.series) {
                    $html += '<th>' + data.series[i].name + '</th>';
                }
                $html += '</tr></thead><tbody><tr class="text-c">';

                for (j in data.categories) {
                    $html += '<tr>';
                    $html += '<td>' + data.categories[j] + '</td>';
                    for (k in data.series) {
                        $list = data.series[k].data;
                        $html += '<td>' + $list[j] + '</td>';
                    }
                    $html += '</tr>';
                }


                $html += '</tr></tbody>';
                $('#wxStatTable').html($html);
                //   console.log($html);
            }


        });
    </script>
@endsection

@section('after.js')
    <style>
        .hide {
            background: rgba(0, 0, 0, 0.9);
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            text-align: center;
        }

        .hide img {
            position: fixed;
            top: 35%;
        }
    </style>



    <div class="hide" id="hide">
        <img src="/static/car-insurance/loading1.gif"/>
    </div>


    <script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="/lib/Highcharts/4.1.7/js/highcharts.js"></script>
    <script type="text/javascript" src="/lib/Highcharts/4.1.7/js/modules/exporting.js"></script>
@endsection
@extends('backend.layout.frame')
@inject('contractPresenter','App\Presenters\ContractPresenter')
@section('content')
    <div class="page-container">
    @include('backend.components.searchv2',  ['search' => $contractPresenter->getDimensionCountSearchParams()])
    <!-- 按钮栏 开始 -->
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            @include('backend.components.handlev2',  ['handle' => $contractPresenter->getHandleParams()])
            <!--<span class="r">共有数据：<strong></strong> 条</span>-->
        </div>
        <!-- 按钮栏 结束 -->

        <!----------统计信息START--------->
        <div class="row cl">
            @include('backend.contract.showTable',  ['table' => $contractPresenter->getStudyTableParams(),'data'=>$installment])

        </div>

        <!--<div class="tabCon">-->
        <div class="row cl" style="width: 100%;height:500px;margin-top: 4%;">
            <div id="capitalMain" class="col-sm-4 col-xs-4" style="height: 550px; width: 80%;"></div>
            <div id="interestMain" class="col-sm-4 col-xs-4" style="height: 500px; width: 30%;"></div>
            <div id="totalMain" class="col-sm-4 col-xs-4" style="height: 500px; width: 30%;"></div>
        </div>
            <!--<div class="row cl">
                <span style="margin-left: 1%;">本金: </span>
            </div>
            <div class="row cl">
                <span style="margin-left: 1%;">利息: </span>
            </div>
            <div class="row cl">
                <span style="margin-left: 1%;">利息: </span>
            </div>-->
        <!--</div>-->

    </div>

@endsection

@section('after.js')
    <script src="/lib/echarts/3.4/echarts.min.js"></script>
    <script src="/lib/echarts/3.4/theme/vintage.js"></script>
    <script type="text/javascript">

        var chart = echarts.init(document.getElementById('capitalMain'));
        var interestChart = echarts.init(document.getElementById('interestMain'));
        var totalChart = echarts.init(document.getElementById('totalMain'));
        //app.title = '嵌套环形图';

        var theOption = {
            title : {
                text: '统计',
                subtext: '{{$_between}}',
                x:'center'
            },
            tooltip: {
                trigger: 'item',
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
           // legend: {
               // orient: 'vertical',
              //  x: 'left',
                //data:['直达','营销广告','搜索引擎','邮件营销','联盟广告','视频广告','百度','谷歌','必应','其他']
           // },
            series: [
                {
                    name:'分布情况',
                    type:'pie',
                    selectedMode: 'single',
                    radius: [0, '30%'],

                    label: {
                        normal: {
                            position: 'inner'
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data:[
                        {value:{{$_money->total}}/*335*/ , name:'{{$_money->type}}'/*'直达'*/, selected:true},
                        {value:{{$_interest->total}} /*679*/, name:'{{$_interest->type}}'/*'营销广告'*/}
                        //{value:1548, name:'搜索引擎'}
                    ]
                },
                {
                    name:'分布情况',
                    type:'pie',
                    radius: ['40%', '55%'],

                    data:[
                        {value:{{$_money->checked}}/*335*/, name:'本金已支付'},
                        {value:{{$_money->unchecked}}, name:'本金未支付'},
                        {value:{{$_interest->unchecked}}, name:'利息未支付'},
                        {value:{{$_interest->checked}}, name:'利息已支付'}
                        /*{value:1048, name:'百度'},
                        {value:251, name:'谷歌'},
                        {value:147, name:'必应'},
                        {value:102, name:'其他'}*/
                    ]
                }
            ]
        };
        var option = {
            title : {
                text: '本金',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            series : [
                {
                    name: '金额',
                    type: 'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:[
                        {value:50, name:'已支付(元)'},
                        {value:80, name:'未支付(元)'}
                    ],
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };

        chart.setOption(theOption);
        /*interestChart.setOption(option);
        totalChart.setOption(option);
        chart.setOption({
            title : {
                text: '本金'
            },
            series : [
                {
                    data:[
                        {value:50, name:'已支付(元)'},
                        {value:80, name:'未支付(元)'}
                    ]
                }]
        });
        interestChart.setOption({
            title : {
                text: '利息'
            },
            series : [
                {
                    data:[
                        {value:50, name:'已支付(元)'},
                        {value:80, name:'未支付(元)'}
                    ]
                }]
        });
        totalChart.setOption({
            title : {
                text: '全部'
            },
            series : [
                {
                    data:[
                        {value:50, name:'已支付(元)'},
                        {value:80, name:'未支付(元)'}
                    ]
                }]
        });*/
        /*function openUrl( obj, url )
        {
            url = url.replace('id', $(obj).data('id'));
            //console.debug(url);
            window.open (url);
        }*/

    </script>
@endsection
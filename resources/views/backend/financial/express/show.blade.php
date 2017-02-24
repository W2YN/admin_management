@extends('backend.layout.frame')
@inject('expressPresenter', 'App\Presenters\Financial\ExpressPresenter')
@inject('contractPresenter', 'App\Presenters\Financial\ContractPresenter')
@section('content')
	<style>.btn-group{margin-bottom:5px;}</style>
    <div class="page-container">
<!--     	<div class="btn-group"> -->
<!--             <button class="btn btn-danger radius delOrder" type="button">删除订单</button> -->
<!--         </div> -->
        <form class="form form-horizontal" id="form-article-add">
            <div id="tab_demo" class="HuiTab">
                <div class="tabBar cl"><span>快递详情</span><span>快递合同列表</span></div>
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">编号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $express['id'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">快递单号：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $express['number'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">快递状态：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $expressPresenter->formatStatus($express['status']) }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">快递公司：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{$expressPresenter->formatCompany($express['express_company_id'])}}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">发快递者名称：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $express['manager_name'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">收快递者名称：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $user['name'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">合同份数：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ count($contracts) }}份
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">快递发送日期：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $express['send_time'] }}
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">快递收到日期：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            {{ $express['arrive_time'] }}
                        </div>
                    </div>
                </div>
                
                <div class="tabCon">
                    <div class="mt-20">
                    <table class="table table-border table-bordered table-hover table-bg table-sort">
                        <thead>
                        <tr class="text-c">
                            <th width="200px">合同编号</th>
                            <th width="200px">合同类型</th>
                            <th width="200px">合同状态</th>
                            <th width="200px">建立合同人</th>
                            <th width="200px">接收合同人</th>
                            <th width="200px">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $contracts as $contract)
                            <tr class="text-c">
                                <td>{{$contract->serial_number}}</td>
                                <td>{{$contractPresenter->formatType($contract->type_id)}}</td>
                                <td>{{$contractPresenter->formatStatus($contract->status)}}</td>
                                <td>{{$contract->manager_name}}</td>
                                <td>{{$user->name}}</td>
                                <td><a _href="{{route('backend.financial.contract.show', $contract->id)}}" onclick="Hui_admin_tab(this)" data-title="合同详情">查看详情</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
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

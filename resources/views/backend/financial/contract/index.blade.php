@extends('backend.layout.frame')
@inject('financialContractPresenter','App\Presenters\Financial\ContractPresenter')
@section('content')
    <div class="page-container">
        @include('backend.components.searchv2',  ['search' => $financialContractPresenter->getSearchParams()])
                <!-- 按钮栏 开始 -->
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            @include('backend.components.handlev2',  ['handle' => $financialContractPresenter->getHandleParams()])
            <span class="r">共有数据：<strong>{{$data->total()}}</strong> 条</span>
        </div>
        <!-- 按钮栏 结束 -->

        @include('backend.components.tablev2',  ['table' => $financialContractPresenter->getTableParams()])
    </div>
@endsection
@section('after.js')
<script>
function set_express_back(_this){
	layer.confirm('确定设为回邮已到达?', {
		  btn: ['确定','取消']
	}, function(){
		var id = $(_this).attr('data-id');
		var data = {
                '_token': '{{csrf_token()}}',
                '_method': 'put'
		};
		
		$.ajax({
			url: '/backend/financial/contract/expressBack/' + id,
			type: 'post',
			data: data,
			dataType: 'json',
			success: function (data){
				layer.msg(data.msg);
                if (data.errorCode == 0) {
                    location.reload();
                }
			}
		});
	}, function(){});
}

function set_keep_in_the_archives(_this){
	layer.confirm('确定设为存档状态?', {
		  btn: ['确定','取消']
	}, function(){
		var id = $(_this).attr('data-id');
		var data = {
              '_token': '{{csrf_token()}}',
              '_method': 'put'
		};
		
		$.ajax({
			url: '/backend/financial/contract/keepInTheArchives/' + id,
			type: 'post',
			data: data,
			dataType: 'json',
			success: function (data){
				layer.msg(data.msg);
                if (data.errorCode == 0) {
                    location.reload();
                }
			}
		});
	}, function(){});
}
</script>
@endsection
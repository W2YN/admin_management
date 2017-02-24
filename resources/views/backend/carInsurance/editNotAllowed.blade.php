@extends('backend.layout.window')
@inject('CarInsuranceOrderPresenter','App\Presenters\CarInsuranceOrderPresenter')
@section('content')

    <div class="page-container">

    </div>

@endsection
@section('after.js')
<script>
    layer.open({
        content: '当前订单暂时无法编辑'
        ,btn: ['确定']
        ,yes: function(index, layero){
            layer_close();
            //layer.close(index);
            //var p = parent.layer.getFrameIndex(window.name); //获取当前index
            //parent.layer.close(p);//这就成功了
            //console.log(layero);
            //console.log(index);
        }
        ,cancel: function(){
            //右上角关闭回调
            layer_close();
        }
    });
</script>


@endsection
@extends('backend.layout.window')
@inject('CarInsuranceOrderPresenter','App\Presenters\CarInsuranceOrderPresenter')
@section('content')

    <div class="page-container">

        <a class="btn btn-default" style="margin-top: -1%;margin-bottom: 1%" href="{{$data['identity_card_file']}}" target="_blank">身份证图片</a> <a class="btn btn-default" style="margin-top: -1%;margin-bottom: 1%" href="{{$data['driving_license_file']}}" target="_blank">行驶证图片</a>

        {!! Form::model($data,['url'=> 'backend/carInsurance/order/'.$data->id, 'method' => 'put','class'=>'form form-horizontal', 'id'=>'form-article-add' ]) !!}
        @include('backend.carInsurance.orderForm',['formType'=>'update'])

        {!! Form::close() !!}


        <input id="pathDetail"  type="file" name="pathDetail"
               onchange="ajaxUpload(this)" style="display:none;">
    </div>

@endsection

@section('after.js')
    <script type="text/javascript" src="/lib/PCASClass/PCASClass.js"></script>
    <script type="text/javascript" src="/lib/My97DatePicker/WdatePicker.js"></script>
    <script type="text/javascript">
        new PCAS("owner_province={{old('owner_province',$data->owner_province)}}", "owner_city={{old('owner_city',$data->owner_city)}}", "owner_area=>{{old('owner_area',$data->owner_area)}}");

        $(function () {
            $.Huitab("#tab_demo .tabBar span", "#tab_demo .tabCon", "current", "click", "0");
        });


        function uploadButton(obj) {
            var pathDetail = $('#pathDetail');
            pathDetail.attr('target', $(obj).attr('id'));
            pathDetail.click()
        }

        function ajaxUpload(obj) {
            var formdata = new FormData();
            var v_this = $(obj);
            $('#upfileDetail').value = v_this.val();
            var fileObj = v_this.get(0).files;
            var target = v_this.attr('target');
            url = '{{route('ajaxUpload')}}';
//var fileObj=document.getElementById("fileToUpload").files;
            formdata.append("imgFile", fileObj[0]);
            formdata.append("_token", '{{csrf_token()}}');
            formdata.append("id", '{{$id}}');
            formdata.append("filed", target);
            $.ajax({
                url: url,
                type: 'post',
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function (xmlhttp) {
                    $('#' + target).attr('src', '/static/car-insurance/loading.gif');
                },
                success: function (res) {
                    if (res.code == 200) {
                        $('#' + target).attr('src', '{{config('carInsurance.store.domain')}}' + res.data+"?"+ Math.random());
                        $('input[name="' + target + '"]').val(res.data);
                    } else {
                        alert(res.msg);
                    }
                }
            });
        }
    </script>
@endsection


@section('after.css')

@endsection
@extends('backend.layout.frame')
@inject('carInsuranceOrderPresenter','App\Presenters\CarInsuranceOrderPresenter')
@section('content')
    <div class="page-container">

    <div class="row cl">
    {{--    <div class="formControls col-xs-4"></div>--}}
        <label class="form-label col-xs-3 col-sm-2 text-li">我的推荐人ID：</label>
        <div class="formControls col-xs-2 col-sm-4">
        {{$id}}
        </div>

    </div>
    </div>
@endsection
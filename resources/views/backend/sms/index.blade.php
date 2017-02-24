@extends('backend.layout.frame')
@inject('smsPresenter','App\Presenters\SmsPresenter')

@section('content')
    @include('backend.components.searchv2', ['search' => $smsPresenter->getSearchParams()])
    @include('backend.components.tablev2',  ['table' => $smsPresenter->getTableParams()])
@endsection

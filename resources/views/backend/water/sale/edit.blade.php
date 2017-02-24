@extends('backend.layout.window')
@section('content')
    <article class="page-container">

        {!! Form::model($data,['url'=>route('backend.waterSale.update',['id'=>$data->id]), 'method' => 'put','class'=>'form form-horizontal', 'id'=>'form-article-add' ]) !!}
        @include('backend.water.sale.form')
        {!! Form::close() !!}
    </article>
@endsection

@extends('backend.layout.window')
@section('content')
    <article class="page-container">

        <form action="{{route('backend.waterSale.store')}}" method="post" class="form form-horizontal"
              id="form-member-add">
            @include('backend.water.sale.form')
        </form>
    </article>
@endsection

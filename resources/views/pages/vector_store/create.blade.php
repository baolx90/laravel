@extends('layouts.default')
@section('content')
    <div class="container p-5">
        <form enctype="multipart/form-data" method="post" action="{{url('create')}}">
            @csrf
            @include('pages.vector_store.includes.form')
        </form>
    </div>
@stop

@extends('layouts.default')
@section('content')
    <div class="container p-5">
        <img src="http://localhost/public/storage/vector-stores/bAIfB4Dqy9.1715583637.png"/>
        <form enctype="multipart/form-data" method="post" action="{{url('admin/vector-store')}}">
            @csrf
            @include('pages.vector_store.includes.form')
        </form>
    </div>
@stop

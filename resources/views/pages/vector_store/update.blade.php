@extends('layouts.default')
@section('content')
    <div class="container p-5">
        <form enctype="multipart/form-data" method="post" action="{{url($bot->id)}}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Prompt</label>
                <textarea class="form-control" style="min-height:200px" name="prompt">{{$bot->prompt}}</textarea>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ url('/') }}">
                    <button type="button" class="btn btn-secondary">Cancel</button>
                </a>
            </div>
        </form>
    </div>
@stop

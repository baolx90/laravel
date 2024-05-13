@extends('layouts.default')
@section('content')
    <div class="container p-5">
        <div class="text-end">
            <a href="{{ url('admin/vector-store/create') }}">
                <button type="button" class="btn btn-primary">Create</button>
            </a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bots as $bot)
                    <tr>
                        <td>{{$bot->id}}</td>
                        <td>{{$bot->name}}</td>
                        <td>{{$bot->status}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

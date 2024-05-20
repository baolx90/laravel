@extends('layouts.default')
@section('content')
    <div class="container p-5">
        <div class="text-end">
            <a href="{{ url('create') }}">
                <button type="button" class="btn btn-primary">Create</button>
            </a>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Code</th>
                <th scope="col">Prompt</th>
                <th scope="col">Status</th>
                <th scope="col">#</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bots as $bot)
                <tr>
                    <td>{{$bot->id}}</td>
                    <td>{{$bot->name}}</td>
                    <td>{{$bot->code}}</td>
                    <td>{{$bot->prompt}}</td>
                    <td>{{$bot->status}}</td>
                    <td>
                        @if($bot->status == 'ACTIVE')
                            <a href="{{url('bot/'.$bot->code)}}" target="_blank">chat</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop

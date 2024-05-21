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
                <th scope="col">Name</th>
                <th scope="col">Code</th>
                <th scope="col">Prompt</th>
                <th scope="col">Status</th>
                <th scope="col" colspan="2">#</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bots as $bot)
                <tr>
                    <td>{{$bot->name}}</td>
                    <td>{{$bot->code}}</td>
                    <td>{{$bot->prompt}}</td>
                    <td>{{$bot->status}}</td>
                    <td>
                        @if($bot->status == 'ACTIVE')
                            <a href="{{url('bot/'.$bot->code)}}" target="_blank">chat</a>
                        @endif
                    </td>
                    <td>
                        @if($bot->status == 'ACTIVE')
                            <a href="#">
                                <button type="button" class="btn p-0" data-bs-toggle="modal"
                                        data-bs-target="#modal{{$bot->id}}">
                                    Embed
                                </button>
                            </a>
                            <div class="modal fade" id="modal{{$bot->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="pills-profile-tab"
                                                            data-bs-toggle="pill" data-bs-target="#pills-profile"
                                                            type="button" role="tab" aria-controls="pills-profile"
                                                            aria-selected="false">Page
                                                    </button>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                                     aria-labelledby="pills-profile-tab">
                                                    <p class="chakra-text css-1ogc5ay">Copy and paste this code <strong>into
                                                            a page </strong> of your website. You may wish to change the
                                                        <strong>height</strong> and <strong>width</strong> attributes
                                                        <br>
                                                        <code class="chakra-code css-1i9kgwe">&lt;iframe
                                                            src="{{env('APP_URL')}}/bot/{{$bot->code}}"
                                                            style="border-width: 0px;"
                                                            allow="clipboard-read; clipboard-write"
                                                            width="100%"
                                                            height="100%"
                                                            &gt;&lt;/iframe&gt;</code>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop

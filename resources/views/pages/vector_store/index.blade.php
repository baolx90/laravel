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
                                                    <button class="nav-link" id="pills-home-tab"
                                                            data-bs-toggle="pill" data-bs-target="#pills-home"
                                                            type="button" role="tab" aria-controls="pills-home"
                                                            aria-selected="true">Widget
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="pills-profile-tab"
                                                            data-bs-toggle="pill" data-bs-target="#pills-profile"
                                                            type="button" role="tab" aria-controls="pills-profile"
                                                            aria-selected="false">Page
                                                    </button>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade " id="pills-home" role="tabpanel"
                                                     aria-labelledby="pills-home-tab">
                                                    <p class="chakra-text css-1s41qea">Copy and paste this code <strong>at
                                                            the end of the &lt;body&gt; tag</strong> of a page on your
                                                        website <br> <code class="chakra-code css-1bw4ib9">&lt;script
                                                            src="{{env('APP_URL')}}/scripts/chat.js"
                                                            data-name="lamxuanbao"
                                                            data-address="{{env('APP_URL')}}"
                                                            data-id="{{$bot->code}}"
                                                            data-widget-size="normal"
                                                            data-widget-button-size="normal"
                                                            defer
                                                            &gt;&lt;/script&gt;</code></p>
                                                </div>
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
{{--    <script--}}
{{--        src="https://app.wonderchat.io/scripts/wonderchat.js"--}}
{{--        data-name="wonderchat"--}}
{{--        data-address="app.wonderchat.io"--}}
{{--        data-id="cltr3xjzf05bkml2jzqyc1vtq"--}}
{{--        data-widget-size="normal"--}}
{{--        data-widget-button-size="normal"--}}
{{--        defer--}}
{{--    ></script>--}}
    <script src="http://127.0.0.1/scripts/chat.js" data-name="lamxuanbao" data-address="http://127.0.0.1" data-id="bb56e1ef81f86b3065c103cb460486680f4ccdd6" data-widget-size="normal" data-widget-button-size="normal" defer ></script>
@stop

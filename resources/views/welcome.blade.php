<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
            }

            .text-large {
                font-size: 150%;
                line-height: 160%;
            }

            .text-medium {
                font-size: 120%;
                line-height: 160%;
            }

            .text-small {
                font-size: 80%;
                line-height: 130%;
            }

            .cursor {
                cursor: pointer;
            }

            code {
                color: inherit !important;
            }
        </style>
    </head>
    <body>
        <div id="app" class="content">
            <div class="row">
                <div class="col-6 mx-auto">
                    <div class="mb-5 text-center">
                        <h1 class="display-1">Proxy Check</h1>
                        <p class="lead">A sanity tool from <a href="https://github.com/indemnity83">Kyle Klaus</a></p>
                    </div>

                    <ul class="list-group mb-3 text-large">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Server thinks request is proxied
                            <code>{{ request()->isFromTrustedProxy() ? 'Yes' : 'No'}}</code>
                        </li>
                        <li class="list-group-item flex-column align-items-start">
                            <div data-toggle="collapse" href="#ip-detail" role="button"
                               aria-expanded="true" aria-controls="collapseExample"
                               class="d-flex w-100 justify-content-between align-items-center cursor"
                            >
                                Server knows IP
                                <i id="ip-check"></i>
                            </div>
                            <div class="alert mt-3 text-small collapse show" id="ip-detail">
                                The server thinks the client IP address is <code>{{ request()->getClientIp() }}</code>.<br />
                                Your public IP address is <code id="ip-address"></code>.
                            </div>
                        </li>
                        <li class="list-group-item flex-column align-items-start">
                            <div data-toggle="collapse" href="#protocol-detail" role="button"
                                 aria-expanded="true" aria-controls="collapseExample"
                                 class="d-flex w-100 justify-content-between align-items-center cursor"
                            >
                                Server knows Protocol
                                <i id="protocol-check"></i>
                            </div>
                            <div class="alert mt-3 text-small collapse show" id="protocol-detail">
                                The server thinks the protocol is <code>{{ request()->isSecure() ? 'https:' : 'http:' }}</code>.<br />
                                The url for this page is <code id="protocol-address"></code>.
                            </div>
                        </li>

                        <li class="list-group-item flex-column align-items-start">
                            <div data-toggle="collapse" href="#route-detail" role="button"
                                 aria-expanded="true" aria-controls="collapseExample"
                                 class="d-flex w-100 justify-content-between align-items-center cursor"
                            >
                                Generated URLs are followable
                                <i id="normalUrl"></i>
                            </div>
                            <div class="alert mt-3 text-small collapse show" id="route-detail">
                                <ul>
                                    <li>sending request to <code>{{ $url }}</code></li>
                                    <li>server thinks we requested <code id="url"></code></li>
                                </ul>
                            </div>
                        </li>
                        <li class="list-group-item flex-column align-items-start">
                            <div data-toggle="collapse" href="#signed-detail" role="button"
                                 aria-expanded="true" aria-controls="collapseExample"
                                 class="d-flex w-100 justify-content-between align-items-center cursor"
                            >
                                Signed URLs are valid
                                <i id="signedUrl"></i>
                            </div>
                            <div class="alert mt-3 text-small collapse show" id="signed-detail">
                                <ul style="overflow: scroll">
                                    <li>sending request to <code>{{ $signedUrl }}</code></li>
                                    <li>server thinks we requested <code id="signed-url"></code></li>
                                    <li>server reports signature is <code id="signed-status"></code></li>
                                </ul>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Request Headers

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#showHeaders">
                                Show
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="showHeaders" tabindex="-1" role="dialog" aria-labelledby="showHeadersLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body text-nowrap text-medium" style="overflow: scroll;">
                        @foreach(request()->header() as $header => $values)
                            <strong>{{ title_case($header)  }}:</strong> {{ implode(', ', $values) }} <br />
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="/js/app.js"></script>
        <script>
            $.getJSON('{{ $url }}', function(data) {
                if(data.status === 'ok') {
                    $('#normalUrl').addClass('fas fa-check text-success');
                } else {
                    $('#normalUrl').addClass('fas fa-times text-danger');
                    $('#route-detail').addClass('alert-danger');
                }

                $('#url').text(data.url);
            });

            $.getJSON('{{ $signedUrl }}', function(data) {
                if(data.status === 'ok') {
                    $('#signedUrl').addClass('fas fa-check text-success');
                } else {
                    $('#signedUrl').addClass('fas fa-times text-danger');
                    $('#signed-detail').addClass('alert-danger');
                }

                $('#signed-url').text(data.url);
                $('#signed-status').text(data.status);
            });

            $.getJSON('https://ipapi.co/json/', function(data) {
                if(data.ip === '{{ request()->getClientIp() }}') {
                    $('#ip-check').addClass('fas fa-check text-success');
                } else {
                    $('#ip-check').addClass('fas fa-times text-danger');
                    $('#ip-detail').addClass('alert-danger');
                    $('#ip-address').text(data.ip);
                }
            });

            $('#protocol-address').text(location.protocol);
            if (location.protocol === '{{ request()->isSecure() ? 'https:' : 'http:' }}') {
                $('#protocol-check').addClass('fas fa-check text-success');
            } else {
                $('#protocol-check').addClass('fas fa-times text-danger');
                $('#protocol-detail').addClass('alert-danger');
            }
        </script>


    </body>
</html>

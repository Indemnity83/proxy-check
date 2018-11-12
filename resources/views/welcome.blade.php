<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
                margin: 0 25px;
            }

            .title {
                font-size: 84px;
            }

            .m-md {
                margin-top: 30px;
                margin-bottom: 30px;
            }

            .key {
                color: #636b6f;
                padding: 0 25px;
                font-size: 20px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                min-width: 400px;
                text-align: right;
            }

            .value {
                text-align: left;
                color: #636b6f;
                padding: 0 25px;
                font-size: 20px;
                line-height: 30px;
            }

            .row {
                display: flex;
                padding: 10px 0;
                margin-bottom: 20px;
            }

            .row:nth-child(even) {
                background-color: #f8fafc;
            }

            code {
                white-space: nowrap;
                overflow-x: scroll;
            }

            pre {
                box-sizing: border-box;
                margin: 0;
                font-size: 14px;
                padding: 15px 20px;
                border-width: 1px;
                border-style: solid;
                border-color: #ccc;
                background-color: #fcfcfc;
                overflow: scroll;
            }
        </style>
    </head>
    <body>
        <div class="position-ref full-height">
            <div class="content">
                <div class="m-md">
                    <div class="title">Proxy Check</div>
                    <span>A sanity tool from <a href="https://github.com/indemnity83">Kyle Klaus</a></span>
                </div>


                <hr />

                <div class="row">
                    <div class="key">Is From Trusted Proxy</div>
                    <div class="value"><code>{{ request()->isFromTrustedProxy() ? 'Yes' : 'No'}}</code></div>
                </div>

                <div class="row">
                    <div class="key">Is Secure</div>
                    <div class="value"><code>{{ request()->isSecure() ? 'Yes' : 'No'}}</code></div>
                </div>

                <div class="row">
                    <div class="key">Client IPs</div>
                    <div class="value"><code>{{ implode(', ', request()->getClientIps()) }}</code></div>
                </div>

                <div class="row">
                    <div class="key">Request Headers</div>
                    <div class="value">
                        <code>
                            @foreach(request()->header() as $header => $values)
                                <strong>{{ title_case($header)  }}:</strong> {{ implode(', ', $values) }} <br />
                            @endforeach
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

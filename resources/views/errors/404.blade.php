<!DOCTYPE html>
<html>
    <head>
        <title>Page not found.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 400;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
                width: 465px;

                animation: type 1.5s steps(14), blink 0.75s infinite alternate;
                overflow: hidden;
                white-space: nowrap;
                border-right: 3px solid;
            }

            @keyframes type {
                from {
                    width: 0;
                }
            }

            @keyframes blink {
                50% {
                    border-color: transparent;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Page not found.</div>
            </div>
        </div>
    </body>
</html>

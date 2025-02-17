<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <!-- note - imported through link for sake of speed -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Code Challenge</title>
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: sans-serif;
            height: 100vh;
            margin: 50px;
        }

        .full-height {
            height: 100vh;
        }

        .result {
        }
    </style>
</head>
<body>
    <div class="full-height">
        <div class="result">
            Your Search Term Was: <b>{{ $searchTerm }}</b>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="result">
                    <h3>Results</h3>
                    <div class="row">
                        <div class="col-md-4">
                            {!! $resultViews['albums'] !!}
                        </div>
                        <div class="col-md-4">
                            {!! $resultViews['artists'] !!}
                        </div>
                        <div class="col-md-4">
                            {!! $resultViews['tracks'] !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

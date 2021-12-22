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
        .text-blue {
            color: #84B7DD;
        }

        .full-height {
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="full-height">
        <div class="container">
            <a href="{{ route('home') }}">
                <h7 class="text-blue">Search again</h7>
            </a>
            @if (!empty($detail))
                <h3>{{ $detail['type'] }} Details</h3>
                <div class="row">
                    {!! $detail['item_view'] !!}
                </div>
            @else
                <h3>No results found</h3>
            @endif
        </div>
    </div>
</body>
</html>

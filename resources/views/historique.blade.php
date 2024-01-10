<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css" />
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            padding-top: 60px;
        }
    </style>
</head>

<body>
    <x-header />
    <div class="field is-grouped is-grouped-centered" style="margin-top: 14px;">
        <div class="box" style="width: 800px;">
            <div class="field is-grouped is-grouped-centered">
                <h1>Mes plongées</h1>
            </div>
            <br>
            @foreach ($dives as $dive)
            <h2>{{$dive[0]['DIV_ID']." ".$dive[0]['DIV_COMMENT']." ".$dive[0]['DIV_DATE']." ".$dive[0]['SIT_ID']}}</h2>
            <br>
            @endforeach
        </div>
        <x-footer />
</body>
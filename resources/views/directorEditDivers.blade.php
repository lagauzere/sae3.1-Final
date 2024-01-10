<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=a, initial-scale=1.0">
    <title>Modifier les adhérents d'une plongée </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css" />

    <style>
        html {scroll-behavior: smooth;}
        body {padding-top: 60px;}
    </style>
</head>

<body>
    <x-header/>
        <h1>Plongée n°{{ $div_id }}</h1>
        <h2>Modifier les adhérents de la plongée</h2>
        {{var_dump($participants)}}
        <table>
        @foreach($participants as $p)
            <tr><!-- maybe in red when cancelled -->
                <th>
                {{$p['DVR_LICENCE']}}&nbsp
                </th>
                <th>
                {{$p['DVR_FIRST_NAME']}}  {{$p['DVR_NAME']}} &nbsp
                </th>
                <th>
                {{$p['DLV_LABEL']}}&nbsp
                </th>
                <th>
                {{$p['DLV_LABEL']}}&nbsp
                </th>
                <th>
                </th>
                <th>
                <form action="{{ route('handle-form-change-participation-state') }}" method="POST">
                    @csrf 
                    <input name="uid" type="hidden" value="{{$p['DVR_LICENCE']}}"/>
                    <input name="div_id" type="hidden" value="{{$div_id}}"/>
                    <input name="wanted_state" type="hidden" value=@if($p['PAR_CANCELLED']) 0 @else 1 @endif/>
                    <button type="submit">@if($p['PAR_CANCELLED']) réinscrire @else désinscrire @endif</button>
                </form>
                </th>
            </tr>
        @endforeach
        </table>
    <x-footer/>
</body>
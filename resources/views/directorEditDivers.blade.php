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
        <h1>Modifier les adhérents d'une plongée</h1>

        {{var_dump($participants)}}
        @foreach($participants as $p)
            <div>
                <!-- maybe in red when cancelled -->
                les infos ici
                <form action="{{ route('handle-form-change-participation-state') }}" method="POST">
                    @csrf 
                    <input name="uid" type="hidden" value={{$p['DVR_LICENCE']}}/>
                    <input name="div_id" type="hidden" value={{$div_id}}/>
                    <input name="wanted_state" type="hidden" value=@if($p['PAR_CANCELLED']) 0 @else 1 @endif/>
                    <button type="submit">@if($p['PAR_CANCELLED']) réinscrire @else désinscrire @endif</button>
                </form>
            </div>
        @endforeach


    <x-footer/>
</body>
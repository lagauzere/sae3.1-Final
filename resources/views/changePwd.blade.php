<?php
     use App\Models\User;

    if(session('userID')==null  ){
        abort(404);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css" />
    <link rel="stylesheet" href="/resources/css/app.css">
    </link>
    <style>
        html {scroll-behavior: smooth;}
        body {padding-top: 60px;}
    </style>
</head>
<body>
    <x-header />

    <div class="field is-grouped is-grouped-centered">
        <form class="box" style="width: 400px;" method="POST">
            @csrf

            <p>Entrer nouveau mot de passe</p>
            <input class="input" type="password" name="password" placeholder="********">
            <p>Confirmer nouveau mot de passe</p>
            <input class="input" type="password" name="passwordCheck" placeholder="********">
            <div class="field is-grouped is-grouped-centered">
             @if(session('erreurCode')==-1)
                <p style="color:red; text-align: center; margin-bottom: 15px;">Erreur mot de passe vide ou vérification différente
            </p>
            @endif
                <button class="button is-info" type="submit">Modifier</button>
            </div>
        </form> 
    </div>
    <x-footer />
</body>

</html>
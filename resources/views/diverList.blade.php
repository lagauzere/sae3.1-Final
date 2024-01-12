<!DOCTYPE html>
<html lang="fr">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css" />
    <style>
        html {scroll-behavior: smooth;}
        body {
            padding-top: 60px;
        }
    </style>
</head>
<body>
    <x-header/>
    </br>
    </br>
    <div class="field is-grouped is-grouped-centered">
    <h1 class="title is-1" style= "position: absolute; left: 50%; transform: translate(-50%, -50%)">Liste des plongeurs</h1>

    
        <table class="box table is-hoverable" style="margin-top: 70px;">
            <thead>
                <tr>
                    <th><abbr title="Nom">Nom</abbr></th>
                    <th><abbr title="Prénom">Prénom</abbr></th>
                </tr>
            </thead>
            <tbody>
        
            <?php 
            foreach ($divers as $diver) :?>
            <tr>
                <th><?php echo $diver['DVR_NAME']; ?></th>
                <td><?php echo $diver['DVR_FIRST_NAME']; ?></td>
            </tr>
            <?php
            endforeach
            ?> 
            </tbody>
        </table>
            </div>

    <x-footer/>
</body>
</html>
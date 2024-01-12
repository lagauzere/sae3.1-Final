<?php
     use App\Models\User;

    if(session('userID')==null  ){
        abort(404);
    }
    elseif (User::isAdmin()==0){
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
    <div class="field is-grouped is-grouped-centered">
        <table class="box table is-hoverable" style="margin-top: 70px;">
            <thead>
                <tr>
                    <th><abbr title="Nom">Nom</abbr></th>
                    <th><abbr title="Prénom">Prénom</abbr></th>
                    <th><abbr title="Licence">Licence</abbr></th>
                    <th><abbr title="Pilote">Pilote</abbr></th>
                    <th><abbr title="Directeur">Directeur</abbr></th>
                    <th><abbr title="Responsable">Sécurité surface</abbr></th>
                    <th>Admin</th>
            <th><abbr title="Valider">Valider</abbr></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><abbr title="Nom">Nom</abbr></th>
                    <th><abbr title="Prénom">Prénom</abbr></th>
                    <th><abbr title="Licence">Licence</abbr></th>
                    <th><abbr title="Pilote">Pilote</abbr></th>
                    <th><abbr title="Directeur">Directeur</abbr></th>
                    <th><abbr title="Responsable">Responsable</abbr></th>
                    <th><abbr title="Valider">Valider</abbr></th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($result as $user) :
                    $userArray = json_decode(json_encode($user), true); ?>
                    <tr>
                        <th><?php echo $userArray['DVR_NAME']; ?></th>
                        <td><?php echo $userArray['DVR_FIRST_NAME']; ?></td>
                        <td><?php echo $userArray['DVR_LICENCE']; ?></td>
                        <form action="{{ route('update-role', ['dvr_licence' => $userArray['DVR_LICENCE']]) }}" method="post">
                            @csrf
                            <td><input name="isPilote" type="checkbox" <?php echo ($userArray['DVR_CANDRIVE'] == 1) ? 'checked' : ''; ?>></td>
                            <td><input name="isDirector" type="checkbox" <?php echo ($userArray['DVR_CANDIRECT'] == 1) ? 'checked' : ''; ?>></td>
                            <td><input name="isManager" type="checkbox" <?php echo ($userArray['DVR_CANMONITOR'] == 1) ? 'checked' : ''; ?>></td>
                            <td><input name="isAdmin" type="checkbox" <?php echo ($userArray['DVR_ISADMIN'] == 1) ? 'checked' : ''; ?>></td>
                        <td><button type="submit" action="" class="button is-white">
                                    <p class="text has-text-success"><strong>ok</strong></p>
                                </button></td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <x-footer />
</body>

</html>
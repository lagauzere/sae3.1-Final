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
</head>
<body>
    <x-header/>
    </br>
</br>
</br>
</br>
</br>



<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Licence</th>
            <th>Pilote</th>
            <th>Directeur</th>
            <th>Sécurité surface</th>
            <th>Admin</th>
            <th>Valider</th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $user): 
             $userArray = json_decode(json_encode($user), true); ?>
            <tr>
                <td><?php echo $userArray['DVR_NAME']; ?></td>
                <td><?php echo $userArray['DVR_FIRST_NAME']; ?></td>
                <td><?php echo $userArray['DVR_LICENCE']; ?></td>
                <form action="{{ route('update-role', ['dvr_licence' => $userArray['DVR_LICENCE']]) }}" method="post">
                  @csrf
                    <td><input name="isPilote" type="checkbox" <?php echo ($userArray['DVR_CANDRIVE'] == 1) ? 'checked' : ''; ?>></td>
                    <td><input name="isDirector" type="checkbox" <?php echo ($userArray['DVR_CANDIRECT'] == 1) ? 'checked' : ''; ?>></td>
                    <td><input name="isManager" type="checkbox" <?php echo ($userArray['DVR_CANMONITOR'] == 1) ? 'checked' : ''; ?>></td>
                    <td><input name="isAdmin" type="checkbox" <?php echo ($userArray['DVR_ISADMIN'] == 1) ? 'checked' : ''; ?>></td>
                    <td><button type="submit" action="">valider</button></td>

                </form>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>






</body>
</html>

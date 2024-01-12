<?php
     use App\Models\User;

    if(session('userID')==null  ){
        abort(404);
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=a, initial-scale=1.0">
    <title>Liste des plongeurs </title>
</head>
<body>
    <h1>Liste des plongeurs</h1>
    <?php 


    foreach ($divers as $diver) {
        echo "<h2>" . $diver['DVR_NAME'] . " " .  $diver['DVR_FIRST_NAME'] . "</h2> ";
    }
    ?>

</body>
</html>
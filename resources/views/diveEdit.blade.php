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
    <title>Modification effectué</title>
    
</head>
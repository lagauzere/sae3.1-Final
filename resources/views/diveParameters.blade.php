<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=a, initial-scale=1.0">
    <title>Information sur la plongée </title>
</head>

<body>
    <h1> Nom du bateau : {{ $divesparameters[0]["SHP_NAME"] }}</h1>
    <h2> Site de la plongée : {{ $divesparameters[0]["SIT_NAME"] }}</h2>
    <h2> Directeur de la plongée : {{ $divesparameters[0]["DIVER"] }}</h2>
    <h2> Pilote de la plongée : {{ $divesDriver[0]["DIVER"] }}</h2>
    <h2> Sécurité surface de la plongée : {{ $divesMonitor[0]["DIVER"] }}</h2>
    <h2> Nombre minimum d'inscrit pour la plongée : 4 </h2>
    <h2> Nombre maximum d'inscrit pour la plongée : {{ $divesparameters[0]["DIV_HEADCOUNT"] }}</h2>
    <h2> Niveau minimun requis de la plongée : {{ $divesparameters[0]["DLV_DESC"] }}</h2>
</body>
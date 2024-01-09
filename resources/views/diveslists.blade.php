<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=a, initial-scale=1.0">
    <title>Liste des plongées </title>
</head>
<body>
    <h1>Listes des plongées disponible</h1>
    @foreach($dives as $dive)
        <h2><a href="#">Plongée numéro : {{ $dive["div_id"] }}</a></h2>
        <h3>Date de la séance : {{$dive["DIV_DATE"] }}</p>
        <h3>Bateau utilisé : {{ $dive["shp_name"]}}</h3>
        <h3>Site de plongée : {{ $dive["sit_name"] }}</h3>
        <h3> Profondeur du site : {{ $dive["sit_depth"] }}m</h3>
    @endforeach
</body>
</html>
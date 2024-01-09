<!DOCTYPE html>
<html lang="fr">
<head>
    @livewireStyles
    <meta charset="UTF-8">
    <meta name="viewport" content="width=a, initial-scale=1.0">
    <title>Liste des plongées </title>
</head>
<body>
    <h1>Listes des plongées disponible</h1>
    @foreach($dives as $dive)
        <h2>Plongée numéro : {{ $dive['DIV_ID'] }}</h2>
        <h3>Date de la séance : {{$dive["DIV_DATE"] }}</p>
        <h3>Bateau utilisé : {{ $dive["SHP_NAME"]}}</h3>
        <h3>Site de plongée : {{ $dive["SIT_NAME"] }}</h3>
        <h3> Profondeur du site : {{ $dive["SIT_DEPTH"] }}m</h3>
        <form action="{{ route('enterTimeSlot',['selectedDive' => $dive['DIV_ID']]) }}" method="POST">
            @csrf
            <input type="submit" name="DiveParticipation" value="M'inscrire">
        </form>
    @endforeach
    <livewire:calendar />
    @livewireScripts
    @stack('scripts')
</body>
</html>
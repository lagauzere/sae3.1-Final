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
        <h2>Plongée numéro : {{ $dive["div_id"] }}</h2>
        <h3>Date de la séance : {{$dive["DIV_DATE"] }}</p>
        <h3>Bateau utilisé : {{ $dive["SHP_NAME"]}}</h3>
        <h3>Site de plongée : {{ $dive["SIT_NAME"] }}</h3>
        <h3> Profondeur du site : {{ $dive["SIT_DEPTH"] }}</h3>
        @if(session()->has('userID'))
        <p>{{session('userID')}}</p>
        <form action="{{ route('enterTimeSlot',['selectedDive' => $dive['DIV_ID']]) }}" method="POST">
            @csrf
            <input type="submit" name="DiveParticipation" value="M'inscrire">
        </form>
        @else 
        <form action="{{ route('leaveTimeSlot',['selectedDive' => $dive['div_id']]) }}" method="POST">
            @csrf
            <input type="submit" value="Me désinscrire">
        </form>
        @endif
    @endforeach
    <livewire:calendar />
    @livewireScripts
    @stack('scripts')
</body>
</html>
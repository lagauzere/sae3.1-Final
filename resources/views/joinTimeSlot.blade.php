<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer un utilisateur</title>
</head>
<body>
    <form action="{{ route('enterTimeSlot') }}" method="GET">
        @csrf
        <input type="submit" name="DiveParticipation" value="M'inscrire">
    </form>
    
    <button class="button is-info" action='/infoDive'>liste</button>

</body>
</html>

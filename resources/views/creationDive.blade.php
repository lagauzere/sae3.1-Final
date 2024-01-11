<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=a, initial-scale=1.0">
    <title>Création d'une plongée </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css" />
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
<x-header/>
    <form id="creationForm" action="/createDataDives" method="POST">
        @csrf
    <h1> Nom du bateau : 
        <select id="choiceBoat" name="choiceBoat">
            @foreach($boatName as $boat)
                <option value="{{ $boat['SHP_ID'] }}">{{ $boat['SHP_NAME'] }} ({{ $boat['SHP_SEATS']}} places)</option>
            @endforeach
        </select>
    </h1>

    <h2> Site de la plongée : 
        <select id="choiceSite" name="choiceSite">
            @foreach($siteName as $site)
                <option value="{{ $site['SIT_ID'] }}">{{ $site['SIT_NAME'] }} {{ $site['SIT_DEPTH']}} mètres de profondeur</option>
            @endforeach
        </select>
    </h2>

    <h2> Directeur de la plongée :   
        <select id="choiceDirector" name="choiceDirector">
            @foreach($directorName as $director)
                <option value="{{ $director['DVR_LICENCE'] }}" >{{ $director['DIVER'] }}</option>
            @endforeach
        </select>
    </h2>

    <h2> Pilote de la plongée : 
        <select id="choiceDriver" name="choiceDriver">
            @foreach($driverName as $driver)
                <option value="{{ $driver['DVR_LICENCE'] }}">{{ $driver['DIVER'] }}</option>
            @endforeach
        </select>
    </h2>

    <h2> Sécurité surface de la plongée : 
        <select id="choiceMonitor" name="choiceMonitor">
            @foreach($monitorName as $monitor)
                <option value="{{ $monitor['DVR_LICENCE'] }}">{{ $monitor['DIVER'] }}</option>
            @endforeach
        </select>
    </h2>

    <h2> Niveau minimum requis de la plongée : 
        <select id="choiceDivingLevel" name="choiceDivingLevel">
            @foreach($minimumLevel as $level)
                <option value="{{ $level['DLV_ID'] }}">{{ $level['DLV_LABEL'] }}</option>
            @endforeach
        </select>
    </h2>
    
    <h2> Date de la session : 
        <input type="date" name="date" id="date"/>
    </h2>

    <h2> Créneau de la session : 
        <select name="choiceHours" id="choiceHours">
            <option value="09:00:00">9h00</option>
            <option value="13:30:00">13h30</option>
            <option value="18:00:00">18h00</option>
        </select>
    </h2>

    <h2>
        <textarea id="comment" name="comment" rows="5" cols="33" placeholder="Description de la plongée..."></textarea>
    </h2>

    <button type="submit" id="validate" onclick="submitForm()">Valider</button>

    </form>
    <script>
        let test = document.getElementById("choiceHours")
        console.log(test.value);

        function submitForm() {

            document.getElementById("creationForm").submit();
        }

    </script>
<x-footer/>
</body>
</html>
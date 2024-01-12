<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=a, initial-scale=1.0">
    <title>Informations sur la plongée n° {{ $divesparameters[0]["DIV_ID"] }} </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css"/>
    <link rel="stylesheet" href="/resources/css/app.css"/>
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
    <form id="updateForm" action="/changeDataDives" method="POST">
        @csrf
    <h1> Nom du bateau : {{ $divesparameters[0]["SHP_NAME"] }} ({{ $divesparameters[0]["SHP_SEATS"]}} places)
    <button type="button" onclick="displayText('choiceBoat')">Modifier</button>  
        <select style="display:none" id="choiceBoat" name="choiceBoat" default="{{ $divesparameters[0]['SHP_NAME'] }}">
            @foreach($boatName as $boat)
                @if(($divesparameters[0]["SHP_SEATS"] - $divesparameters[0]["DIV_HEADCOUNT"]) + 2 <= $boat['SHP_SEATS'])
                <option value="{{ $boat['SHP_ID'] }}" @if($boat['SHP_NAME'] == $divesparameters[0]['SHP_NAME']) selected @endif>{{ $boat['SHP_NAME'] }} ({{ $boat['SHP_SEATS']}} places)</option>
                @endif
            @endforeach
        </select>
    </h1>

    <h1>
        Nombre de personne présente sur le bateau : {{ ($divesparameters[0]["SHP_SEATS"] - $divesparameters[0]["DIV_HEADCOUNT"] + 2) }}
    </h1>

    <h2> Site de la plongée : {{ $divesparameters[0]["SIT_NAME"] }} ({{ $divesparameters[0]["SIT_DEPTH"]}} mètres de profondeur)  
    <button type="button" onclick="displayText('choiceSite')">Modifier</button>  
        <select style="display:none" id="choiceSite" name="choiceSite">
            @foreach($siteName as $site)
                <option value="{{ $site['SIT_ID'] }}" @if($site['SIT_NAME'] == $divesparameters[0]['SIT_NAME']) selected @endif>{{ $site['SIT_NAME'] }} ({{ $site['SIT_DEPTH']}} mètres de profondeur)</option>
            @endforeach
        </select>

    <h2> Directeur de la plongée : {{ $divesparameters[0]["DIVER"] }}  
    <button type="button" onclick="displayText('choiceDirector')">Modifier</button>  
        <select style="display:none" id="choiceDirector" name="choiceDirector">
            @foreach($directorName as $director)
                <option value="{{ $director['DVR_LICENCE'] }}" @if($director['DIVER'] == $divesparameters[0]['DIVER']) selected @endif>{{ $director['DIVER'] }}</option>
            @endforeach
        </select>
    </h2>

    <h2> Pilote de la plongée : {{ $divesDriver[0]["DIVER"] }}  
    <button type="button" onclick="displayText('choiceDriver')">Modifier</button>  
        <select style="display:none" id="choiceDriver" name="choiceDriver">
            @foreach($driverName as $driver)
                <option value="{{ $driver['DVR_LICENCE'] }}" @if($driver['DIVER'] == $divesDriver[0]['DIVER']) selected @endif>{{ $driver['DIVER'] }}</option>
            @endforeach
        </select>

    <h2> Sécurité surface de la plongée : {{ $divesMonitor[0]["DIVER"] }}  
    <button type="button" onclick="displayText('choiceMonitor')">Modifier</button>  
        <select style="display:none" id="choiceMonitor" name="choiceMonitor">
            @foreach($monitorName as $monitor)
                <option value="{{ $monitor['DVR_LICENCE'] }}" @if($monitor['DIVER'] == $divesMonitor[0]['DIVER']) selected @endif>{{ $monitor['DIVER'] }}</option>
            @endforeach
        </select>
    </h2>
    
    <h2> Nombre maximum d'inscrit pour la plongée : {{ $divesparameters[0]["SHP_SEATS"]}} plongeurs

    <h2> Niveau minimum requis de la plongée : {{ $divesparameters[0]["DLV_LABEL"] }}  
        <button type="button" onclick="displayText('choiceDivingLevel')">Modifier</button>  
        <select style="display:none" id="choiceDivingLevel" name="choiceDivingLevel">
            @foreach($minimumLevel as $level)
                <option value="{{ $level['DLV_ID'] }}" @if($level['DLV_LABEL'] == $divesparameters[0]['DLV_LABEL']) selected @endif>{{ $level['DLV_LABEL'] }}</option>
            @endforeach
        </select>
        <input style="display:none;" type="text" id="diveNumber" name="diveNumber" value="{{ $divesparameters[0]['DIV_ID'] }}">
    </h2>
        <h2><button type="submit" style="display:none;" id="validate" onclick="submitForm()">Valider</button></h2>


    </form>
    <script>
        function displayText(elementId) {
            var textZone = document.getElementById(elementId);
            textZone.style.display = "inline-block";
            var validate = document.getElementById("validate");
            validate.style.display = "inline-block";
        }

        function submitForm() {
            document.getElementById("updateForm").submit();
        }

    </script>
<x-footer/>
</body>
</html>
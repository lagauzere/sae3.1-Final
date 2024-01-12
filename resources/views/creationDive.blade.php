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
    <form id="creationForm" action="/createDataDives" method="POST" class="section">
        @csrf
        <h2 class="subtitle is-5">Nom du bateau :</h2>
        <div class="select is-rounded mb-4" style="margin-top: -1rem;">
        <select id="choiceBoat" name="choiceBoat">
            @foreach($boatName as $boat)
                <option value="{{ $boat['SHP_ID'] }}">{{ $boat['SHP_NAME'] }} ({{ $boat['SHP_SEATS']}} places)</option>
            @endforeach
        </select>
        </div>
  

    <h2 class="subtitle is-5">Site de la plongée : </h2>
    <div class="select is-rounded mb-4" style="margin-top: -1rem;">
        <select id="choiceSite" name="choiceSite" class="select">
            @foreach($siteName as $site)
                <option value="{{ $site['SIT_ID'] }}">{{ $site['SIT_NAME'] }} {{ $site['SIT_DEPTH']}} mètres de profondeur</option>
            @endforeach
        </select>
        </div>
   

    <h2 class="subtitle is-5"> Directeur de la plongée : </h2>
    <div class="select is-rounded mb-4" style="margin-top: -1rem;">
        <select id="choiceDirector" name="choiceDirector" class="select">
            @foreach($directorName as $director)
                <option value="{{ $director['DVR_LICENCE'] }}" >{{ $director['DIVER'] }}</option>
            @endforeach
        </select>
        </div>


    <h2 class="subtitle is-5">Pilote de la plongée : </h2> 
    <div class="select is-rounded mb-4" style="margin-top: -1rem;">
        <select id="choiceDriver" name="choiceDriver" class="select">
            @foreach($driverName as $driver)
                <option value="{{ $driver['DVR_LICENCE'] }}">{{ $driver['DIVER'] }}</option>
            @endforeach
        </select>
        </div>


    <h2 class="subtitle is-5"> Sécurité surface de la plongée : </h2> 
    <div class="select is-rounded mb-4" style="margin-top: -1rem;">
        <select id="choiceMonitor" name="choiceMonitor" class="select">
            @foreach($monitorName as $monitor)
                <option value="{{ $monitor['DVR_LICENCE'] }}">{{ $monitor['DIVER'] }}</option>
            @endforeach
        </select>
        </div>


    <h2 class="subtitle is-5"> Niveau minimum requis de la plongée : </h2>
    <div class="select is-rounded mb-4" style="margin-top: -1rem;">
        <select id="choiceDivingLevel" name="choiceDivingLevel" class="select">
            @foreach($minimumLevel as $level)
                <option value="{{ $level['DLV_ID'] }}">{{ $level['DLV_LABEL'] }}</option>
            @endforeach
        </select>
        </div>

    
    <h2 class="subtitle is-5"> Date de la session : </h2>
        <input class="input is-rounded mb-4" style="margin-top: -1rem;" type="date" name="date" id="date"/>
 

    <h2 class="subtitle is-5"> Créneau de la session : </h2> 
    <div class="select is-rounded mb-4" style="margin-top: -1rem;">
        <select name="choiceHours" id="choiceHours">
            <option value="09:00:00">9h00</option>
            <option value="13:30:00">13h30</option>
            <option value="18:00:00">18h00</option>
        </select>
        </div>
    

    <h2 class="subtitle is-5"> </h2>
        <textarea id="comment" name="comment" rows="5" cols="33" placeholder="Description de la plongée..." class="textarea has-fixed-size"></textarea>
   

    <button type="submit" id="validate" onclick="submitForm()" style="margin-right: 50%; margin-left: 50%; margin-top:1%; width: 8rem; height: 4rem; font-size:large;" class="button is-primary">Valider</button>

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
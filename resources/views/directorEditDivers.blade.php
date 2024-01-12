<?php
use App\Models\Dive;
?>

@if(Dive::isDiveDirector($div_id)>0)
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=a, initial-scale=1.0">
    <title>Modifier les adhérents d'une plongée </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css" />

    <style>
        html {scroll-behavior: smooth;}
        body {padding-top: 60px;}
    </style>
</head>

<body>
    <x-header/>
        <h1>Plongée n°{{ $div_id }}</h1>
        @php
            $date = "2024-01-12";
            // dd($div_date);
        @endphp
        @if($div_date[0]['DIV_DATE'] > $date)
        <button><a id="editDivesButton" href="/diveParameters/{{ $div_id }}">Modifier la plongée</a></button>
        <form action="{{ route('handle-form-delete') }}" method="POST">
            @csrf
            <input name="div_id" type="hidden" value="{{$div_id}}"/>
            <button type="submit" id="deleteDivesButton">Supprimer la plongée</button>
        </form>
        
        <h2>Ajouter participant :</h2>
        <input type="text" id="searchInput" placeholder="Rechercher une personne...">
        <table style="position:fixed;background:#FFFFFF;border:solid black 2px" id="searchResults"></table>
        
        <h2>Modifier les adhérents de la plongée</h2>
        @endif
        <table>
        @foreach($participants as $p)
            <tr><!-- maybe in red when cancelled -->
                <th>
                {{$p['DVR_LICENCE']}}&nbsp
                </th>
                <th>
                {{$p['DVR_FIRST_NAME']}}  {{$p['DVR_NAME']}} &nbsp
                </th>
                <th>
                {{$p['DLV_LABEL']}}&nbsp
                </th>
                <th>
                {{$p['TRL_LABEL']}}&nbsp
                </th>
                <th>
                    @if($div_date[0]['DIV_DATE'] > $date)
                    <form action="{{ route('handle-form-change-participation-state') }}" method="POST">
                        @csrf 
                        <input name="uid" type="hidden" value="{{$p['DVR_LICENCE']}}"/>
                        <input name="div_id" type="hidden" value="{{$div_id}}"/>
                        <input name="wanted_state" type="hidden" value=@if($p['PAR_CANCELLED']) 0 @else 1 @endif/>
                        <button type="submit">@if($p['PAR_CANCELLED']) réinscrire @else désinscrire @endif</button>
                    </form>
                    @endif
                <th>
                    @if($div_date[0]['DIV_DATE'] > $date)
                <form action="{{ route('handle-form-remove-participation') }}" method="POST">
                    @csrf 
                    <input name="uid" type="hidden" value="{{$p['DVR_LICENCE']}}"/>
                    <input name="div_id" type="hidden" value="{{$div_id}}"/>
                    <button type="submit">SUPPRIMER</button>
                </form>
                    @endif
                </th> 
                @if($div_date[0]['DIV_DATE'] > $date) 
                <th>
                    @if($p['PAR_CANCELLED']) @else
                    <p>Palanquée : </p>
                    @endif
                </th>
                <th>
                    
                    @if($p['PAR_CANCELLED']) @else
                    <select class="palanquee-select" onchange="handlePalanqueeChange('{{ json_encode($p) }}', this.value)" ></select>
                    @endif
                </th>
                @endif 
            </tr>
        @endforeach
        </table>
        <div id="palanquee-error">
        </div>
    <x-footer/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    const userLicence2PalNum = {};
    let numPeople;
    const userLicence2Diver = {};

    document.getElementById('deleteDivesButton').addEventListener('click', function() {
        alert('Le plongée va être supprimé !!');
    });

    function updatePalanqueeError() {
        let numDivers = Object.keys(userLicence2PalNum).length;
        let txtHtml = '';
        //not everyone in a palanquee
        if (numDivers != numPeople) txtHtml += '<div class="error-line">Tous les plongeurs ne sont pas dans une palanquée</div>';
        //fill a palNum2Users to easely check each palanquee
        let palNum2Users = {};
        for (var userLicence in userLicence2PalNum)
        {
            let palNum = userLicence2PalNum[userLicence];
            if (!(palNum in palNum2Users)) palNum2Users[palNum] = [];
            palNum2Users[palNum].push(userLicence2Diver[userLicence]);
        }
        console.log(palNum2Users);

        //check for each palanquee
        for (var palNum in palNum2Users)
        {
            
        }
        $('#palanquee-error').html(txtHtml);
    }
    function fillSelects() {
        let txtHtml = '<option value=0>---</option>';
        for (let i = 1; i <= numPeople/2; i++) {
            txtHtml += '<option value='+i+'>n°'+i+'</option>';
            
        }
        $('.palanquee-select').html(txtHtml);
    }
    function handlePalanqueeChange(p, selectedValue) {
        let user = JSON.parse(p);
        const licence = user['DVR_LICENCE'];  
        userLicence2PalNum[licence] = selectedValue;
        if (selectedValue == 0) delete userLicence2PalNum[licence];

        updatePalanqueeError();
    }
    $(document).ready(function() {
        numPeople = 0;
        const participants = @json($participants);

        for (let i = 0; i<participants.length; i++)
        {
            let person = participants[i];
            if (person['PAR_CANCELLED']==0){
                numPeople+=1; 
                userLicence2Diver[person['DVR_LICENCE']]=person;
            }
            
        }
        
        fillSelects();

        $('#searchInput').on('keyup', function() {
            let query = $(this).val().trim();

            if (query.length > 0) {
                $.ajax({
                    url: '/search-people',
                    method: 'GET',
                    data: { query: query },
                    success: function(response) {
                        displayResults(response);
                    },
                    error: function(error) {
                        console.error('Error searching people like '+query+' :', error);
                    }
                });
            } else {
                $('#searchResults').empty();
            }
        });

        function displayResults(people) {
            let resultsHtml = '';

            if (people.length > 0) {
                people.forEach(function(person) {
                    resultsHtml += "<tr>";
                    resultsHtml += '<th>' + person.DVR_FIRST_NAME +' ' + person.DVR_NAME + '</th><th>' + person.DVR_LICENCE + '</th>';
                    resultsHtml += "<th>";
                    resultsHtml += '<form action="{{ route('handle-form-add-participation') }}" method="POST">@csrf';
                    resultsHtml += `<input name="uid" type="hidden" value="`+person.DVR_LICENCE+`"/>
                    <input name="div_id" type="hidden" value="{{$div_id}}"/>`;
                    resultsHtml += '<button type="submit">inscrire</button>';
                    resultsHtml += "</th>";
                    resultsHtml += '</form>';
                    resultsHtml += "</tr>";
                });
                
            } else {
                resultsHtml = '<li>Aucun résultat.</li>';
            }

            $('#searchResults').html(resultsHtml);
        }

    });
    </script>
</body>
@endif
<?php
use App\Models\Dive;
use App\Models\User;
?>

@if(Dive::isDiveDirector($div_id)>0 || User::isAdmin())
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
    <div style="padding: 0px 200px">
        <h1 class="title is-1">Plongée n°{{ $div_id }}</h1>
        <div style="width: 100%; display: flex;">
            <button class="button is-primary"><a id="editDivesButton" href="/diveParameters/{{ $div_id }}" style="color: white;">Modifier la plongée</a></button>
            <div style="width: 10px;"></div>
            <form action="{{ route('handle-form-delete') }}" method="POST">
                @csrf
                <input name="div_id" type="hidden" value="{{$div_id}}"/>
                <button type="submit" id="deleteDivesButton" class="button is-danger">Annuler la plongée</button>
            </form>
        </div>
        <h2 class="title is-3">Ajouter participant :</h2>
        <input type="text" id="searchInput" class="input is-primary" placeholder="Rechercher une personne...">
        <table class="table is-rounded" style="position:fixed;background:#FFFFFF;border-collapse: separate; border:solid white 1px; border-radius: 1px 1px 20px 20px; box-shadow: 3px 3px 20px -10px" id="searchResults"></table>
        <div style="height: 30px;"></div>
        <h2 class="subtitle is-5">Modifier les adhérents de la plongée</h2>
        <table class="table">
        <tr class="thead">
                <th>
                Licence
                </th>
                <th>
                Plongeur
                </th>
                <th>
                Niveau de plongée
                </th>
                <th>
                Niveau d'encadrant
                </th>
        </tr>
        @foreach($participants as $p)
            @if ($p['PAR_CANCELLED'])
            <tr style="background-color: #fcc"><!-- in red when cancelled -->
            @else
            <tr>
            @endif
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
                    <form action="{{ route('handle-form-change-participation-state') }}" method="POST">
                        @csrf 
                        <input name="uid" type="hidden" value="{{$p['DVR_LICENCE']}}"/>
                        <input name="div_id" type="hidden" value="{{$div_id}}"/>
                        <input name="wanted_state" type="hidden" value=@if($p['PAR_CANCELLED']) 0 @else 1 @endif/>
                        <button type="submit" @if($p['PAR_CANCELLED']) class="button is-primary"> RÉINSCRIRE @else class="button is-warning"> DÉSINSCRIRE @endif</button>
                    </form>
                    
                <th>
                <form action="{{ route('handle-form-remove-participation') }}" method="POST">
                    @csrf 
                    <input name="uid" type="hidden" value="{{$p['DVR_LICENCE']}}"/>
                    <input name="div_id" type="hidden" value="{{$div_id}}"/>
                    <button type="submit" class="button is-danger">SUPPRIMER</button>
                </form>
                </th>
                <th>
                    @if($p['PAR_CANCELLED']) @else
                    <p>Palanquée : </p>
                    @endif
                </th>
                <th>
                    @if($p['PAR_CANCELLED']) @else
                    <select class="palanquee-select" onchange="handlePalanqueeChange('{{ json_encode($p) }}', this.value)"></select>
                    @endif
                </th>
                
            </tr>
        @endforeach
        </table>
        <div id="palanquee-error">
        </div>
    </div>
    <x-footer/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    const userLicence2PalNum = {};
    let numPeople;
    const userLicence2Diver = {};

    document.getElementById('deleteDivesButton').addEventListener('click', function() {
        alert('Le plongée va etre supprimé!!');
    });


    function errorLinePal(numPal, txt){
        return '<div class="error-line"> Palanquée n°'+numPal+': '+txt+'</div>';
    }
    function updatePalanqueeError() {
        let numDivers = Object.keys(userLicence2PalNum).length;
        let txtHtml = '';
        let isFine = 1;
        //not everyone in a palanquee
        if (numDivers != numPeople) {
            txtHtml += '<div class="error-line">Tous les plongeurs ne sont pas dans une palanquée</div>';
            isFine = 0;
        }
        //fill a palNum2Users to easely check each palanquee
        let palNum2Users = {};
        for (var userLicence in userLicence2PalNum)
        {
            let palNum = userLicence2PalNum[userLicence];
            if (!(palNum in palNum2Users)) palNum2Users[palNum] = [];
            palNum2Users[palNum].push(userLicence2Diver[userLicence]);
        }
        //console.log(palNum2Users);

        //check for each palanquee
        for (var palNum in palNum2Users)
        {
            let trainingLevels = [];
            let divingLevels = [];
            let count = 0;
            let maxTrl = 0;
            for (var userIndex in palNum2Users[palNum])
            {
                user=palNum2Users[palNum][userIndex];
                console.log(palNum, user);
                trainingLevels.push(user['TRL_ID']);
                divingLevels.push(user['DLV_ID']);
                count+=1;
                if (user['TRL_ID'] > maxTrl) maxTrl = user['TRL_ID'];    
            }
            if (count>3){ 
                txtHtml += errorLinePal(palNum, 'Maximum 3 plongeurs par palanquée (ici '+count+')');
                isFine = 0;
            }
            if (count<2) {
                txtHtml += errorLinePal(palNum, 'Minimum 2 plongeurs par palanquée (ici '+count+')');
                isFine = 0;
            } 
            for (var userIndex in palNum2Users[palNum])
            {
                user=palNum2Users[palNum][userIndex];
                dlv = user['DLV_ID'];
                trl = user['TRL_ID'];
                if (dlv==1 && count==3) txtHtml += errorLinePal(palNum, 'Si un plongeur est de niveau PB, la palanquée est au maximum de 2 (ici '+count+')');
                console.log(dlv)
                if ([1,2,3,4].includes(dlv) && maxTrl<1){
                    txtHtml += errorLinePal(palNum, 'PO, PB, PA nécessitent au minimum un E1(si moins de 6m), E2, E3, E4');
                    isFine = 0;
                }
                if ([5,7,10].includes(dlv) && maxTrl<2) {
                    txtHtml += errorLinePal(palNum, 'PE-12, PE-20, PE-40, nécessitent au minimum un E2, E3 ou E4');
                    isFine = 0;
                }
                if ([6,8,9,11,12].includes(dlv) && maxTrl==0) {
                    txtHtml += errorLinePal(palNum, 'PA-12, PA-20, PA-40 ou PA-60 nécéssitent au minimum un E1 pour plonger en autonomie');
                    
                    isFine = 0;
                }
                if ([1,2,3,4].includes(dlv) && maxTrl==0 && 0) {
                    txtHtml += errorLinePal(palNum, '');
                    isFine = 0;
                }
            }
        }
        if (isFine==0) txtHtml += '<div class="error-line">Palanquées incorrectes</div>';
        else txtHtml += '<div class="error-line">Palanquées correctes</div>';
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
            let dive = {{$div_id}};
            if (query.length > 0) {
                $.ajax({
                    url: '/search-people-for-dive',
                    method: 'GET',
                    data: { query: query, dive: dive },
                    success: function(response) {
                        displayResults(response);
                    },
                    error: function(error) {
                        console.error('Error searching people like '+query+' in dive '+dive+' :', error);
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
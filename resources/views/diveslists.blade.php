<?php

use App\Models\User;

if (session('userID') == null) {
    abort(404);
}
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Liste des plongées disponibles</title>
    @livewireStyles

    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="/resources/css/app.css">
    </link>
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
    <x-header />
    <h1>Liste des plongées disponibles</h1>

    <?php
    $AllDives = json_encode($dives);
    $DiversDives = json_encode($everyDivesRegistered);
    $LevelOfDiver = json_encode($userLevel);
    ?>

    <div id='calendar-container' style="padding: 20px;">
        <div id='calendar'></div>
    </div>

    <div wire:ignore.self>
        <div class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" id="dynamic-modal-content">
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </script>
        <script>
          
            document.addEventListener('livewire:load', function() {
                const Calendar = FullCalendar.Calendar;
                const calendarEl = document.getElementById('calendar');  
                const divesData = <?php echo $AllDives; ?>;
                const divesForDivers = <?php echo $DiversDives; ?>;
                const DiversLevel = <?php echo $LevelOfDiver; ?>;
         
                const events = divesData.map((dive) => ({
                    title: dive.DIV_ID,
                    start: new Date(dive.DIV_DATE),
                    end: new Date(new Date(dive.DIV_DATE).getTime() + 3 * 60 * 60 * 1000),
                    boat: `Bateau: ${dive.SHP_NAME}\n`,
                    site: `Site: ${dive.SIT_NAME}\n`,
                    requireLevel: `Niveau requis: ${dive.DLV_LABEL}`,
                    levelId : dive.DLV_ID,
                    remainingCapacity: dive.DIV_HEADCOUNT
                }));
                
                
                const calendar = new Calendar(calendarEl, {
                    slotMinTime: '8:00:00',
                    slotMaxTime: '22:00:00',
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    locale: 'fr',
                    events: events,
                    
                    eventContent: function(info) {
                        const content = document.createElement('div');
                        
                        if(info.event.extendedProps.levelId > DiversLevel[0].DLV_ID ) {
                            content.style.backgroundColor = '#CF9FFF';
                            content.innerHTML = `
                                <div style="cursor: pointer;">
                                    <strong>Plongée numéro:  ${info.event.title}</strong><br>
                                    <p>${info.event.extendedProps.boat}</p>
                                    <p>${info.event.extendedProps.site}</p>
                                    <p>${info.event.extendedProps.requireLevel}</p>
                                    <strong> Le niveau requis est supérieur au votre </strong>
                                </div>
                            `;
                        }
                        else if(info.event.extendedProps.remainingCapacity <= 0){
                            content.style.backgroundColor = 'grey';
                            content.innerHTML = `
                                <div style="cursor: pointer;">
                                    <strong>Plongée numéro:  ${info.event.title}</strong><br>
                                    <p>${info.event.extendedProps.boat}</p>
                                    <p>${info.event.extendedProps.site}</p>
                                    <p>${info.event.extendedProps.requireLevel}</p>
                                    <strong> Il n'y a plus de place dans cette plongée </strong>
                                </div>
                            `;
                        }
                        else{
                            content.innerHTML = `
                                <div style="cursor: pointer;">
                                    <strong>Plongée numéro:  ${info.event.title}</strong><br>
                                    <p>${info.event.extendedProps.boat}</p>
                                    <p>${info.event.extendedProps.site}</p>
                                    <p>${info.event.extendedProps.requireLevel}</p>
                                </div>
                            `;
                        }
                        return {
                            domNodes: [content]
                        };
                    },
                    
                    eventClick: function(info) {
                        const retireFormAction = "{{ route('leaveTimeSlot', ['selectedDive' => '']) }}" + info.event.title; 
                        const registerFormAction = "{{ route('enterTimeSlot', ['selectedDive' => '']) }}" + info.event.title;
                        const displayDiversIn = "{{ route('diverlist', ['div_id' => ':selectedDive']) }}".replace(':selectedDive', info.event.title);

                   
                        var modalContent = `
                            <div class="modal-header">
                                <h5 class="modal-title"> Plongée numéro: ${info.event.title} </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            
                            <div class="modal-body">
                                <p>${info.event.extendedProps.boat}</p>
                                <p>${info.event.extendedProps.site}</p>
                                <p>${info.event.extendedProps.requireLevel}</p>
                            </div>
                            <div class="modal-footer">`
                        var diversListLink = `<a href="${displayDiversIn}" id="diversList">Liste des plongeurs</a>`;
                        modalContent += diversListLink;
                        var registered = false;
                        var cancelled = false; 
                        divesForDivers.forEach(dive => {
                            if(dive.DIV_ID == info.event.title && dive.PAR_CANCELLED == 0){
                                modalContent += `
                                        <form id="retireForm" action="" method="POST">
                                        @csrf 
                                        <button type="submit" class="btn btn-primary" data-dismiss="modal">Se désinscrire</button>
                                        </form>`
                                document.getElementById('dynamic-modal-content').innerHTML = modalContent;
                                document.getElementById('retireForm').action = retireFormAction.replace(':selectedDive', info.event.title);
                                registered = true;
                            }
                            else if(dive.DIV_ID == info.event.title && dive.PAR_CANCELLED == 1){
                                cancelled = true;
                                registered = true;
                                modalContent += `<p style= "color:red" > Vous avez déjà annulé la participation à cette plongée</p>`
                            }
                        })
                        
                        if(cancelled==true || info.event.extendedProps.levelId > DiversLevel[0].DLV_ID || info.event.extendedProps.remainingCapacity == 0){
                            console.log("disable");
                            modalContent += `<form id="registerForm" action="" method="POST">
                                    @csrf <button type="submit" class="btn btn-primary" disabled>S'inscrire</button> </form>`
                                document.getElementById('dynamic-modal-content').innerHTML = modalContent; 
                                document.getElementById('registerForm').action = registerFormAction.replace(':selectedDive', info.event.title);
                        }
                        else if(registered == true ){
                            console.log("rien");
                            modalContent += ``;
                        }
                        else if(registered==false && cancelled == false ){
                            console.log("s'inscrire");
                            modalContent += `<form id="registerForm" action="" method="POST">
                                    @csrf`
                               
                                    modalContent +=`<button type="submit" class="btn btn-primary">S'inscrire</button>`
                                    modalContent +=`  </form>`
                                document.getElementById('dynamic-modal-content').innerHTML = modalContent; 
                                document.getElementById('registerForm').action = registerFormAction.replace(':selectedDive', info.event.title);
                        }
                       
                        
                           
                            
                        $('.modal').modal('show');
                    }
                    
            });
            calendar.render();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/locales-all.min.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.css' rel='stylesheet' />
    @endpush

    <livewire:calendar></livewire:calendar>
    @livewireScripts
    @stack('scripts')

    <x-footer />
</body>

</html>
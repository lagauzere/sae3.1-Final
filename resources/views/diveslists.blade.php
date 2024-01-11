<?php
     use App\Models\User;

    if(session('userID')==null  ){
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    ?>

    <div id='calendar-container' wire:ignore data-dives-for-divers="{{ json_encode($DiversDives) }}">
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
                
                const events = divesData.map((dive) => ({
                    title: dive.DIV_ID,
                    start: new Date(dive.DIV_DATE),
                    end: new Date(new Date(dive.DIV_DATE).getTime() + 3 * 60 * 60 * 1000),
                    boat: `Bateau: ${dive.SHP_NAME}\n`,
                    site: `Site: ${dive.SIT_NAME}\n`,
                    requireLevel: `Niveau requis: ${dive.DLV_DESC}`,
                }));
                
                
                
                const calendar = new Calendar(calendarEl, {
                    slotMinTime: '8:00:00',
                    slotMaxTime: '22:00:00',
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    locale: 'fr',
                    events: events,
                    eventContent: function(info) {
                        const content = document.createElement('div');
                        content.innerHTML = `
                            <div style="cursor: pointer;">
                                <strong>Plongée numéro:  ${info.event.title}</strong><br>
                                <p>${info.event.extendedProps.boat}</p>
                                <p>${info.event.extendedProps.site}</p>
                                <p>${info.event.extendedProps.requireLevel}</p>
                            </div>
                        `;
                        return {
                            domNodes: [content]
                        };
                    },
                    eventClick: function(info) {
                        const registerFormAction = "{{ route('enterTimeSlot', ['selectedDive' => '']) }}" + info.event.title;
                        const retireFormAction = "{{ route('leaveTimeSlot', ['selectedDive' => '']) }}" + info.event.title; 
                        
                        var modalContent = `
                            <div class="modal-header">
                                <h5 class="modal-title"> Plongée numéro: ${info.event.title} </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            
                            <div class="modal-body">
                                <p>${info.event.extendedProps.boat}</p>
                                <p>${info.event.extendedProps.site}</p>
                                <p>${info.event.extendedProps.requireLevel}</p>
                            </div>
                            <div class="modal-footer">`
                            
                                    modalContent += `<form id="retireForm" action="" method="POST">
                                    @csrf 
                                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Se désinscrire</button>
                                    </form>`
                                    document.getElementById('dynamic-modal-content').innerHTML = modalContent; 
                                    document.getElementById('retireForm').action = retireFormAction.replace(':selectedDive', info.event.title);
                              
                            
                                modalContent += `<form id="registerForm" action="" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                                </form>`
                                document.getElementById('dynamic-modal-content').innerHTML = modalContent; 
                                document.getElementById('registerForm').action = registerFormAction.replace(':selectedDive', info.event.title);
                                              
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
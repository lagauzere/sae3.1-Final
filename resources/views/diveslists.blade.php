<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=a, initial-scale=1.0">
    <title>Liste des plongées </title>
    @livewireStyles
</head> 
<body>
    <h1>Listes des plongées disponible</h1>

    <?php 
        $test = json_encode($dives);
    ?>

    <div>
    <div id='calendar-container' wire:ignore>
        <div id='calendar'></div>
    </div>
    </div>

    @push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js'></script>
<script>
    document.addEventListener('livewire:load', function () {
        
        const Calendar = FullCalendar.Calendar;
        var array = <?php echo $test?>;
        console.table(array);
        const calendarEl = document.getElementById('calendar');
        
        const divesData = <?php echo $test; ?>;
        
        const events = divesData.map((dive) => ({
            title: "Plongée numéro: " + dive.DIV_ID,
            start: new Date(dive.DIV_DATE), 
            end: new Date(new Date(dive.DIV_DATE).getTime() + 3 * 60 * 60 * 1000),  
            boat: `Bateau: ${dive.SHP_NAME}\n`,
            site: `Site: ${dive.SIT_NAME}\n`,
            requireLevel : `Niveau requis: ${dive.DLV_DESC}`,
        }));
        console.table(events);
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
                                <strong>${info.event.title}</strong><br>
                                <p>${info.event.extendedProps.boat}</p>
                                <p>${info.event.extendedProps.site}</p>
                                <p>${info.event.extendedProps.requireLevel}</p>
                            </div>
                        `;
                        return { domNodes: [content] };
                    },
            eventClick: function(info) {
                alert('Event: ' + info.event.title);
            }
        });
        calendar.render();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/locales-all.min.js"></script>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.css' rel='stylesheet' />

@endpush

    <livewire:calendar/>
    @livewireScripts
    @stack('scripts')
    
</body>
</html>
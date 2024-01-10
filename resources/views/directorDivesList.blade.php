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
    <style>
        html {scroll-behavior: smooth;}
        body {padding-top: 60px;}
    </style>
</head>
<body>
    <x-header/>
    <h1>Liste des plongées disponibles</h1>

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
        document.addEventListener('livewire:load', function() {

            const Calendar = FullCalendar.Calendar;
            var array = <?php echo $test ?>;
            console.table(array);
            const calendarEl = document.getElementById('calendar');

            const divesData = <?php echo $test; ?>;

            const events = divesData.map((dive) => ({
                title: "Plongée numéro: " + dive.div_id,
                start: new Date(dive.DIV_DATE),
                end: new Date(new Date(dive.DIV_DATE).getTime() + 3 * 60 * 60 * 1000),
                boat: `Bateau: ${dive.shp_name}\n`,
                site: `Site: ${dive.sit_name}\n`,
                requireLevel: `Niveau requis: ${dive.DLV_DESC}`,
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
                    return {
                        domNodes: [content]
                    };
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

    <livewire:calendar></livewire:calendar>
    @livewireScripts
    @stack('scripts')

    <x-footer />
</body>

</html>
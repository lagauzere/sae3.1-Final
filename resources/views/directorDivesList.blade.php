<?php
use App\Models\User;


if(session('userID')==null  ){
    abort(404);
}
else if (User::isDirector()==0){
    abort(404);
}

?>
?>

@if(User::canDirect()>0)
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Plongées dirigées</title>
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
    <h1>Liste des plongées prévues que vous dirigez</h1>

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
                div_id: dive.DIV_ID,
                title: "Plongée numéro: " + dive.DIV_ID,
                start: new Date(dive.DIV_DATE),
                end: new Date(new Date(dive.DIV_DATE).getTime() + 3 * 60 * 60 * 1000),
                boat: `Bateau: ${dive.SHP_NAME}\n`,
                site: `Site: ${dive.SIT_NAME}\n`,
                requireLevel: `Niveau requis: ${dive.DLV_LABEL}`,
                diverCount: `Nombre d'inscrits: ${dive.COUNT}`
            }));
            console.table(events);
            const calendar = new Calendar(calendarEl, {
                slotMinTime: '8:00:00',
                slotMaxTime: '22:00:00',
                initialView: 'listMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'listMonth'
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
                                <p>${info.event.extendedProps.diverCount}</p>
                            </div>
                        `;
                    return {
                        domNodes: [content]
                    };
                },
                eventClick: function(info) {
                    const form = document.createElement('form');
        
                    form.action = "{{ route('edit-dive') }}";
                    form.method = 'POST';

                    const csrfTokenInput = document.createElement('input');
                    csrfTokenInput.type = 'hidden';
                    csrfTokenInput.name = '_token';
                    csrfTokenInput.value = '{{ csrf_token() }}';

                    const inputValueInput = document.createElement('input');
                    inputValueInput.type = 'hidden';
                    inputValueInput.name = 'div_id';
                    inputValueInput.value = info.event.extendedProps.div_id;

                    form.appendChild(csrfTokenInput);
                    form.appendChild(inputValueInput);

                    document.body.appendChild(form);
                    form.submit();
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
@endif
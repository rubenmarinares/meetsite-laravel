<x-app-layout>

    @php
        $imenu1 = 1;
        $imenu2 = 0;
    @endphp
    
    <x-slot name="sidemenu">
        @include('partials.sidemenu')             
    </x-slot>

    <x-slot name="menu">
        @include('partials.menu')             
    </x-slot>
 
    
    
    <div id="calendar"></div>
    
    
    
    
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("CALENDARIO")
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Vista inicial
                locale: 'es',               // Idioma en español
                themeSystem: 'bootstrap',
                firstDay: 1,
                //eventStartEditable: true,
                height: 'auto',
                eventClick: function (info) { 
                    console.log("",info.event.extendedProps);

                    let url = 'grupos/' + info.event.extendedProps.idgrupo + '/edit?sidepanel=1';
                    openSidepanel(url);
                    
                
                
                },
                headerToolbar: {            // Configuración de botones
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                },
                               
                events:  {
                    url: '{{ route('calendario.events') }}',                    
                    method: 'GET',
                        extraParams: {
                            custom_param1: 'something',
                            custom_param2: 'somethingelse'
                    },
                    failure: function() {
                        //alert('there was an error while fetching events!');
                        console.log("error fetching data")
                    },
                },
                eventDidMount: function (info) {

                    // Agrega popover con descripción del evento
                    info.el.setAttribute('data-bs-toggle', 'popover');
                    info.el.setAttribute('data-bs-html', 'true');
                    info.el.setAttribute('data-bs-content', info.event.extendedProps.description);
                    info.el.setAttribute('data-bs-placement', 'top');
                    // Inicializa el popover
                    new bootstrap.Popover(info.el, {
                        trigger: 'hover',
                        html: true
                    });

                    // Aplica colores personalizados
                    if (info.event.backgroundColor) {
                        info.el.style.backgroundColor = info.event.backgroundColor;
                    }                  
                    if (info.event.textColor) {                        
                       info.el.style.color = info.event.textColor; // Aplicar color correctamente                        
                       
                    }
                    info.el.style.borderColor = '#000000'
                    info.el.style.cursor = 'pointer';
                    
                }
            });
            calendar.render(); // Renderiza el calendario
        
        /*var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '{{ route('calendario.events') }}', // consume tu endpoint JSON
        });*/

        calendar.render();
    });
    </script>
    
</x-app-layout>
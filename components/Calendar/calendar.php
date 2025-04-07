<!DOCTYPE html>
<html>
    <head>
        <title> Prova </title>
        <meta charset='UTF-8'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

        <script>
            
            
        $(document).ready (function() {
            var calendarElement = $('#calendar')[0];
            var dayCalElement = $('#dayCal')[0];

            var calendar = new FullCalendar.Calendar(calendarElement, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: 'prev,next today'
                },
                titleFormat: {
                    year: 'numeric',
                    month: 'long'
                },
                selectable: true,
                dateClick: function (info) {
                    alert(`${info.dateStr}`);
                    dayCal.set
                }
            });

            var dayCal = new FullCalendar.Calendar(dayCalElement, {
                initialView: 'timeGridDay',
                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: ''
                }
            });

            calendar.render();
            dayCal.render();
        });

    </script>
    </head>
    <body>
        <div class="container">
            <h1>Prova</h1>
            <div class="row">
                <div class="col-md-6">
                    <div id="calendar"></div>
                </div>
                <div class="col-md-6">
                    <div id="dayCal"></div>
                </div>
            </div>
        </div>
    </body>
</html>
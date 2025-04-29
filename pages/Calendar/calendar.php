<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/funzioniDB.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/globals.php';

// require_once '/funzioniDB.php';
// require_once '/globals.php';


?>

<!DOCTYPE html>
<html>
    <head>
        <title> Prova </title>
        <meta charset='UTF-8'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
        <script src="/public/js/calendar.js"></script>

        <script>
            
            
        $(document).ready (function() {
            let calendarElement = $('#calendar')[0];
            let dayCalElement = $('#dayCal')[0];

            let today = new Date(); // Get today's date
            let nextMonth = new Date(today.getFullYear(), today.getMonth() + 1, 1);

            let year = nextMonth.getFullYear();
            let month = String(nextMonth.getMonth() + 1).padStart(2, '0');
            let day = String(nextMonth.getDate()).padStart(2, '0');

            let nextMonthString = `${year}-${month}-${day}`;

            let turni = {};

            while (nextMonth.getMonth() === today.getMonth() + 1) {
                let year = nextMonth.getFullYear();
                let month = String(nextMonth.getMonth() + 1).padStart(2, '0');
                let day = String(nextMonth.getDate()).padStart(2, '0');

                let nextDateString = `${year}-${month}-${day}`;

                let turno = turniData(nextDateString); // Fetch shifts for the next date
                turni[nextDateString] = turno ? turno : []; // Fetch shifts for the next date

                // Increment the date by one day
                nextMonth.setDate(nextMonth.getDate() + 1);
            }

            let events = [];
            for (let date in turni) {
                if (turni[date].length == 9) {
                    color = '#66ff66';
                } else if (turni[date].length == 0) {
                    color = '#ff3300'; // Color for no shifts
                } else {
                    color = '#ff9933'; // Default color for other cases
                }

                let event = {
                    title: date, 
                    start: date + 'T00:00:00', 
                    end: date + 'T23:59:59',   
                    backgroundColor: color, 
                    display: 'background' 
                };

                events.push(event);
            }

            console.log( events); // Log the events array to the console

            let calendar = new FullCalendar.Calendar(calendarElement, {
                locale: 'it',
                initialDate: nextMonthString, // Set the initial date to the first day of the next month
                initialView: 'dayGridMonth',
                navLink: true,
                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: 'prev,next'
                },
                titleFormat: {
                    year: 'numeric',
                    month: 'long'
                },
                aspectRatio: 0.7,
                selectable: true,
                dateClick: function (info) {
                    let turni = turniData(info.dateStr); // Navigate to the clicked date in the day calendar
                    $("#dayCal").html(generaTabella(info.dateStr, turni)); 
                }, 
                select: function (info) {
                    // Ensure only one day is selected
                    let start = new Date(info.start);
                    let end = new Date(info.end);
                    let diff = (end - start) / (1000 * 60 * 60 * 24);

                    if (diff > 1) { // Restrict to a single day
                        calendar.unselect(); // Deselect the selection
                    }
                }, 
                events: events // Add the events to the calendar
            });

            calendar.render();
            //dayCal.render();

        });

    </script>
    </head>
    <body>
        <div class="container">
            <h1>Prova</h1>
            <div class="row">
                <div class="col-md-3">
                    <div id="calendar"></div>
                </div>
                <div class="col-md-9">
                    <div id="dayCal"></div>
                </div>
            </div>
        </div>
    </body>
</html>
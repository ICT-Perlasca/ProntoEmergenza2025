<?php 
require_once('./funzioniDB.php');
require_once ("./components/Head/head.php");

// require_once '/funzioniDB.php';
// require_once '/globals.php';

?>

<!DOCTYPE html>
<html>
<?php

echo COMP_head();

?>
    <body>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
        <script src="public/js/calendar.js"></script>
        <style>
            td: {
                height: 25px;
            }
        </style>
        <script>
            
        let fullDays = 0;
        let daysOfMonth = 0;

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
                daysOfMonth++;

                let turno = turniData(nextDateString); // Fetch shifts for the next date
                turni[nextDateString] = turno ? turno : []; // Fetch shifts for the next date

                // Increment the date by one day
                nextMonth.setDate(nextMonth.getDate() + 1);
            }

            let events = [];
            for (let date in turni) {
                if (turni[date].length == 9) {
                    color = '#66ff66';  
                    fullDays++;
                } else if (turni[date].length == 0) {
                    color = '#ff3300'; // Color for no shifts
                } else {
                    color = '#ff9933'; // Default color for other cases
                }

                let event = { 
                    start: date + 'T00:00:00', 
                    end: date + 'T23:59:59',   
                    backgroundColor: color
                };

                events.push(event);
            }

            console.log( events); // Log the events array to the console

            let calendar = new FullCalendar.Calendar(calendarElement, {
                locale: 'it',
                displayEventTime: false,
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
                    generaTabella(info.dateStr, turni); 
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
            if (fullDays != daysOfMonth) $("#btnConvalida").addClass("disabled");
            //dayCal.render();

        });

    </script>
    <body>
        <div class="container">
            <h1>Prova</h1>
            <div class="row">
                <div class="col-md-3">
                    <div id="calendar"></div>
                    <button type="button" id="btnConvalida" class="btn btn-primary">
                        Convalida turni
                    </button>
                </div>
                <div class="col-md-9">
                    <div id="dayCal"></div>
                </div>
            </div>
        </div>
    </body>
</html>
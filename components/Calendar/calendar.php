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
                locale: 'it',
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
                    generateTable(info.dateStr); // Navigate to the clicked date in the day calendar
                }, 
                select: function (info) {
                    // Ensure only one day is selected
                    var start = new Date(info.start);
                    var end = new Date(info.end);
                    var diff = (end - start) / (1000 * 60 * 60 * 24);

                    if (diff > 1) { // Restrict to a single day
                        calendar.unselect(); // Deselect the selection
                    }
                }
            });
/*
            var dayCal = new FullCalendar.Calendar(dayCalElement, {
                locale: 'it',
                initialView: 'timeGridDay',
                allDaySlot: false,
                slotMinTime: '07:00:00',
                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                slotDuration: '06:00:00',
                expandRows: true,
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit'
                },
                eventContent: function (arg) {
                    return {
                        html: `
                            <div class="col-md-4 h-100">
                                <h1>${arg.event.title}</h1>
                            </div>

                        `
                    };
                },
                events: [
                    {
                        title: 'Meeting with Team',
                        start: '2025-04-10T09:00:00', // Event start time
                        end: '2025-04-10T10:00:00',   // Event end time
                        description: 'Discuss project updates',
                        color: '#007bff' // Optional: Custom color for the event
                    },
                    {
                        title: 'Lunch Break',
                        start: '2025-04-10T09:00:00',
                        end: '2025-04-10T10:00:00',
                        color: '#28a745'
                    },
                    {
                        title: 'Lunch Break',
                        start: '2025-04-10T09:00:00',
                        end: '2025-04-10T10:00:00',
                        color: '#28a745'
                    }
                ]
            });
*/
            calendar.render();
            //dayCal.render();

            
            function generateTable(date) {
                var tableHtml = `
                    <h3>Schedule for ${date}</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Event</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>09:00 - 10:00</td>
                                <td>Meeting with Team</td>
                            </tr>
                            <tr>
                                <td>12:00 - 13:00</td>
                                <td>Lunch Break</td>
                            </tr>
                            <tr>
                                <td>14:00 - 15:00</td>
                                <td>Client Call</td>
                            </tr>
                        </tbody>
                    </table>
                `;
                dayCalElement.innerHTML = tableHtml; // Update the day calendar with the generated table
            }

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
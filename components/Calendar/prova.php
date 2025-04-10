<?php
// Imposta il fuso orario
date_default_timezone_set('Europe/Rome');

// Ottieni il mese e l'anno correnti
$currentMonth = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$currentYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Calcola il primo giorno del mese e il numero di giorni nel mese
$firstDayOfMonth = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
$daysInMonth = date('t', $firstDayOfMonth);
$dayOfWeek = date('w', $firstDayOfMonth); // Giorno della settimana del primo giorno del mese (0=Domenica, 6=Sabato)

// Array dei nomi dei mesi
$months = [
    1 => 'Gennaio', 2 => 'Febbraio', 3 => 'Marzo', 4 => 'Aprile',
    5 => 'Maggio', 6 => 'Giugno', 7 => 'Luglio', 8 => 'Agosto',
    9 => 'Settembre', 10 => 'Ottobre', 11 => 'Novembre', 12 => 'Dicembre'
];

// Mese precedente e successivo
$prevMonth = $currentMonth == 1 ? 12 : $currentMonth - 1;
$prevYear = $currentMonth == 1 ? $currentYear - 1 : $currentYear;
$nextMonth = $currentMonth == 12 ? 1 : $currentMonth + 1;
$nextYear = $currentMonth == 12 ? $currentYear + 1 : $currentYear;

// Giorno selezionato (se presente)
$selectedDay = isset($_GET['day']) ? (int)$_GET['day'] : null;
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="calendar">
        <div class="header">
            <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>" class="nav-btn">❮</a>
            <h2><?= $months[$currentMonth] . ' ' . $currentYear ?></h2>
            <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>" class="nav-btn">❯</a>
        </div>
        <div class="days-of-week">
            <div>D</div>
            <div>L</div>
            <div>M</div>
            <div>M</div>
            <div>G</div>
            <div>V</div>
            <div>S</div>
        </div>
        <div class="days">
            <?php
            // Aggiungi spazi vuoti per i giorni prima del primo giorno del mese
            for ($i = 0; $i < $dayOfWeek; $i++) {
                echo '<div class="empty"></div>';
            }

            // Stampa i giorni del mese
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $isSelected = ($selectedDay === $day) ? 'selected' : '';
                echo '<a href="?month=' . $currentMonth . '&year=' . $currentYear . '&day=' . $day . '" class="day ' . $isSelected . '">' . $day . '</a>';
            }
            ?>
        </div>
    </div>
</body>
</html>
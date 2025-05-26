<?php
require('fpdf/fpdf.php');
session_start();

// API che genera un PDF da dati (array associativo) ricevuti tramite query esterna
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["errore" => "Metodo non consentito. Usa POST."]);
    exit;
}

// Riceve i dati della tabella
$inputJSON = file_get_contents('php://input');
$inputData = json_decode($inputJSON, true);

if (!is_array($inputData) || empty($inputData)) {
    http_response_code(400);
    echo json_encode(["errore" => "Dati non validi o vuoti."]);
    exit;
}

class PDF extends FPDF {
    public $larghezze = [];

    function Row($widths, $row) {
        $nb = 1;
        foreach ($row as $i => $txt)
            if (isset($widths[$i]) && strlen($txt) > 20) $nb = max($nb, $this->NbLines($widths[$i], $txt));

        $h = 6 * $nb;
        $this->CheckPageBreak($h);
        foreach ($row as $i => $txt) {
            $w = $widths[$i];
            $x = $this->GetX();
            $y = $this->GetY();
            if (strlen($txt) > 20) {
                $this->MultiCell($w, 6, $txt, 1, 'L');
                $this->SetXY($x + $w, $y);
            } else {
                $this->Cell($w, $h, $txt, 1, 0, 'L');
            }
        }
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        $sep = -1; $i = $j = $l = 0; $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") { $i++; $sep = -1; $j = $i; $l = 0; $nl++; continue; }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c] ?? 0;
            if ($l > $wmax) {
                if ($sep == -1) { if ($i == $j) $i++; }
                else $i = $sep + 1;
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else $i++;
        }
        return $nl;
    }
}

// Intestazioni e righe
$intestazioni = array_keys($inputData[0]);
$righe = array_map('array_values', $inputData);

// Formatta date
foreach ($righe as &$riga) {
    foreach ($riga as &$val) {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $val)) {
            $dt = DateTime::createFromFormat('Y-m-d', $val);
            if ($dt) $val = $dt->format('d-m-Y');
        }
    }
}

$pdf = new PDF('L', 'mm', [397, 210]);
$pdf->SetAutoPageBreak(true, 15);
$pdf->AddPage();
$pdf->SetFont('Courier', '', 10);

$pdf->Cell(0, 5, 'Data generazione PDF: ' . date("d-m-Y H:i:s"), 0, 1, 'L');
$pdf->Ln(5);

// Titolo opzionale
$pdf->SetFont('Courier', 'B', 12);
$pdf->Cell(0, 10, "Elenco Dati", 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Courier', '', 10);

// Calcolo larghezze colonne
$larghezze = [];
foreach ($intestazioni as $i => $etichetta) {
    $max = $pdf->GetStringWidth($etichetta);
    foreach ($righe as $riga) {
        $max = max($max, $pdf->GetStringWidth($riga[$i]));
    }
    $larghezze[] = $max + 15;
}

$totalWidth = array_sum($larghezze);
if ($totalWidth > 397) {
    $scale = 397 / $totalWidth;
    foreach ($larghezze as &$w) $w *= $scale;
}
$pdf->larghezze = $larghezze;

// Intestazioni grassetto
$pdf->SetFont('Courier', 'B', 10);
foreach ($intestazioni as $i => $etichetta) {
    $pdf->Cell($larghezze[$i], 6, $etichetta, 1, 0, 'C');
}
$pdf->Ln();
$pdf->SetFont('Courier', '', 10);

// Righe
foreach ($righe as $riga) {
    $pdf->Row($larghezze, $riga);
}

$pdf->Output('I', 'tabella.pdf');
exit;

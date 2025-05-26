<?php 
require('fpdf/fpdf.php');
require_once("funzioniDB.php");
require_once("ElencoMezziDisponibili.php");
session_start();

class PDF extends FPDF {
    public $larghezze = [];

    function Row($widths, $row) {
        $nb = 1;
        foreach ($row as $i => $txt) {
            if (in_array($i, [1, 8])) {
                $nb = max($nb, $this->NbLines($widths[$i], $txt));
            }
        }

        $h = 6 * $nb;
        $this->CheckPageBreak($h);

        foreach ($row as $i => $txt) {
            $w = $widths[$i];
            $x = $this->GetX();
            $y = $this->GetY();

            if ($i == 1 || $i == 8) {
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
            if ($c == "\n") {
                $i++; $sep = -1; $j = $i; $l = 0; $nl++;
                continue;
            }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c] ?? 0;
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                } else {
                    $i = $sep + 1;
                }
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else {
                $i++;
            }
        }

        return $nl;
    }
}

function convertiData($data) {
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
        $dt = DateTime::createFromFormat('Y-m-d', $data);
        return $dt ? $dt->format('d-m-Y') : $data;
    }
    return $data;
}

function generaPDFMezzi($mezziAssociativi) {
    if (empty($mezziAssociativi)) {
        echo "Nessun mezzo trovato o accesso negato.";
        return;
    }

    $mezziNumerici = [];
    foreach ($mezziAssociativi as $mezzo) {
        $riga = array_values($mezzo);

        // Converti solo le colonne con date (indici 3-7)
        for ($i = 3; $i <= 7; $i++) {
            if (isset($riga[$i])) {
                $riga[$i] = convertiData($riga[$i]);
            }
        }

        $mezziNumerici[] = $riga;
    }

    $pdf = new PDF('L', 'mm', 'A3');
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->AddPage();

    // Titolo centrato
    $pdf->SetFont('Courier', 'B', 16);
    $pdf->Cell(0, 10, "Elenco Mezzi", 0, 1, 'C');

    // Data e ora in alto a sinistra
    $pdf->SetFont('Courier', '', 10);
    $dataOra = date("d-m-Y H:i:s");
    $pdf->Cell(0, 10, "Ultimo download: $dataOra", 0, 1, 'L');
    $pdf->Ln(5);

    $intestazioni = [
        "ID", "Modello", "Targa", "Data Immatric.", "Data Revisione",
        "Scad. Assicur.", "Scad. Revis.", "Scad. Bollo", "Tipo Mezzo"
    ];

    $larghezze = [];
    foreach ($intestazioni as $i => $etichetta) {
        $max = $pdf->GetStringWidth($etichetta);
        foreach ($mezziNumerici as $mezzo) {
            $max = max($max, $pdf->GetStringWidth($mezzo[$i]));
        }

        if (in_array($i, [1, 8])) {
            $larghezze[] = $max + 6;
        } else {
            $larghezze[] = $max + 20;
        }
    }

    $totalWidth = array_sum($larghezze);
    $scale = 397 / $totalWidth;
    foreach ($larghezze as &$w) {
        $w *= $scale;
    }

    $pdf->larghezze = $larghezze;

    // Intestazione grassetto
    $pdf->SetFont('Courier', 'B', 10);
    foreach ($intestazioni as $i => $etichetta) {
        $pdf->Cell($larghezze[$i], 6, $etichetta, 1, 0, 'C');
    }
    $pdf->Ln();

    // Righe normali
    $pdf->SetFont('Courier', '', 10);
    foreach ($mezziNumerici as $riga) {
        $pdf->Row($larghezze, $riga);
    }

    $pdf->Output('I', 'mezzi.pdf');
}

// ==== CHIAMATA ====
$get = $_GET;
$post = $_POST;
$session = $_SESSION;

$mezzi = API_ElencoMezziDisponibili($get, $post, $session);
generaPDFMezzi($mezzi);
?>

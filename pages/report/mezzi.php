<?php
require_once("./funzioniDB.php");

session_start();

if(!isset($_SESSION['idUtente']) || $_SESSION['tipoUtente'] != 'admin'){
    header("Location: /ProntoEmergenza2025/login");
}else{
    
    require_once("./api/ElencoMezziDisponibili.php");
    $data =  API_ElencoMezziDisponibili([], [], $_SESSION);

    require('fpdf/fpdf.php');
    
    class PDF extends FPDF {}

    $pdf = new PDF('L', 'mm', 'A3');
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->AddPage();
    $pdf->SetFont('Courier', '', 10);
    $pdf->Cell(0, 5, 'Data generazione PDF: ' . date("d/m/Y H:i:s"), 0, 1, 'L');
    $pdf->Ln(5);

    // Titolo centrato
    $pdf->SetFont('Courier', 'B', 16);
    $pdf->Cell(0, 10, "Elenco Mezzi", 0, 1, 'C');

    $intestazioni = [
        "ID", "Modello", "Targa", "Data Immatric.", "Data Revisione",
        "Scad. Assicur.", "Scad. Revis.", "Scad. Bollo", "Tipo Mezzo"
    ];

    $larghezze = [20, 70, 30, 40, 40, 40, 40, 40, 50];

    $pdf->SetFont('Courier', 'B', 12);
    foreach ($intestazioni as $i => $etichetta) {
        $pdf->Cell($larghezze[$i], 6, $etichetta, 1, 0, 'C');
    }
    $pdf->Ln();
    
    $pdf->SetFont('Courier', '', 12);
    foreach ($data as $riga) {
        $i = 0;
        foreach ($riga as $etichetta) {
            $pdf->Cell($larghezze[$i], 6, $etichetta, 1, 0);
            $i++;
        }
        $pdf->Ln();
    }

    $pdf->Output('I', 'mezzi.pdf');
}
?>

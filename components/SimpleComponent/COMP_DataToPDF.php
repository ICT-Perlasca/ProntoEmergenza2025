<?php
// lib/excel_export.php
require_once __DIR__ . '/../../vendor/autoload.php';

/**
 * Esporta un array di dati in un file Excel e ne forza il download.
 *
 * @param array $dati Array associativo dei dati da esportare
 * @param string $nomeFile Nome del file da salvare (senza estensione)
 * @param string $formato Estensione del file: 'xlsx' o 'xls'
 */
function DataToPDF(){//array $dati, string $nomeFile, string $formato) {
    /*
    if (empty($dati)) {
        
    }
    */
    try {


            use Dompdf\Dompdf;

        $dompdf = new Dompdf();
        $html = '
            <!DOCTYPE html>
            <html>
            <head>
                <title>Esempio PDF</title>
            </head>
            <body>
                <h1>Ciao Mondo!</h1>
                <p>Questo è un PDF generato con DomPDF.</p>
            </body>
            </html>
        ';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('esempio.pdf');



        /*
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Intestazioni
        $colonna = 'A';
        foreach (array_keys($dati[0]) as $intestazione) {
            $sheet->setCellValue($colonna . '1', $intestazione);
            $colonna++;
        }

        // Dati
        $riga = 2;
        foreach ($dati as $record) {
            $colonna = 'A';
            foreach ($record as $valore) {
                $sheet->setCellValue($colonna . $riga, $valore);
                $colonna++;
            }
            $riga++;
        }

        // Auto-dimensionamento colonne
        foreach (range('A', chr(ord('A') + count($dati[0]) - 1)) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Scrittura file
        $tmpFile = tempnam(sys_get_temp_dir(), 'excel');
        $writer = ($formato === 'xls') ?
            new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet) :
            new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($tmpFile);

        // Download
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename={$nomeFile}.{$formato}");
        header("Content-Type: application/octet-stream");
        header("Content-Transfer-Encoding: binary");
        header('Cache-Control: must-revalidate'); //aggiunto by prati
        header('Content-Length: ' . filesize($tmpFile));

        readfile($tmpFile);
        unlink($tmpFile);
       // $ret['ok']='ok';
*/    

    } catch (Exception $e) {
        die('Errore durante la generazione del file: ' . $e->getMessage());
    }

}

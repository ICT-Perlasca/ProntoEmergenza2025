<?php
function generaCardMezzo($mezzo) {
    if (isset($mezzo['idMezzo'])) {
        $idMezzo = htmlspecialchars($mezzo['idMezzo']);
    } else {
        $idMezzo = 'n/a';
    }

    if (isset($mezzo['modello'])) {
        $modello = htmlspecialchars($mezzo['modello']);
    } else {
        $modello = 'Modello sconosciuto';
    }

    if (isset($mezzo['targa'])) {
        $targa = htmlspecialchars($mezzo['targa']);
    } else {
        $targa = 'Nessuna targa';
    }

    if (isset($mezzo['dataImmatricolazione'])) {
        $dataImmatricolazione = date("d/m/Y", strtotime(
            htmlspecialchars($mezzo['dataImmatricolazione'])
        ));
    } else {
        $dataImmatricolazione = 'Data non disponibile';
    }

    if (isset($mezzo['dataRevisione'])) {
        $dataRevisione = date("d/m/Y", strtotime(
            htmlspecialchars($mezzo['dataRevisione'])
        ));
    } else {
        $dataRevisione = 'Non effettuata';
    }

    if (isset($mezzo['scadAssicurazione'])) {
        $scadAssicurazione = date("d/m/Y", strtotime(
            htmlspecialchars($mezzo['scadAssicurazione'])
        ));
    } else {
        $scadAssicurazione = 'Non disponibile';
    }

    if (isset($mezzo['scadRevisione'])) {
        $scadRevisione = date("d/m/Y", strtotime(
            htmlspecialchars($mezzo['scadRevisione'])
        ));
    } else {
        $scadRevisione = 'Non disponibile';
    }

    if (isset($mezzo['scadBollo'])) {
        $scadBollo = date("d/m/Y", strtotime(
            htmlspecialchars($mezzo['scadBollo'])
        ));
    } else {
        $scadBollo = 'Non disponibile';
    }

    if (isset($mezzo['tipoMezzo'])) {
        $tipoMezzo = htmlspecialchars($mezzo['tipoMezzo']);
    } else {
        $tipoMezzo = 'Tipo sconosciuto';
    }

    if (isset($mezzo['nomeMezzo'])) {
        $nomeMezzo = htmlspecialchars($mezzo['nomeMezzo']);
    } else {
        $nomeMezzo = 'Non disponibile';
    }
    return '
        <div class="col-12 col-sm-6 col-md-4 p-3">
            <div class="card mb-3 border-2 rounded-3 shadow">
                <div class="card-body bg-white text-dark">
                    <h4 class="card-title" id="ricerca1">' . $nomeMezzo . '</h4>
                    <h5 class="card-title">' . $modello . '<br> (' . strtoupper($tipoMezzo) . ')</h5>
                    <p class="card-text" id="ricerca2"><strong>Targa:</strong> ' . $targa . '</p>
                    <p class="card-text"><strong>Immatricolazione:</strong> ' . $dataImmatricolazione . '</p>
                    <p class="card-text"><strong>Ultima Revisione:</strong> ' . $dataRevisione . '</p>
                    <p class="card-text"><strong>Scadenza Assicurazione:</strong> ' . $scadAssicurazione . '</p>
                    <p class="card-text"><strong>Scadenza Revisione:</strong> ' . $scadRevisione . '</p>
                    <p class="card-text"><strong>Scadenza Bollo:</strong> ' . $scadBollo . '</p>
                    <div class="text-center">
                        <a href="mezzi/profiloMezzo?id=' . $idMezzo . '" class="text-decoration-none">
                            <button class="btn btn-primary">
                                Visualizza Dettagli
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>';
}
?>
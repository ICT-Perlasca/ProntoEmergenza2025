<?php
function COMP_Popup($id, $titolo, $messaggio, $funzione) {
    return '
        <!-- Modal -->
        <div class="modal fade" id="' . $id . '" tabindex="-1" aria-labelledby="' . $id . 'Label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="' . $id . 'Label">' . htmlspecialchars($titolo) . '</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                    </div>
                    <div class="modal-body">
                        ' . $messaggio . '
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="' . htmlspecialchars($funzione) . '">Conferma</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annulla</button>
                    </div>
                </div>
            </div>
        </div>
    ';
}
?>

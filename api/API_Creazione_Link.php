<?php
function api_creaLink($get, $post, $session) {
    require_once ("./globals.php");

    $idUHash = md5($post['idU']);
    $dataHash = md5($post['data']);
    $link = $DOMAIN_NAME . "/click_email?idU=".$post['idU']."&data=".$post['data']."&idUHash=".$idUHash."&dataHash=".$dataHash;
    $ris = [
        "link" => $link
    ];
    return $ris;
}
?>
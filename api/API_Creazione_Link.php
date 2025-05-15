<?php
function creaLink([$get, $post, $session) {
    $idUHash = md5($post['idU']);
    $dataHash = md5($post['data']);
    $link = "./click_email?idU=".$post['idU']."&data=".$post['data']."&idUHash=".$idUHash."&dataHash=".$dataHash;
    return $ris['link'][$link];
}
?>
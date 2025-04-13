1)Al 13/04 modificato il database per aggiunta campo immagine nela tabella utenti
2) i dati memorizzati in sessione sono i seguenti:
            $_SESSION['idUtente']=$ris[0]['idUtente'];
            $_SESSION['nome']=$ris[0]['nome'];
            $_SESSION['cognome']=$ris[0]['cognome'];
            $_SESSION['dataNascita']=$ris[0]['dataNascita'];
            $_SESSION['email']=$ris[0]['email'];
            $_SESSION['telefono']=$ris[0]['telefono'];
            $_SESSION['istruttore']=$ris[0]['istruttore'];
            $_SESSION['status']=$ris[0]['status'];
            $_SESSION['tipoUtente']=$ris[0]['tipoUtente'];
            $_SESSION['immagine']=(is_null($ris[0]['immagine']))?$ris[0]['immagine']:"./public/images/avatar.jpg";

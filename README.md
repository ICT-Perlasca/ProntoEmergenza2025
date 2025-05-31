1)Al 13/04 modificato il database per aggiunta campo immagine nella tabella utenti

2) i dati memorizzati in sessione sono i seguenti:
            $_SESSION['idUtente']
            $_SESSION['username']
            $_SESSION['nome']
            $_SESSION['cognome']
            $_SESSION['dataNascita']
            $_SESSION['email']
            $_SESSION['telefono']
            $_SESSION['istruttore']
            $_SESSION['status']
            $_SESSION['tipoUtente']
            $_SESSION['immagine']

3) account utente ADMIN
username: mario.rossi
password: password123

4) account utente USER
username: admin
password: admin123

5) Caricamento file
```
    /uploads
    |
    |-/documents
    |
    |-/images
    |
    |-/comunications
```

In comunications i file saranno salvati yyyymmddHHiiss.pdf (es. 20250428083522.pdf) e conterranno i file allegati delle comunicazioni.
In documents i file saranno salvati yyyymmddHHiiss_f_vbnmhjkiol.pdf, dove f indica fronte, r indica retro e gli ultimi caratteri sono ottenuti facendo la funzione md5 del nome del file. In documents i file saranno gli allegati dai documenti caricati.

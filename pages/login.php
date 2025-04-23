<?php
require_once("funzioniDB.php");

session_start();
if (isset($_SESSION['nome']))  //utente già loggato
    header("location:/ProntoEmergenza2025");
else {
    if (isset($_POST['username'])){//utente ha compilato il form
        //cerca utente
        $strSql="select * from utenti where username=? and password=?";
        $ris=db_query($strSql,[$_POST['username'],$_POST['password']],[PDO::PARAM_STR,PDO::PARAM_STR]);
        //print_r($ris);
        if (count($ris)==0) { //utente non esiste
            setcookie("errorelogin","Nome utente o password errati!!",time()+60*60,"/");
            header("location:/ProntoEmergenza2025/login");
        }
        else{ //utente esiste
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
            header("location:/ProntoEmergenza2025");
        }
            
    }
    else{ //utente deve compilare il form
?>
    <html>
    <head>
        <base href="./" />
        <base href="./" />
        <link href="./public/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
        
    </head>
    <body>
    <div class="row min-vh-90">
            <div class="col-lg-6 col-12 px-5 py-5">
                <img class="rounded img-fluid px-5 py-3" src="./public/images/logo-ambulanza.png" alt="Logo Pronto Emergenza">
                <img class="rounded img-fluid px-5 py-3" src="./public/images/icona-ambulanza.png" alt="Icona Ambulanza">
            </div>
            <div class="col-lg-6 col-12 bg-primary min-vh-100 align-middle px-5 py-5 rounded">
                <form method="POST" class="container-fluid row align-items-center justify-content-center" name="formLog" onsubmit="return loginJS(this)">
                    <div class="col-12">
                        <label for="inputUsername" class="form-label">Username</label>
                        <input type="text" name="username" id="inputUsername" placeholder="username" class="form-control text-secondary" aria-label="Username">
                    </div>
                    <div class="col-12">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" name="password" id="inputPassword" placeholder="password" class="form-control  text-secondary" aria-label="Password">
                    </div>
                    <div class="col-12"><h2 id="h2Log"></h2></div>
                    <div class="col-12 text-center">
                        <button class="btn btn-primary" type="submit">ACCEDI</button>
                    </div>
                    <!--<div class='col-12 alert alert-secondary' role='alert'>sezione dell'errore</div>-->
                    <?php
                    if (isset($_COOKIE['errorelogin'])){
                       echo "<div class='col-12 alert alert-secondary' role='alert'>Nome utente o password inesistenti!!!!</div>"; 
                       setcookie("errorelogin","",time()-1,"/");                  
                    }
                    ?>
                    <div class="col-12 text-center text-primary">
                        <a href="ripristino" class="text  text-secondary">Password dimenticata??</a>
                        <a href="registrazione" class="text  text-secondary">Registrati</a>
                    </div>
                </form> 
            </div>
        </div>
    </body>
    </html>
<?php
    }
}
?>
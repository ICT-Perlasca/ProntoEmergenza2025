<html>
<head>
    <base href="./" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="row min-vh-90">
        <div class="col-lg-6 col-12 px-5 py-5">
            <img class="rounded img-fluid px-5 py-3" src="public/images/logo-ambulanza.png" alt="Logo Pronto Emergenza">
            <img class="rounded img-fluid px-5 py-3" src="public/images/icona-ambulanza.png" alt="Icona Ambulanza">
        </div>
        <div class="col-lg-6 col-12 bg-warning min-vh-100 align-middle px-5 py-5 rounded">
            <form action="#" method="POST" class="container-fluid row align-items-center justify-content-center" name="formLog" onsubmit="return loginJS(this)">
                <div class="col-12">
                    <label for="inputUsername" class="form-label">Username</label>
                    <input type="text" id="inputUsername" placeholder="username" class="form-control"aria-label="Username">
                </div>
                <div class="col-12">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input type="password" id="inputPassword" placeholder="password" class="form-control" aria-label="Password">
                </div>
                <div class="col-12"><h2 id="h2Log"></h2></div>
                <div class="col-12 text-center">
                    <button class="btn btn-primary" type="submit">ACCEDI</button>
                </div>
                <div class="col-12 text-center text-primary">
                    <a href="ripristino" class="text">Password dimenticata??</a>
                    <a href="registrazione" class"text">Registrati</a>
                </div>
            </form> 
        </div>
    </div>
</body>
</html>
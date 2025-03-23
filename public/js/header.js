function ritornaLog(xhttp) {
    try {
        document.getElementById("h2Log").innerHTML = xhttp.responseText;
        let strJson = JSON.parse(xhttp.responseText);
        if (strJson.risultato === "false") {
            if (strJson.tipoErr === "log") {
                document.getElementById("h2Log").innerHTML = "Errore, username o password errati!";
            } else {
                document.getElementById("h2Log").innerHTML = "Errore con il database!";
            }
			let formDati=document.getElementById("formLog");
			formLog.textLog.value = '';
			formLog.pswLog.value = '';
        } else {
           window.location.replace("home.php");
        }
    } catch (e) {
        console.error("Error parsing JSON response:", e, xhttp.responseText);
        document.getElementById("h2Log").innerHTML += "Errore nel sistema, riprova più tardi!";
    }
}


function loginJS(formLog)
{
    let user = formLog.textLog.value;
    let psw = formLog.pswLog.value;
    
    let xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
        ritornaLog(this);
    }
    xhttp.open("POST", "api\\ricercaUser.php");
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("user="+user+"& psw="+psw);
    
	return false;
}
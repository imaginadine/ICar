function checkEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function checkTel(tel) {
    var re = /^0[1-9]\d{8}$/;
    return re.test(tel);
}

function modifierMail() {
    newMail = document.getElementById('modifMail').value;

    if (checkEmail(newMail)) {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                /*traitement*/
                    document.getElementById("msg1").innerHTML="<div class='alert'>Votre mail a été modifié !</div>";
                    document.getElementById("mail").innerHTML= this.responseText;
            }
        };
        //on envoi les info au serveur
        xhttp.open("POST", "modifierMail.php", true);
        /*Ne pas oublier l'encodage des caractères */
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        /*Format de la donnée lorsque l'on envoi avec POST*/
        xhttp.send("newMail="+newMail);
    } else {
        document.getElementById("msg1").innerHTML="<div class='alert'>L'adresse mail rentré n'est pas valide...</div>";
    }

}

function modifierTel() {
    newTel = document.getElementById('modifTel').value;

    if (checkTel(newTel)) {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                /*traitement*/
                document.getElementById("msg2").innerHTML="<div class='alert'>Votre numéro de téléphone a été modifié</div>";
                document.getElementById("tel").innerHTML= this.responseText;
            }
        };
        //on envoi les info au serveur
        xhttp.open("POST", "modifierTel.php", true);
        /*Ne pas oublier l'encodage des caractères */
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        /*Format de la donnée lorsque l'on envoi avec POST*/
        xhttp.send("newTel="+newTel);
    } else {
        document.getElementById("msg2").innerHTML="<div class='alert'>Votre numéro de téléphone n'est pas valide ...</div>";
    }
}

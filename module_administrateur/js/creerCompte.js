function afficherAssureur(){
  if(document.getElementById("liste").value == "gestionnaire"){
    var message = "profil=true";
  } else {
    var message = "profil=false";
  }
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("listeAssureur").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "afficherListeAssuereurs.php", true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send(message);
}

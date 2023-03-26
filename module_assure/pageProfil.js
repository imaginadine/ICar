//fonction pour envoyer le numéro de contrat à afficherContrat.php en AJAX
function afficher(numContrat){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("contrat").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "afficherContrat.php", true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send("numero="+numContrat);
}

// fonction pour rediriger vers la page permettant de modifier les coordonnées
function modifierCoord(){
  document.location.href = "modifCoordonnees.php";
}

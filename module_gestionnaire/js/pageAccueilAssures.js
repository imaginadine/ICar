// fonction pour envoyer sur la page qui va traiter la demande
function traiter(demande){
  document.location.href = "modifierAdresse.php?numero="+demande.id;
}

function traiterCession(demande){
  document.location.href = "validerCession.php?numero="+demande.id; 
}

//fonction pour envoyer les information du formulaire à afficherRechercheAssure.php en AJAX
function rechercher(){
  var xhttp = new XMLHttpRequest();
  // on récupère les infos du formulaire
  var nom = document.getElementById("nom").value;
  var prenom = document.getElementById("prenom").value;
  var tel = document.getElementById("tel").value;
  var mail = document.getElementById("mail").value;
  var contrat = document.getElementById("contrat").value;
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("resultatRecherche").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "afficherRechercheAssure.php", true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send("nom="+nom+"&prenom="+prenom+"&tel="+tel+"&mail="+mail+"&contrat="+contrat);
}

//fonction pour accéder à la page de l'assuré
function acceder(assure){
  document.location.href = "pageAssure.php?identifiant="+assure.id;
}

//fonction pour accéder à la page permettant d'ajouter un assuré
function ajouter(){
  document.location.href = "creationCompte.php";
}

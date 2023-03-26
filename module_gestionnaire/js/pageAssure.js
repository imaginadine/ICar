// fonction pour accéder à la page contrat
function acceder(contrat){
  var info = contrat.id.split(";");
  document.location.href = "pageContrat.php?numero="+info[0]+"&identifiant="+info[1];
}

// fonction pour rediriger sur la page permettent de créer un nouveau contrat
function nvContrat(assure){
  document.location.href = "creerContrat.php?identifiant="+assure.id;
}

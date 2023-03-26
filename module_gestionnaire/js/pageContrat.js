//fonction pour rediriger le gestionnaire sur une page où il pourra entrer les modification du contrat sélectionné
function modifier(contrat){
  var info = contrat.id.split(";");
  document.location.href = "entrerModifContrat.php?contrat="+info[0]+"&identifiant="+info[1];
}

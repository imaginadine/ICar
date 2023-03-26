// fonction pour valider la demande
function valider(demande){
  document.location.href = "enregistrerModifAdresse.php?numero="+demande.id+"&action=valider";
}

// fonction pour refuser la demande
function refuser(demande){
  document.location.href = "enregistrerModifAdresse.php?numero="+demande.id+"&action=refuser";
}

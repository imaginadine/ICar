// fonction qui ouvre la conversation entre le gestionnaire et l'assuré
function accesConversation(assure){
  var info = assure.id.split(";");
  document.location.href = "conversation.php?identifiant="+info[0]+"&nom="+info[1]+"&prenom="+info[2];
}


// fonction qui affiche une liste déroulante avec tous les assurés pour ouvrir une conversation
function afficherListe(){
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("listeNvConv").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "afficherNvConversation.php", true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send("");
}

function accesConversationListe(){
  var info = document.getElementById("liste").value.split(";");
  document.location.href = "conversation.php?identifiant="+info[0]+"&nom="+info[1]+"&prenom="+info[2];
}

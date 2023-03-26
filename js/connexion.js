var modal = document.getElementById("modalEl");

var btn = document.getElementById("connexionBtn");

var span = document.getElementsByClassName("close")[0];

// ouvrir le modal quad l'utilisateur clique sur le bouton "Se connecter"
btn.onclick = function() {
  modal.style.display = "block";
}

// fermer le modal quand l'utilisateur clique sur la croix
span.onclick = function() {
  modal.style.display = "none";
}

// Quand l'utilisateur clique ailleur, fermer le modal
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
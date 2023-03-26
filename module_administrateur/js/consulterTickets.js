function supprimer(numTicket){
  if(confirm("Avez-vous vraiment traité ce ticket ?")){
    document.location.href="ticketTraite.php?numero="+numTicket;
  }
}

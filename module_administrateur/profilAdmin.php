<?php
	session_start();
	//vérification que l'utilisateur soit connecté pour accéder à la page, et qu'il soit un administrateur
	if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="administrateur")){
			header('Location: ../index.php');
			exit();
	}
?>
<html>
<head>
	<title>I-Car</title>
	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="../img/icon.png">
  <link rel="stylesheet" type="text/css" href="../css/designGlobal.css" />
	<link rel="stylesheet" type="text/css" href="../css/navbar.css" />
	<link rel="stylesheet" type="text/css" href="../css/pageAccueil.css" />
</head>
<body>
	<div class="nav">
    <input type="checkbox" id="nav-check">
    <div class="nav-header">
      <div class="nav-title">
        <a href="./profilAdmin.php"><img style="width: 50px" src="../img/icon.png"/></a>
      </div>
    </div>
    <div class="nav-btn">
      <label for="nav-check">
        <span></span>
        <span></span>
        <span></span>
      </label>
    </div>

    <div class="nav-links">
      <a href="./php/creerCompte.php">Comptes</a>
      <a href="./php/inscrireAssurance.php">Assurances</a>
      <a href="./php/consulterTickets.php">Tickets</a>
      <a href="./php/consulterModification.php">Modifications</a>
      <a href="../deconnexion.php?connexion=out">Déconnexion</a>
    </div>
  </div>

	<div class="titre">
		<h1>Bienvenue sur le profil Administrateur</h1>
	</div>

	<div class="menu_icone">
    <div class="icone"><a href="./php/creerCompte.php"><img style="height: 150px;" src="../img/assure.png"/><p>Comptes</p></a></div>
    <div class="icone"><a href="./php/inscrireAssurance.php"><img style="height: 150px;" src="../img/assurance.png"/><p>Assurances</p></a></div>
    <div class="icone"><a href="./php/consulterTickets.php"><img style="height: 150px;" src="../img/ticket.png"/><p>Tickets</p></a></div>
    <div class="icone"><a href="./php/consulterModification.php"><img style="height: 150px;" src="../img/modification.png"/><p>Modifications</p></a></div>
  </div>



</body>

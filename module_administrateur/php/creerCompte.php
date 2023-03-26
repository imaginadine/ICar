<?php
	session_start();
	//vérification que l'utilisateur soit connecté pour accéder à la page, et qu'il soit un administrateur
	if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="administrateur")){
			header('Location: ../../index.php');
			exit();
	}
?>
<html>
<head>
	<title>I-Car</title>
	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="../../img/icon.png">
  <link rel="stylesheet" type="text/css" href="../../css/designGlobal.css" />
	<link rel="stylesheet" type="text/css" href="../../css/navbar.css" />
	<link rel="stylesheet" type="text/css" href="../../css/form.css" />
</head>
<body>
	<div class="nav">
		<input type="checkbox" id="nav-check">
		<div class="nav-header">
			<div class="nav-title">
				<a href="../profilAdmin.php"><img style="width: 50px" src="../../img/icon.png"/></a>
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
			<a href="./creerCompte.php">Comptes</a>
			<a href="./inscrireAssurance.php">Assurances</a>
			<a href="./consulterTickets.php">Tickets</a>
			<a href="./consulterModification.php">Modifications</a>
			<a href="../../deconnexion.php?connexion=out">Déconnexion</a>
		</div>
	</div>

  <div class="titre">
    <h1>Créer un nouveau compte</h1>
  </div>

	<div class="affichage">
		<form id='formulaire' class='form' method='post' action='enregistrerCompte.php'>
	    <p>Identifiant <input type='text' id='identifiant' name='identifiant' required/></p>
	    <p>Mot de passe <input type='password' id='mdp' name='mdp' required/></p>
	    <p onclick="afficherAssureur()">Profil <select size='1' name='profil' id="liste">
	      <option value="police">Force de l'ordre</option>
	      <option value="gestionnaire">Gestionnaire</option>
	      <option value="administrateur">Administrateur</option>
	    </select></p>
			<div id="listeAssureur"></div>
	    <p><input type='submit' value='Valider' id='boutonValider' class='btn'/></p>
	  </form>
	</div>

	<script type="text/javascript" src="../js/creerCompte.js"></script>
</body>

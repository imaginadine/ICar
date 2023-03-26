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
		<h1>Ajouter une assurance au système</h1>
	</div>

	<div class="affichage">
		<form id='formulaire' class='form' method='post' action='enregistrerAssurance.php'>
	    <p>Nom <input type='text' name='nom' required/></p>
			<p>Adresse <input type='text' name='adresse' placeholder="ex: 1 rue Ronsard"required/></p>
			<p>Ville <input type='text' name='ville' required/></p>
			<p>Code postal <input type='text' name='codePostal' placeholder="ex: 75000" maxlength=5 minlength=5 required/></p>
			<p>Pays <input type='text' name='pays' required/></p>
			<p>Numéro de téléphone <input type='text' name='tel' pattern="[0-9]{10}" placeholder="ex: 06-01-02-03-04" required/></p>
			<p>Prend en charge les dégats des assurés <select size='1' name='degatsAssurés'>
	      <option value="oui">Oui</option>
	      <option value="non">Non</option>
	    </select></p>
	    <p><input type='submit' value='Valider' id='boutonValider' class='btn'/></p>
	  </form>
	</div>




</body>

<?php
	session_start();
	//vérification que l'utilisateur soit connecté pour accéder à la page, et qu'il soit un gestionnaire
	if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="gestionnaire")){
			header('Location: ../../index.php');
			exit();
	}
?>
<html>
<head>
	<meta charset="utf-8">
	<title>I-Car</title>
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
        <a href="../profilGestionnaire.php"><img style="width: 50px" src="../../img/icon.png"/></a>
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
      <a href="./pageAccueilAssures.php">Assurés</a>
      <a href="./pageAccueilSinistres.php">Sinistres</a>
      <a href="./messagerie.php">Messagerie</a>
      <a href="./tickets.php">Tickets</a>
      <a href="../../deconnexion.php?connexion=out">Déconnexion</a>
    </div>
  </div>
	<!--Titre informatif-->
	<div class="titre">
		<h1>Création d'un nouveau compte assuré</h1>
	</div>

	<!--Formulaire envoyant les informations renseignées par l'utilisateur dans la page EnregistrerNouveauContrat.php sans que les informations soient disponibles dans l'URL-->
	<form action="enregistrerCompte.php" method="POST" class="form">
		<div class="affichage">
			<h4>Informations personnelles</h4>
			<!--Emplacement pour que l'utilisateur rentre son nom-->
			<p>Nom: <input type="text" name="nom" required></p>
			<!--Emplacement pour que l'utilisateur rentre son prenom-->
			<p>Prénom: <input type="text" name="prenom" required></p>
			<!--Emplacement pour que l'utilisateur rentre son numéro de téléphone-->
			<p>Téléphone: <input type="tel" name="telephone" pattern="[0-9]{10}" placeholder="ex: 0601020304" required></p>
			<!--Emplacement pour que l'utilisateur rentre son adresse mail-->
			<p>Adresse Mail: <input type="email" name="mail" required></p>
			<!--Emplacement pour que l'utilisateur rentre son adresse postale-->
			<p>Adresse Postale: <input type="text" name="adresse" placeholder="ex: 1 rue Ronsard" required></p>
			<!--Emplacement pour que l'utilisateur rentre sa ville-->
			<p>Ville: <input type="text" name="ville" required></p>
			<!--Emplacement pour que l'utilisateur rentre son code postal-->
			<p>Code Postal: <input type="text" name="codePostal" placeholder="ex: 75000" maxlength=5 minlength=5 required></p>
			<!--Emplacement pour que l'utilisateur rentre son pays-->
			<p>Pays:<input type="text" name="pays" required></p>
			<h4>Informations du compte</h4>
			<!--Emplacement pour que l'utilisateur rentre son identifiant-->
			<p>Identifiant: <input type="text" name="identifiant" required></p>
			<!--Emplacement pour que l'utilisateur rentre son mot de passe-->
			<p>Mot de Passe:<input type="password" name="password" required></p>
			<input class="btn" type="submit" value="Valider" style="margin-bottom: 15px">
		</div>
	</form>
</body>
</html>

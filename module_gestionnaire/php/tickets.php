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

  <div class="titre">
		<h1>Remonter un problème à l'administrateur</h1>
	</div>

	<div class="affichage">

		<form class="form" method="post" action="enregistrerTicket.php">

			<p>Type </p>
			<select size='1' name='type'>
				<option value="---">---</option>
				<option value="incident">Incident</option>
				<option value="demande">Demande</option>
			</select>

			<p>Catégorie </p>
			<select size='1' name='categorie'>
				<option value="---">---</option>
				<option value="pb1">Problème 1</option>
				<option value="pb2">Problème 2</option>
				<option value="pb3">Problème 3</option>
			</select>

			<p>Urgence </p>
			<select size='1' name='urgence'>
				<option value="---">---</option>
				<option value="haute">Haute</option>
				<option value="moyenne">Moyenne</option>
				<option value="basse">Basse</option>
			</select>

			<p>Titre </p>
			<input type="text" name="titre" required/>

			<p>Description </p>
			<textarea name="description" class="description" rows="5" cols="33" required></textarea>

			<p><input type="submit" value="Valider" id="boutonValider" class="btn"/></p>

			<?php
				//s'affiche seulement si l'utilisateur a mal rempli le formulaire
				if(!empty($_GET)){
					echo("<h4>Vous n'avez pas rempli et/ou sélectionné tous les champs obligatoires</h4>");
				}
			?>
		</form>

	</div>

</body>

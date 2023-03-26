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

  <?php
		/* Fonction pour récupérer tous les identifiants existants */
		function recupIdentifiant(){
			$row = 0;
      $TabIdentifiants = array(); //tableau qui contient tous les identifiants existants
      if (($handle = fopen("../../csv/identifiants.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
          if($row != 0){
            $TabIdentifiants[$row-1] = $data[0];
          }
          $row++;
        }
        fclose($handle);
      }
      return($TabIdentifiants);
		}

		$TabIdentifiants = recupIdentifiant();

		if(in_array($_POST["identifiant"], $TabIdentifiants)){
			$_POST["identifiant"] = $_POST["identifiant"]."_";
		}

		if($_POST["profil"] == "gestionnaire"){
			$compte = array("identifiant" => $_POST["identifiant"],
												"mdp" => password_hash($_POST["mdp"], PASSWORD_DEFAULT),
												"profil" => $_POST["profil"],
												"codeAssureur" => $_POST["assurance"]);
		} else {
			$compte = array("identifiant" => $_POST["identifiant"],
												"mdp" => password_hash($_POST["mdp"], PASSWORD_DEFAULT),
												"profil" => $_POST["profil"],
												"codeAssureur" => "");
		}
		$fp = fopen('../../csv/identifiants.csv', 'a+');
		fputcsv($fp, $compte,";");
		fclose($fp);

		// on sauvegarde les modifications faites pour les administrateurs
		$modificattion = array("document" => "compte",
													 "numero" => $_POST["identifiant"],
													 "type" => "creation",
												 	 "identifiant" => $_SESSION["identifiant"],
												 	 "date" => date("d-m-Y"),
												   "heure" => date("H:i"));

		$fp = fopen('../../csv/modifications.csv', 'a+');
 		fputcsv($fp, $modificattion,";");
 		fclose($fp);
  ?>

	<div class="affichage">
		<h2 style="text-align:center;">Le compte a bien été créé !</h2>
		<a href="../profilAdmin.php">Retour à l'accueil</a>
	</div>


</body>

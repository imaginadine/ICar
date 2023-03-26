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
		<h1>Consulter les modifications réalisées dans le système</h1>
	</div>

	<?php
		/*Fonction pour lire le fichier modifications.csv et récupérer les modifications faites dans le système*/
		function recupInfoModifications(){
      $row = 0;
      $tabModifications = array(); //tableau qui contient les info de toutes les modifications
      $tabKeys = array(); //tableau qui contient toutes les clés du tableau $tabModifications
      if (($handle = fopen("../../csv/modifications.csv", "r"))) {
	    	while (($data = fgetcsv($handle, 1000, ";"))) {
					if($row == 0){
						// si on est à la première ligne du csv, on récupère les clés
						$tabKeys = $data;
					} else {
            $i = 0;
            foreach ($tabKeys as $key) {
              $tabModifications[$row-1][$key] = $data[$i];
              $i ++;
            }
					}
					$row++;
	    	}
				fclose($handle);
	    }
      return($tabModifications);
    }

		/*Fonction pour afficher un ticket dans un encadré*/
		function afficherModification($modification){
			switch ($modification["type"]) {
				// selon l'urgence du ticket on change la couleur de l'encadré
				case 'suppression':
					$couleur = "#ff5722";
					break;
				case 'modification':
					$couleur = "#ff9800";
					break;
				case 'creation':
					$couleur = "#4caf50";
					break;
				default:
					echo("Erreur");
					break;
			}
			echo("<div class='encadreInfoModification' style='border: 2px solid ".$couleur.";'>
				<div class='info'>".$modification["type"]." du ".$modification["document"]." ".$modification["numero"]." par ".$modification["identifiant"]."</div>
				<div class='info'>Le ".$modification["date"]." à ".$modification["heure"]."</div>
			</div>");
		}

		// on récupère les modifications faites dans le système
		$tabModifications = recupInfoModifications();
		// on les affiche dans des encadrés
		foreach ($tabModifications as $modification) {
			afficherModification($modification);
		}
	?>


</body>

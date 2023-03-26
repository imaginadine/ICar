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
		<h1>Création d'un nouveau compte assuré</h1>
	</div>

	<div class="affichage">
	<?php echo('</h4>Le compte de '.$_POST["nom"].' '.$_POST["prenom"].' a été créé avec succés</h4><br/>
		<a href="pageAccueilAssures.php">Retour à la page de gestion des assurés</a>'); ?>
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

		while(in_array($_POST["identifiant"], $TabIdentifiants)){
			$_POST["identifiant"] = $_POST["identifiant"]."_";
		}

		/*Ouverture du fichier dans lequel on veut écrire*/
		$fpa = fopen('../../csv/assures.csv','a+');
		/*Création du tableau*/
		$assures = array(
			    $_POST["identifiant"],
					$_POST["nom"],
					$_POST["prenom"],
					$_POST["telephone"],
					$_POST["mail"],
					$_POST["adresse"],
					$_POST["ville"],
					$_POST["codePostal"],
					$_POST["pays"],
					$_SESSION["codeAssureur"]
		);

		fputcsv($fpa, $assures,";");

		/* On ferme le fichier */
		fclose($fpa);

		$fpb = fopen('../../csv/identifiants.csv', 'a+');

		$identifiants = array(
		      $_POST["identifiant"],
					password_hash($_POST["password"], PASSWORD_DEFAULT),
					"assure",
					$_SESSION["codeAssureur"],
		);

		fputcsv($fpb, $identifiants,";");

		/* On ferme le fichier */
		fclose($fpb);

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
</body>
</html>

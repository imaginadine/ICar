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
		<h1>Modifier les informations du contrat</h1>
	</div>

	<?php
    /*Fonction pour modifier le fichier contrats.csv avec les nouvelles modifications*/
    function modifFichierContrat(){
      $row = 0;
      $contrat = array(); // tableau dans lequel on stocke les données du contrat
      $donneesCsv = array(); // le tableau dans le quel on va stocker toutes les donées présentes dans le csv
      $tabKeys = array(); //tableau qui contient toutes les clés du tableau $contrat
      if (($handle = fopen("../../csv/contrats.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
					if($row == 0){
						// si on est à la première ligne du csv, on récupère les clés
						$tabKeys = $data;
					} else {
						if($data[0] == $_GET["contrat"]){
							// on modifie les données à envoyer au nouveau fichier csv
							$data[1] = $_POST["date"];
							// on sauvegarde les données du contrat
							$i = 0;
							foreach ($tabKeys as $key) {
								$contrat[$key] = $data[$i];
								$i ++;
							}
						}
					}
					array_push($donneesCsv, $data);
          $row++;
        }
        // on ferme et on supprime l'ancien csv
        fclose($handle);
        unlink("../../csv/contrats.csv");
      }
      // on crée un nouveau fichier csv, on y écrit toutes les nouvelles données
      $fp = fopen("../../csv/contrats.csv", "a+");
      foreach ($donneesCsv as $ligne) {
        fputcsv($fp, $ligne, ";");
      }
      fclose($fp);
      return($contrat);
    }


		/*Fonction pour modifier le fichier cartesVertes.csv avec les nouvelles modifications*/
    function modifCarteVerte($numeroCarteVerte){
      $row = 0;
      $donneesCsv = array(); // le tableau dans le quel on va stocker toutes les donées présentes dans le csv
      if (($handle = fopen("../../csv/cartesVertes.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
					if($row != 0){
						if($data[0] == $numeroCarteVerte){
							// on modifie les données à envoyer au nouveau fichier csv
							$data[6] = $_POST["catégorie"];
							$data[7] = $_POST["marque"];
						}
					}
					array_push($donneesCsv, $data);
					$row++;
				}
				// on ferme et on supprime l'ancien csv
        fclose($handle);
        unlink("../../csv/cartesVertes.csv");
      }
      // on crée un nouveau fichier csv, on y écrit toutes les nouvelles données
      $fp = fopen("../../csv/cartesVertes.csv", "a+");
      foreach ($donneesCsv as $ligne) {
        fputcsv($fp, $ligne, ";");
      }
      fclose($fp);
    }

		// on modifie le contrat
		$contrat = modifFichierContrat();
		// on modifie la carte verte
		modifCarteVerte($contrat["numCarteVerte"]);
		// on affiche les modifications à l'utilisateur
		echo("<div class=affichage>
			<h4>Les nouvelles informations du contrat sont :</h4>
			<p>Numéro de contrat : ".$contrat["numero"]."</p>
			<p>Identifiant de l'assuré : ".$contrat["identifiantAssure"]."</p>
			<p>Date de fin de validité : ".$contrat["date"]."</p>
			<p>Nom de l'assurance : ".$_SESSION["nom"]."</p>
			<p>Numéro de carte verte : ".$contrat["numCarteVerte"]."</p>
			<p>Catégorie du véhicule : ".$_POST["catégorie"]."</p>
			<p>Marque du véhicule : ".$_POST["marque"]."</p>
		</div>");

		// on sauvegarde les modifications faites pour les administrateurs
		$modificattion = array("document" => "contrat",
													 "numero" => $contrat["numero"],
													 "type" => "modification",
												 	 "identifiant" => $_SESSION["identifiant"],
												 	 "date" => date("d-m-Y"),
												   "heure" => date("H:i"));

		$fp = fopen('../../csv/modifications.csv', 'a+');
 		fputcsv($fp, $modificattion,";");
 		fclose($fp);

		echo('<div class="affichage" style="margin-top:50px">
			<a href="pageContrat.php?numero='.$_GET["contrat"].'&identifiant='.$_GET["identifiant"].'">Retour à la page contrat</a>
		</div>');
  ?>



</body>

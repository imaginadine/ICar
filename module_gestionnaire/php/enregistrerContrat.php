<?php
  // librairie qui créer les QRcode
  include('../../lib/phpqrcode/qrlib.php');
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
    <h1>Creer un nouveau contrat</h1>
  </div>

  <?php

    /* Fonction pour récupérer la liste des numéros de contrats existants */
    function recupNumeroContrat(){
      $row = 0;
  		$numeros = array(); //tableau qui contient les numéros de contrats existants
  		if (($handle = fopen("../../csv/contrats.csv", "r"))) {
  			while (($data = fgetcsv($handle, 1000, ";"))) {
  				if($row != 0){
  					$numeros[$row-1] = $data[0];
  				}
  				$row++;
  			}
  			fclose($handle);
  		}
  		return($numeros);
    }

    /* Fonction pour récupérer la liste des numéros des cartes vertes existantes */
    function recupNumeroCarteVerte(){
      $row = 0;
  		$numeros = array(); //tableau qui contient les numéros des cartes vertes existantes
  		if (($handle = fopen("../../csv/cartesVertes.csv", "r"))) {
  			while (($data = fgetcsv($handle, 1000, ";"))) {
  				if($row != 0){
  					$numeros[$row-1] = $data[0];
  				}
  				$row++;
  			}
  			fclose($handle);
  		}
  		return($numeros);
    }

    // on récupère les numéros de contrat et les numéros de carte verte déja existants
    $tabNumContrat = recupNumeroContrat();
    $tabNumCarteVerte = recupNumeroCarteVerte();

    // on génère un nouveau numéro de contrat
    do {
      $numContrat = rand(0, 9999999);
    } while (in_array($numContrat, $tabNumContrat));

    // on génère un nouveau numéro de carte verte
    do {
      $numCarteVerte = rand(0, 99999999);
    } while (in_array($numCarteVerte, $tabNumCarteVerte));

    $contrat = array('numero' => $numContrat,
                     'date' => $_POST["dateFin"],
                     'codeAssureur' => $_SESSION["codeAssureur"],
                     'identifiantAssure' => $_GET["identifiant"],
                     'numCarteVerte' => $numCarteVerte);

    $fp = fopen('../../csv/contrats.csv', 'a+');
    fputcsv($fp, $contrat,";");
    fclose($fp);

    $validitePossibles = array("A", "B", "BG", "CY", "CZ", "D", "DK", "E", "EST", "F", "FN", "GB", "GR", "H", "I", "IRL", "IS", "L", "LT", "LV", "M", "N", "NL", "P", "PL", "RO", "S", "SK", "SLO", "CH", "AL", "AND", "BIH", "BY", "HR", "IL", "IR", "MA", "MD", "MK", "RUS", "SRB", "TN", "TR", "UA");
    $validites = "";

    for($i = 1; $i <= 45; $i++){
      if(isset($_POST["validite".$i]) && $_POST["validite".$i] == "on"){
        $validites = $validites.$validitePossibles[$i-1]."-";
      }
    }

    $carteVerte = array('numero' => $numCarteVerte,
                        'dateDebut' => $_POST["dateDebut"],
                        'dateFin' => $_POST["dateFin"],
                        'codePays' => $_POST["codePays"],
                        'codeAssureur' => $_SESSION["codeAssureur"],
                        'plaque' => $_POST["plaque"],
                        'catégorie' => $_POST["categorie"],
                        'marque' => $_POST["marque"],
                        'validiteTerritoriale' => $validites,
                        'paysImmatriculation' => $_POST["paysImmatriculation"],
                        'identifiantAssure' => $_GET["identifiant"]);

    $fp = fopen('../../csv/cartesVertes.csv', 'a+');
    fputcsv($fp, $carteVerte,";");
    fclose($fp);

    // création du QR code
    QRcode::png('localhost/index.php?numeroContrat='.$numContrat, "../../QRcode/".$numContrat.".png");

    // on sauvegarde les modifications faites pour les administrateurs
		$modificattion = array("document" => "contrat",
													 "numero" => $numContrat,
													 "type" => "creation",
												 	 "identifiant" => $_SESSION["identifiant"],
												 	 "date" => date("d-m-Y"),
												   "heure" => date("H:i"));

		$fp = fopen('../../csv/modifications.csv', 'a+');
 		fputcsv($fp, $modificattion,";");
 		fclose($fp);

    echo("<div class='affichage'>
      <h4>Le contrat a bien été créé !</h4>
      <p>Le QR code associé est : </p>
      <a href='../../QRcode/".$numContrat.".png' download='".$numContrat.".png'><img style='width:250px' src='../../QRcode/".$numContrat.".png'/></a>
      <p><i>(Cliquez sur le QR code pour le télécharger)</i></p>
      <a href='pageAssure.php?identifiant=".$_GET["identifiant"]."'>Retour à la page assuré</a>
    </div>")
  ?>

</body>

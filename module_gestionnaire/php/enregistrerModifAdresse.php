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
    <h1>Traitement de la demande de changement d'adresse</h1>
  </div>

  <?php

    /* Fonction pour récupérer les infos de la demande de changements de coordonnées */
    function recupDemandes(){
     $row = 0;
     $demande = array(); //tableau qui contient les info de la demande de changement de coordonnées
     $tabKeys = array(); // tableau qui contient toutes les clé de $demande
     $donneesCsv = array(); // le tableau dans le quel on va stocker toutes les donées présentes dans le csv
     if (($handle = fopen("../../csv/demandeAdresse.csv", "r"))) {
       while (($data = fgetcsv($handle, 1000, ";"))) {
         if($row == 0){
             // si on est à la première ligne du csv, on récupère les clés
             $tabKeys = $data;
         } else {
            if($data[0] == $_GET["numero"]){
              // on modifie le traitement actuel de la demande
              $data[11] = $_GET["action"];
              // on stocke les info de la demande
              $i = 0;
              foreach ($tabKeys as $key) {
                $demande[$key] = $data[$i];
                $i ++;
              }
            }
         }
         array_push($donneesCsv, $data);
         $row++;
       }
       // on ferme et on supprime l'ancien csv
       fclose($handle);
       unlink("../../csv/demandeAdresse.csv");
     }
     // on crée un nouveau fichier csv, on y écrit toutes les nouvelles données
     $fp = fopen("../../csv/demandeAdresse.csv", "a+");
     foreach ($donneesCsv as $ligne) {
       fputcsv($fp, $ligne, ";");
     }
     fclose($fp);
     return($demande);
    }


    /*Fonction pour modifier le fichier assures.csv avec les nouvelles modifications*/
    function modifierAdresse($demande){
      $row = 0;
      $donneesCsv = array(); // le tableau dans le quel on va stocker toutes les donées présentes dans le csv
      if (($handle = fopen("../../csv/assures.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
					if($row != 0){
						if($data[0] == $demande["identifiant"]){
							// on modifie les données à envoyer au nouveau fichier csv
              $data[5] = $demande["nvAdresse"];
							$data[6] = $demande["nvVille"];
							$data[7] = $demande["nvCodePostal"];
              $data[8] = $demande["nvPays"];
						}
					}
					array_push($donneesCsv, $data);
					$row++;
				}
				// on ferme et on supprime l'ancien csv
        fclose($handle);
        unlink("../../csv/assures.csv");
      }
      // on crée un nouveau fichier csv, on y écrit toutes les nouvelles données
      $fp = fopen("../../csv/assures.csv", "a+");
      foreach ($donneesCsv as $ligne) {
        fputcsv($fp, $ligne, ";");
      }
      fclose($fp);
    }



    // on récupère les info et on modifie le traitement actuel
    $demande = recupDemandes();
    if ($demande["traitement"] == "valider"){
      // on effectue les modifications si la demande est validée
      modifierAdresse($demande);

      echo("<div class='affichage'><h4>Vous avez validé la demande de changement d'adresse, les modifications ont bien été apportées !</h4></div>");

      // on sauvegarde les modifications faites pour les administrateurs
  		$modificattion = array("document" => "adresse",
  													 "numero" => $demande["numero"],
  													 "type" => "modification",
  												 	 "identifiant" => $_SESSION["identifiant"],
  												 	 "date" => date("d-m-Y"),
  												   "heure" => date("H:i"));

  		$fp = fopen('../../csv/modifications.csv', 'a+');
   		fputcsv($fp, $modificattion,";");
   		fclose($fp);
    } else {
      echo("<div class='affichage'><h4>Vous avez refusé la demande de changement d'adresse</h4></div>");
    }
  ?>

  <div class="affichage">
    <a href="pageAccueilAssures.php">Retour à la page de gestion des assurés</a>
  </div>

</body>

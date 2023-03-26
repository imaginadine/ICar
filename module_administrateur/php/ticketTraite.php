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

  <?php
    /*Fonction pour marqué un ticket comme "traité"*/
    function traiterTicket(){
      $row = 0;
      $donneesCsv = array(); // le tableau dans le quel on va stocker toutes les donées présentes dans le csv
      if (($handle = fopen("../../csv/tickets.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
					// on cherche la ligne correspondant au ticket à traiter
					if($data[9] == $_GET["numero"]){
						$data[8] = "traite";
					}
					array_push($donneesCsv, $data);
          $row++;
        }
        // on ferme et on supprime l'ancien csv
        fclose($handle);
        unlink("../../csv/tickets.csv");
      }
      // on crée un nouveau fichier csv, on y écrit toutes les nouvelles données
      $fp = fopen("../../csv/tickets.csv", "a+");
      foreach ($donneesCsv as $ligne) {
        fputcsv($fp, $ligne, ";");
      }
      fclose($fp);
    }

    /*Fonction pour enlever les guillemets en trop dans le csv*/
    function enleverGuillemets(){
      $row = 0;
      $donneesCsv = array(); // le tableau dans le quel on va stocker toutes les donées présentes dans le csv
      if (($handle = fopen("../../csv/tickets.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
					// on enlève les guillemets pour les chaînes de caractères
					$titre = explode('"', $data[6]);
					$description = explode('"', $data[7]);
					foreach ($titre as $value) {
						if($value != ""){
							$data[6] = $value;
						}
					}
					foreach ($description as $value) {
						if($value != ""){
							$data[7] = $value;
						}
					}
					array_push($donneesCsv, $data);
          $row++;
        }
        // on ferme et on supprime l'ancien csv
        fclose($handle);
        unlink("../../csv/tickets.csv");
      }
      // on crée un nouveau fichier csv, on y écrit toutes les nouvelles données
      $fp = fopen("../../csv/tickets.csv", "a+");
      foreach ($donneesCsv as $ligne) {
        fputcsv($fp, $ligne, ";");
      }
      fclose($fp);
    }


    traiterTicket();
    enleverGuillemets();
    header('Location: consulterTickets.php');
  ?>

</body>

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
		<h1>Ajouter une assurance au système</h1>
	</div>

	<div class="affichage">
		<h2 style="text-align:center;">L'assurance a bien été ajouté au sytème !</h2>
		<a href="../profilAdmin.php">Retour à l'accueil</a>
	</div>

  <?php

    /*Fonction pour récupérer les code assureurs déjà existants*/
    function recupCodeAssureur(){
      $row = 0;
      $codes = array(); //tableau qui contient les codes assureur existants
      if (($handle = fopen("../../csv/assureurs.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
          if($row != 0){
            $codes[$row-1] = $data[0];
          }
          $row++;
        }
        fclose($handle);
      }
      return($codes);
    }

    // on récupère les codes assureurs existants
    $codes = recupCodeAssureur();
    // on génère on nouveau code assureur
    do {
      $codeAssureur = rand(0, 999);
    } while (in_array($codeAssureur, $codes));

    $assurance = array("code" => $codeAssureur,
                       "nom" => $_POST["nom"],
                       "adresse" => $_POST["adresse"],
                       "ville" => $_POST["ville"],
                       "codePostal" => $_POST["codePostal"],
                       "pays" => $_POST["pays"],
                       "tel" => $_POST["tel"],
                       "degatsAssurés" => $_POST["degatsAssurés"]);

    $fp = fopen('../../csv/assureurs.csv', 'a+');
    fputcsv($fp, $assurance,";");
    fclose($fp);

    // on sauvegarde les modifications faites pour les administrateurs
    $modificattion = array("document" => "assurance",
                           "numero" => $codeAssureur,
                           "type" => "creation",
                           "identifiant" => $_SESSION["identifiant"],
                           "date" => date("d-m-Y"),
                           "heure" => date("H:i"));

    $fp = fopen('../../csv/modifications.csv', 'a+');
    fputcsv($fp, $modificattion,";");
    fclose($fp);
  ?>

</body>

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
	<link rel="stylesheet" type="text/css" href="../../css/messagerie.css" />
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
		<h1>Messagerie</h1>
	</div>


	<div class="affichage" style="margin-bottom: 5px;">
		<input type='submit' value='Nouvelle conversation' id='boutonNvMessage' class='btn' onclick='afficherListe()'/>
	</div>

	<div class="affichage" id="listeNvConv"></div>


  <?php

  /*Fonction pour lire le fichier messages.csv et récupérer les émetteurs*/
  function recupIdEmetteur(){
		$row = 0;
		$tabId = array(); //tableau qui contient les émetteurs des message destinés à l'assurance
		if (($handle = fopen("../../csv/messages.csv", "r"))) {
			while (($data = fgetcsv($handle, 1000, ";"))) {
				if($row != 0){
					if(!in_array($data[0], $tabId) && $data[1] == $_SESSION["codeAssureur"]){
						array_push($tabId, $data[0]);
					} else {
						if(!in_array($data[1], $tabId) && $data[0] == $_SESSION["codeAssureur"]){
							array_push($tabId, $data[1]);
						}
					}

				}
				$row++;
			}
			fclose($handle);
		}
		return($tabId);
  }

  /*Fonction pour récupérer le nom et prénom des émetteurs*/
  function recupInfoEmetteur($tabId){
    $row = 0;
    $tabEmetteurs = array(); //tableau qui contient les émetteurs des message destinés à l'assurance
    if (($handle = fopen("../../csv/assures.csv", "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        for ($c=0; $c < $num; $c++) {
          $array = explode(";", $data[$c]);
          if($row != 0){
            if(in_array($array[0], $tabId)){
              $tabEmetteurs[$row-1]["identifiant"] = $array[0];
              $tabEmetteurs[$row-1]["nom"] = $array[1];
              $tabEmetteurs[$row-1]["prenom"] = $array[2];
            }
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return($tabEmetteurs);
  }

  /* Fonction pour afficher les conversations */
  function afficherConversation($tabConversations){
    foreach ($tabConversations as $emetteur) {
      echo("<div class='conversation' id='".$emetteur["identifiant"].";".$emetteur["nom"].";".$emetteur["prenom"]."' onclick='accesConversation(this)'>
        <p>".$emetteur["nom"]." ".$emetteur["prenom"]."</p>
      </div>");
    }
  }

  $tabId = recupIdEmetteur();
  $tabConversations = recupInfoEmetteur($tabId);
  afficherConversation($tabConversations);

  ?>

  <script type="text/javascript" src="../js/messagerie.js"></script>
</body>

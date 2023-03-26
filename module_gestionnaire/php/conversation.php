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


  <?php

		/* Fonction pour récupérer tous les messages de l'assuré */
		function recupMessages(){
			$row = 0;
			$tabMessages = array(); //tableau qui contient les info de tous les messages de l'assuré
      $tabKeys = array(); //tableau qui contient toutes les clés du tableau $tabMessages
			if (($handle = fopen("../../csv/messages.csv", "r"))) {
	    	while (($data = fgetcsv($handle, 1000, ";"))) {
					if($row == 0){
							// si on est à la première ligne du csv, on récupère les clés
							$tabKeys = $data;
						} else {
							if($_GET["identifiant"] == $data[0]  ||  (isset($data[1]) &&  $_GET["identifiant"] == $data[1])){
                // si l'assuré est soit un destinataire soit un emetteur, on stocke le message
                $i = 0;
    						foreach ($tabKeys as $key) {
    							$tabMessages[$row-1][$key] = $data[$i];
    							$i ++;
    					}
          	}
					}
					$row++;
	    	}
				fclose($handle);
	    }
			return($tabMessages);
		}


		/* Fonction pour afficher les messages */
		function afficherMessages($tabMessages){
			foreach ($tabMessages as $message) {
				// on vérifie qui est l'émetteur et le destinataire pour afficher le message différement
				if($message["emetteur"] == $_GET["identifiant"]){
					$class = "messageAutre";
				} else {
					$class = "messageMoi";
				}
				// on affiche le contenu du message sans les guillemets
				$contenuMessage = explode('"', $message['message']);
				foreach ($contenuMessage as $value){
					if($value != ""){
						$message['message'] = $value;
					}
				}
				// on affiche le message
				echo("<div class='".$class."'>
					<p>".$message['message']."</p>
					<div class='date'><p>Le ".$message['date']." à ".$message['heure']."</p></div>
				</div>");
			}
		}

    echo('<div class="titre">
  		<h1>Conversation avec '.$_GET["nom"].' '.$_GET["prenom"].'</h1>
  	</div>
		<div class="affichage" style="margin-bottom:15px;">
			<a href="messagerie.php">Retour à la messagerie</a>
		</div>');

		$tabMessages = recupMessages();
		afficherMessages($tabMessages);

		echo("<div><form id='formulaire' class='formulaire' method='post' action='enregistrerMessage.php?identifiant=".$_GET["identifiant"]."&nom=".$_GET["nom"]."&prenom=".$_GET["prenom"]."'>
	    <textarea name='nvMessage' class='nvMessage' placeholder='Écrivrez votre message' required></textarea>
	    <p><input type='submit' value='Envoyer' id='boutonEnvoyer' class='btn' style='float: right;margin-bottom:5px;'/></p>
	  </form></div>");

  ?>

</body>

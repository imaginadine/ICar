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
	<link rel="stylesheet" type="text/css" href="../../css/tickets.css" />
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
			<a href="../../deconnexion.php?connexion=out">Déconexion</a>
		</div>
	</div>

	<div class="titre">
		<h1>Consulter les problèmes remontés par les utilisateurs</h1>
	</div>

	<?php
		/*Fonction pour lire le fichier tickets.csv et récupérer les tickets non-traités*/
		function recupInfoTickets(){
      $row = 0;
      $tabTickets = array(); //tableau qui contient les info de tous les tickets non traités
      $tabKeys = array(); //tableau qui contient toutes les clés du tableau $tabTickets
      if (($handle = fopen("../../csv/tickets.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
					if($row == 0){
						// si on est à la première ligne du csv, on récupère les clés
						$tabKeys = $data;
					} else {
						if($data[8] == "en_cours"){
							// si le ticket n'est pas traité, on l'ajoute dans le tableau
							$i = 0;
							foreach ($tabKeys as $key) {
								$tabTickets[$row-1][$key] = $data[$i];
								$i ++;
							}
						}
					}
          $row++;
        }
        fclose($handle);
      }
      return($tabTickets);
    }

		/*Fonction pour afficher un ticket dans un encadré*/
		function afficherTicket($ticket){
			switch ($ticket["urgence"]) {
				// selon l'urgence du ticket on change la couleur de l'encadré
				case 'haute':
					$couleur = "#ff5722";
					break;
				case 'moyenne':
					$couleur = "#ff9800";
					break;
				case 'basse':
					$couleur = "#4caf50";
					break;
				default:
					echo("Erreur");
					break;
			}
			$titre = explode('"', $ticket["titre"]);
			if(isset($titre[1])){
				$ticket["titre"] = $titre[1];
			} else {
				$ticket["titre"] = $titre[0];
			}
			$description = explode('"', $ticket["description"]);
			if(isset($description[1])){
				$ticket["description"] = $description[1];
			} else {
				$ticket["description"] = $description[0];
			}
			echo("<div class='ticket' style='background-color: ".$couleur."'>
				<div class='info'>Assureur : ".$ticket["emetteur"]."</div>
				<div class='info'>Type : ".$ticket["type"]."</div>
				<div class='info'>Catégorie : ".$ticket["categorie"]."</div>
				<div class='titre'>".$ticket["titre"]."</div>
				<div class='description'>".$ticket["description"]."</div>
				<div class='bas'><div class='date'>Date d'envoi le ".$ticket["date"]." à ".$ticket["heure"]."</div>
				<div class='btnTicket'><input type='submit' value='Ticket traité' class='btn' onclick='supprimer(".$ticket["numero"].")'/></div></div>
			</div>");
		}

		// on récupère les tickets non traités
		$tabTickets = recupInfoTickets();
		// on les affiche dans des encadrés
		foreach ($tabTickets as $ticket) {
			afficherTicket($ticket);
		}
	?>


	<script type="text/javascript" src="../js/consulterTickets.js"></script>
</body>

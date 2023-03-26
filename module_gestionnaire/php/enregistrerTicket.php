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
		<h1>Remonter un problème à l'administrateur</h1>
	</div>

	<?php
		/*Fonction pour récupérer le numéro du dernier ticket*/
		function recupNum(){
			$row = 0;
			$numeros = array(); //tableau qui contient les numéros de tous les tickets
			if (($handle = fopen("../../csv/tickets.csv", "r"))) {
	    	while (($data = fgetcsv($handle, 1000, ";"))) {
					if($row != 0){
						array_push($numeros, $data[9]);
					}
					$row++;
	    	}
				fclose($handle);
	    }
			return(end($numeros));
		}


    // on vérifie que le gestionnaire a bien sélectionné et rempli toutes les info
    if(($_POST["type"] != "---") && ($_POST["categorie"] != "---") && ($_POST["urgence"] != "---") && ($_POST["titre"] != "") && ($_POST["description"] != "")){
      // on récupère toutes les informationsnécessaires pour ce ticket
      $ticket = array('emetteur'=> $_SESSION["nom"],
                      'date' => date("d-m-Y"),
                      'heure' => date("H:i"),
                      'type' => $_POST["type"],
                      'categorie' => $_POST["categorie"],
                      'urgence' => $_POST["urgence"],
                      'titre' => $_POST["titre"],
                      'description' => str_replace("\n", "</br>", $_POST["description"]),
											'traitement' => "en_cours",
											'numero' => recupNum()+1);

      // on ouvre le fichier tickets.csv et on y stocke les information du ticket
      $fp = fopen('../../csv/tickets.csv', 'a+');
      fputcsv($fp, $ticket,";");
      fclose($fp);
      // on affiche à l'utilisateur les informations de son ticket
      echo("<div class='affichage'>
        <h4>Le ticket suivant a bien été envoyé</h4>
        <table>
          <tr><th>Date</th><td>".$ticket["date"]."</td></tr>
          <tr><th>Heure</th><td>".$ticket["heure"]."</td></tr>
          <tr><th>Type</th><td>".$ticket["type"]."</td></tr>
          <tr><th>Catégorie</th><td>".$ticket["categorie"]."</td></tr>
          <tr><th>Urgence</th><td>".$ticket["urgence"]."</td></tr>
          <tr><th>Titre</th><td>".$ticket["titre"]."</td></tr>
          <tr><th>Description</th><td>".$ticket["description"]."</td></tr>
        </table>
				<br/>
				<a href='../profilGestionnaire.php'>Retour à l'accueil</a>
        </div>");

    } else {
      // si l'utilisateur a mal rempli le formulaire on lui affiche une erreur
      header('Location: tickets.php?FormError=true');
    }


  ?>


</body>

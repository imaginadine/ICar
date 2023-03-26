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
	<link rel="stylesheet" type="text/css" href="../../css/rechercheAssures.css" />
	<link rel="stylesheet" type="text/css" href="../../css/demandeAdresse.css" />
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
    <h1>Gestion des assurés</h1>
  </div>

  <div class="affichage">
    <h4>Rechercher un assuré</h4>

		<div class="recherche">
			<input type="text" id="nom" name="nom" placeholder="Nom"/>
		  <input type="text" id="prenom" name="prenom" placeholder="Prénom"/>
		  <input type="text" id="tel" name="tel" placeholder="Numéro de téléphone"/>
		  <input type="text" id="mail" name="mail" placeholder="Adresse mail"/>
			<input type="text" id="contrat" name="contrat" placeholder="Numéro de contrat"/>
			<input type="submit" value="Valider" id="boutonValider" class="btn" onclick="rechercher()"/>
		</div>

	</div>


	<div id="resultatRecherche" class="affichage" style="margin:50px;"></div>

	<div class="affichage" style="margin:50px;"><input type="submit" value="Cliquez ici pour ajouter un assuré" id="boutonAjouter" class="btnAjouter" onclick="ajouter()"/></div>


  <div class="affichage">
    <h4>Consulter les demandes de changements de coordonnées</h4>
  </div>

  <?php

    /* Fonction pour récupérer toutes les demandes de changements de coordonnées */
    function recupDemandes(){
      $row = 0;
			$tabDemandes = array(); //tableau qui contient toutes les demandes de changement de coordonnées
			if (($handle = fopen("../../csv/demandeAdresse.csv", "r"))) {
	    	while (($data = fgetcsv($handle, 1000, ";"))) {
					if($row != 0){
						if($data[11] == "en_cours" && $data[2] == $_SESSION["codeAssureur"]){
              // on stocke la demande si elle n'est pas encore traitée et qu'elle est destinée à l'assurance
              $tabDemandes[$data[0]] = $data[1];
            }
					}
					$row++;
	    	}
				fclose($handle);
	    }
			return($tabDemandes);
    }

    /* Fonction pour afficher les demandes */
    function afficherDemande(){
      $tabDemandes = recupDemandes();
      foreach ($tabDemandes as $numero => $identifiant) {
        echo("<div class='demandeAdresse'>
          <p> Demande de ".$identifiant." | Changement d'adresse</p>
          <p><input type='submit' value='Traiter' id='".$numero."' class='btn'onclick='traiter(this)'/></p>
        </div>");
      }
			if(empty($tabDemandes)){
				echo("<div class='affichage'><p>Vous n'avez pas de demandes pour le moment</p></div>");
			}
    }


    afficherDemande();

  ?>

	<div class="affichage">
    <h4>Consulter les demandes de cessions de véhicule</h4>
  </div>

  <?php
// Fonction pour récupérer toutes les demandes de changements de coordonnées
//../../csv/
    function recupDemandesCession(){
      $rowCession = 0;
      $tabDemandesCession = array(); //tableau qui contient toutes les demandes de changement de coordonnées
      if (($handle = fopen("../../csv/cessionVehicule.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
          if($rowCession != 0){
            if($data[3] == "en cours de traitement" && $data[2] == $_SESSION["codeAssureur"]){
              // on stocke la demande si elle n'est pas encore traitée et qu'elle est destinée à l'assurance
              $tabDemandesCession[$data[0]] = $data[1];
            }
          }
          $rowCession++;
        }
        fclose($handle);
      }
      return($tabDemandesCession);
    }

    // Fonction pour afficher les demandes
    function afficherDemandeCession(){
      $tabDemandesCession = recupDemandesCession();
      foreach ($tabDemandesCession as $numero => $identifiant) {
        echo("<div class='demandeAdresse'>
          <p> Demande de ".$identifiant." | Cession de véhicule</p>
          <p><input type='submit' value='Traiter' id='".$numero."' class='btn'onclick='traiterCession(this)'/></p>
        </div>");
      }
      if(empty($tabDemandesCession)){
        echo("<div class='affichage'><p>Vous n'avez pas de demandes pour le moment</p></div>");
      }
    }


    afficherDemandeCession();

?>

	<script type="text/javascript" src="../js/pageAccueilAssures.js"></script>
</body>

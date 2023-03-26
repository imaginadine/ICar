<?php
    session_start();
    //vérification que l'utilisateur soit connecté pour accéder à la page, et qu'il soit un assuré
    if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
        header('Location: connexion.php'); //à changer peut-être
        exit();
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
    <title>I-Car</title>
    <meta name="Amandine" lang="fr" content="menu assuré"/>
    <meta charset="UTF8"/>
    <link rel="icon" type="image/png" href="../img/icon.png">
    <link rel="stylesheet" type="text/css" href="../css/designGlobal.css" />
    <link rel="stylesheet" type="text/css" href="../css/navbar.css" />
    </head>
    <body>

      <div class="nav">
        <input type="checkbox" id="nav-check">
        <div class="nav-header">
          <div class="nav-title">
            <a href="./menu_assure.php"><img style="width: 50px" src="../img/icon.png"/></a>
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
          <a href="./pageProfil.php">Profil</a>
          <a href="./cAmiable.php">Constats</a>
          <a href="./pageAccueilSinistres.php">Sinistres</a>
          <a href="./contacterAssurance.php">Messagerie</a>
          <a href="./dVenteVehicule.php">Cession vehicule</a>
          <a href="../deconnexion.php?connexion=out">Déconnexion</a>
        </div>
      </div>

      <div class="titre">
        <h1>Mon profil</h1>
      </div>

      <div class="affichage">
        <h2>Vos informations</h2>
        <?php
            echo "<p>Identifiant : ".$_SESSION['identifiant']."</p>";
            echo "<p>Nom : ".$_SESSION['nom']."</p>";
            echo "<p>Prénom : ".$_SESSION['prenom']."</p>";
            echo "<p>Téléphone : ".$_SESSION['tel']."</p>";
            echo "<p>Adresse mail : ".$_SESSION['mail']."</p>";
            echo "<p>Adresse postale : ".$_SESSION['adresse']." ".$_SESSION['codePostal']." ".$_SESSION['ville']." ".$_SESSION['pays']."</p>";
        ?>
        <input type="button" class="btn" value="Modifier mes coordonnées" onclick="modifierCoord()"/>
      </div>

      <div class="affichage">
        <h2>Quel contrat voulez-vous visualiser ?</h2>
      </div>

      <?php

        /*Fonction pour récupérer tous les contrats appartenant à l'utilisateur*/
        function recupNumContrat(){
          $row = 0;
    			$tabContrats = array(); //tableau qui contient les contrats de l'assuré
    			if (($handle = fopen("../csv/contrats.csv", "r"))) {
    	    	while (($data = fgetcsv($handle, 1000, ";"))) {
    					if($row != 0){
                if($_SESSION["identifiant"] == $data[3]){
                  // si le contrat appartient à l'assuré, on stocke le contrat
                  $tabContrats[$row-1] = $data[0];
                }
    					}
    					$row++;
    	    	}
    				fclose($handle);
    	    }
    			return($tabContrats);
        }

        /* Fonction pour afficher des petits encadrées avec les numéros de contrats de l'utilisateur */
        function afficherNumContrat(){
          $tabContrats = recupNumContrat();
          echo("<div class='affichage'>");
          foreach ($tabContrats as $numContrat) {
            echo("<div class='encadreNumContrat' onclick='afficher(".$numContrat.")'>contrat n°".$numContrat."</div>");
          }
          echo("</div>");
        }

        afficherNumContrat();
      ?>

      <div id="contrat"></div>

      <script type="text/javascript" src="./pageProfil.js"></script>
    </body>
</html>

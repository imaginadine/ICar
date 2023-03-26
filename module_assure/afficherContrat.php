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
    </head>
    <body>

      <?php

        /*Fonction pour récupérer tous les info du contrat*/
        function recupInfoContrat(){
          $row = 0;
    			$contrat = array(); //tableau qui contient les info du contrat
          $tabKeys = array(); //tableau qui contient toutes les clés du tableau $contrat
    			if (($handle = fopen("../csv/contrats.csv", "r"))) {
    	    	while (($data = fgetcsv($handle, 1000, ";"))) {
    					if($row == 0){
    						// si on est à la première ligne du csv, on récupère les clés
    						$tabKeys = $data;
    					} else {
    						if($_POST["numero"] == $data[0]){
                  // si on est à la ligne du bon contrat, on stocke les informations
                  $i = 0;
      						foreach ($tabKeys as $key) {
      							$contrat[$key] = $data[$i];
      							$i ++;
        					}
              	}
    					}
    					$row++;
    	    	}
    				fclose($handle);
    	    }
    			return($contrat);
        }


        /*Fonction pour récupérer tous les info de la carte verte*/
        function recupInfoCarteVerte($numeroCarteVerte){
          $row = 0;
    			$carteVerte = array(); //tableau qui contient les info de la carte verte
          $tabKeys = array(); //tableau qui contient toutes les clés du tableau $carteVerte
    			if (($handle = fopen("../csv/cartesVertes.csv", "r"))) {
    	    	while (($data = fgetcsv($handle, 1000, ";"))) {
    					if($row == 0){
    						// si on est à la première ligne du csv, on récupère les clés
    						$tabKeys = $data;
    					} else {
    						if($numeroCarteVerte == $data[0]){
                  // si on est à la ligne de la bonne carte verte, on stocke les informations
                  $i = 0;
      						foreach ($tabKeys as $key) {
      							$carteVerte[$key] = $data[$i];
      							$i ++;
        					}
              	}
    					}
    					$row++;
    	    	}
    				fclose($handle);
    	    }
    			return($carteVerte);
        }


        /*Fonction pour récupérer tous les info de l'assurance*/
        function recupInfoAssurance($codeAssureur){
          $row = 0;
    			$assurance = array(); //tableau qui contient les info de l'assurance
          $tabKeys = array(); //tableau qui contient toutes les clés du tableau $assurance
    			if (($handle = fopen("../csv/assureurs.csv", "r"))) {
    	    	while (($data = fgetcsv($handle, 1000, ";"))) {
    					if($row == 0){
    						// si on est à la première ligne du csv, on récupère les clés
    						$tabKeys = $data;
    					} else {
    						if($codeAssureur == $data[0]){
                  // si on est à la ligne de la bonne carte verte, on stocke les informations
                  $i = 0;
      						foreach ($tabKeys as $key) {
      							$assurance[$key] = $data[$i];
      							$i ++;
        					}
              	}
    					}
    					$row++;
    	    	}
    				fclose($handle);
    	    }
    			return($assurance);
        }


        /* Fonction pour afficher un contrat */
        function afficherContrat($contrat, $carteVerte, $assurance){
          $validite = array("A", "B", "BG", "CY", "CZ", "D", "DK", "E", "EST", "F", "FN", "GB", "GR", "H", "I", "IRL", "IS", "L", "LT", "LV", "M", "N", "NL", "P", "PL", "RO", "S", "SK", "SLO", "CH", "AL", "AND", "BIH", "BY", "HR", "IL", "IR", "MA", "MD", "MK", "RUS", "SRB", "TN", "TR", "UA");
          echo("<div class='contrat'>
            <p>Fin de validité du contrat : ".$contrat["date"]."</p>
            <h4>Informations de la carte verte : </h4>
            <p>Numéro de carte verte : ".$carteVerte["numero"]."</p>
            <p>Valable du : ".$carteVerte["dateDebut"]." , au : ".$carteVerte["dateFin"]."</p>
            <p>Code pays / code assureur - numéro : ".$carteVerte["codePays"]." ".$carteVerte["codeAssureur"]."</p>
            <p>Numéro d'immatriculation : ".$carteVerte["plaque"]."</p>
            <p>Catégorie du véhicule : ".$carteVerte["catégorie"]."</p>
            <p>Marque du véhicule : ".$carteVerte["marque"]."</p>
            <p>Validité territoriale : </p>
            <table>");
          $vInterdites = explode("-", $carteVerte["validiteTerritoriale"]);
          echo("<tr>");
          $i = 1;
          foreach ($validite as $value) {
            if(in_array($value, $vInterdites)){
              echo("<td style='background-color: #5a5958'>".$value."</td>");
            } else {
              echo("<td>".$value."</td>");
            }
            if($i % 14 == 0){
              echo("</tr><tr>");
            }
            $i ++;
          }
          echo("</tr></table>
            <p>Nom du souscripteur : ".$_SESSION["nom"]." ".$_SESSION["prenom"]."</p>
            <p>Adresse du souscripteur : ".$_SESSION["adresse"]." ".$_SESSION["ville"]." ".$_SESSION["codePostal"]."</p>
            <p>Carte délivrée par : ".$assurance["nom"]." | ".$assurance["adresse"]." ".$assurance["ville"]." ".$assurance["codePostal"]."</p>
            <h4>QR code associé à ce contrat : </h4>
       			<a href='../QRcode/".$_POST["numero"].".png' download='".$_POST["numero"].".png'><img src='../QRcode/".$_POST["numero"].".png'/></a>
       			<p><i>(Cliquez sur le QR code pour le télécharger)</i></p>
          </div>");
        }


        $contrat = recupInfoContrat();
        $carteVerte = recupInfoCarteVerte($contrat["numCarteVerte"]);
        $assurance = recupInfoAssurance($contrat["codeAssureur"]);
        afficherContrat($contrat, $carteVerte, $assurance);

      ?>



    </body>
</html>

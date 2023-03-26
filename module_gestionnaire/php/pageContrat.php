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

 <?php
  echo('<div class="titre">
    <h1>Page du contrat n°'.$_GET["numero"].'</h1>
  </div>');
 ?>

 <div class="affichage">
   <h4>Visualisation du contrat :</h4>
 </div>

 <?php

   /*Fonction pour récupérer tous les info du contrat*/
   function recupInfoContrat(){
     $row = 0;
     $contrat = array(); //tableau qui contient les info du contrat
     $tabKeys = array(); //tableau qui contient toutes les clés du tableau $contrat
     if (($handle = fopen("../../csv/contrats.csv", "r"))) {
       while (($data = fgetcsv($handle, 1000, ";"))) {
         if($row == 0){
           // si on est à la première ligne du csv, on récupère les clés
           $tabKeys = $data;
         } else {
           if($_GET["numero"] == $data[0]){
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
     if (($handle = fopen("../../csv/cartesVertes.csv", "r"))) {
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


   /*Fonction pour récupérer tous les info de l'assuré*/
   function recupInfoAssure(){
     $row = 0;
     $assure = array(); //tableau qui contient les info de l'assuré
     $tabKeys = array(); //tableau qui contient toutes les clés du tableau $assure
     if (($handle = fopen("../../csv/assures.csv", "r"))) {
       while (($data = fgetcsv($handle, 1000, ";"))) {
         if($row == 0){
           // si on est à la première ligne du csv, on récupère les clés
           $tabKeys = $data;
         } else {
           if($_GET["identifiant"] == $data[0]){
             // si on est à la ligne de la bonne carte verte, on stocke les informations
             $i = 0;
             foreach ($tabKeys as $key) {
               $assure[$key] = $data[$i];
               $i ++;
             }
           }
         }
         $row++;
       }
       fclose($handle);
     }
     return($assure);
   }


   /* Fonction pour afficher un contrat */
   function afficherContrat($contrat, $carteVerte, $assure){
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
       <p>Nom du souscripteur : ".$assure["nom"]." ".$assure["prenom"]."</p>
       <p>Adresse du souscripteur : ".$assure["adresse"]." ".$assure["ville"]." ".$assure["codePostal"]."</p>
       <p>Carte délivrée par : ".$_SESSION["nom"]." | ".$_SESSION["adresse"]." ".$_SESSION["ville"]." ".$_SESSION["codePostal"]."</p>
			 <h4>QR code associé à ce contrat : </h4>
			 <a href='../../QRcode/".$_GET["numero"].".png' download='".$_GET["numero"].".png'><img src='../../QRcode/".$_GET["numero"].".png'/></a>
			 <p><i>(Cliquez sur le QR code pour le télécharger)</i></p>
     </div>");
   }


   $contrat = recupInfoContrat();
   $carteVerte = recupInfoCarteVerte($contrat["numCarteVerte"]);
   $assure = recupInfoAssure();
   afficherContrat($contrat, $carteVerte, $assure);

   echo('<div class="affichage">
     <input type="submit" style="margin-bottom: 10px" value="Modifier" id="'.$_GET["numero"].';'.$_GET["identifiant"].'" class="btn" onclick="modifier(this)"/>
   </div>
	 <div class="affichage">
		 <a href="pageAssure.php?identifiant='.$_GET["identifiant"].'">Retour à la page assuré</a>
   </div>');
 ?>

 <script type="text/javascript" src="../js/pageContrat.js"></script>
</body>

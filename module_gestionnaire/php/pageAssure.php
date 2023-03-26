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

   /*Fonction pour récupérer les informations de l'assuré dans le fichier assures.csv*/
   function recupInfoAssures(){
     $row = 0;
     $assure = array(); //tableau qui contient les info de l'assuré
     $tabKeys = array(); //tableau qui contient toutes les clés
     if (($handle = fopen("../../csv/assures.csv", "r"))) {
       while (($data = fgetcsv($handle, 1000, ";"))) {
         if($row == 0){
           // si on est à la première ligne du csv, on récupère les clés
           $tabKeys = $data;
         } else {
           $i = 0;
           // on vérifie que c'est le bon assuré
           if($data[0] == $_GET["identifiant"]){
             // on construit notre tableau avec la ligne actuelle et les clés
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

   /*Fonction pour afficher les infos de l'assuré*/
   function afficherInfo(){
     $assure = recupInfoAssures();
		 echo('<div class="titre">
	     <h1>Page assuré de '.$assure["nom"].' '.$assure["prenom"].'</h1>
	   </div>
	 	 <div class="affichage">
	 	 	<h4>Informations de l\'assuré</h4>
	 	 </div>');
     echo("<div class='affichage'>
		  <p>Identifiant : ".$assure["identifiant"]."</p>
      <p>Nom : ".$assure["nom"]."</p>
      <p>Prénom : ".$assure["prenom"]."</p>
      <p>Numéro de téléphone : ".$assure["tel"]."</p>
      <p>Adresse mail : ".$assure["mail"]."</p>
      <p>Adresse : ".$assure["adresse"].", ".$assure["ville"].", ".$assure["codePostal"].", ".$assure["pays"]."</p>
     </div>");
   }

   afficherInfo();

 ?>

 <div class="affichage">
   <h4>Contrat(s) de l'assuré : </h4>

 <?php

 /* Fonction pour récupérer les numéros de contrat de l'assuré */
 function recupNumContrat(){
   $row = 0;
   $contrats = array(); //tableau qui contient les numéros de contrats
   if (($handle = fopen("../../csv/contrats.csv", "r"))) {
     while (($data = fgetcsv($handle, 1000, ";"))) {
      if($row != 0){
        // on regarde si le contrat appartient à l'assuré
        if($data[3] == $_GET["identifiant"]){
          array_push($contrats, $data[0]);
        }
      }
       $row++;
     }
     fclose($handle);
   }
   return($contrats);
 }

 /* Fonction pour afficher les contrats */
 function afficherContrat(){
   $contrats = recupNumContrat();
   foreach ($contrats as $numContrat) {
     echo("<div class='encadreNumContrat' id='".$numContrat.";".$_GET["identifiant"]."' onclick='acceder(this)'>
      <p>contrat n°".$numContrat."</p>
     </div>");
   }
 }

 afficherContrat();

 echo('<input type="submit" style="margin-bottom: 10px" value="+" id="'.$_GET["identifiant"].'" class="encadreNumContrat" onclick="nvContrat(this)"/>')
 ?>
 </div>

	<script type="text/javascript" src="../js/pageAssure.js"></script>
</body>

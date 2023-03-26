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
   <link rel="stylesheet" type="text/css" href="../../css/demandeAdresse.css" />
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
     <h1>Traiter une demande de changement d'adresse</h1>
   </div>

   <?php

     /* Fonction pour récupérer les infos de la demande de changements de coordonnées */
     function recupDemandes(){
      $row = 0;
 			$demande = array(); //tableau qui contient les info de la demande de changement de coordonnées
      $tabKeys = array(); // tableau qui contient toutes les clé de $demande
 			if (($handle = fopen("../../csv/demandeAdresse.csv", "r"))) {
 	    	while (($data = fgetcsv($handle, 1000, ";"))) {
 					if($row == 0){
 							// si on est à la première ligne du csv, on récupère les clés
 							$tabKeys = $data;
 					} else {
             if($data[0] == $_GET["numero"]){
               // on stocke les info de la demande
               $i = 0;
               foreach ($tabKeys as $key) {
                 $demande[$key] = $data[$i];
                 $i ++;
               }
             }
 					}
 					$row++;
 	    	}
 				fclose($handle);
 	    }
 			return($demande);
     }

     /* Fonction pour afficher les demandes */
     function afficherDemande(){
       $demande = recupDemandes();
       echo("<div class='affichage'>
         <h4> Demande de ".$demande["identifiant"]."</h4>
         <p>Ancienne adresse : ".$demande["ancienAdresse"]." ".$demande["ancienVille"]." ".$demande["ancienCodePostal"]." ".$demande["ancienPays"]."</p>
         <p>Nouvelle adresse : ".$demande["nvAdresse"]." ".$demande["nvVille"]." ".$demande["nvCodePostal"]." ".$demande["nvPays"]."</p>
         Justificatif de domicile <a href='../../photos_justificatif/".$demande["numero"].".png' target='_blank'>ici</a>
         <p><input type='submit' value='Valider' id='".$demande["numero"]."' class='btnValider' onclick='valider(this)'/></p>
         <p><input type='submit' value='Refuser' id='".$demande["numero"]."' class='btnRefuser' onclick='refuser(this)'/></p>
       </div>");
     }

     afficherDemande();
   ?>

   <script type="text/javascript" src="../js/modifierAdresse.js"></script>
 </body>

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
    <h1>Traiter une demande de cession de véhicule</h1>
  </div>

  <div class="affichage">
  <?php
      $traitement = $_GET['traitement'];
      $identifiant = $_GET['identifiant'];
      $numero = $_GET['numero'];

      if($traitement == 'validé'){
          //on note les nouvelles infos dans le fichier info
          $i=0;
          $ligneSuppr=0;  // numéro de la ligne
          $infoCession = fopen("../../csv/cessionVehicule.csv", "r");
          while (($data = fgetcsv($infoCession, 1000, ";"))) {
              if($data[1] == $identifiant && $data[0 == $numero]){
                  $ligneSuppr = $i;
                  $codeAssureur = $data[2];
                  $document = $data[4];
              }
              $i=$i+1;
          }
          fclose($infoCession);


          $donnee=file("../../csv/cessionVehicule.csv"); // on met le contenu du fichier dans $donnee

          $infoCession = fopen("../../csv/cessionVehicule.csv", "w"); // ouvre le fichier en droit d'écriture
              fputs($infoCession,''); // on le vide

              $i=0;
              foreach($donnee as $d)
              //
              {
                  if($i!=$ligneSuppr){
                      fputs($infoCession,$d);
                  }else{
                      fputs($infoCession,'');
                  }
                  $i=$i+1;
              }

          fclose($infoCession);

          $fp = fopen('../../csv/cessionVehicule.csv', 'a+');
          $maCession=array(
              array($numero,
                  $identifiant,
                  $codeAssureur,
                  $traitement,
                  $document
              )
          );
          foreach ($maCession as $fields) {
              fputcsv($fp, $fields,";");
          }
          fclose($fp);

          //on note les nouvelles infos dans le fichier info
          $i=0;
          $ligneSuppr=0;  // numéro de la ligne
          $infoContrat = fopen("../../csv/contrats.csv", "r");
          while (($data = fgetcsv($infoContrat, 1000, ";"))) {
              if($data[3] == $identifiant){
                  $ligneSuppr = $i;
                  $numeroContrat = $data[0];
                  $numCarteVerte = $data[4];
              }
              $i=$i+1;
          }
          fclose($infoContrat);


          $donnee=file("../../csv/contrats.csv"); // on met le contenu du fichier dans $donnee

          $infoContrat = fopen("../../csv/contrats.csv", "w"); // ouvre le fichier en droit d'écriture
              fputs($infoContrat,''); // on le vide

              $i=0;
              foreach($donnee as $d)
              //
              {
                  if($i!=$ligneSuppr){
                      fputs($infoContrat,$d);
                  }else{
                      fputs($infoContrat,'');
                  }
                  $i=$i+1;
              }

          fclose($infoContrat);

          $fp = fopen('../../csv/contrats.csv', 'a+');
          $annee = date("Y");
          $mois = date("m")+1;
          if($mois == 13){
              $mois = 01;
          }
          $jour = date("d");
          $date = $annee.'-'.$mois.'-'.$jour;

          $maCession=array(
              array($numeroContrat,
                  $date,
                  $codeAssureur,
                  $identifiant,
                  $numCarteVerte
              )
          );
          foreach ($maCession as $fields) {
              fputcsv($fp, $fields,";");
          }
          fclose($fp);
          echo "Vous avez validé le demande de cession de vehicule de ".$identifiant;
          echo "<br>Son contrat d'assurance prendra fin avec un délais de 1 mois";


      }

      if($traitement == 'refusé'){
          //on note les nouvelles infos dans le fichier info
          $i=0;
          $ligneSuppr=0;  // numéro de la ligne
          $infoCession = fopen("../../csv/cessionVehicule.csv", "r");
          while (($data = fgetcsv($infoCession, 1000, ";"))) {
              if($data[1] == $identifiant && $data[0 == $numero]){
                  $ligneSuppr = $i;
                  $codeAssureur = $data[2];
                  $document = $data[4];
              }
              $i=$i+1;
          }
          fclose($infoCession);


          $donnee=file("../../csv/cessionVehicule.csv"); // on met le contenu du fichier dans $donnee

          $infoCession = fopen("../../csv/cessionVehicule.csv", "w"); // ouvre le fichier en droit d'écriture
              fputs($infoCession,''); // on le vide

              $i=0;
              foreach($donnee as $d)
              //
              {
                  if($i!=$ligneSuppr){
                      fputs($infoCession,$d);
                  }else{
                      fputs($infoCession,'');
                  }
                  $i=$i+1;
              }

          fclose($infoCession);

          $fp = fopen('../../csv/cessionVehicule.csv', 'a+');
          $maCession=array(
              array($numero,
                  $identifiant,
                  $codeAssureur,
                  $traitement,
                  $document
              )
          );
          foreach ($maCession as $fields) {
              fputcsv($fp, $fields,";");
          }
          fclose($fp);
          echo "Vous avez refusé le demande de cession de vehicule de ".$identifiant;

      }


      ?>
      <br/><br/>
      <a href="pageAccueilAssures.php">Retour à la page de gestion des assurés</a>
  </div>
</body>

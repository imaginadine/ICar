<?php
    session_start();
    //vérification que l'utilisateur soit connecté pour accéder à la page, et qu'il soit un assuré
    if (!isset($_SESSION['pseudo'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../pageConnexion.php');
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
    <link rel="stylesheet" type="text/css" href="../css/pageAccueil.css" />
    <link rel="stylesheet" type="text/css" href="../css/form.css" />
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
        <h1>Gestion des sinistres</h1>
      </div>

      <div class="affichage">
        <div class="form">

      <?php
          $i=0;
          if($_SESSION['QRcode']!=NULL){
              echo "Vous vous occupez des sinistres liés au contrat :".$_SESSION['QRcode'];
              echo "<p><a href='hSinistre.php'>Historique de déclaration des sinistres</a></p>";
          }else{
              echo "<p>De quel contrat voulez-vous voir l'historique des sinistres ?</p>";
              if (($handle = fopen("../csv/contrats.csv", "r"))) {
                  while (($data = fgetcsv($handle, 1000, ";"))) {
                       if($data[3]==$_SESSION['identifiant']){
                           $contrats[$i]=$data[0];
                           $i++;
                       }
                   }
               }
               $nb=$i;
               fclose($handle);
               echo'<form id="choixContrat" name="choixContrat" method="POST" action="hSinistre.php" class="formulaire"><p>';
              for($i=0;$i<$nb;$i++){
                   echo '<input type="radio" id="contrat'.$i.'" name="contrat" value="'.$contrats[$i].'" /> '.$contrats[$i].' ';
              }
              echo '</p><input type="submit" value="Historique de déclaration des sinistres"/></form>';
          }

      ?>
      </div>
    </div>

        <!--menu-->
        <div class="menu_icone" style="justify-content:center;">
          <div class="icone"><a href="dSinistre.php"><img style="height: 200px;" src="../img/contrat.png"/><p>Déclarer un sinistre</p></a></div>
        </div>

    </body>
</html>

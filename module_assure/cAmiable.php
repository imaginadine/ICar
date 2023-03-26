<!-- ici pour déclarer un sinistre-->

<?php
    session_start();
    //on vérifie que l'utilisateur est connecté, et que c'est un assuré
    if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../pageConnexion.php');
        exit();
    }

    $_SESSION["page"]=0;//si on vient de cAmiable
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
    <title>I-Car</title>
    <meta name="Amandine" lang="fr" content="déclaration sinistre"/>
    <meta charset="UTF8"/>
    <link rel="icon" type="image/png" href="../img/icon.png">
    <link rel="stylesheet" type="text/css" href="../css/designGlobal.css" />
    <link rel="stylesheet" type="text/css" href="../css/navbar.css" />
    <link rel="stylesheet" type="text/css" href="../css/pageAccueil.css" />
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

      <div class="titre" style="margin-bottom:50px;">
        <h1>Remplir un constat amiable</h1>
      </div>

      <div class="affichage">
        <p>Ici vous pouvez remplir un constat amiable en cas de sinistre. Un assuré doit remplir les informations communes, l'autre non. Vérifiez bien que les deux parties du contrat soient remplies.</p>
        <div style="text-align:center;font-size:18px;color:#208ecf;">
          <p>Ne nous fâchons pas</p>
          <p>Restons courtois</p>
          <p>Soyons calmes</p>
        </div>
      </div>

      <?php

        if(isset($_SESSION["QRcode"]) && $_SESSION["QRcode"] != ""){
          echo('<div class="menu_icone" style="margin-top:50px;">
            <div class="icone"><a href="cAmiable1.php"><img style="height: 180px;" src="../img/contrat.png"/><p style="font-size:23px;">Je remplis les informations générales</p></a></div>
            <div class="icone"><a href="cAmiableB.php"><img style="height: 180px;" src="../img/document.png"/><p style="font-size:23px;">L\'autre conducteur remplit les informations générales</p></a></div>
            <div class="icone"><a href="cAmiablePhotos.php"><img style="height: 180px;" src="../img/photo.png"/><p>Photos</p></a></div>
          </div>');
        } else {
          echo('<div class="affichage">
            <h4>Veuillez scanner le QR code de votre véhicule !</h4>
          </div>');
        }

       ?>


    </body>
</html>

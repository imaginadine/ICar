<?php
    session_start();
    //vérification que l'utilisateur soit connecté pour accéder à la page, et qu'il soit un assuré
    if (!isset($_SESSION['pseudo'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../pageConnexion.php');
        exit();
    }
    if($_SESSION['QRcode']!=NULL){
        $numContrat=$_SESSION['QRcode'];
    }else{
        $numContrat=$_POST['contrat'];
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
    <link rel="stylesheet" type="text/css" href="../css/sinistre.css" />
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

      <h1 class="titre">Historique de déclaration des sinistres</h1>

      <div class="affichage">
        <h4>Ici, vous avez accès aux dernières déclarations de sinistres (et constats amiables) : </h4>

        <?php
            $i=1;
            while(file_exists("../csv/declaration_sinistre/".$_SESSION['nom'].$numContrat."/sinistre-".$i.$_SESSION['nom'].$numContrat.".pdf")){
                echo "<div class='sinistre'>";
                echo "<h2>Sinistre ".$i."</h2>";
                echo "<p>Constat amiable : <a href='../csv/constats_amiables/".$_SESSION['nom'].$numContrat."/c-amiable-".$i.$_SESSION['nom'].$numContrat.".pdf' target='_blank'>ici</a></p>";
                echo "<p>Déclaration de sinistre : <a href='../csv/declaration_sinistre/".$_SESSION['nom'].$numContrat."/sinistre-".$i.$_SESSION['nom'].$numContrat.".pdf' target='_blank'>ici</a></p>";
                echo "</div>";
                $i+=1;
            }

        ?>
      </div>

    </body>
</html>

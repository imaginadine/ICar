<?php
    session_start();
    //on vérifie que l'utilisateur est connecté, et que c'est un assuré
    if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../pageConnexion.php');
        exit();
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
    <title>I-Car</title>
    <meta name="Amandine" lang="fr" content="déclaration sinistre"/>
    <meta charset="UTF8"/>
    <link rel="icon" type="image/png" href="../img/icon.png">
    <link rel="stylesheet" type="text/css" href="../css/designGlobal.css" />
    <link rel="stylesheet" type="text/css" href="../css/form.css" />
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

        <h1 class="titre">Déclarer un sinistre</h1>

        <div class="affichage">
          <h2>Témoins</h2>
          <form id="temoins" name="temoins" method="POST" action="enregistrerTemoins.php" class="form">
          <p>Veuillez renseigner les informations concernant le(s) témoin(s) :</p>
          <?php
              for($i=0;$i<$_SESSION['nbtemoins'];$i++){
                  echo "<h4>Témoin ".($i+1)."</h4>";
                  echo '<p>Nom : <input type="text" id="nom'.($i+1).'" name="nom'.($i+1).'" /></p>';
                  echo '<p>Adresse : <input type="text" id="adresse'.($i+1).'" name="adresse'.($i+1).'" /></p>';
                  echo '<p>Ville : <input type="text" id="ville'.($i+1).'" name="ville'.($i+1).'" /></p>';
                  echo '<p>Code postal : <input type="text" id="codePostal'.($i+1).'" name="codePostal'.($i+1).'" /></p>';
                  echo '<p>Pays : <input type="text" id="pays'.($i+1).'" name="pays'.($i+1).'" /></p>';
                  echo '<p>Téléphone : <input type="text" id="tel'.($i+1).'" name="tel'.($i+1).'" /></p>';
              }
          ?>
          <input type="submit" value="Suivant"/>
          </form>
        </div>




        <!--<form method="POST" action="verificationConnexion.php">
            <input type="submit" name="OUT" value="Déconnexion"/>
        </form>-->
    </body>
</html>

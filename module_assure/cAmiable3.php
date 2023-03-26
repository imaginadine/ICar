<?php
    session_start();
    //on vérifie que l'utilisateur est connecté, et que c'est un assuré
    if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../pageConnexion.php');
        exit();
    }
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
    <title>I-Car</title>
    <meta name="Amandine" lang="fr" content="déclaration sinistre"/>
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

        <h1 class="titre">Remplir un constat amiable</h1>

        <div class="affichage">
          <p>Merci pour votre patience, les informations ont bien été envoyées.</p>
          <p>N'oubliez pas de remplir la déclaration de sinistre dans les 5 jours qui suivent l'accident.</p>
          <p>Vous pourrez toujours (re)ajouter des photos plus tard (avant 5 jours).</p>

          <?php
              if($_SESSION['type']=="A"){
                  echo "<h2>Code sinistre</h2>";
                  echo"<p>Veuillez transmettre le code ci-dessous à l'autre conducteur, pour qu'il puisse continuer les démarches :</p>";
                  echo $_SESSION['nom'].$_SESSION['QRcode'];
                  echo "<p>Ainsi que le numéro sinistre :</p>";
                  echo $_SESSION['numero'];
              }
          ?>

          <p><a href="menu_assure.php">Retour à l'accueil</a></p>
        </div>

    </body>
</html>

<!-- ici pour déclarer un sinistre-->

<?php
    session_start();
    //on vérifie que l'utilisateur est connecté, et que c'est un assuré
    if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../pageConnexion.php');
        exit();
    }

    $_SESSION["page"]=1;//si on vient de cAmiable1
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

        <h1 class="titre">Remplir un constat amiable</h1>

        <?php
            $j=1;
            while(file_exists("../csv/constats_amiables/".$_SESSION['nom'].$_SESSION['QRcode']."/c-amiable-".$j.$_SESSION['nom'].$_SESSION['QRcode'].".csv")){
                $j+=1;
            }
            $_SESSION['numero']=$j;
        ?>

        <div class="affichage">
          <h2>Informations communes</h2>


          <form id="amiable1" name="amiable1" method="POST" action="enregistrerAmiable1.php" class="form">
          <?php
              date_default_timezone_set("Europe/Paris");
              $_SESSION['dateAccident']=date("d/m/Y");
              $_SESSION['heureAccident']=date("H:i");
              echo "<p>Date de l'accident : ".date("d/m/Y")."</p>";
              echo "<p>Heure de l'accident : ".date("H:i")."</p>";
              echo "<h4>Localisation</h4>";
          ?>

              <p>Pays : <input type="text" id="pays" name="pays" required/></p>
              <p>Lieu : <input type="text" id="lieu" name="lieu" required/></p>
              <p>Blessé(s) même léger(s) : <input type="radio" id="non1" name="blesse" value="non" /> Non <input type="radio" id="oui1" name="blesse" value="oui" /> Oui </p>
              <p class="gras">Dégâts matériels à des :</p>
              <p>- véhicules autres que A et B <input type="radio" id="non2" name="degat1" value="non" /> Non <input type="radio" id="oui2" name="degat1" value="oui" /> Oui </p>
              <p>- objets autres que des véhicules <input type="radio" id="non3" name="degat2" value="non" /> Non <input type="radio" id="oui3" name="degat2" value="oui" /> Oui </p>
              <p>Nombre de témoins : <input type="number" id="temoin" name="temoin" min="0" required/>
              </br>
              </br>
              <input type="submit" value="Suivant"/>
          </form>
        </div>


    </body>
</html>

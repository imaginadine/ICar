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
    <link rel="stylesheet" type="text/css" href="../css/navbar.css" />
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

        <h1 class="titre">Déclarer un sinistre</h1>

        <div class="affichage">
          <h2>Blessés</h2>
          <form id="blesses" name="blesses" method="POST" action="enregistrerBlesse.php" class="form">
          <p>Veuillez renseigner les informations concernant le(s) blessé(s) :</p>
          <?php
              for($i=0;$i<$_SESSION['nbBlesses'];$i++){
                  echo "<h4>Blessé ".($i+1)."</h4>";
                  echo '<p>Nom : <input type="text" id="nom'.($i+1).'" name="nom'.($i+1).'" /></p>';
                  echo '<p>Prénom : <input type="text" id="prenom'.($i+1).'" name="prenom'.($i+1).'" /></p>';
                  echo '<p>Adresse : <input type="text" id="adresse'.($i+1).'" name="adresse'.($i+1).'" /></p>';
                  echo '<p>Ville : <input type="text" id="ville'.($i+1).'" name="ville'.($i+1).'" /></p>';
                  echo '<p>Code postal : <input type="text" id="codePostal'.($i+1).'" name="codePostal'.($i+1).'" /></p>';
                  echo '<p>Pays : <input type="text" id="pays'.($i+1).'" name="pays'.($i+1).'" /></p>';
                  echo '<p>Téléphone : <input type="text" id="tel'.($i+1).'" name="tel'.($i+1).'" /></p>';
                  echo '<p>Profession : <input type="text" id="profession'.($i+1).'" name="profession'.($i+1).'" /></p>';
                  echo "<p>Situation au moment de l'accident (conducteur, passager d'un véhicule, cycliste, piéton...) : <input type='text' id='situation".($i+1)."' name='situation".($i+1)."' /></p>";
                  echo "<p>Portait-il casque ou ceinture ? : <input type='radio' id='non".($i+1)."' name='port".($i+1)."' value='non' /> Non <input type='radio' id='oui".($i+1)."' name='port".($i+1)."' value='oui' /> Oui </p>";
                  echo "<p>Premiers soins ou hospitalisation à : <input type='text' id='hospitalisation".($i+1)."' name='hospitalisation".($i+1)."' /></p>";
                  echo "<p>Nature et gravité des blessures : <input type='text' id='blessures".($i+1)."' name='blessures".($i+1)."' size='100'/></p>";
              }
          ?>
          <input type="submit" value="Suivant" style="margin-bottom:20px;"/>
          </form>
        </div>

    </body>
</html>

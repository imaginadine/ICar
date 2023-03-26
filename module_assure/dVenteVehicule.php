<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>I-Car</title>
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

    <h1 class="titre">Cession de véhicule</h1>

    <div class="affichage">
      <p>Veuillez uploader le certificat de cession de véhicule rempli.</p>

      <form action="uploadCession.php" method="post" enctype="multipart/form-data" class="form">
        Selectionner le fichier à uploader :
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Uploader le fichier" name="submit">
      </form>

      <?php
        if (($handle = fopen("../csv/cessionVehicule.csv", "r"))) {
          while (($data = fgetcsv($handle, 1000, ";"))) {
              if($data[1]==$_SESSION["pseudo"]){
                echo "<p>Votre demande de cession de véhicule est ".$data[3].".</p>";
              }
          }
          fclose($handle);
        }
      ?>
    </div>

</body>
</html>

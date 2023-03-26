<?php
    session_start();
    //vérification que l'utilisateur soit connecté pour accéder à la page, et qu'il soit un assuré
    if (!isset($_SESSION['pseudo'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../index.php');
        exit();
    }
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

  <div class="titre">
    <h1>Modifications de Coordonnées</h1>
  </div>

  <div class="affichage">
    <div class="form">
      <h4> Si vous voulez modifier votre adresse mail, rentrez votre nouvelle adresse mail ci-dessous et validez.</h4>
  	  <?php echo('<p><input type="text" id="modifMail" name="modifMail" value="'.$_SESSION["mail"].'"/></p>'); ?>
      <p><input type="submit" name='modif' value="valider" onclick="modifierMail()"></p>
    </div>
    <div id="msg1"></div>

    <div class="form">
      <h4> Si vous voulez modifier votre numéro de téléphone, rentrez votre nouveau numero de téléphone ci-dessous et validez.</h4>
  	  <?php echo('<p><input type="text" name="modifTel" id="modifTel" value="'.$_SESSION["tel"].'"/></p>'); ?>
      <p><input type="submit" name='modif' value="valider" onclick="modifierTel()"></p>
    </div>
    <div id="msg2"></div>



  <?php

  /* Fonction pour récupérer les demandes refusées */
  function recupDemandesRefusees(){
    $row = 0;
    $tabDemandes = array(); //tableau qui contient les info de tous les demandes refusées
    $tabKeys = array(); //tableau qui contient toutes les clés du tableau $tabDemandes
    if (($handle = fopen("../csv/demandeAdresse.csv", "r"))) {
      while (($data = fgetcsv($handle, 1000, ";"))) {
        if($row == 0){
            // si on est à la première ligne du csv, on récupère les clés
            $tabKeys = $data;
          } else {
            if($data[11] == "refuser" && $data[1] == $_SESSION["identifiant"]){
              $i = 0;
              foreach ($tabKeys as $key) {
                $tabDemandes[$row-1][$key] = $data[$i];
                $i ++;
            }
          }
        }
        $row++;
      }
      fclose($handle);
    }
    return($tabDemandes);
  }

  /* Fonction pour afficher les demandes refusées */
  function afficherDemandesRefusees(){
    $tabDemandes = recupDemandesRefusees();
    if(!empty($tabDemandes)){
      echo("<h4>Ces précédentes demandes ont été refusées</h4>");
      foreach ($tabDemandes as $demande) {
        echo('<div>
        <p>Changement d\'adresse : '.$demande["nvAdresse"].' '.$demande["nvVille"].' '.$demande["nvCodePostal"].' '.$demande["nvPays"].'</p>
        </div>');
      }
    }
  }

  echo('<form action="enregistrerModifAdresse.php" method="post" enctype="multipart/form-data" class="form">
    <h4>Si vous voulez modifier votre adresse, rentrez votre nouvelle adresse ci-dessous et validez.</h4>
    <p>Adresse : <input type="text" id="adresse" name="adresse" value="'.$_SESSION["adresse"].'" required/></p>
    <p>Ville : <input type="text" id="ville" name="ville" value="'.$_SESSION["ville"].'" required/></p>
    <p>Code Postal : <input type="text" id="codePostal" name="codePostal" value="'.$_SESSION["codePostal"].'" required/></p>
    <p>Pays : <input type="text" id="pays" name="pays" value="'.$_SESSION["pays"].'" required/></p>
    <h4>Il est nécessaire d\'importer un justificatif de domicile</h4>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <p><i>Nous n\'acceptons que des images au format PNG</i></p>
    <p><input type="submit" name="btnValider" value="Valider" class="btn"></p>
  </form>');

  if(isset($_GET["adresse"]) && $_GET["adresse"] == "succes"){
    echo("<h4>La demande de changement d'adresse a bien été envoyée !</h4>");
  } else {
    if(isset($_GET["adresse"]) && $_GET["adresse"] == "echec"){
      echo("<h4>Il y a eu une erreur lors du chargement du fichier...</h4>");
    }
  }

  if(isset($_GET["fichier"])){
    switch ($_GET["fichier"]) {
      case 'lourd':
        echo("<div class='alert'>Le fichier est trop lourd ...</div>");
        break;
      case 'format':
        echo("<div class='alert'>Le fichier n'est pas au bon format ...</div>");
        break;
      case 'absent':
        echo("<div class='alert'>Vous n'avez sélectionné aucun fichier ...</div>");
        break;
    }
  }

  afficherDemandesRefusees();
  ?>

  </div>

  <script type="text/javascript" src="./modifCoordonnees.js"></script>
</body>
</html>

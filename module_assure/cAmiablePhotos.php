<?php
    session_start();
    //on vérifie que l'utilisateur est connecté, et que c'est un assuré
    if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../pageConnexion.php');
        exit();
    }
?>

<?php

/************************************************************
 * Definition des constantes / tableaux et variables
 *************************************************************/

// Constantes
$ok_photos = 0;

if (($handle = fopen("../csv/sinistres.csv", "r"))) {
  while (($data = fgetcsv($handle, 1000, ";"))) {
    if($data[0]==$_SESSION['nom'].$_SESSION['QRcode']){
        $numSinistre=$data[1];
        $ok_photos = 1;
    }
  }
}
fclose($handle);
if($ok_photos == 1){
  $ok_photos = 0;
  if (($handle = fopen("../csv/constats_amiables/".$_SESSION['nom'].$_SESSION['QRcode']."/c-amiable-".$numSinistre.$_SESSION['nom'].$_SESSION['QRcode'].".csv", "r"))) {
      while (($data = fgetcsv($handle, 1000, ";"))) {
          if($data[0]=="1"){
            if($_SESSION['nom'].$_SESSION['QRcode']==$data[1]){
              $type="A";
            }else{
              $type="B";
              $codeSinistre=$data[1];
              $numSinistreB=$data[2];
            }
            $ok_photos = 1;
          }
      }
  }
}
fclose($handle);

if($ok_photos == 1){
  if($type=="A"){
    define('TARGET', '../csv/constats_amiables/photos'.$numSinistre.$_SESSION['nom'].$_SESSION['QRcode']);
  }else{
    define('TARGET', '../csv/constats_amiables/photos'.$numSinistreB.$codeSinistre);
  }
}
  /************************************************************
   * Creation du repertoire cible si inexistant
   *************************************************************/
  if( !is_dir(TARGET) ) {
    if( !mkdir(TARGET, 0755) ) {
      exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
    }
  }


    // Repertoire cible
define('MAX_SIZE', 100000000000);    // Taille max en octets du fichier
define('WIDTH_MAX', 10000000000);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 10000000000);    // Hauteur max de l'image en pixels

// Tableaux de donnees
$tabExt = array('jpg','gif','png','jpeg','JPG');    // Extensions autorisees
$infosImg = array();

// Variables
$extension = '';
$message = '';
$nomImage = '';



/************************************************************
 * Script d'upload
 *************************************************************/
if(!empty($_POST))
{
  // On verifie si le champ est rempli
  if( !empty($_FILES['fichier']['name']) )
  {
    // Recuperation de l'extension du fichier
    $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);

    // On verifie l'extension du fichier
    if(in_array(strtolower($extension),$tabExt))
    {
      // On recupere les dimensions du fichier
      $infosImg = getimagesize($_FILES['fichier']['tmp_name']);

      // On verifie le type de l'image
      if($infosImg[2] >= 1 && $infosImg[2] <= 14)
      {
        // On verifie les dimensions et taille de l'image
        if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
        {
          // Parcours du tableau d'erreurs
          if(isset($_FILES['fichier']['error'])
            && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
          {
            // On renomme le fichier
            $nomImage = $_SESSION['identifiant'].$_SESSION['QRcode'].'_'.md5(uniqid()).'.'.$extension;

            // Si c'est OK, on teste l'upload
            if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.'/'.$nomImage))
            {
              $message = 'Upload réussi !';
            }
            else
            {
              // Sinon on affiche une erreur systeme
              $message = 'Problème lors de l\'upload !';
            }
          }
          else
          {
            $message = 'Une erreur interne a empêché l\'upload de l\'image';
          }
        }
        else
        {
          // Sinon erreur sur les dimensions et taille de l'image
          $message = 'Erreur dans les dimensions de l\'image !';
        }
      }
      else
      {
        // Sinon erreur sur le type de l'image
        $message = 'Le fichier à uploader n\'est pas une image !';
      }
    }
    else
    {
      // Sinon on affiche une erreur pour l'extension
      $message = 'L\'extension du fichier est incorrecte !';
    }
  }
  else
  {
    // Sinon on affiche une erreur pour le champ vide
    $message = 'Veuillez remplir le formulaire svp !';
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
    <title>I-Car</title>
    <meta name="Amandine" lang="fr" content="menu assuré"/>
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

    <h1 class="titre">Remplir un constat amiable</h1>
    <div class="affichage">
 <?php
      if( !empty($message) )
      {
        echo '<p>',"\n";
        echo "\t\t<strong>", htmlspecialchars($message) ,"</strong>\n";
        echo "\t</p>\n\n";
      }

      if($ok_photos == 1){
        echo('<h2>Photos</h2>
          <p>Merci de prendre les photos des deux voitures sur tous les angles, de façon à bien voir les dégâts et la situation.</p>
          <p>Vous pouvez passer à la suite et transmettre les photos plus tard si vous le souhaitez.</p>
        <form enctype="multipart/form-data" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post" class="form"/>
         <fieldset>
             <legend>Formulaire</legend>
               <p>
                 <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier :</label>
                 <input type="hidden" name="MAX_FILE_SIZE" value="'.MAX_SIZE.'" />
                 <input name="fichier" type="file" id="fichier_a_uploader" />
                 <input type="submit" name="submit" value="Uploader" />
               </p>
           </fieldset>
         </form>');
      } else {
        echo("<h2>Veuillez remplir le sinistre avant d'importer des photos</h2>");
      }


      echo "<p><a href='cAmiable.php'>Retour</a></p>";
    ?>
  </div>

  </body>
</html>

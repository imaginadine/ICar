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
</head>
<body>

  <div class="titre">
    <h1>Modification d'adresse</h1>
  </div>

  <div class="affichage">
  <?php
  /*Fonction pour récupérer le numéro de la dernière demande*/
  function recupNum(){
    $row = 0;
    $numeros = array(); //tableau qui contient les numéros de toutes les demandes
    if (($handle = fopen("../csv/demandeAdresse.csv", "r"))) {
      while (($data = fgetcsv($handle, 1000, ";"))) {
        if($row != 0){
          array_push($numeros, $data[0]);
        }
        $row++;
      }
      fclose($handle);
    }
    return(end($numeros));
  }



  $target_dir = "../photos_justificatif/"; // le dossier dans lequel on va charger le fichier
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // le nom du fichier
  $uploadOk = 1; // booléen qui indique si on peut tenter le charger le fichier (=1) ou non (=0)
  $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // extension du fichier
  $error="";

  // on vérifie qu'il n'est pas trop lourd
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    $error = "lourd";
    $uploadOk = 0;
  }

  // on vérifie que c'est bien un fichier .png
  if($fileType != "png") {
    $error = "format";
    $uploadOk = 0;
  }

  // on vérifie que l'utilisateur a bien chargé un fichier
  if (basename($_FILES["fileToUpload"]["name"]) == "") {
    $error = "absent";
    $uploadOk = 0;
  }

  // on vérifie qu'il n'y a pas eu d'erreur
  if ($uploadOk == 0) {
    header('Location: modifCoordonnees.php?fichier='.$error);
    echo("<h4>Le fichier n'a pa pu être chargé...</h4>");
  // si tout est bon, on charge le fichier
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      // si le fichier a bien été chargé, on envoie la demande de changement d'adresse
      echo("<h4>Le fichier ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " a bien été chargé !</h4>");

      $numero = recupNum()+1;

      $demande = array("numero" => $numero,
                       "identifiant" => $_SESSION["identifiant"],
                       "codeAssureur" => $_SESSION["codeAssureur"],
                       "ancienAdresse" => $_SESSION["adresse"],
                       "ancienVille" => $_SESSION["ville"],
                       "ancienCodePostal" => $_SESSION["codePostal"],
                       "ancienPays" => $_SESSION["pays"],
                       "nvAdresse" => $_POST["adresse"],
                       "nvVille" => $_POST["ville"],
                       "nvCodePostal" => $_POST["codePostal"],
                       "nvPays" => $_POST["pays"],
                       "traitement" => "en_cours");

    // on ouvre le fichier demandeAdresse.csv et on y stocke les information de la demande
    $fp = fopen('../csv/demandeAdresse.csv', 'a+');
    fputcsv($fp, $demande,";");
    fclose($fp);

    //on renomme le fichier
    rename($target_file, "../photos_justificatif/".$numero.".png");

    header('Location: modifCoordonnees.php?adresse=succes');

    } else {
      header('Location: modifCoordonnees.php?adresse=echec');
    }
  }
  ?>
  </div>

</body>
</html>

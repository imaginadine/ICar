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

    <?php
        $numero = 1;
        $target_dir = "../CessionVehicule/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $nomFichier = basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Allow certain file formats
        if($imageFileType != "pdf" ) {
            echo "Désolé, uniquement les format pdf sont autorisés.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo " Désolé, votre fichier n'a pas pu etre uploader.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "Votre fichier a bien été uploadé.<br> Votre demande est en cours.<br> Vous pourrez suivre votre demande dans cession de véhicule.";
                //echo "Votre fichier a bien été uploader.";
				$tab = file('../csv/cessionVehicule.csv');
				$der_ligne = $tab[count($tab)-1];
				//on sépare les données de la derniere ligne
				$data = explode(";",$der_ligne);
				$numero = $data[0]+1;
        rename($target_file, $target_dir.$_SESSION['pseudo'].$numero.'.pdf');
                $fp = fopen('../csv/cessionVehicule.csv', 'a+');
                    $maCession=array(
                        array($numero,
                            $_SESSION["pseudo"],
                            $_SESSION['codeAssureur'],
                            "en cours de traitement",
                            $_SESSION['pseudo'].$numero.'.pdf',
                        )
                    );
                    foreach ($maCession as $fields) {
                        fputcsv($fp, $fields,";");
                    }
                fclose($fp);
            } else {
                echo "Désolé, il y a eu une erreur lors de l'upload de votre fichier.";
            }
        }


    ?>

     <p><a href="menu_assure.php">Retour</a></p>
   </div>


</body>
</html>

<?php
	session_start();
	//vérification que l'utilisateur soit connecté pour accéder à la page, et qu'il soit un gestionnaire
	if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="gestionnaire")){
			header('Location: ../../index.php');
			exit();
	}
?>
<html>
<head>
	<title>I-Car</title>
	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="../../img/icon.png">
  <link rel="stylesheet" type="text/css" href="../../css/designGlobal.css" />
</head>
<body>

  <?php

    /* Fonction pour récupérer le nom, prénom et identifiant de tous les assurés */
    function recupInfoAssure(){
      $row = 0;
			$tabAssures = array(); //tableau qui contient les info de tous les assurés
			if (($handle = fopen("../../csv/assures.csv", "r"))) {
	    	while (($data = fgetcsv($handle, 1000, ";"))) {
					if($row != 0){
						if($data[9] == $_SESSION["codeAssureur"]){
              // si l'assuré est client chez l'assurance, on stocke ses informations
              $tabAssures[$row]["identifiant"] = $data[0];
              $tabAssures[$row]["nom"] = $data[1];
              $tabAssures[$row]["prenom"] = $data[2];
          	}
					}
					$row++;
	    	}
				fclose($handle);
	    }
			return($tabAssures);
    }

    $tabAssures = recupInfoAssure();

    // on affiche la liste déroulante
    echo("<h4>Sélectionnez l'assuré :</h4>
		<div class='form'>
    <select size='1' id='liste' name='assure' onclick='accesConversationListe()' style='margin-bottom:25px;'>");
    foreach ($tabAssures as $assure) {
      echo("<option value='".$assure["identifiant"].";".$assure["nom"].";".$assure["prenom"]."'>".$assure["nom"]." ".$assure["prenom"]."</option>");
    }
    echo("</select></div>");

  ?>

</body>

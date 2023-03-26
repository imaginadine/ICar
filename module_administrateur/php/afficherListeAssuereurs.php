<?php
	session_start();
	//vérification que l'utilisateur soit connecté pour accéder à la page, et qu'il soit un administrateur
	if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="administrateur")){
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
    /*Fonction pour récupérer les code et les noms des assureurs*/
    function recupInfoAssureur(){
      $row = 0;
      $tabAssureurs = array(); //tableau qui contient les info des assureurs
      if (($handle = fopen("../../csv/assureurs.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          $num = count($data);
          for ($c=0; $c < $num; $c++) {
  					$array = explode(";", $data[$c]);
  					if($row != 0){
  						$tabAssureurs[$array[0]] = $array[1];
  					}
          }
          $row++;
        }
        fclose($handle);
      }
      return($tabAssureurs);
    }


    if($_POST["profil"] == "true"){
      $tabAssureurs = recupInfoAssureur();
      echo("<p>Compagnie d'assurance * <select size='1' name='assurance'>");
      foreach ($tabAssureurs as $code => $nom) {
        echo("<option value='".$code."'>".$nom."</option>");
      }
      echo("</select></p>");
    }
  ?>

</body>

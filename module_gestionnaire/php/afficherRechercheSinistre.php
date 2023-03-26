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
  function recupInfoAssure($identifiantAssure){
    $row = 0;
    $assure = array();
    $tabKeys = array(); //tableau qui contient toutes les clés
    if (($handle = fopen("../../csv/assures.csv", "r"))) {
      while (($data = fgetcsv($handle, 1000, ";"))) {
				if($row == 0){
					// si on est à la première ligne du csv, on récupère les clés
					$tabKeys = $data;
				} else {
					$i = 0;
					if($data[0] == $identifiantAssure){
						foreach ($tabKeys as $key) {
							$assure[$key] = $data[$i];
							$i++;
						}
					}
				}
        $row++;
      }
      fclose($handle);
    }
    return($assure);
  }


	function recupIdAssure(){
		$row = 0;
		$identifiantAssure = "";
		if (($handle = fopen("../../csv/contrats.csv", "r"))) {
			while (($data = fgetcsv($handle, 1000, ";"))) {
						if($row != 0){
							if($data[0] == $_POST["contrat"] && $data[2] == $_SESSION["codeAssureur"]){
								$identifiantAssure = $data[3];
							}
						}
				$row++;
			}
			fclose($handle);
		}
		return($identifiantAssure);
	}


  /*Fonction pour afficher un petit encadré avec des infos sur l'assuré*/
  function afficherAssure($assure){
	$ok=false;
	if (($handle = fopen("../../csv/sinistres.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
            if($data[0]==$assure['nom'].$_POST['contrat']){
                $codeSinistre=$data[0];
				$numero=$data[1];
				$resp=$data[4];
				if(file_exists("../../csv/constats_amiables/photos".$numero.$codeSinistre."/")){
					$type="A";
				  }else{
					$type="B";
					if (($handle2 = fopen("../../csv/constats_amiables/".$codeSinistre."/c-amiable-".$numero.$codeSinistre.".csv", "r"))) {
						while (($data2 = fgetcsv($handle2, 1000, ";"))) {
							if($data2[0]=="1"){
								$numA=$data2[2];
								$codeSinistreA=$data2[1];
							}
						}
					}
					fclose($handle2);
				  }
				echo("<div class=contrat id='".$assure["identifiant"].";".$assure["nom"].";".$assure["prenom"]."' onclick='acceder(this)' style='text-align:center'>
      			<p>".$assure["nom"]." ".$assure["prenom"]."</p>
				<h4>Sinistre ".$numero." ".$codeSinistre."</h4>
				<p><a href='../../csv/constats_amiables/".$codeSinistre."/c-amiable-".$numero.$codeSinistre.".pdf' target='_blank'>Constat amiable</a></p>
				<p><a href='../../csv/declaration_sinistre/".$codeSinistre."/sinistre-".$numero.$codeSinistre.".pdf' target='_blank'>Déclaration de sinistre</a></p>");
				if($type=="A"){
					if(file_exists("../../csv/constats_amiables/photos".$numero.$codeSinistre)){
						$photos = scandir("../../csv/constats_amiables/photos".$numero.$codeSinistre);
						$i = 1;
						foreach ($photos as $photo) {
							if($photo != "." && $photo != ".."){
								echo "<p><a target='_blank' href='../../csv/constats_amiables/photos".$numero.$codeSinistre."/".$photo."'>Photos".$i."</a></p>";
								$i ++;
							}
						}
					}
				}else{
					if(file_exists("../../csv/constats_amiables/photos".$numA.$codeSinistreA)){
						$photos = scandir("../../csv/constats_amiables/photos".$numA.$codeSinistreA);
						$i = 1;
						foreach ($photos as $photo) {
							if($photo != "." && $photo != ".."){
								echo "<p><a target='_blank' href='../../csv/constats_amiables/photos".$numA.$codeSinistreA."/".$photo."'>Photos".$i."</a></p>";
								$i ++;
							}
						}
					}
				}
				echo ("<p>Responsabilité : ".$resp."</p>
				</div>");
				$ok=true;
			}
        }
    }
		if(!$ok){
			echo "Pas de sinistre pour ce/ces contrat(s).";
		}
  }


  $identifiantAssure = recupIdAssure();
	if($identifiantAssure != ""){
		$assure = recupInfoAssure($identifiantAssure);
		afficherAssure($assure);
	} else {
		echo("Ce contrat n'existe pas ou n'appartient pas à la compagnie d'assurance");
	}
  ?>

</body>

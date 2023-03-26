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
  /*Fonction pour récupérer les informations de tous les assurés dans le fichier assures.csv*/
  function recupTabAssures(){
    $row = 0;
    $tabAssures = array(); //tableau qui contient les info de tous les assurés
    $tabKeys = array(); //tableau qui contient toutes les clés
    if (($handle = fopen("../../csv/assures.csv", "r"))) {
      while (($data = fgetcsv($handle, 1000, ";"))) {
				if($row == 0){
					// si on est à la première ligne du csv, on récupère les clés
					$tabKeys = $data;
				} else {
					$i = 0;
					// on vérifie que l'assuré est bien client de l'assurance
					if($data[9] == $_SESSION["codeAssureur"]){
						// on construit notre tableau avec la ligne actuelle et les clés
						foreach ($tabKeys as $key) {
							$tabAssures[$row-1][$key] = $data[$i];
							$i ++;
						}
					}
				}
        $row++;
      }
      fclose($handle);
    }
    return($tabAssures);
  }

	/*Fonction pour récupérer tous les contrats dans contrats.csv*/
	function recupTabContrats($tabAssures){
		$row = 0;
    $tabContrats = array(); //tableau qui contient les contrats
    if (($handle = fopen("../../csv/contrats.csv", "r"))) {
      while (($data = fgetcsv($handle, 1000, ";"))) {
				if($row != 0){
					// on regarde si le contrat appartient à un client du gestionnaire
					foreach ($tabAssures as $assure) {
						if($data[3] == $assure["identifiant"]){
							if(empty($tabContrats[$assure["identifiant"]])){
								$tabContrats[$assure["identifiant"]] = array();
							}
							array_push($tabContrats[$assure["identifiant"]], $data[0]);
						}
					}
				}
        $row++;
      }
      fclose($handle);
    }
    return($tabContrats);
	}

	/*Fonction pour rechercher un assuré*/
	function rechercherAssure(){
		$okRecherche = 0;
		// on récupère le tableau avec les infos de tous les clients
		$tabAssures = recupTabAssures();
		// on récupère le tableau avec tous les contrats pour chaque client
		$tabContrats = recupTabContrats($tabAssures);
		foreach($tabAssures as $assure){
			// pour chaque client on compare les valeurs entrées par le gestionnaire dans le formulaire avec les info et les contrats des clients
			$okInfo = comparerInfoAssure($assure);
			if(!empty($tabContrats)){
				if(isset($tabContrats[$assure["identifiant"]])){
						$okContrat =comparerContratsAssure($tabContrats[$assure["identifiant"]]);
				}
			} else {
				$okContrat = 1;
				$tabContrats[$assure["identifiant"]] = array();
			}
			if($okInfo && $okContrat){
				// si la recherche est correcte, on affiche le client
				afficherAssure($assure);
				$okRecherche = 1;
			}
		}
		if(!$okRecherche){
			echo("Aucun assuré ne correspond à votre recherche...");
		}
	}

	/*Fonction pour comparer les champs du formulaire avec les info de l'assuré*/
	function comparerInfoAssure($assure){
		$rechercheCorrecte = 0;
		// on accepte la recherche si le champ est vide ou correct, mais pas si il y a au moins un champ faux
		if((($_POST["prenom"] == "") || ($assure["prenom"] == $_POST["prenom"])) && (($_POST["nom"] == "") || ($assure["nom"] == $_POST["nom"])) && (($_POST["tel"] == "") || ($assure["tel"] == $_POST["tel"])) && (($_POST["mail"] == "") || ($assure["mail"] == $_POST["mail"]))){
			$rechercheCorrecte = 1;
		}
		return($rechercheCorrecte);
	}

	/*Fonction pour comparer les champs du formulaire avec les contrats de l'assuré*/
	function comparerContratsAssure($contrats){
		$rechercheCorrecte = 0;
		if($_POST["contrat"] == ""){
			// on accepte la recherche si le champ est vide
			$rechercheCorrecte = 1;
		} else {
			// on accepte la recherche si le contrat correspond à un des contrats de l'assuré
			foreach ($contrats as $numContrat) {
				if($_POST["contrat"] == $numContrat){
					$rechercheCorrecte = 1;
				}
			}
		}
		return($rechercheCorrecte);
	}

  /*Fonction pour afficher un petit encadré avec des infos sur l'assuré*/
  function afficherAssure($assure){
    echo("<div class=encadreInfo id='".$assure["identifiant"]."' onclick='acceder(this)'>
      <p>".$assure["nom"]." ".$assure["prenom"]."</p>
    </div>");
  }


  rechercherAssure();

  ?>

</body>

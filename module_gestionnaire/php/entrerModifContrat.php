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
	<link rel="stylesheet" type="text/css" href="../../css/form.css" />
	<link rel="stylesheet" type="text/css" href="../../css/navbar.css" />
</head>
<body>

	<div class="nav">
    <input type="checkbox" id="nav-check">
    <div class="nav-header">
      <div class="nav-title">
        <a href="../profilGestionnaire.php"><img style="width: 50px" src="../../img/icon.png"/></a>
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
      <a href="./pageAccueilAssures.php">Assurés</a>
      <a href="./pageAccueilSinistres.php">Sinistres</a>
      <a href="./messagerie.php">Messagerie</a>
      <a href="./tickets.php">Tickets</a>
      <a href="../../deconnexion.php?connexion=out">Déconnexion</a>
    </div>
  </div>



	<div class="titre">
		<h1>Modifier les informations du contrat</h1>
	</div>

	<?php
    /*Fonction pour retrouver les info du contrat à modifier dans contrats.csv*/
    function recupInfoContrat(){
      $row = 0;
      $contrat = array(); //tableau qui contient les info du contrat à modifier
      $tabKeys = array(); //tableau qui contient toutes les clés du tableau $contrat
      if (($handle = fopen("../../csv/contrats.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          $num = count($data);
          for ($c=0; $c < $num; $c++) {
  					$array = explode(";", $data[$c]);
  					if($row == 0){
  						// si on est à la première ligne du csv, on récupère les clés
  						$tabKeys = $array;
  					} else {
              if($_GET["contrat"] == $array[0]){
                // si le contrat correspond au tableau à modifier, on l'ajoute dans un tableau
                $i = 0;
    						foreach ($tabKeys as $key) {
    							$contrat[$key] = $array[$i];
    							$i ++;
    						}
              }
  					}
          }
          $row++;
        }
        fclose($handle);
      }
      return($contrat);
    }

		/* Fonction pour récupérer l'adresse du contrat dans assures.csv */
		function recupInfoCarteVerte($numeroCarteVerte){
			$row = 0;
			$carteVerte = array(); //tableau qui contient les info de la carte verte
      $tabKeys = array(); //tableau qui contient toutes les clés du tableau $carteVerte
      if (($handle = fopen("../../csv/cartesVertes.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
					if($row == 0){
						// si on est à la première ligne, on récupère les clés du tableau
						$tabKeys = $data;
					} else {
						// on regarde si on est à la ligne correspondant à la carte verte
						if($numeroCarteVerte == $data[0]){
							$i = 0;
							foreach ($tabKeys as $key) {
								$carteVerte[$key] = $data[$i];
								$i ++;
							}
						}
					}
          $row++;
        }
        fclose($handle);
      }
      return($carteVerte);
		}



    $contrat = recupInfoContrat();
		$carteVerte = recupInfoCarteVerte($contrat["numCarteVerte"]);
    // on affiche le formulaire pré-rempli
    echo("<div class='affichage'>
			<form id='formulaire' class='form' method='post' action='enregistrerModifContrat.php?contrat=".$contrat["numero"]."&identifiant=".$_GET["identifiant"]."'>
	      <h4>Entrez les modifications pour le contrat n°".$contrat["numero"]."</h4>
	      <p>Identifiant de l'assuré : ".$contrat["identifiantAssure"]."</p>
	      <p>Numéro de carte verte : ".$contrat["numCarteVerte"]."</p>
	      <p>Date de fin de validité : <input type='date' id='date' name='date' value='".$contrat["date"]."' required/></p>
	      <p>Nom de l'assurance : ".$_SESSION["nom"]."</p>
				<p>Catégorie du véhicule : <input type='text' name='catégorie' value='".$carteVerte["catégorie"]."' required/></p>
				<p>Marque du véhicule : <input type='text' name='marque' value='".$carteVerte["marque"]."' required/></p>
	  		<p><input type='submit' value='Valider' id='boutonValider' class='btn'/></p>
    	</form>
		</div>");

  ?>

</body>

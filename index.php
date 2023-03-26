<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>I-Car</title>
  <link rel="icon" type="image/png" href="./img/icon.png">
  <link rel="stylesheet" type="text/css" href="css/designGlobal.css" />
  <link rel="stylesheet" type="text/css" href="css/pageConnexion.css" />
  <link rel="stylesheet" type="text/css" href="css/form.css" />
</head>
<body>
	<div class="contenu">
    <img src="./img/icon.png"/>
		<h1>Bienvenue sur I-Car</h1>
		<?php
		//Vérifie si il y a un numero de contrat en methode get
			if (isset($_GET["numeroContrat"])) {
        $numero_existe = 0;
				if (($handle = fopen("csv/contrats.csv", "r"))) {
					while (($data = fgetcsv($handle, 1000, ";"))) {
						if($data[0]==$_GET["numeroContrat"]){
							$numeroCarteVerte = $data[4];
              $numero_existe = 1;
						}
					}
					fclose($handle);
				}

        if($numero_existe == 1){
          echo "<h2>Voici les informations de la carte verte scannée : </h2>";
  				if (($handle = fopen("csv/cartesVertes.csv", "r"))) {
  					while (($data = fgetcsv($handle, 1000, ";"))) {
  						if($data[0]==$numeroCarteVerte){
  							echo "<div class='infoCarteVerte'>
                      <p><strong>Dates de validité de l’assurance :</strong><br>
  										<i style=\"margin-left: 10px;\">".$data[2]."</i><br>
  								     <strong>Plaque d'imatriculation du véhicule :</strong><br>
  									 	<i style=\"margin-left: 10px;\">".$data[5]."</i><br>
  									 <strong>Numéro du contrat d’assurance :</strong><br>
  									 	<i style=\"margin-left: 10px;\">".$_GET["numeroContrat"]."</i><br>";

                $codeAssureur = $data[4];
  						}
  					}
  					fclose($handle);
  				}

          if (($handle = fopen("csv/assureurs.csv", "r"))) {
  					while (($data = fgetcsv($handle, 1000, ";"))) {
  						if($data[0]==$codeAssureur){
  							echo "<strong>Nom de l’assurance :</strong><br>
  									 	<i style=\"margin-left: 10px;\">".$data[1]."</i></p>
                      </div>";
  						}
  					}
  					fclose($handle);
  				}

  				echo "<div style='margin-bottom: 20px'>Pour plus d'informations, veuillez vous connecter.</div>";
        } else {
          echo "<h4>Ce numéro de contrat n'existe pas. Veuillez réessayer.</h4>";
        }




			}else{
				echo "<div style='margin-bottom: 20px'>Bonjour, bienvenue sur I-Car. Si vous avez un compte vous pouvez vous connecter ci-dessous.</div>";
			}
		?>

		<!-- formulaire de connexion -->
		<div style="text-align: center;">
			<input type="button" class="btn" value="Se connecter" id="connexionBtn"/>
		</div>

		<?php
		//Vérifie si il y a une erreur dans le mot de passe
			if (isset($_GET["erreur"])) {
				echo "Erreur de connexion";
			}
			// efface la session
			if (isset($_POST["OUT"])){
				session_destroy();
			}
		?>
	</div>
	<div id="modalEl" class="modal">
		<div class="modal-content">
			<span class="close">&times;</span>
			<h3>Connexion : </h3><br>
			<?php
			if (isset($_GET["numeroContrat"])){
				echo '<form action="verifConnexion.php?numeroContrat='.$_GET["numeroContrat"].'" class="form" method="post" >';
			} else {
				echo '<form action="verifConnexion.php" class="form" method="post" >';
			}
			?>
				<p><input type="text" name="pseudo" placeholder="Identifiant" required /></p>
				<p><input type="password" name="mdp"  placeholder="Mot de passe" required /></p>
				<p><input type="submit" name='IN' value="valider"></p>
			</form>
		</div>
	</div>

  <div class="footer">
    Icônes conçues par
    <a href="https://www.flaticon.com/fr/auteurs/iconixar" title="iconixar">iconixar</a>,
    <a href="https://www.freepik.com" title="Freepik">Freepik</a>,
    <a href="https://www.flaticon.com/fr/auteurs/eucalyp" title="Eucalyp">Eucalyp</a>,
    <a href="https://www.flaticon.com/fr/auteurs/flat-icons" title="Flat Icons">Flat Icons</a>,
    <a href="" title="Vitaly Gorbachev">Vitaly Gorbachev</a>
    from
    <a href="https://www.flaticon.com/fr/" title="Flaticon">www.flaticon.com</a>
  </div>

	<script type="text/javascript" src="./js/connexion.js"></script>
</body>
</html>

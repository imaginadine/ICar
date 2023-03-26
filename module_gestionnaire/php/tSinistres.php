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
    <h1>Gérer les déclarations de sinistres</h1>
  </div>

	<div class="affichage">
	  <p>Ici vous pouvez traiter les différentes déclarations de sinistres.</p>
	  <h2>Sinistres à traiter</h2>
	</div>

	  <?php
	  	$i=1;
		if (($handle = fopen("../../csv/sinistres.csv", "r"))) {
	        while (($data = fgetcsv($handle, 1000, ";"))) {
	            if(isset($data[3]) && $data[3]=="non" && $data[2]==$_SESSION["codeAssureur"]){
	                $codeSinistre=$data[0];
					$numero=$data[1];
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
					echo "<div id='".$i."' class='form' style='margin-left:5%;margin-right:5%;color:#5a5958;font-family:sans-serif;'>";
					echo "<h4>Sinistre ".$numero." <span id='code".$i."'>".$codeSinistre."</span></h4>";
					echo "<p><a href='../../csv/constats_amiables/".$codeSinistre."/c-amiable-".$numero.$codeSinistre.".pdf' target='_blank'>Constat amiable</a></p>";
					echo "<p><a href='../../csv/declaration_sinistre/".$codeSinistre."/sinistre-".$numero.$codeSinistre.".pdf' target='_blank'>Déclaration de sinistre</a></p>";
					if($type=="A"){
						if(file_exists("../../csv/constats_amiables/photos".$numero.$codeSinistre)){
							$photos = scandir("../../csv/constats_amiables/photos".$numero.$codeSinistre);
							$j = 1;
							foreach ($photos as $photo) {
								if($photo != "." && $photo != ".."){
									echo "<p><a target='_blank' href='../../csv/constats_amiables/photos".$numero.$codeSinistre."/".$photo."'>Photos".$i."</a></p>";
									$j ++;
								}
							}
						}
					}else{
						if(file_exists("../../csv/constats_amiables/photos".$numA.$codeSinistreA)){
							$photos = scandir("../../csv/constats_amiables/photos".$numA.$codeSinistreA);
							$k = 1;
							foreach ($photos as $photo) {
								if($photo != "." && $photo != ".."){
									echo "<p><a target='_blank' href='../../csv/constats_amiables/photos".$numA.$codeSinistreA."/".$photo."'>Photos".$i."</a></p>";
									$k ++;
								}
							}
						}
					}
					echo '<p> Responsabilité <input type="radio" id="responsabilite1" name="Responsabilite" value="totale" /> Totale <input type="radio" id="responsabilite2" name="Responsabilite" value="partielle" /> Partielle <input type="radio" id="responsabilite3" name="Responsabilite" value="non responsable" /> Non responsable</p>';
					echo '<input type="submit" value="Valider" onclick="valider('.$i.','.$numero.')"/>';
					echo "</div>";
					$i=$i+1;
				}
	        }
	    }
		fclose($handle);
	  ?>

		<div class="affichage">
		  <h2>Tous les sinistres</h2>
			<p>Vous pouvez rechercher n'importe quel contrat pour avoir accès aux constats amiables et déclarations de sinistre.</p>
			<div class="form">
				<p>Numéro de contrat : <input type="text" id="contrat" name="contrat"/></p>
				<p><input type="submit" value="Valider" id="boutonValider" class="btn" onclick="rechercher()"/></p>
			</div>

			<div id="resultatRecherche" class="affichage"></div>
		</div>


</body>
</html>

<script>
	function valider(numDiv, num){
		ok=confirm("Validez-vous ce sinistre ?");
		if(ok){
			var branche=document.getElementById("code"+numDiv).innerHTML;
			var radios = document.getElementsByName('Responsabilite');
			for (var i = 0, length = radios.length; i < length; i++){
				if (radios[i].checked){
					var resp=radios[i].value;
				break;
				}
			}
			document.body.removeChild(document.getElementById(numDiv));
			xhttp=new XMLHttpRequest();
			xhttp.onreadystatechange=function() {
				if (this.readyState==4 && this.status==200){
				}
			}
			xhttp.open("POST", "validerSinistre.php", true);
			xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhttp.send("branche="+branche+"&num="+num+"&resp="+resp);
		}
	}

	//fonction pour envoyer les information du formulaire à afficherRechercheAssure.php en AJAX
	function rechercher(){
	var xhttp = new XMLHttpRequest();
	// on récupère l'info du formulaire
	var contrat = document.getElementById("contrat").value;
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		document.getElementById("resultatRecherche").innerHTML = this.responseText;
		}
	};
	xhttp.open("POST", "afficherRechercheSinistre.php", true);
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhttp.send("contrat="+contrat);
	}
</script>

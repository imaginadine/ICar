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
    <h1>Creer un nouveau contrat</h1>
  </div>

	<div class="affichage">
			<?php echo('<form action="enregistrerContrat.php?identifiant='.$_GET["identifiant"].'" method="POST" class="form">'); ?>
				<!--Emplacement pour que l'utilisateur rentre la date de début de validité-->
				<p>Date de Début de Validité: <input type="date" name="dateDebut" required></p>
				<!--Emplacement pour que l'utilisateur rentre la date de fin de validité-->
				<p>Date de Fin de Validité: <input type="date" name="dateFin" required></p>
				<!--Emplacement pour que l'utilisateur rentre le code du pays-->
				<p>Code du Pays : <input type="text" name="codePays" maxlength=1 placeholder="ex: F"required></p>
				<!--Emplacement pour que l'utilisateur rentre sa plaque d'immatriculation-->
				<p>Plaque d'immatriculation: <input type="text" name="plaque" pattern="[A-Z]{2}-[0-9]{3}-[A-Z]{2}" placeholder="AA-001-BB" required></p>
				<!--Emplacement pour que l'utilisateur rentre la catégorie de son véhicule-->
				<p>Catégorie: <input type="text" name="categorie" maxlength=1 placeholder="ex: A"required></p>
				<!--Emplacement pour que l'utilisateur rentre la marque de son véhicule-->
				<p>Marque:<input type="text" name="marque" placeholder="ex: Renault" required></p>
				<!--Emplacement pour que l'utilisateur rentre la validité territoriale-->
				<p>Validité Territoriale: Veuillez cocher les cases correspondnat aux pays où la circulation est interdite </p>
				<table>
					<tr>
						<td><input type="checkbox" name="validite1"><label for="A">A</label></td>
						<td><input type="checkbox" name="validite2"><label for="B">B</label></td>
						<td><input type="checkbox" name="validite3"><label for="BG">BG</label></td>
						<td><input type="checkbox" name="validite4"><label for="CY">CY</label></td>
						<td><input type="checkbox" name="validite5"><label for="CZ">CZ</label></td>
						<td><input type="checkbox" name="validite6"><label for="D">D</label></td>
						<td><input type="checkbox" name="validite7"><label for="DK">DK</label></td>
						<td><input type="checkbox" name="validite8"><label for="E">E</label></td>
						<td><input type="checkbox" name="validite9" ><label for="EST">EST</label></td>
						<td><input type="checkbox" name="validite10" ><label for="F">F</label></td>
						<td><input type="checkbox" name="validite11" ><label for="FIN">FIN</label></td>
						<td><input type="checkbox" name="validite12" ><label for="GB">GB</label></td>
						<td><input type="checkbox" name="validite13" ><label for="GR">GR</label></td>
						<td><input type="checkbox" name="validite14" ><label for="H">H</label></td>
					</tr>
						<td><input type="checkbox" name="validite15" ><label for="I">I</label></td>
						<td><input type="checkbox" name="validite16" ><label for="IRL">IRL</label></td>
						<td><input type="checkbox" name="validite17" ><label for="IS">IS</label></td>
						<td><input type="checkbox" name="validite18" ><label for="L">L</label></td>
						<td><input type="checkbox" name="validite19" ><label for="LT">LT</label></td>
						<td><input type="checkbox" name="validite20" ><label for="LV">LV</label></td>
						<td><input type="checkbox" name="validite21" ><label for="M">M</label></td>
						<td><input type="checkbox" name="validite22" ><label for="N">N</label></td>
						<td><input type="checkbox" name="validite23" ><label for="NL">NL</label></td>
						<td><input type="checkbox" name="validite24" ><label for="P">P</label></td>
						<td><input type="checkbox" name="validite25" ><label for="PL">PL</label></td>
						<td><input type="checkbox" name="validite26" ><label for="RO">RO</label></td>
						<td><input type="checkbox" name="validite27" ><label for="S">S</label></td>
						<td><input type="checkbox" name="validite28" ><label for="SK">SK</label></td>
					</tr>
					<tr>
						<td><input type="checkbox" name="validite29" ><label for="SLO">SLO</label></td>
						<td><input type="checkbox" name="validite30" ><label for="CH">CH</label></td>
						<td><input type="checkbox" name="validite31" ><label for="AL">AL</label></td>
						<td><input type="checkbox" name="validite32" ><label for="AND">AND</label></td>
						<td><input type="checkbox" name="validite33" ><label for="BIH">BIH</label></td>
						<td><input type="checkbox" name="validite34" ><label for="BY">BY</label></td>
						<td><input type="checkbox" name="validite35" ><label for="IL">IL</label></td>
						<td><input type="checkbox" name="validite36" ><label for="IR">IR</label></td>
						<td><input type="checkbox" name="validite37" ><label for="MA">MA</label></td>
						<td><input type="checkbox" name="validite38" ><label for="MD">MD</label></td>
						<td><input type="checkbox" name="validite39" ><label for="MK">MK</label></td>
						<td><input type="checkbox" name="validite40" ><label for="MNE">MNE</label></td>
						<td><input type="checkbox" name="validite41" ><label for="RUS">RUS</label></td>
						<td><input type="checkbox" name="validite42" ><label for="SRB">SRB</label></td>
					</tr>
					<tr>
						<td><input type="checkbox" name="validite43" ><label for="TN">TN</label></td>
						<td><input type="checkbox" name="validite44" ><label for="TR">TR</label></td>
						<td><input type="checkbox" name="validite45" ><label for="UA">UA</label></td>
					</tr>
				</table>
				<!--Emplacement pour que l'utilisateur rentre le pays d'immatriculation-->
				<p>Pays Immatriculation:<input type="text" name="paysImmatriculation" placeholder="ex: France" required></p>
				<!--Bouton de validation pour passer à la page suivante-->
				<input class="btn" type="submit" value="Valider">
			</form>
		</div>

</body>

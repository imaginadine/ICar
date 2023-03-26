<?php
	session_start();
	//vérification que l'utilisateur soit connecté pour accéder à la page, et qu'il soit un gestionnaire
	if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="gestionnaire")){
			header('Location: ../../index.php');
			exit();
	}
?>

<?php
$resp=0;
$partiel=0;
$nonResp=0;
if (($handle = fopen("../../csv/sinistres.csv", "r"))) {
    while (($data = fgetcsv($handle, 1000, ";"))) {
        if($data[3]=="oui"){
            if($data[4]=="totale"){
                $resp++;
            }
            if($data[4]=="partielle"){
                $partiel++;
            }
            if($data[4]=="non responsable"){
                $nonResp++;
            }
        }
    }
}

?>

<html>
<head>
	<title>I-Car</title>
	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="../../img/icon.png">
  	<link rel="stylesheet" type="text/css" href="../../css/designGlobal.css" />
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
        <h1>Connaître le nombre de sinistres</h1>
    </div>

		<div class="affichage">
	    <p>Ici vous pouvez connaître le nombre de sinistres en fonction de la responsabilité de l'assuré.</p>
	    <h2>Sinistres à responsabilité totale : </h2>
	    <?php
	    echo "<p>Nombre : ".$resp."</p>";
	    ?>
	    <h2>Sinistres à responsabilité partielle : </h2>
	    <?php
	    echo "<p>Nombre : ".$partiel."</p>";
	    ?>
	    <h2>Sinistres non responsables : </h2>
	    <?php
	    echo "<p>Nombre : ".$nonResp."</p>";
	    ?>
		</div>

  </body>
</html>

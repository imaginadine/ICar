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
  </head>
  <body>

    <?php
    if($_GET["connexion"] == "out"){
			// on supprime la session de l'utilisateur
      session_destroy();
			$_SESSION = array();
    }
		// on redirige l'utilisateur vers l'accueil
    header('Location: index.php');
  ?>

  </body>
</html>

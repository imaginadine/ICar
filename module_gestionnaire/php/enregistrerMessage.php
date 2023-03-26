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
date_default_timezone_set("Europe/Paris");
    $message = array("emetteur" => $_SESSION["codeAssureur"],
                     "destinataire" => $_GET["identifiant"],
                     'date' => date("d-m-Y"),
                     'heure' => date("H:i"),
                     "message" => str_replace("\n", "</br>", $_POST["nvMessage"]));

    $fp = fopen('../../csv/messages.csv', 'a+');
    fputcsv($fp, $message,";");
    fclose($fp);

    header('Location: conversation.php?identifiant='.$_GET["identifiant"].'&nom='.$_GET["nom"].'&prenom='.$_GET["prenom"]);

  ?>

</body>

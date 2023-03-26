<?php
    session_start();
    //on vérifie que l'utilisateur est connecté, et que c'est un assuré
    if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../pageConnexion.php');
        exit();
    }
?>

<html>
<head>
	<title>I-Car</title>
	<meta charset="utf-8">
	<link rel="icon" type="image/png" href="../img/icon.png">
  <link rel="stylesheet" type="text/css" href="../css/designGlobal.css" />
</head>
<body>

  <?php

    /* "emetteur" => $_SESSION["codeAssureur"] */
    date_default_timezone_set("Europe/Paris");
    $message = array("emetteur" => $_SESSION["identifiant"],
                     "destinataire" => $_SESSION["codeAssureur"],
                     'date' => date("d-m-Y"),
                     'heure' => date("H:i"),
                     "message" => str_replace("\n", "</br>", $_POST["nvMessage"]));

    $fp = fopen('../csv/messages.csv', 'a+');
    fputcsv($fp, $message,";");
    fclose($fp);

    header('Location: contacterAssurance.php');

  ?>


</body>

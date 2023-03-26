<?php
    session_start();
    //on vérifie que l'utilisateur est connecté, et que c'est un assuré
    if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../pageConnexion.php');
        exit();
    }
?>

<?php
    if(!file_exists("../csv/constats_amiables/".$_SESSION['nom'].$_SESSION['QRcode']."/")){
      mkdir("../csv/constats_amiables/".$_SESSION['nom'].$_SESSION['QRcode']."/", 0700);
    }
    $f = fopen("../csv/constats_amiables/".$_SESSION['nom'].$_SESSION['QRcode']."/c-amiable-".$_SESSION['numero'].$_SESSION['nom'].$_SESSION['QRcode'].".csv", "a+");
    $infos1= array(
        array("A",$_SESSION['dateAccident'],$_SESSION['heureAccident'],$_POST['pays'], $_POST['lieu'], $_POST['blesse'], $_POST['degat1'], $_POST['degat2'])
    );
    foreach ($infos1 as $fields) {
        fputcsv($f, $fields,";");
    }
    fclose($f);

    // on sauvegarde les modifications faites pour les administrateurs
		$modificattion = array("document" => "constat",
													 "numero" => $_SESSION['numero'],
													 "type" => "creation",
												 	 "identifiant" => $_SESSION["identifiant"],
												 	 "date" => date("d-m-Y"),
												   "heure" => date("H:i"));

		$fp = fopen('../csv/modifications.csv', 'a+');
 		fputcsv($fp, $modificattion,";");
 		fclose($fp);
?>

<?php
    if($_POST['temoin']!="0"){
        $_SESSION['nbtemoins']=$_POST['temoin'];
        header('Location: temoins.php');
        exit();
    }
    header('Location: cAmiable2.php');
?>

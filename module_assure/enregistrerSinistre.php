<?php
    session_start();
    //on vérifie que l'utilisateur est connecté, et que c'est un assuré
    if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../pageConnexion.php');
        exit();
    }
?>

<?php
if(!file_exists("../csv/declaration_sinistre/".$_SESSION['nom'].$_SESSION['QRcode']."/")){
      mkdir("../csv/declaration_sinistre/".$_SESSION['nom'].$_SESSION['QRcode']."/", 0700);
    }
$j=1;
while(file_exists("../csv/declaration_sinistre/".$_SESSION['nom'].$_SESSION['QRcode']."/sinistre-".$j.$_SESSION['nom'].$_SESSION['QRcode'].".csv")){
    $j+=1;
}
$_SESSION['numeroS']=$j;
    $f = fopen("../csv/declaration_sinistre/".$_SESSION['nom'].$_SESSION['QRcode']."/sinistre-".$_SESSION['numeroS'].$_SESSION['nom'].$_SESSION['QRcode'].".csv", "a+");
    $infos= array(
        array("1",$_POST['nomConducteur'], $_POST['telConducteur'], $_POST['mailConducteur'], $_POST['professionAssure']),
        array("2",$_POST['professionConducteur'], $_POST['situation'], $_POST['habituel'], $_POST['reside'], $_POST['salarie'], $_POST['titre'], $_POST['motifDeplacement']),
        array("3",$_POST['circonstances']),
        array("4",$_POST['proces-verbal'], $_POST['rapportPolice'], $_POST['main-courante'], $_POST['commissariat']),
        array("5",$_POST['lieuGarage'], $_POST['reparateur'], $_POST['telReparateur'], $_POST['faxReparateur'], $_POST['mailReparateur'], $_POST['quandReparateur'], $_POST['telReparateur2']),
        array("6",$_POST['numVehiculeVole'], $_POST['nomLocation'], $_POST['adresseLocation'], $_POST['poidsLourd'], $_POST['poidsRemorque'], $_POST['societeRemorque'], $_POST['contratRemorque']),
        array("7",$_POST['natureDegatAutre'],$_POST['importanceAutre'],$_POST['nomAutre'],$_POST['adresseAutre']),
        array("nbBlesses",$_POST['nbBlesses']),
        array("numero", $_SESSION['numeroS'])
    );
    foreach ($infos as $fields) {
        fputcsv($f, $fields,";");
    }
    fclose($f);

    $f = fopen("../csv/sinistres.csv", "a+");
    $infos= array(
        array($_SESSION['nom'].$_SESSION['QRcode'],$_SESSION['numeroS'],$_SESSION['codeAssureur'],"non")
    );
    foreach ($infos as $fields) {
        fputcsv($f, $fields,";");
    }
    fclose($f);

    // on sauvegarde les modifications faites pour les administrateurs
		$modificattion = array("document" => "sinistre",
													 "numero" => $_SESSION['numeroS'],
													 "type" => "creation",
												 	 "identifiant" => $_SESSION["identifiant"],
												 	 "date" => date("d-m-Y"),
												   "heure" => date("H:i"));

		$fp = fopen('../csv/modifications.csv', 'a+');
 		fputcsv($fp, $modificattion,";");
 		fclose($fp);
?>

<?php
    if($_POST['nbBlesses']!="0"){
        $_SESSION['nbBlesses']=$_POST['nbBlesses'];
        header('Location: blesses.php');
        exit();
    }
    header('Location: dSinistrePDF.php');
?>

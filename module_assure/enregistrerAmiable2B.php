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
    $j=1;
    while(file_exists("../csv/constats_amiables/".$_SESSION['nom'].$_SESSION['QRcode']."/c-amiable-".$j.$_SESSION['nom'].$_SESSION['QRcode'].".csv")){
        $j+=1;
    }
    $_SESSION['numero']=$j;

    $f = fopen("../csv/constats_amiables/".$_SESSION['nom'].$_SESSION['QRcode']."/c-amiable-".$_SESSION['numero'].$_SESSION['nom'].$_SESSION['QRcode'].".csv", "a+");
    $infos= array(
        array("1",$_POST['codeSinistre'],$_POST['numSinistre']),
        array("2",$_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['codePostal'],$_POST['ville'], $_POST['pays'], $_POST['tel']),
        array("3",$_POST['nomAssureur'], $_POST['numeroContrat'], $_POST['numeroCarteVerte'], $_POST['attestationDebut'], $_POST['attestationFin'], $_POST['adresseAssureur'], $_POST['codePostalAssureur'],$_POST['villeAssureur'],$_POST['paysAssureur'], $_POST['telAssureur'],$_SESSION['degatsAssures']),
        array("4",$_POST['type'], $_POST['immatriculation'], $_POST['paysImmatriculation'], $_POST['numRemorque'], $_POST['paysRemorque']),
        array("5",$_POST['nomConducteur'], $_POST['prenomConducteur'], $_POST['dateConducteur'], $_POST['adresseConducteur'], $_POST['codePostalConducteur'],$_POST['villeConducteur'], $_POST['paysConducteur'], $_POST['telConducteur'], $_POST['numPermisConducteur'],$_POST['categorieConducteur'],$_POST['validitePermisConducteur']),
        array("6",$_POST['degatsApparents']),
        array("7",$_POST['observations']),
        array("8",$_POST['boxstat'],$_POST['boxarret'],$_POST['boxqstat'],$_POST['boxportiere'],$_POST['boxpstat'],$_POST['boxsort'],$_POST['boxengage'],$_POST['boxengagegir'],$_POST['boxroulegir'],$_POST['boxheurtememesens'],$_POST['boxroulefile'],$_POST['boxchangefile'],$_POST['boxdouble'],$_POST['boxdroite'],$_POST['boxgauche'],$_POST['boxrecul'],$_POST['boxempiete'],$_POST['boxdroitecarrefour'],$_POST['boxprio']),
        array("numero", $_SESSION['numero'])
    );
    foreach ($infos as $fields) {
        fputcsv($f, $fields,";");
    }
    fclose($f);
    $_SESSION['codeSinistre']=$_POST['codeSinistre'];
?>

<?php
    header('Location: cAmiablePDF.php');
?>

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
    $f = fopen("../csv/declaration_sinistre/".$_SESSION['nom'].$_SESSION['QRcode']."/sinistre-".$_SESSION['numeroS'].$_SESSION['nom'].$_SESSION['QRcode'].".csv", 'a+');
    for($i=0;$i<$_SESSION['nbBlesses'];$i++){
        $infost= array(
            array("Blessé".($i+1), $_POST['nom'.($i+1)], $_POST['prenom'.($i+1)], $_POST['adresse'.($i+1)], $_POST['ville'.($i+1)], $_POST['codePostal'.($i+1)], $_POST['pays'.($i+1)], $_POST['tel'.($i+1)], $_POST['profession'.($i+1)], $_POST['situation'.($i+1)], $_POST['hospitalisation'.($i+1)], $_POST['port'.($i+1)], $_POST['blessures'.($i+1)])
        );
        foreach ($infost as $fields) {
            fputcsv($f, $fields,";");
        }
    }
    fclose($f);
?>

<?php
    header('Location: dSinistrePDF.php');
?>

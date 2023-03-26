<?php
    session_start();
?>

<?php
    if ($handle = fopen("csv/identifiants.csv", "r")) {
        while ($data = fgetcsv($handle, 1000, ";")) {
            if($data[0]==$_POST['pseudo'] && password_verify($_POST["mdp"], $data[1]) && $data[2]=='assure'){
                $_SESSION['profil'] = 'assure';
                $_SESSION['pseudo'] = $_POST['pseudo'];
                if (isset($_GET["numeroContrat"])){
                    $_SESSION['numeroContrat'] = $_GET["numeroContrat"];
                } else {
                  $_SESSION['numeroContrat'] = "";
                }
                header('Location: module_assure/menu_assure.php');
                exit();
            }
        }
        fclose($handle);
    }

    if ($handle = fopen("csv/identifiants.csv", "r")) {
        while ($data = fgetcsv($handle, 1000, ";")) {
            if($data[0]==$_POST['pseudo'] && password_verify($_POST["mdp"], $data[1]) && $data[2]=="police"){
                $_SESSION['profil'] = "police";
                $_SESSION['pseudo'] = $_POST['pseudo'];
                if (isset($_GET["numeroContrat"])){
                    $_SESSION['numeroContrat'] = $_GET["numeroContrat"];
                }
                header('Location: menuForceDeOrdre.php');
                exit();
            }
        }
        fclose($handle);
    }

    if ($handle = fopen("csv/identifiants.csv", "r")) {
        while ($data = fgetcsv($handle, 1000, ";")) {
            if($data[0]==$_POST['pseudo'] && password_verify($_POST["mdp"], $data[1]) && $data[2]=='gestionnaire'){
                $_SESSION['identifiant'] = $data[0];
                $_SESSION['mdp'] = $data[1];
                $_SESSION['profil'] = $data[2];
                $_SESSION['codeAssureur'] = $data[3];
                if (isset($_GET["numeroContrat"])){
                    $_SESSION['numeroContrat'] = $_GET["numeroContrat"];
                }
                header('Location: ./module_gestionnaire/profilGestionnaire.php');
                exit();
            }
        }
        fclose($handle);
    }
	if ($handle = fopen("csv/identifiants.csv", "r")) {
        while ($data = fgetcsv($handle, 1000, ";")) {
            if($data[0]==$_POST['pseudo'] && password_verify($_POST["mdp"], $data[1]) && $data[2]=='administrateur'){
                $_SESSION['profil'] = 'administrateur';
                $_SESSION['identifiant'] = $_POST['pseudo'];
                if (isset($_GET["numeroContrat"])){
                    $_SESSION['numeroContrat'] = $_GET["numeroContrat"];
                }
                header('Location: ./module_administrateur/profilAdmin.php');
                exit();
            }
        }
        fclose($handle);
    }

    if (isset($_GET["numeroContrat"])){
        header('Location: index.php?numeroContrat='.$_GET["numeroContrat"].'&erreur=mdp');
    }else{
        header('Location: index.php?erreur=mdp');
    }

?>

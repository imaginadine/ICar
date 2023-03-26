<?php
    session_start();
    //on vérifie que l'utilisateur est connecté, et que c'est un assuré
    if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../pageConnexion.php');
        exit();
    }
    $_SESSION['type']="A";
?>

<?php
     if (($handle = fopen("../csv/contrats.csv", "r"))) {
       while (($data = fgetcsv($handle, 1000, ";"))) {
            if($data[3]==$_SESSION['identifiant']){
                $_SESSION['codeAssureur']=$data[2];
                $_SESSION['numeroContrat']=$data[0];
                $_SESSION['numeroCarteVerte']=$data[4];
            }
        }
    }
    fclose($handle);
    if (($handle = fopen("../csv/assureurs.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
            if($data[0]==$_SESSION['codeAssureur']){
                $_SESSION['nomAssureur']=$data[1];
                $_SESSION['adresseAssureur']=$data[2];
                $_SESSION['villeAssureur']=$data[3];
                $_SESSION['codePostalAssureur']=$data[4];
                $_SESSION['paysAssureur']=$data[5];
                $_SESSION['telAssureur']=$data[6];
                $_SESSION['degatsAssures']=$data[7];
            }
        }
    }
    fclose($handle);
    if (($handle = fopen("../csv/cartesVertes.csv", "r"))) {
        while (($data = fgetcsv($handle, 1000, ";"))) {
            if($data[10]==$_SESSION['identifiant']){
                $_SESSION['type']=$data[7];
                $_SESSION['immatriculation']=$data[5];
                $_SESSION['paysImmatriculation']=$data[9];
                $_SESSION['attestationDebut']=$data[1];
                $_SESSION['attestationFin']=$data[2];
            }
        }
    }
    fclose($handle);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
    <title>I-Car</title>
    <meta name="Amandine" lang="fr" content="déclaration sinistre"/>
    <meta charset="UTF8"/>
    <link rel="icon" type="image/png" href="../img/icon.png">
    <link rel="stylesheet" type="text/css" href="../css/designGlobal.css" />
    <link rel="stylesheet" type="text/css" href="../css/form.css" />
    <link rel="stylesheet" type="text/css" href="../css/navbar.css" />
    </head>
    <body>
      <div class="nav">
        <input type="checkbox" id="nav-check">
        <div class="nav-header">
          <div class="nav-title">
            <a href="./menu_assure.php"><img style="width: 50px" src="../img/icon.png"/></a>
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
          <a href="./pageProfil.php">Profil</a>
          <a href="./cAmiable.php">Constats</a>
          <a href="./pageAccueilSinistres.php">Sinistres</a>
          <a href="./contacterAssurance.php">Messagerie</a>
          <a href="./dVenteVehicule.php">Cession vehicule</a>
          <a href="../deconnexion.php?connexion=out">Déconnexion</a>
        </div>
      </div>

        <h1 class="titre">Remplir un constat amiable</h1>

        <div class="affichage">
          <?php
              echo "<h2>Véhicule : ".$_SESSION['prenom']." ".$_SESSION['nom']."</h2>";
          ?>
          <p>Le propriétaire de ce véhicule l'a scanné avec le code QR associé et s'est identifié en tant qu'assuré.</p>
          <form id="amiable2" name="amiable2" method="POST" action="enregistrerAmiable2.php" class="form">
          <h4>Preneur d'assurance/assuré</h4>
          <?php
              echo '<p>Nom : <input type="text" id="nom" name="nom" value="'.$_SESSION['nom'].'"/></p>';
              echo '<p>Prénom : <input type="text" id="prenom" name="prenom" value="'.$_SESSION['prenom'].'"/></p>';
              echo '<p>Adresse : <input type="text" id="adresse" name="adresse" value="'.$_SESSION['adresse'].'"/></p>';
              echo '<p>Ville : <input type="text" id="ville" name="ville" value="'.$_SESSION['ville'].'"/></p>';
              echo '<p>Code postal : <input type="text" id="codePostal" name="codePostal" value="'.$_SESSION['codePostal'].'"/></p>';
              echo '<p>Pays : <input type="text" id="pays" name="pays" value="'.$_SESSION['pays'].'"/></p>';
              echo '<p>Téléphone : <input type="text" id="tel" name="tel" value="'.$_SESSION['tel'].'"/></p>';
          ?>

          <h4>Société d'assurance</h4>
          <?php
              echo '<p>Nom : <input type="text" id="nomAssureur" name="nomAssureur" value="'.$_SESSION['nomAssureur'].'"/></p>';
              echo '<p>Numéro de contrat : <input type="text" id="numeroContrat" name="numeroContrat" value="'.$_SESSION['numeroContrat'].'"/></p>';
              echo '<p>Numéro de carte verte : <input type="text" id="numeroCarteVerte" name="numeroCarteVerte" value="'.$_SESSION['numeroCarteVerte'].'"/></p>';
              echo "<p>Attestation d'assurance ou carte verte valable du : <input type='text' id='attestationDebut' name='attestationDebut' value='".$_SESSION['attestationDebut']."'/> au <input type='text' id='attestationFin' name='attestationFin' value='".$_SESSION['attestationFin']."'/></p>";
              echo "<p>Adresse de l'agence (adresse, ville, codePostal, pays) : <input type='text' id='adresseAssureur' name='adresseAssureur' value='".$_SESSION['adresseAssureur']."'/></p>";
              echo "<p>Téléphone : <input type='text' id='telAssureur' name='telAssureur' value='".$_SESSION['telAssureur']."'/></p>";
              echo "<p>Les dégâts matériels sont-ils assurés par le contrat ? : ".$_SESSION['degatsAssures']."</p>";
          ?>

          <h4>Véhicule</h4>
          <h5>A moteur</h5>
          <?php
              echo "<p>Marque, type : <input type='text' id='type' name='type' value='".$_SESSION['type']."'/></p>";
              echo "<p>Numéro d'immatriculation : <input type='text' id='immatriculation' name='immatriculation' value='".$_SESSION['immatriculation']."'/></p>";
              echo "<p>Pays d'immatriculation : <input type='text' id='paysImmatriculation' name='paysImmatriculation' value='".$_SESSION['paysImmatriculation']."'/></p>";
          ?>
          <h5>Remorque (facultatif)</h5>

              <p>Numéro d'immatriculation : <input type="text" id="numRemorque" name="numRemorque"/></p>
              <p>Pays d'immatriculation : <input type="text" id="paysRemorque" name="paysRemorque"/></p>

          <h4>Conducteur</h4>
              <p>Nom : <input type="text" id="nomConducteur" name="nomConducteur" required/></p>
              <p>Prénom : <input type="text" id="prenomConducteur" name="prenomConducteur" required/></p>
              <p>Date de naissance : <input type="date" id="dateConducteur" name="dateConducteur" required/></p>
              <p>Adresse : <input type="text" id="adresseConducteur" name="adresseConducteur" required/></p>
              <p>Code postal : <input type="text" id="codePostalConducteur" name="codePostalConducteur" required/></p>
              <p>Ville : <input type="text" id="villeConducteur" name="villeConducteur" required/></p>
              <p>Pays : <input type="text" id="paysConducteur" name="paysConducteur" required/></p>
              <p>Tél. ou e-mail : <input type="text" id="telConducteur" name="telConducteur" required/></p>
              <p>Numéro du permis de conduire : <input type="text" id="numPermisConducteur" name="numPermisConducteur" required/></p>
              <p>Catégorie (A, B...) : <input type="text" id="categorieConducteur" name="categorieConducteur" required/></p>
              <p>Permis valable jusqu'au : <input type="date" id="validitePermisConducteur" name="validitePermisConducteur" required/></p>

          <h4>Dégâts apparents au véhicule : <input type="text" id="degatsApparents" name="degatsApparents" size="100" required/></h4>
          <h4>Mes observations : <input type="text" id="observations" name="observations" size="100" required/></h4>

          <h4>Circonstances</h4>
          <p>Votre véhicule était : (cocher toutes les cases utiles pour préciser les circonstances)</p>
          <p><input type="checkbox" id="boxstat" name="boxstat" value="stationnement" /> En stationnement </p>
          <p><input type="checkbox" id="boxarret" name="boxarret" value="arret" /> A l'arrêt </p>
          <p><input type="checkbox" id="boxqstat" name="boxqstat" value="quittait un stationnement" /> Quittait un stationnement </p>
          <p><input type="checkbox" id="boxportiere" name="boxportiere" value="ouvrait une portière" /> Ouvrait une portière </p>
          <p><input type="checkbox" id="boxpstat" name="boxpstat" value="prenait un stationnement" /> Prenait un stationnement </p>
          <p><input type="checkbox" id="boxsort" name="boxsort" value="sortait d'un parking, d'un lieu privé, d'un chemin de terre" /> Sortait d'un parking, d'un lieu privé, d'un chemin de terre </p>
          <p><input type="checkbox" id="boxengage" name="boxengage" value="s'engageait dans un parking, un lieu privé, un chemin de terre" /> S'engageait dans un parking, un lieu privé, un chemin de terre </p>
          <p><input type="checkbox" id="boxengagegir" name="boxengagegir" value="s'engageait dans une place à sens giratoire" /> S'engageait dans une place à sens giratoire </p>
          <p><input type="checkbox" id="boxroulegir" name="boxroulegir" value="roulait sur une place à sens giratoire" /> Roulait sur une place à sens giratoire </p>
          <p><input type="checkbox" id="boxheurtememesens" name="boxheurtememesens" value="heurtait à l'arrière, en roulant dans le même sens et sur une même file" /> Heurtait à l'arrière, en roulant dans le même sens et sur une même file </p>
          <p><input type="checkbox" id="boxroulefile" name="boxroulefile" value="Roulait dans le même sens et sur une file différente" /> Roulait dans le même sens et sur une file différente </p>
          <p><input type="checkbox" id="boxchangefile" name="boxchangefile" value="changeait de file" /> Changeait de file </p>
          <p><input type="checkbox" id="boxdouble" name="boxdouble" value="doublait" /> Doublait </p>
          <p><input type="checkbox" id="boxdroite" name="boxdroite" value="virait à droite" /> Virait à droite </p>
          <p><input type="checkbox" id="boxgauche" name="boxgauche" value="virait à gauche" /> Virait à gauche </p>
          <p><input type="checkbox" id="boxrecul" name="boxrecul" value="reculait" /> Reculait </p>
          <p><input type="checkbox" id="boxempiete" name="boxempiete" value="empiétait sur une voie réservée à la circulation inverse" /> Empiétait sur une voie réservée à la circulation inverse </p>
          <p><input type="checkbox" id="boxdroitecarrefour" name="boxdroitecarrefour" value="venait de droite (dans un carrefour)" /> Venait de droite (dans un carrefour) </p>
          <p><input type="checkbox" id="boxprio" name="boxprio" value="n'avait pas observé un signal de priorité ou un feu rouge" /> N'avait pas observé un signal de priorité ou un feu rouge </p>

          </br>
          <p><input type="checkbox" id="ok" name="ok" value="ok" required/>Je suis d'accord avec tout ce qui est marqué.</p>
          </br>
          <input type="submit" value="Suivant" style="margin-bottom:20px;"/>
          </form>
        </div>


    </body>
</html>

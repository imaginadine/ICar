<?php
    session_start();
    //on vérifie que l'utilisateur est connecté, et que c'est un assuré
    if (!isset($_SESSION['identifiant'])|| ($_SESSION['profil']!="assure")){
        header('Location: ../pageConnexion.php');
        exit();
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
    <title>I-Car</title>
    <meta name="Amandine" lang="fr" content="menu assuré"/>
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

      <h1 class="titre">Déclaration de sinistre</h1>

      <div class="affichage">
        <p>A remplir après un sinistre, et à transmettre dans les cinq jours à votre assureur.</p>

        <form class="form" id="sinistre1" name="sinistre1" method="POST" action="enregistrerSinistre.php">
        <h3>1. Assuré</h3>
        <?php
            echo '<p>Nom : <input type="text" id="nomConducteur" name="nomConducteur" value="'.$_SESSION['nom'].'"/></p>';
            echo '<p>Téléphone : <input type="text" id="telConducteur" name="telConducteur" value="'.$_SESSION['tel'].'"/></p>';
            echo '<p>E-mail : <input type="text" id="mailConducteur" name="mailConducteur" value="'.$_SESSION['mail'].'"/></p>';
        ?>
        <p>Profession : <input type="text" id="professionAssure" name="professionAssure" required/></p>

        <h3>2. Conducteur du véhicule</h3>
        <p>Profession : <input type="text" id="professionConducteur" name="professionConducteur" required/></p>
        <p>Est-il : <input type="radio" id="celibataire" name="situation" value="celibataire" /> Célibataire <input type="radio" id="marie" name="situation" value="marie" /> Marié <input type="radio" id="autre" name="situation" value="autre" /> Autre </p>
        <p>Est-il le conducteur habituel du véhicule ? <input type="radio" id="non1" name="habituel" value="non" /> Non <input type="radio" id="oui1" name="habituel" value="oui" /> Oui </p>
        <p>Réside-t-il habituellement chez l'assuré ? <input type="radio" id="non2" name="reside" value="non" /> Non <input type="radio" id="oui2" name="reside" value="oui" /> Oui </p>
        <p>Est-il salarié de l'assuré ? <input type="radio" id="non3" name="salarie" value="non" /> Non <input type="radio" id="oui3" name="salarie" value="oui" /> Oui </p>
        <p>Si non à quel titre conduisait-il ? <input type="text" id="titre" name="titre"/></p>
        <p>Motif du déplacement <input type="text" id="motifDeplacement" name="motifDeplacement" required/></p>

        <h3>3. Ciconstances de l'accident</h3>
        <p>A préciser dans tous les cas même si un procès-verbal ou un rapport de police a été établi.</p>
        <p><input type="text" id="circonstances" name="circonstances" size="100" required/></p>

        <h3>4. A-t-il été établi :</h3>
        <p>Un procès verbal de gendarmerie : <input type="radio" id="non4" name="proces-verbal" value="non" /> Non <input type="radio" id="oui4" name="proces-verbal" value="oui" /> Oui </p>
        <p>Un rapport de police : <input type="radio" id="non5" name="rapportPolice" value="non" /> Non <input type="radio" id="oui5" name="rapportPolice" value="oui" /> Oui </p>
        <p>Une main-courante : <input type="radio" id="non6" name="main-courante" value="non" /> Non <input type="radio" id="oui6" name="main-courante" value="oui" /> Oui </p>
        <p>Si oui : Brigade ou commissariat de <input type="text" id="commissariat" name="commissariat"/></p>

        <h3>5. Véhicule assuré</h3>
        <p>Lieu habituel de garage : <input type="text" id="lieuGarage" name="lieuGarage" required/></p>
        <h4>Expertise des dégâts</h4>
        <p>Réparateur chez qui le véhicule sera visible : <input type="text" id="reparateur" name="reparateur" size="50"/></p>
        <p>Téléphone : <input type="text" id="telReparateur" name="telReparateur" /></p>
        <p>Fax : <input type="text" id="faxReparateur" name="faxReparateur" /></p>
        <p>E-mail : <input type="text" id="mailReparateur" name="mailReparateur" /></p>
        <p>Quand ? <input type="date" id="quandReparateur" name="quandReparateur"/></p>
        <p>Eventuellement téléphoner à : <input type="text" id="telReparateur2" name="telReparateur2" /></p>
        <h4>Si le véhicule...</h4>
        <p>...a été volé, indiquer son numéro dans la série du type (voir carte grise) : <input type="text" id="numVehiculeVole" name="numVehiculeVole" /></p>
        <p>...est gagé ou fait l'objet d'un contrat de location (ou crédit-bail) :</p>
        <p>Nom de l'oganisme concerné : <input type="text" id="nomLocation" name="nomLocation" /></p>
        <p>Adresse de l'organisme concerné : <input type="text" id="adresseLocation" name="adresseLocation" /></p>
        <p>...est un poids lourd : poids total en charge <input type="text" id="poidsLourd" name="poidsLourd" /></p>
        <p>...est attelé à un autre véhicule (tractant ou remorqué) au moment de l'accident, indiquer le poids en charge : <input type="text" id="poidsRemorque" name="poidsRemorque" /></p>
        <p>Nom de la société qui l'assure : <input type="text" id="societeRemorque" name="societeRemorque" /></p>
        <p>Numéro de contrat dans la société : <input type="text" id="contratRemorque" name="contratRemorque" /></p>

        <h3>6. Dégâts matériels autres qu'aux deux principaux véhicules</h3>
        <p>Nature : <input type="text" id="natureDegatAutre" name="natureDegatAutre" /></p>
        <p>Importance : <input type="radio" id="faible" name="importanceAutre" value="faible" /> Faible <input type="radio" id="moyenne" name="importanceAutre" value="moyenne" /> Moyenne <input type="radio" id="forte" name="importanceAutre" value="forte" /> Forte</p>
        <p>Nom propriétaire : <input type="text" id="nomAutre" name="nomAutre" /></p>
        <p>Adresse propriétaire : <input type="text" id="adresseAutre" name="adresseAutre" /></p>

        <h3>7. Blessés</h3>
        <p>Nombre de blessés : <input type="number" id="nbBlesses" name="nbBlesses" min="0" required/></p>

        <input type="submit" value="Valider" style="margin-bottom:20px;"/>
        </form>
      </div>

    </body>
</html>

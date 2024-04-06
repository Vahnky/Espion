<?php
//On vérifie si le $_SESSION[nom] existe, il se trouve après la vérification login MDP dans connexion.php et si non on est redirigé vers connexion.php
session_start();
if (!isset($_SESSION['nom'])) {
    header('Location: connexion.php');
    exit();
}


echo "Bienvenue" . " " . $_SESSION['nom'];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin</title>
</head>
<body>
    <h1>Admins</h1>




    <!-- /////////////////////////////////////////////CREATION CIBLE -->
<div class="fstyle">
        <h2>Formulaire de création de la cible</h2>

        <form action="admin.php" method="post">

        <label for="Contact">Nom de la Cible :</label>
        <input type="text" id="NomCible" name="NomCible" required><br>

        <label for="Contact">Prénom de la Cible :</label>
        <input type="text" id="PrenomCible" name="PrenomCible" required><br>

        <label for="DateFin">Date de naissance :</label>
        <input type="date" id="DateNaissance" name="DateNaissance" required><br>

        <label for="Contact">Nom de Code de la Cible :</label>
        <input type="text" id="NomCode" name="NomCode" required><br>

        <label for="Contact">Nationalité de la cible :</label>
        <input type="text" id="NatCible" name="NatCible" required><br>


        <input class="dd" type="submit" value="Créer" name="EnregistrerCible">
</form>
</div>

<!-- ///////////////////////////PHP CREATION CIBLE -->

        <?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['EnregistrerCible'])) {

    require_once 'pdo.php'; 



try {



    // Prépare et exécute la requête SQL
    $sql = "INSERT INTO Cibles (Nom, Prenom, DateNaissance, NomDeCode, Nationalite) 
                           VALUES (:nom, :prenom, :dateNaissance, :nomCode, :nationalite)";

    $stmt = $conn->prepare($sql);                       

    $stmt->bindParam(':nom', $_POST['NomCible']);
    $stmt->bindParam(':prenom', $_POST['PrenomCible']);
    $stmt->bindParam(':dateNaissance', $_POST['DateNaissance']);
    $stmt->bindParam(':nomCode', $_POST['NomCode']);
    $stmt->bindParam(':nationalite', $_POST['NatCible']);
    $stmt->execute();

    // Affiche un message de succès
    echo "Données insérées avec succès !";
} catch (PDOException $e) {
    // Gère les erreurs de connexion à la base de données
    echo "Erreur : " . $e->getMessage();
}

finally{
$conn = null;}
}

?>


  <!-- /////////////////////////////////////////////UPDATE  CIBLE -->

  <!-- ////////////////////////////////////UPDATE NOM CIBLE -->

  <div class="fstyle">

  <h2>Changement Valeurs de cible. Renseignez l'id, laissez vide les champs que vous ne voulez pas modifier, les anciennes valeurs seront conservées.</h2>

<form action="admin.php" method="post">

<label for="Contact">Id de la Cible à changer:</label>
<input type="number" id="IdCible" name="CibleID" required><br>

<label for="Contact">Nom de la Cible :</label>
<input type="text" id="NomCible" name="NomCible"><br>

<label for="prenom">Prénom :</label>
<input type="text" id="prenom" name="prenom"><br>

<label for="dateNaissance">Date de naissance :</label>
<input type="date" id="dateNaissance" name="dateNaissance"><br>

<label for="nomDeCode">Nom de code :</label>
<input type="text" id="nomDeCode" name="nomDeCode"><br>

<label for="nationalite">Nationalité :</label>
<input type="text" id="nationalite" name="nationalite"><br>

<input type="submit" class="dd" value="Modifier" name="ChangerCible">

</form>

</div>
<!-- /////////////////////////////PHP UPDATE CIBLE -->
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ChangerCible'])) {

    require_once 'pdo.php'; 

try {



// ///////////////////On récupère les anciennes valeurs si champs vides
$sql_select = "SELECT Nom, Prenom, DateNaissance, NomDeCode, Nationalite FROM Cibles WHERE CibleID = :CibleID";
        $stmt_select = $conn->prepare($sql_select);
        $stmt_select->bindParam(':CibleID', $_POST['CibleID']);
        $stmt_select->execute();
        $row = $stmt_select->fetch(PDO::FETCH_ASSOC);


        $nom = empty($_POST['NomCible']) ? $row['Nom'] : $_POST['NomCible'];
        $prenom = empty($_POST['prenom']) ? $row['Prenom'] : $_POST['prenom'];
        $DateNaissance = empty($_POST['dateNaissance']) ? $row['DateNaissance'] : $_POST['dateNaissance'];
        $NomDeCode = empty($_POST['nomDeCode']) ? $row['NomDeCode'] : $_POST['nomDeCode'];
        $Nationalite = empty($_POST['nationalite']) ? $row['Nationalite'] : $_POST['nationalite'];




$sql = "UPDATE Cibles
SET Nom = :nom, 
    Prenom = :prenom, 
    DateNaissance = :dateNaissance, 
    NomDeCode = :nomDeCode, 
    Nationalite = :nationalite
WHERE CibleID = :CibleID";


$stmt = $conn->prepare($sql);


$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':prenom', $prenom);
$stmt->bindParam(':dateNaissance', $DateNaissance);
$stmt->bindParam(':nomDeCode', $NomDeCode);
$stmt->bindParam(':nationalite', $Nationalite);
$stmt->bindParam(':CibleID', $_POST['CibleID']);


$stmt->execute();

} catch (PDOException $e) {
echo "Erreur lors de la mise à jour : " . $e->getMessage();
}
}
$conn = null;
?>



  <!-- /////////////////////////////////////////////DELETE CIBLE -->

  <div class="fstyle">
  <h2>Formulaire de suppression la cible</h2>

<form action="admin.php" method="post">

<label for="Contact">Id de la Cible à supprimer:</label>
<input type="number" id="IdCible" name="IdCible" required><br>

<input type="submit" class="dd" value="Supprimer" name="SupprCible">

</form>
</div>
<!-- //////////////////////////////////////PHP DELETE CIBLE -->
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SupprCible'])) {

    require_once 'pdo.php'; 

try {







    $sql = "DELETE FROM Cibles WHERE CibleID = :cibleID";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cibleID', $_POST['IdCible']);
    $stmt->execute();
    echo "Données supprimées avec succès !";
} catch (PDOException $e) {
    echo "Erreur lors de la suppression : " . $e->getMessage();
}
}

$conn = null;
?>



<!-- //////////////////////////////INSERT CONTACT -->

<div class="fstyle">

<h2>Ajouter un nouveau contact</h2>

    <form action="admin.php" method="post">


        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="dateNaissance">Date de naissance :</label>
        <input type="date" id="dateNaissance" name="dateNaissance" required><br>

        <label for="nomDeCode">Nom de code :</label>
        <input type="text" id="nomDeCode" name="nomDeCode" required><br>

        <label for="nationalite">Nationalité :</label>
        <input type="text" id="nationalite" name="nationalite" required><br>

        <input type="submit" class="dd" value="Créer" name="NouveauContact">
    </form>

</div>

<!-- //////////////////////////////////////PHP INSERT CONTACT -->

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['NouveauContact'])) {

    require_once 'pdo.php'; 

try {




    $sql = "INSERT INTO Contacts (Nom, Prenom, DateNaissance, NomDeCode, Nationalite)
            VALUES (:nom, :prenom, :dateNaissance, :nomDeCode, :nationalite)";


    $stmt = $conn->prepare($sql);


    $stmt->bindParam(':nom', $_POST['nom']);
    $stmt->bindParam(':prenom', $_POST['prenom']);
    $stmt->bindParam(':dateNaissance', $_POST['dateNaissance']);
    $stmt->bindParam(':nomDeCode', $_POST['nomDeCode']);
    $stmt->bindParam(':nationalite', $_POST['nationalite']);


    $stmt->execute();

    echo "Nouvel enregistrement ajouté avec succès !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}


$conn = null;
}
?>



<!-- ///////////////////////////////UPDATE CONTACT -->
<div class="fstyle">

<h2>Modifier un contact, renseignez l'id, laissez vide les champs que vous ne voulez pas modifier, les anciennes valeurs seront conservées</h2>

    <form action="admin.php" method="post">

        <label for="Contact">Id du Contact à changer:</label>
        <input type="number" id="ContactID" name="ContactID" required><br>


        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom"><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom"><br>

        <label for="dateNaissance">Date de naissance :</label>
        <input type="date" id="dateNaissance" name="dateNaissance"><br>

        <label for="nomDeCode">Nom de code :</label>
        <input type="text" id="nomDeCode" name="nomDeCode"><br>

        <label for="nationalite">Nationalité :</label>
        <input type="text" id="nationalite" name="nationalite"><br>

        <input type="submit" class="dd" value="Modifier" name="ModifierContact">
    </form>

</div>

<!-- //////////////////////////////////////PHP UPDATE CONTACT -->

    <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ModifierContact'])) {

    require_once 'pdo.php'; 

try {




    $sql_select = "SELECT Nom, Prenom, DateNaissance, NomDeCode, Nationalite FROM Contacts WHERE ContactID = :ContactID";
        $stmt_select = $conn->prepare($sql_select);
        $stmt_select->bindParam(':ContactID', $_POST['ContactID']);
        $stmt_select->execute();
        $row = $stmt_select->fetch(PDO::FETCH_ASSOC);


        $nom = empty($_POST['nom']) ? $row['Nom'] : $_POST['nom'];
        $prenom = empty($_POST['prenom']) ? $row['Prenom'] : $_POST['prenom'];
        $DateNaissance = empty($_POST['dateNaissance']) ? $row['DateNaissance'] : $_POST['dateNaissance'];
        $NomDeCode = empty($_POST['nomDeCode']) ? $row['NomDeCode'] : $_POST['nomDeCode'];
        $Nationalite = empty($_POST['nationalite']) ? $row['Nationalite'] : $_POST['nationalite'];





    $sql = "UPDATE Contacts
                SET Nom = :nom,  
                    Prenom = :prenom, 
                    DateNaissance = :dateNaissance, 
                    NomDeCode = :nomDeCode, 
                    Nationalite = :nationalite 
                WHERE ContactID = :ContactID";


    $stmt = $conn->prepare($sql);


    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':dateNaissance', $DateNaissance);
    $stmt->bindParam(':nomDeCode', $NomDeCode);
    $stmt->bindParam(':nationalite', $Nationalite);
    $stmt->bindParam(':ContactID', $_POST['ContactID']);


    $stmt->execute();

    echo "Données du contact mises à jour avec succès !";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}


$conn = null;
}
?>

<!-- ////////////////////////////////DELETE CONTACT -->

<div class="fstyle">

<h2>Formulaire de suppression d'un contact</h2>

<form action="admin.php" method="post">

<label for="Contact">Id du Contact à supprimer:</label>
<input type="number" id="IdContact" name="IdContact" required><br>

<input type="submit" class="dd" value="Supprimer" name="SupprContact">
</form>

</div>
<!-- ///////////////////////////////////PHP DELETE CONTACT -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SupprContact'])) {

    require_once 'pdo.php'; 

try {




    $idContact = $_POST['IdContact'];


    $sql = "DELETE FROM Contacts WHERE ContactID = :idContact";


    $stmt = $conn->prepare($sql);


    $stmt->bindParam(':idContact', $idContact);


    $stmt->execute();

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}


$conn = null;




}

?>


<!-- /////////////////////////INSERT NOUVELLE PLANQUE -->

<div class="fstyle">

<h2>Ajouter une nouvelle planque</h2>

<form action="admin.php" method="POST">
    <label for="code">Code :</label>
    <input type="text" id="code" name="code" required><br>

    <label for="adresse">Adresse :</label>
    <input type="text" id="adresse" name="adresse" required><br>

    <label for="pays">Pays :</label>
    <input type="text" id="pays" name="pays" required><br>

    <label for="type">Type :</label>
    <input type="text" id="type" name="type" required><br>

    <input type="submit" class="dd" value="Créer" name="NewPlanque">
</form>

</div>

<!-- ///////////////////////PHP INSERT NOUVELLE PLANQUE -->

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['NewPlanque'])) {

    require_once 'pdo.php'; 

    try {
    



        $sql = "INSERT INTO Planques (Code, Adresse, Pays, Type) VALUES (:code, :adresse, :pays, :type)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':code', $_POST['code']);
    $stmt->bindParam(':adresse', $_POST['adresse']);
    $stmt->bindParam(':pays', $_POST['pays']);
    $stmt->bindParam(':type', $_POST['type']);


    $stmt->execute();

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;


}
?>

<!-- ////////////////////////UPDATE PLANQUE -->

<div class="fstyle">

<h2>Modifier la planque, En renseignant l'id. Laissez vide les champs pour conserver les anciennes valeurs</h2>
<form action="admin.php" method="POST">


    <label for="Contact">Id de la planque à changer:</label>
    <input type="number" id="PlanqueID" name="PlanqueID" required><br>
    
    <label for="code">Code :</label>
    <input type="text" id="Code" name="Code"><br>

    <label for="adresse">Adresse :</label>
    <input type="text" id="Adresse" name="Adresse"><br>

    <label for="pays">Pays :</label>
    <input type="text" id="Pays" name="Pays"><br>

    <label for="type">Type :</label>
    <input type="text" id="Type" name="Type"><br>

    <input type="submit" class="dd" value="Modifier" name="ChangePlanque">
</form>
</div>
<!-- //////////////////////////////////////PHP UPDATE PLANQUE -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ChangePlanque'])) {

    require_once 'pdo.php'; 
    
    try {
    



        $sql_select = "SELECT Code, Adresse, Pays, Type FROM Planques WHERE PlanqueID = :PlanqueID";
        $stmt_select = $conn->prepare($sql_select);
        $stmt_select->bindParam(':PlanqueID', $_POST['PlanqueID']);
        $stmt_select->execute();
        $row = $stmt_select->fetch(PDO::FETCH_ASSOC);

        $Code = empty($_POST['Code']) ? $row['Code'] : $_POST['Code'];
        $Adresse = empty($_POST['Adresse']) ? $row['Adresse'] : $_POST['Adresse'];
        $Pays = empty($_POST['Pays']) ? $row['Pays'] : $_POST['Pays'];
        $Type = empty($_POST['Type']) ? $row['Type'] : $_POST['Type'];

        $sql = "UPDATE Planques SET Code = :Code, Adresse = :Adresse, Pays = :Pays, Type = :Type
                WHERE PlanqueID = :PlanqueID";

        $stmt = $conn->prepare($sql);
    

        $stmt->bindParam(':PlanqueID', $_POST['PlanqueID']);
        $stmt->bindParam(':Code', $Code);
        $stmt->bindParam(':Adresse', $Adresse);
        $stmt->bindParam(':Pays', $Pays);
        $stmt->bindParam(':Type', $Type);
    

        $stmt->execute();
    
        echo "Données mises à jour avec succès !";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

$conn=null;
}
    ?>


<!-- ///////////////////////////////////////DELETE PLANQUE -->

<div class="fstyle">
<h2>Formulaire de suppression d'une planque</h2>

<form action="admin.php" method="post">

<label for="Contact">Id de la planque:</label>
<input type="number" id="PlanqueID" name="PlanqueID" required><br>

<input type="submit" class="dd" value="Supprimer" name="SupprPlanque">

</form>
</div>
<!-- /////////////////////////////PHP DELETE PLANQUE -->

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SupprPlanque'])) {

    require_once 'pdo.php'; 

try {



    $sql = "DELETE FROM Planques WHERE PlanqueID = :PlanqueID";
    $stmt = $conn->prepare($sql);


    $stmt->bindParam(':PlanqueID', $_POST['PlanqueID']);

    $stmt->execute();

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

}

$conn=null;

?>

<!-- ///////////////////////////////INSERT AGENTS -->
<div class="fstyle">

<h2>Formulaire pour créer les agents</h2>

    <form action="admin.php" method="POST">

        <label for="nom">Nom :</label>
        <input type="text" id="Nom" name="Nom" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="dateNaissance">Date de naissance :</label>
        <input type="date" id="dateNaissance" name="dateNaissance" required><br>

        <label for="codeIdentification">Code d'identification :</label>
        <input type="text" id="codeIdentification" name="CodeIdentification" required><br>

        <label for="nationalite">Nationalité :</label>
        <input type="text" id="nationalite" name="nationalite" required><br>

        <label for="specialite">Spécialité :</label>
        <input type="text" id="specialite" name="specialite" required><br>

        <input type="submit" class="dd" value="Créer" name="CreerAgent">

    </form>

</div>
    
<!-- ////////////////////////////PHP INSERT AGENTS -->
    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CreerAgent'])) {

    require_once 'pdo.php'; 
    
    try {
    


        


        $sql = "INSERT INTO Agents (Nom, Prenom, DateNaissance, CodeIdentification, Nationalite, Specialite)
                VALUES (:Nom, :prenom, :dateNaissance, :CodeIdentification, :nationalite, :specialite)";



$stmt = $conn->prepare($sql);


$stmt->bindParam(':Nom', $_POST['Nom']);
$stmt->bindParam(':prenom', $_POST['prenom']);
$stmt->bindParam(':dateNaissance', $_POST['dateNaissance']);
$stmt->bindParam(':CodeIdentification', $_POST['CodeIdentification']);
$stmt->bindParam(':nationalite', $_POST['nationalite']);
$stmt->bindParam(':specialite', $_POST['specialite']);

$stmt->execute();
}catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
$conn=null;
}
?>




<!-- ////////////////////////////////UPDATE AGENTS -->
<div class="fstyle">
<h2>Formulaire pour modifier les données des agents, laissez vide les champs que vous ne voulez pas modifier, les anciennes valeurs seront conservées</h2>

    <form action="admin.php" method="POST">

        <label for="Contact">Id de l'agent à changer:</label>
        <input type="number" id="AgentID" name="AgentID" required><br>

        <label for="nom">Nom :</label>
        <input type="text" id="Nom" name="Nom"><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="Prenom" name="Prenom"><br>

        <label for="dateNaissance">Date de naissance :</label>
        <input type="date" id="DateNaissance" name="DateNaissance"><br>

        <label for="codeIdentification">Code d'identification :</label>
        <input type="text" id="CodeIdentification" name="CodeIdentification"><br>

        <label for="nationalite">Nationalité :</label>
        <input type="text" id="Nationalite" name="Nationalite"><br>

        <label for="specialite">Spécialité :</label>
        <input type="text" id="specialite" name="Specialite"><br>

        <input type="submit" class="dd" value="Créer" name="ModifAgent">

    </form>
</div>

<!-- /////////////////////PHP UPDATE AGENTS -->

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ModifAgent'])) {
    
    require_once 'pdo.php'; 

try {



    $sql_select = "SELECT Nom, Prenom, DateNaissance, CodeIdentification, Nationalite, Specialite FROM Agents WHERE AgentID = :AgentID";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bindParam(':AgentID', $_POST['AgentID']);
    $stmt_select->execute();
    $row = $stmt_select->fetch(PDO::FETCH_ASSOC);

    $Nom = empty($_POST['Nom']) ? $row['Nom'] : $_POST['Nom'];
    $Prenom = empty($_POST['Prenom']) ? $row['Prenom'] : $_POST['Prenom'];
    $DateNaissance = empty($_POST['DateNaissance']) ? $row['DateNaissance'] : $_POST['DateNaissance'];
    $CodeIdentification = empty($_POST['CodeIdentification']) ? $row['CodeIdentification'] : $_POST['CodeIdentification'];
    $Nationalite = empty($_POST['Nationalite']) ? $row['Nationalite'] : $_POST['Nationalite'];
    $Specialite = empty($_POST['Specialite']) ? $row['Specialite'] : $_POST['Specialite'];

    


$sql = "UPDATE Agents SET Nom=:Nom, Prenom=:Prenom, DateNaissance=:DateNaissance, CodeIdentification=:CodeIdentification, Nationalite=:Nationalite, Specialite=:Specialite
        WHERE AgentID=:AgentID";


$stmt = $conn->prepare($sql);


$stmt->bindParam(':AgentID', $_POST['AgentID']);
$stmt->bindParam(':Nom', $Nom);
$stmt->bindParam(':Prenom', $Prenom);
$stmt->bindParam(':DateNaissance', $DateNaissance);
$stmt->bindParam(':CodeIdentification', $CodeIdentification);
$stmt->bindParam(':Nationalite', $Nationalite);
$stmt->bindParam(':Specialite', $Specialite);


$stmt->execute();





}catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
$conn=null;
}
?>

<!-- ///////////////////////////////FORMULAIRE DELETE AGENTS -->
<div class="fstyle">
<h2>Formulaire de suppression d'un agent</h2>

<form action="admin.php" method="post">

<label for="Contact">Id de l'agent:</label>
<input type="number" id="IdAgent" name="IdAgent" required><br>

<input type="submit" class="dd" value="Supprimer" name="SupprAgent">

</form>
</div>
<!-- ///////////////////////////////////////PHP DELETE AGENTS -->
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprAgent'])) {

    require_once 'pdo.php'; 

try {




$sql = "DELETE FROM Agents WHERE AgentID = :idAgent";

$stmt = $conn->prepare($sql);


$stmt->bindParam(':idAgent', $_POST['IdAgent']);

$stmt->execute();



}catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
$conn=null;
}
?>


<!-- ///////////////////FORMULAIRE INSERT ADMINS -->
<div class="fstyle">

<h2>Ajouter un nouvel administrateur</h2>

    <form action="admin.php" method="POST">

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="pass">Mot de passe :</label>
        <input type="password" id="pass" name="pass" required><br>

        <label for="adresseMail">Adresse e-mail :</label>
        <input type="email" id="adresseMail" name="adresseMail" required><br>

        <label for="dateCreation">Date de création :</label>
        <input type="date" id="dateCreation" name="dateCreation" required><br>

        <input type="submit" class="dd" value="Créer" name="CréerAdmin">
    </form>
</div>

    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['CréerAdmin'])) {

require_once 'pdo.php'; 

try {





    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $adresseMail = $_POST['adresseMail'];
    $dateCreation = $_POST['dateCreation'];


    $sql = 'INSERT INTO Admins (Nom, Prenom, Pass, AdresseMail, DateCreation)
            VALUES (:nom, :prenom, :pass, :adresseMail, :dateCreation)';

    $statement = $conn->prepare($sql);

    $statement->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':pass' => $pass,
        ':adresseMail' => $adresseMail,
        ':dateCreation' => $dateCreation
    ]);

} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
$conn=null;
}
?>

<!-- ////////////////////////////////UPDATE ADMINS -->

<div class="fstyle">

<h2>Modifier un administrateur, laissez vide les champs que vous ne voulez pas modifier, les anciennes valeurs seront conservées</h2>

    <form action="admin.php" method="POST">

        <label for="Contact">Id de l'admin à modifier:</label>
        <input type="number" id="AdminID" name="AdminID" required><br>

        <label for="nom">Nom :</label>
        <input type="text" id="Nom" name="Nom"><br>

        <label for="prenom">Prénom :</label>
        <input type="text" id="Prenom" name="Prenom"><br>

        <label for="adresseMail">Adresse e-mail :</label>
        <input type="email" id="AdresseMail" name="AdresseMail"><br>

        <label for="dateCreation">Date de création :</label>
        <input type="date" id="DateCreation" name="DateCreation" ><br>

        <label for="Pass">Pass :</label>
        <input type="password" id="Pass" name="Pass" ><br>

        <input type="submit" class="dd" value="Modifier" name="ModifAdmin">
    </form>
</div>

    <!-- ////////////////////////////////////PHP UPDATE ADMINS -->


    <?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ModifAdmin'])) {

    require_once 'pdo.php'; 
    
    try {
    



        $sql_select = "SELECT Nom, Prenom, AdresseMail, DateCreation, Nationalite, Specialite, Pass FROM Admins WHERE AdminID = :AdminID";
        $stmt_select = $conn->prepare($sql_select);
        $stmt_select->bindParam(':AdminID', $_POST['AdminID']);
        $stmt_select->execute();
        $row = $stmt_select->fetch(PDO::FETCH_ASSOC);
    
        $Nom = empty($_POST['Nom']) ? $row['Nom'] : $_POST['Nom'];
        $Prenom = empty($_POST['Prenom']) ? $row['Prenom'] : $_POST['Prenom'];
        $AdresseMail = empty($_POST['AdresseMail']) ? $row['AdresseMail'] : $_POST['AdresseMail'];
        $DateCreation = empty($_POST['DateCreation']) ? $row['DateCreation'] : $_POST['DateCreation'];
        $Nationalite = empty($_POST['Nationalite']) ? $row['Nationalite'] : $_POST['Nationalite'];
        $Specialite = empty($_POST['Specialite']) ? $row['Specialite'] : $_POST['Specialite'];
        $Pass = empty($_POST['Pass']) ? $row['Pass'] : password_hash($_POST['Pass'], PASSWORD_DEFAULT);


    $sql = 'UPDATE Admins
            SET Nom = :Nom, Prenom = :Prenom, AdresseMail = :AdresseMail, DateCreation = :DateCreation, Pass = :Pass
            WHERE AdminID = :AdminID';




    $statement = $conn->prepare($sql);

    $statement->execute([
        ':AdminID' => $AdminID,
        ':Nom' => $Nom,
        ':Prenom' => $Prenom,
        ':AdresseMail' => $AdresseMail,
        ':DateCreation' => $DateCreation,
        ':Pass' => $Pass
    ]);

} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
$conn=null;
}
?>

<!-- ////////////////////////FORMULAIRE DELETE ADMIN -->
<div class="fstyle">

<h2>Formulaire de suppression d'un admin</h2>

<form action="admin.php" method="post">

<label for="Contact">Id de l'admin:</label>
<input type="number" id="IdAdmin" name="IdAdmin" required><br>

<input type="submit" class="dd" value="Supprimer" name="SupprAdmin">

</form>
</div>

<!-- //////////////////////////////PHP DELETE ADMIN -->


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SupprAdmin'])) {

    require_once 'pdo.php'; 

try {


    $sql = "DELETE FROM Admins WHERE AdminID = :AdminID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':AdminID', $_POST['IdAdmin']);
    $stmt->execute();

}catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
$conn=null;
}
?>




<div class="fstyle">

<h2>Formulaire de création de mission</h2>

<p>Vous pouvez ajouter plusieurs agents, cibles et contacts, séparez les par un espace</p>


<form action="admin.php" method="post">
    <label for="titre">Titre :</label>
    <input type="text" id="titre" name="titre" required><br>

    <label for="description">Description :</label>
    <input type="text" id="description" name="description"required><br>

    <label for="nomDeCode">Nom de Code :</label>
    <input type="text" id="nomDeCode" name="nomDeCode" required><br>

    <label for="pays">Pays :</label>
    <input type="text" id="pays" name="pays" required><br>

    <label for="Agent">Nom de l'Agent :</label>
    <input type="text" id="NomAgent" name="NomAgent" required><br>

    <label for="Contact">Nom du Contact :</label>
    <input type="text" id="NomContact" name="NomContact" required><br>

    <label for="Contact">Nom de la Cible :</label>
    <input type="text" id="NomCible" name="NomCible" required><br>

    <label for="Type">Type de mission (Surveillance, Assassinat, Infiltration …) :</label>
    <input type="text" id="Type" name="Type" required><br>

    <label for="Statut">Statut (En cours, réussie, échec ...) :</label>
    <input type="text" id="Statut" name="Statut" required><br>

    <label for="Planque">Code de la planque :</label>
    <input type="number" id="Planque" name="Planque" required><br>

    <label for="specialiteRequise">Spécialité Requise :</label>
    <input type="text" id="specialiteRequise" name="specialiteRequise" required><br>

    <label for="dateDebut">Date de Début :</label>
    <input type="date" id="DateDebut" name="DateDebut" required><br>

    <label for="dateFin">Date de Fin :</label>
    <input type="date" id="DateFin" name="DateFin" required><br>

    

    <input type="submit" class="dd" value="Créer" name="EnregistrerMission">
</form>

</div>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['EnregistrerMission'])) {

    require_once 'pdo.php'; 

try {


    // ///////////////////////////////////////////////////////NATIONALITE CIBLES ET AGENTS INCOMPATBLE CONDITION 1

    // Toutes les nationalités des agents et cibles entrés dans le form :

    $cible_names = explode(" ", $_POST['NomCible']);
    $agent_names = explode(" ", $_POST['NomAgent']);

    foreach ($cible_names as $cible_name) {
        foreach ($agent_names as $agent_name) {
            $sqlCible = 'SELECT Nationalite FROM Cibles WHERE Nom = :NomCible';
            $stmtCible = $conn->prepare($sqlCible);
            $stmtCible->execute([':NomCible' => $cible_name]);
            $resultCible = $stmtCible->fetch(PDO::FETCH_ASSOC);

            $sqlAgent = 'SELECT Nationalite FROM Agents WHERE Nom = :NomAgent';
            $stmtAgent = $conn->prepare($sqlAgent);
            $stmtAgent->execute([':NomAgent' => $agent_name]);
            $resultAgent = $stmtAgent->fetch(PDO::FETCH_ASSOC);

    // Résolution de si les nationalités sont identiques
    if ($resultCible['Nationalite'] === $resultAgent['Nationalite']) {
        die("La nationalité de la cible '$cible_name' et de l'agent '$agent_name' ne peuvent pas être la même.");
    }
}


    // //////////////////////////////////////////////////Contacts ont la nationalité du pays de la mission CONDITION 2
    // Je pense que si les 3 premières lettres correspondent, alors c'est bon

// Nationalité du contact :
$sqlContact = 'SELECT Nationalite FROM Contacts WHERE Nom = :NomContact';
$stmtContact = $conn->prepare($sqlContact);
$stmtContact->execute([':NomContact' => $_POST['NomContact']]);
$resultContact = $stmtContact->fetch(PDO::FETCH_ASSOC);

// On divise la chaîne de contacts en un tableau
$contacts = explode(' ', $_POST['NomContact']);

// On vérif si chaque contact a la même nationalité que le pays de la mission
foreach ($contacts as $contact) {
    // Récupérez la nationalité du contact
    $sqlContact = 'SELECT Nationalite FROM Contacts WHERE Nom = :NomContact';
    $stmtContact = $conn->prepare($sqlContact);
    $stmtContact->execute([':NomContact' => $contact]);
    $resultContact = $stmtContact->fetch(PDO::FETCH_ASSOC);

    // On récupère les 3 premières lettres de la nationalité du contact puis du pays

    $nationaliteContact = substr($resultContact['Nationalite'], 0, 3);

    $paysMission = substr($_POST['pays'], 0, 3);


    // On vérifie si la nationalité du contact correspond au pays de la mission

        if ($nationaliteContact !== $paysMission) {
            die("Le contact doit avoir la nationalité du pays");
        }
    



    // ////////////////////////////////////////////// Sur une mission, la planque est obligatoirement dans le même pays que la mission CONDITION 3


    // Pays de la planque : 

    $sqlPlanque = 'SELECT Pays FROM Planques WHERE Code = :CodePlanque';
    $stmtPlanque = $conn->prepare($sqlPlanque);
    $stmtPlanque->execute([':CodePlanque' => $_POST['Planque']]);
    $resultPlanque = $stmtPlanque->fetch(PDO::FETCH_ASSOC);
    
    // Vérification du pays
    if($resultPlanque){
    if ($resultPlanque['Pays'] !== $_POST['pays']) {
        die("La planque doit être du même pays que la mission");
    }}
    


    // ////////////////////////////////////// Sur une mission, il faut assigner au moins 1 agent disposant de la spécialité requise  CONDITION 4

    // Spécialité requise
    $specialiteRequise = $_POST['specialiteRequise'];

    // Noms d'agents (séparés par des espaces)
    $nomsAgents = $_POST['NomAgent'];
    $agents = explode(' ', $nomsAgents);

    // Vérification pour chaque agent
    foreach ($agents as $nomAgent) {
    $sqlAgentSpé = 'SELECT Specialite FROM Agents WHERE Nom = :NomAgent';
    $stmtAgentSpé = $conn->prepare($sqlAgentSpé);
    $stmtAgentSpé->execute([':NomAgent' => $nomAgent]);
    $resultAgentSpé = $stmtAgentSpé->fetch(PDO::FETCH_ASSOC);

    if ($resultAgentSpé['Specialite'] === $specialiteRequise) {
        // Au moins un agent a la spécialité requise
        break;
    }
}

if ($resultAgentSpé['Specialite'] !== $specialiteRequise) {
    die("Aucun agent n'a la spécialité requise");
}

    $sql = 'INSERT INTO Missions (Titre, Description, NomDeCode, Pays, NomAgent, NomContact, NomCible, Type, Statut, CodePlanque, SpecialiteRequise, DateDebut, DateFin)
            VALUES (:titre, :description, :nomDeCode, :pays, :nomAgent, :nomContact, :nomCible, :type, :statut, :codePlanque, :specialiteRequise, :dateDebut, :dateFin)';
    $statement = $conn->prepare($sql);


    $params = [
        ':titre' => $_POST['titre'],
        ':description' => $_POST['description'],
        ':nomDeCode' => $_POST['nomDeCode'],
        ':pays' => $_POST['pays'],
        ':nomAgent' => $_POST['NomAgent'],
        ':nomContact' => $_POST['NomContact'],
        ':nomCible' => $_POST['NomCible'],
        ':type' => $_POST['Type'],
        ':statut' => $_POST['Statut'],
        ':codePlanque' => $_POST['Planque'],
        ':specialiteRequise' => $_POST['specialiteRequise'],
        ':dateDebut' => $_POST['DateDebut'],
        ':dateFin' => $_POST['DateFin'],
    ];


    $statement->execute($params);


}} }
Finally{
$conn=null;}
}

?>




<!-- //////////////SUPPRIMER MISSION -->

<div class="fstyle">


<h2>Formulaire de suppression d'une mission</h2>

<form action="admin.php" method="post">

<label for="Contact">Id de la mission:</label>
<input type="number" id="MissionID" name="MissionID" required><br>

<input type="submit" class="dd" value="Supprimer" name="SupprMission">

</form>

</div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SupprMission'])) {

    require_once 'pdo.php'; 

try {




$sql = "DELETE FROM Missions WHERE MissionID = :MissionID";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':MissionID', $_POST['MissionID']);
$stmt->execute();


}catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
$conn=null;
}
?>
<?php
//On démarre une session pour pouvoir bloquer les utilisateurs non connectés sur la page d'arrivée par la suite
 session_start();
// Variable en cas d'erreur d'authentification
$non="";




// Connexion à la base de données
$host = 'localhost';
$dbname = 'agence';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;", $username, $password);
 
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Envoyer'])) {
    if(isset($_POST['nom'])){$nom = htmlentities($_POST['nom']);}
    if(isset($_POST['pass'])){$pass = htmlentities($_POST['pass']);}


    // Requête préparée pour récupérer l'utilisateur
    $statement = $pdo->prepare('SELECT * FROM admins WHERE nom = :nom');
    $statement->bindValue(':nom', $nom);

    if ($statement->execute()) {
        $admins = $statement->fetch(PDO::FETCH_ASSOC);

if ($admins === false) {
    $non=1;
} else {
    // Vérification du mot de passe hash est pour le sha SQL et password_verify est pour le password_hash en PHP
    if ((hash('sha512', $pass) === $admins['Pass'])||(password_verify($pass, $admins['Pass']))) {
        $_SESSION['nom'] = $nom;
        header('Location: admin.php');
        exit();

    } else {
        $non=1;
    }
}

    } else {
        echo 'Impossible de récupérer l\'utilisateur.';
    }
}
?>



<!DOCTYPE html>
<!-- /////////////////////////////////////////////On lie cet html au fichier css, affiche le logo dans l'onglet et importe l'en tete -->
<title>KGB</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="img/logo.png"/>


<html>
    


<div class="co">
<br>
<h1>Formulaire de connexion pour les administrateurs et les agents</h1>
      <br>  

<!--/////////////////////////////////// FORMULAIRE POUR SE CONNECTER EN TANT QUE EMPLOYE OU ADMINISTRATEUR -->

        <form method="post" action="connexion.php">
            

                <label for=""><p class="index">Nom d'utilisateur : </p></label>
                <input type="text" id="nom" name="nom" required><br>



                <label for="password"><p class="index">Mot de passe : </p></label>
                <input type="password" id="pass" name="pass" required><br>


          
            
            <div class="c100" id="submit">
                <input type="submit" class="dd" value="Envoyer" name="Envoyer">
               

        </form>

        <?php

if ($non==1){
    echo "<p class='fcont'>Le login ou le password ne sont pas exacts</p>";
}

?>


<br><br>
</div></div>


           
    </body>
</html>

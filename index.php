<?php
require_once 'pdo.php'; 
try {

    $sql = "SELECT MissionID, Titre FROM Missions";
    $stmt = $conn->query($sql);

    if ($stmt === false) {
        die("Erreur lors de l'exécution de la requête.");
    }
    $conn = null;  
} catch (PDOException $e) {
    echo $e->getMessage();
}?>

<!DOCTYPE html>
<link rel="stylesheet" href="style.css">
<html>

<body>

    <h1>Bienvenue</h1>

    <div class="seco"><a href="connexion.php">Se connecter </a></div>
    <div class="fstyle">
    <h1>Liste des missions</h1>
    <ul>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
            <li>
                <a href="mission_details.php?mission_id=<?php echo htmlspecialchars($row['MissionID']); ?>">
                    <?php echo htmlspecialchars($row['Titre']); ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
        </div>
</body>
</html>

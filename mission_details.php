<?php
require_once 'pdo.php'; 
try {



    // Récup l'ID de mission depuis l'URL
    $mission_id = $_GET['mission_id'];

    // Prépare une requête SQL pour récupérer toutes les données de la mission sélectionnée
    $sql = "SELECT * FROM Missions WHERE MissionID = :mission_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':mission_id', $mission_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt === false) {
        die("Erreur lors de l'exécution de la requête.");
    }

    // Récup les données de la mission
    $mission_data = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn=null;
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<link rel="stylesheet" href="style.css">
<html>
<head>
    <title>Détails de la mission</title>
</head>
<body>
    <h1>Détails de la mission</h1>
    <ul>
        <?php foreach ($mission_data as $column => $value) : ?>
            <li>
                <p class="detail"><strong><?php echo htmlspecialchars($column); ?>:</strong>
                <?php echo htmlspecialchars($value); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

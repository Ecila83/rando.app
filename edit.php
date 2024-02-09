<?php
require_once("./db.inc.php");
$pdo = connect_db();

// Traitement de la modification d'une randonnée
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_form_submitted'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $difficulty = $_POST['difficulty'];
    $distance = $_POST['distance'];
    $duration = $_POST['duration'];
    $height = $_POST['height_difference'];

    // Préparez la requête de mise à jour
    $sql = "UPDATE hiking SET name = :name, difficulty = :difficulty, distance = :distance, duration = :duration, height_difference = :height_difference WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Liaison des valeurs
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':difficulty', $difficulty, PDO::PARAM_STR);
    $stmt->bindParam(':distance', $distance, PDO::PARAM_INT);
    $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
    $stmt->bindParam(':height_difference', $height, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Exécutez la requête de mise à jour
    if ($stmt->execute()) {
        // Rediriger vers read.php
        header("Location: read.php");
        exit(); // Assure que le script se termine ici pour éviter toute exécution supplémentaire
    } else {
        echo "Erreur lors de la modification de la randonnée.";
    }
}

// Récupérer l'identifiant de la randonnée à modifier depuis l'URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les données de la randonnée à modifier
    $stmt = $pdo->prepare("SELECT * FROM hiking WHERE id = ?");
    $stmt->execute([$id]);
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<form action="" method="post">
    <input type="hidden" name="id" value="<?= $record['id'] ?>">
    <div>
        <label for="name">Name</label>
        <input type="text" name="name" value="<?= $record['name'] ?>">
    </div>

    <div>
        <label for="difficulty">Difficulté</label>
        <select name="difficulty">
            <option value="très facile" <?= ($record['difficulty'] === 'très facile') ? 'selected' : '' ?>>Très facile</option>
            <option value="facile" <?= ($record['difficulty'] === 'facile') ? 'selected' : '' ?>>Facile</option>
            <option value="moyen" <?= ($record['difficulty'] === 'moyen') ? 'selected' : '' ?>>Moyen</option>
            <option value="difficile" <?= ($record['difficulty'] === 'difficile') ? 'selected' : '' ?>>Difficile</option>
            <option value="très difficile" <?= ($record['difficulty'] === 'très difficile') ? 'selected' : '' ?>>Très difficile</option>
        </select>
    </div>

    <div>
        <label for="distance">Distance</label>
        <input type="text" name="distance" value="<?= $record['distance'] ?>">
    </div>
    <div>
        <label for="duration">Durée</label>
        <input type="time" name="duration" value="<?= $record['duration'] ?>">
    </div>
    <div>
        <label for="height_difference">Dénivelé</label>
        <input type="text" name="height_difference" value="<?= $record['height_difference'] ?>">
    </div>
    <input type="hidden" name="edit_form_submitted" value="true">
    <button type="submit">Modifier</button>
</form>

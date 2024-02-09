<?php
require_once("./db.inc.php");
$pdo = connect_db();

// Vérifie si le formulaire a été soumis pour ajouter une randonnée
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    // Récupérer les données saisies dans le formulaire
    $name = $_POST['name'];
    $difficulty = $_POST['difficulty'];
    $distance = $_POST['distance'];
    $duration = $_POST['duration'];
    $height = $_POST['height_difference'];

    // Préparer la requête d'insertion
    $sql = "INSERT INTO hiking (name, difficulty, distance, duration, height_difference) VALUES (:name, :difficulty, :distance, :duration, :height_difference)";
    $stmt = $pdo->prepare($sql);

    // Liaison des valeurs
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':difficulty', $difficulty, PDO::PARAM_STR);
    $stmt->bindParam(':distance', $distance, PDO::PARAM_INT);
    $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
    $stmt->bindParam(':height_difference', $height, PDO::PARAM_INT);

    // Exécuter la requête d'insertion
    if ($stmt->execute()) {
        // Redirection vers read.php après l'ajout réussi
        header("Location: read.php");
        exit(); // Assure que le script se termine ici pour éviter toute exécution supplémentaire
    } else {
        echo "Erreur lors de l'ajout de la randonnée.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des randonnées</title>
</head>
<body>
    <h1>Liste des randonnées</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Difficulty</th>
                <th>Distance</th>
                <th>Duration</th>
                <th>Height Difference</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $stmt = $pdo->query("SELECT * FROM hiking");
            while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?= $record['name'] ?></td>
                    <td><?= $record['difficulty'] ?></td>
                    <td><?= $record['distance'] ?> Km</td>
                    <td><?= $record['duration'] ?> H</td>
                    <td><?= $record['height_difference'] ?> m</td>
                    <td>
                        <a href="edit.php?id=<?= $record['id'] ?>">Modifier</a>
                        <form action="delete.php" method="post" style="display: inline-block;">
                            <input type="hidden" name="id" value="<?= $record['id'] ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php 
            } 
            ?>
        </tbody>
    </table>

    <h1>Ajouter</h1>
    <form action="add.php" method="post">
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" value="">
        </div>

        <div>
            <label for="difficulty">Difficulté</label>
            <select name="difficulty">
                <option value="très facile">Très facile</option>
                <option value="facile">Facile</option>
                <option value="moyen">Moyen</option>
                <option value="difficile">Difficile</option>
                <option value="très difficile">Très difficile</option>
            </select>
        </div>

        <div>
            <label for="distance">Distance</label>
            <input type="text" name="distance" value="">
        </div>
        <div>
            <label for="duration">Durée</label>
            <input type="time" name="duration" value="">
        </div>
        <div>
            <label for="height_difference">Dénivelé</label>
            <input type="text" name="height_difference" value="">
        </div>
        <button type="submit" name="button">Envoyer</button>
    </form>
</body>
</html>



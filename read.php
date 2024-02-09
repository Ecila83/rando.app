<?php
require_once("./db.inc.php");
$pdo = connect_db();

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



<?php
require_once("./db.inc.php");
$pdo = connect_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Préparez la requête de suppression en utilisant l'ID de la randonnée
    $sql = "DELETE FROM hiking WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(["id" => $id])) {
        // Redirection vers read.php après la suppression réussie
        header("Location: read.php");
        exit(); // Assure que le script se termine ici pour éviter toute exécution supplémentaire
    } else {
        echo "Erreur lors de la suppression de la randonnée.";
    }
}
?>
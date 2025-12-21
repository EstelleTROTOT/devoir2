<?php
$serveur = "localhost";
$base = "base_test";
$utilisateur = "root";
$motdepasse = "";
$title = "Mon site";

try {
    $conn = new PDO("mysql:host=$serveur;dbname=$base;charset=utf8", $utilisateur, $motdepasse);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_produit = $_POST['nom_produit'];
    $description_produit = $_POST['description_produit'];
    $prix_produit = $_POST['prix_produit'];

    $sql = "INSERT INTO produits (nom_produit, description_produit, prix_produit) VALUES (:nom_produit, :description_produit, :prix_produit)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nom_produit', $nom_produit);
    $stmt->bindParam(':description_produit', $description_produit);
    $stmt->bindParam(':prix_produit', $prix_produit);

    try {
        $stmt->execute();
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "<script>alert('Erreur lors de l\'ajout du produit');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?> - Ajouter un produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Ajouter un produit</h1>
    <form method="post">
        <div class="mb-3">
            <label for="nom_produit" class="form-label">Nom du produit</label>
            <input type="text" name="nom_produit" id="nom_produit" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description_produit" class="form-label">Description</label>
            <textarea name="description_produit" id="description_produit" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="prix_produit" class="form-label">Prix (€)</label>
            <input type="number" step="0.01" name="prix_produit" id="prix_produit" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter le produit</button>
        <a href="index.php" class="btn btn-secondary">Retour</a>
    </form>
</div>
</body>
</html>

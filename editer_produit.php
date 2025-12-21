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
    die("Erreur de connexion : " . $e->getMessage());
}


if (!isset($_GET['id_produit'])) {
    echo "Aucun produit sélectionné";
    exit;
}

$id_produit = $_GET['id_produit'];

$sql = "SELECT * FROM produits WHERE id_produit = :id_produit";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);
$stmt->execute();
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    echo "Produit non trouvé";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_produit = $_POST['nom_produit'];
    $description_produit = $_POST['description_produit'];
    $prix_produit = $_POST['prix_produit'];

    $sqlUpdate = "UPDATE produits SET nom_produit = :nom_produit, description_produit = :description_produit, prix_produit = :prix_produit WHERE id_produit = :id_produit";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':nom_produit', $nom_produit);
    $stmtUpdate->bindParam(':description_produit', $description_produit);
    $stmtUpdate->bindParam(':prix_produit', $prix_produit);
    $stmtUpdate->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);

    try {
        $stmtUpdate->execute();
        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "<script>alert('Erreur lors de la mise à jour du produit');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?> - Éditer un produit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Éditer le produit</h1>
    <form method="post">
        <div class="mb-3">
            <label for="nom_produit" class="form-label">Nom du produit</label>
            <input type="text" name="nom_produit" id="nom_produit" class="form-control" value="<?= htmlspecialchars($produit['nom_produit']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description_produit" class="form-label">Description</label>
            <textarea name="description_produit" id="description_produit" class="form-control" required><?= htmlspecialchars($produit['description_produit']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="prix_produit" class="form-label">Prix (€)</label>
            <input type="number" step="0.01" name="prix_produit" id="prix_produit" class="form-control" value="<?= $produit['prix_produit'] ?>" required>
        </div>
        <button type="submit" class="btn btn-warning">Mettre à jour</button>
        <a href="details_produit.php?id_produit=<?= $produit['id_produit'] ?>" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>

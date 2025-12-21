<?php 
$serveur = "localhost";
$base = "base_test";
$utilisateur = "root";
$motdepasse = "";
$title = "Mon site";

try {
    $conn = new PDO("mysql:host=$serveur;dbname=$base;charset=utf8", $utilisateur, $motdepasse);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // set error mode to exception
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


if (isset($_GET['id_produit'])) {
    $id_produit = $_GET['id_produit'];

    $sql = "SELECT * FROM produits WHERE id_produit = :id_produit";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_produit', $id_produit, PDO::PARAM_INT); // bind the URL parameter
    $stmt->execute();

    $produit = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$produit) {
        echo "Produit non trouvé";
        exit;
    }
} else {
    echo "Aucun produit reçu";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?> - <?= $produit['nom_produit'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title"><?= $produit['nom_produit'] ?></h1>
            <p class="card-text"><?= $produit['description_produit'] ?></p>
            <p><strong>Prix : <?= $produit['prix_produit'] ?> €</strong></p>
            <a href="index.php" class="btn btn-secondary">Retour à la liste</a>
            <a href="supprimer_produit.php?id_produit=<?= $produit['id_produit'] ?>" class="btn btn-danger" 
onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?');">
Supprimer le produit
</a>
<a href="editer_produit.php?id_produit=<?= $produit['id_produit'] ?>" class="btn btn-warning">
    Éditer le produit
</a>


        </div>
    </div>
</div>
</body>
</html>

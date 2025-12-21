<?php

// Connexion à la base de données


// Variables PHP
$serveur = "localhost";
$base = "base_test";
$utilisateur = "root";
$motdepasse = "";
$title = "Mon site";

try {
    // Création de la connexion PDO
    $conn = new PDO("mysql:host=$serveur;dbname=$base;charset=utf8", $utilisateur, $motdepasse);
    // Définir le mode d'erreur PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}


// Requête SQL pour récupérer les produits

$sql = "SELECT * FROM produits";
$resultat = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Template HTML5 avec PHP">
    <!-- Lien Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Header -->
    <header class="bg-light py-3 mb-4">
        <div class="container">
            <h1 class="mb-0"><?= $title ?></h1>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link" href="#">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">À propos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main content -->
    <main class="container">

        <section class="mb-5">
            <h2>Bienvenue</h2>
            <p>Ceci est un template HTML5 de base intégré dans un fichier <strong>index.php</strong>.</p>
        </section>

        <section>
            <h2>Produits disponibles</h2>
            <a href="ajouter_produit.php" class="btn btn-success mb-3">Ajouter un produit</a>
            <div class="row">
                <?php foreach ($resultat as $produit) : ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= $produit['nom_produit'] ?></h5>
                                <p class="card-text"><?= $produit['description_produit'] ?></p>
                                <p class="card-text"><strong>Prix : <?= $produit['prix_produit'] ?> €</strong></p>
                                <a href="details_produit.php?id_produit=<?= $produit['id_produit'] ?>" class="btn btn-info">Détails du produit</a>


                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-light py-3 mt-5">
        <div class="container text-center">
            <p>&copy; <?= date("Y") ?> - Tous droits réservés</p>
        </div>
    </footer>

</body>
</html>

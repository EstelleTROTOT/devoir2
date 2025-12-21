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

if (isset($_GET['id_produit']) && !empty($_GET['id_produit'])) {
    $id_produit = intval($_GET['id_produit']); 

    $sql = "DELETE FROM produits WHERE id_produit = :id_produit";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_produit', $id_produit, PDO::PARAM_INT);

    try {
        $stmt->execute();
        
        echo "<!DOCTYPE html>
        <html lang='fr'>
        <head><meta charset='UTF-8'><title>Suppression</title></head>
        <body>
        <script>
            alert('Produit supprimé avec succès !');
            window.location.href = 'index.php';
        </script>
        </body>
        </html>";
        exit(); 
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }

} else {
    echo "<!DOCTYPE html>
    <html lang='fr'>
    <head><meta charset='UTF-8'><title>Erreur</title></head>
    <body>
        Aucun produit spécifié<br>
        <a href='index.php'>Retour à la liste</a>
    </body>
    </html>";
}
?>


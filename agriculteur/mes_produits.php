<?php
// Connexion à la base de données
$host = 'localhost';
$db   = 'hydroculture';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Récupérer les produits du catalogue
$stmt = $pdo->query('SELECT id, nom, description, prix, image FROM produits ORDER BY id DESC');
$produits = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Produits - Catalogue</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .produit-card img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .produit-card {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Mes Produits sur le Catalogue</h1>
    <?php if (count($produits) === 0): ?>
        <div class="alert alert-info">Aucun produit ajouté pour le moment.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($produits as $produit): ?>
                <div class="col-md-4 produit-card">
                    <div class="card h-100">
                        <?php if (!empty($produit['image'])): ?>
                            <img src="<?= htmlspecialchars($produit['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($produit['nom']) ?>">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/300x200?text=Pas+d'image" class="card-img-top" alt="Pas d'image">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($produit['description'])) ?></p>
                        </div>
                        <div class="card-footer">
                            <strong><?= number_format($produit['prix'], 2, ',', ' ') ?> €</strong>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
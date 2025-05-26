<?php
// /c:/wamp64/www/hydroculture_test/agriculteur/mes_ventes.php

session_start();
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "hydroculture";
$port = 3308;

try {
    $conn = new mysqli($host, $username, $password, $database, $port);
    $conn->set_charset("utf8");
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    exit("Erreur de connexion à la base de données.");
}

if (!isset($_SESSION['vendeur_id'])) {
    header("Location: ../autentification/php_files/logint.php");
    exit();
}

$vendeur_id = $_SESSION['vendeur_id'];

// Récupérer les ventes du vendeur
$query = "
    SELECT c.id, c.date_commande, cd.quantite, cd.prix_unitaire, cd.quantite * cd.prix_unitaire AS prix_total, p.nom AS produit
    FROM commandes c
    JOIN commande_details cd ON c.id = cd.id_commande
    JOIN produits p ON cd.id_produit = p.id
    WHERE p.id_vendeur = ?
    AND c.statut = 'livrée'
    ORDER BY c.date_commande DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $vendeur_id);
$stmt->execute();
$result = $stmt->get_result();
$ventes = $result->fetch_all(MYSQLI_ASSOC);

// Calcul du total des ventes
$total_ventes = 0;
foreach ($ventes as $vente) {
    $total_ventes += $vente['prix_total'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Ventes - Dashboard</title>
    <link rel="stylesheet" href="../assets/dashboard.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; }
        .container { max-width: 900px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; }
        h1 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #27ae60; color: #fff; }
        tr:hover { background: #f1f1f1; }
        .total { font-size: 1.2em; margin-top: 20px; color: #27ae60; }
        .logout { float: right; }
    </style>
</head>
<body>
    <div class="container">
        <a href="../logout.php" class="logout">Déconnexion</a>
        <h1>Tableau de bord - Mes Ventes</h1>
        <div class="total">
            Total des ventes : <strong><?php echo number_format($total_ventes, 2, ',', ' '); ?> FCFA</strong>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Prix total (FCFA)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($ventes) === 0): ?>
                    <tr><td colspan="5">Aucune vente enregistrée.</td></tr>
                <?php else: ?>
                    <?php foreach ($ventes as $vente): ?>
                        <tr>
                            <td><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($vente['date_commande']))); ?></td>
                            <td><?php echo htmlspecialchars($vente['produit']); ?></td>
                            <td><?php echo htmlspecialchars($vente['quantite']); ?></td>
                            <td><?php echo number_format($vente['prix_unitaire'], 2, ',', ' '); ?></td>
                            <td><?php echo number_format($vente['prix_total'], 2, ',', ' '); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
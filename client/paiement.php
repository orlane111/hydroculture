<?php
session_start();
require_once('config.php');

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$message = '';
$panier = [];
$total = 0;

// Récupérer les articles du panier
try {
    $conn = new mysqli($host, $username, $password, $database, $port);
    $conn->set_charset("utf8");
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $sql = "SELECT p.nom, p.prix, pa.quantite FROM panier pa INNER JOIN produits p ON pa.id_produit = p.id WHERE pa.id_utilisateur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $panier[] = $row;
        $total += $row['prix'] * $row['quantite'];
    }
    $conn->close();
} catch (mysqli_sql_exception $e) {
    $message = "❌ Erreur de connexion à la base de données.";
}

// Si validation du paiement
if (isset($_POST['valider_paiement'])) {
    try {
        $conn = new mysqli($host, $username, $password, $database, $port);
        $conn->set_charset("utf8");
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $sql = "DELETE FROM panier WHERE id_utilisateur = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $conn->close();
        $message = "✅ Paiement effectué avec succès ! Votre panier a été vidé.";
        $panier = [];
        $total = 0;
    } catch (mysqli_sql_exception $e) {
        $message = "❌ Erreur lors du paiement.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture - Paiement</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .facture-container { max-width: 700px; margin: 30px auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px; }
        h1 { text-align: center; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f8f9fa; }
        .total { text-align: right; font-size: 1.2em; margin-top: 20px; color: #28a745; font-weight: bold; }
        .btn-payer { background: #28a745; color: #fff; border: none; padding: 12px 30px; border-radius: 5px; font-size: 1.1em; cursor: pointer; margin-top: 30px; display: block; width: 100%; }
        .btn-payer:hover { background: #218838; }
        .message { padding: 15px; margin: 20px 0; border-radius: 5px; text-align: center; font-size: 1.1em; }
        .message.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .retour { display: block; text-align: center; margin-top: 30px; color: #007bff; text-decoration: none; }
        .retour:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <?php include('en_teteC.php'); ?>
    <div class="facture-container">
        <h1>Facture</h1>
        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, "✅") === 0 ? 'success' : 'error'; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if (!empty($panier)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Sous-total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($panier as $article): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($article['nom'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo number_format($article['prix'], 2, ',', ' '); ?> FCFA</td>
                            <td><?php echo $article['quantite']; ?></td>
                            <td><?php echo number_format($article['prix'] * $article['quantite'], 2, ',', ' '); ?> FCFA</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="total">Total à payer : <?php echo number_format($total, 2, ',', ' '); ?> FCFA</div>
            <form method="post">
                <button type="submit" name="valider_paiement" class="btn-payer">Valider et payer</button>
            </form>
        <?php elseif (empty($message)): ?>
            <div class="message error">Votre panier est vide.</div>
        <?php endif; ?>
        <a href="Catalogue.php" class="retour">&larr; Retour au catalogue</a>
    </div>
</body>
</html> 
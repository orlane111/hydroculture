<?php
session_start();

// Vérifie si le panier existe, sinon le crée
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Ajout d'un produit au panier
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];

    // Vérifie si le produit est déjà dans le panier
    if (isset($_SESSION['panier'][$product_id])) {
        $_SESSION['panier'][$product_id]['quantity'] += $product_quantity;
    } else {
        $_SESSION['panier'][$product_id] = [
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $product_quantity
        ];
    }
}

// Suppression d'un produit du panier
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    unset($_SESSION['panier'][$product_id]);
}

// Vider le panier
if (isset($_POST['clear_cart'])) {
    $_SESSION['panier'] = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php 
        include('en_tete_article.php');
    ?>
    <h1>Votre Panier</h1>

    <?php if (!empty($_SESSION['panier'])): ?>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['panier'] as $id => $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= number_format($product['price'], 2) ?> €</td>
                        <td><?= $product['quantity'] ?></td>
                        <td><?= number_format($product['price'] * $product['quantity'], 2) ?> €</td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="product_id" value="<?= $id ?>">
                                <button type="submit" name="remove_from_cart">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Total général :</strong> 
            <?= number_format(array_sum(array_map(function($product) {
                return $product['price'] * $product['quantity'];
            }, $_SESSION['panier'])), 2) ?> €
        </p>
        <form method="post">
            <button type="submit" name="clear_cart">Vider le panier</button>
        </form>
    <?php else: ?>
        <p>Votre panier est vide.</p>
    <?php endif; ?>

    <a href="catalogue.php">Continuer vos achats</a>
</body>
</html>
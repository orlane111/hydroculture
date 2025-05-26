<?php
session_start();
var_dump($_SESSION["user_id"]);
echo "User ID: " . $_SESSION["user_id"] . "<br>";
require_once('config.php');

// Initialiser le message
$message = '';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

try {
    $conn = new mysqli($host, $username, $password, $database, $port);
    $conn->set_charset("utf8");
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Récupérer les articles du panier pour l'utilisateur connecté
    $sql = "SELECT p.id, p.nom, p.prix, p.image, pa.quantite FROM panier pa INNER JOIN produits p ON pa.id_produit = p.id WHERE pa.id_utilisateur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Ajout de messages de débogage
    error_log("Recherche du panier pour l'utilisateur ID: " . $user_id);
    error_log("Nombre d'articles trouvés: " . $result->num_rows);

    $panier = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $panier[] = $row;
            error_log("Article trouvé - ID: " . $row['id'] . ", Nom: " . $row['nom'] . ", Quantité: " . $row['quantite']);
        }
    } else {
        error_log("Aucun article trouvé dans le panier pour l'utilisateur ID: " . $user_id);
    }

    $conn->close();

} catch (mysqli_sql_exception $e) {
    die("❌ Erreur de connexion à la base de données. Veuillez vérifier vos paramètres.");
}

// Traitement de la suppression d'un article
if (isset($_POST['supprimer_article'])) {
    $produit_id = $_POST['produit_id'];
    try {
        $conn = new mysqli($host, $username, $password, $database, $port);
        $conn->set_charset("utf8");
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $sql = "DELETE FROM panier WHERE id_utilisateur = ? AND id_produit = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $produit_id);
        $stmt->execute();

        $conn->close();

        header("Location: panier.php"); // Rafraîchir la page
        exit();

    } catch (mysqli_sql_exception $e) {
        die("❌ Erreur de connexion à la base de données. Veuillez vérifier vos paramètres.");
    }
}

// Traitement de la mise à jour de la quantité
if (isset($_POST['mettre_a_jour_quantite'])) {
    $produit_id = $_POST['produit_id'];
    $quantite = $_POST['quantite'];

    if ($quantite > 0) {
        try {
            $conn = new mysqli($host, $username, $password, $database, $port);
            $conn->set_charset("utf8");
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            $sql = "UPDATE panier SET quantite = ? WHERE id_utilisateur = ? AND id_produit = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $quantite, $user_id, $produit_id);
            
            if ($stmt->execute()) {
                $message = "✅ Quantité mise à jour avec succès !";
            } else {
                $message = "❌ Erreur lors de la mise à jour de la quantité.";
            }

            $conn->close();

        } catch (mysqli_sql_exception $e) {
            $message = "❌ Erreur de connexion à la base de données.";
        }
    }
}

// Traitement de la suppression de tout le panier
if (isset($_POST['vider_panier'])) {
    try {
        $conn = new mysqli($host, $username, $password, $database, $port);
        $conn->set_charset("utf8");
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $sql = "DELETE FROM panier WHERE id_utilisateur = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $conn->close();

        header("Location: panier.php"); // Rafraîchir la page
        exit();

    } catch (mysqli_sql_exception $e) {
        die("❌ Erreur de connexion à la base de données. Veuillez vérifier vos paramètres.");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .panier-container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.2em;
        }

        .article {
            display: flex;
            align-items: center;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .article:hover {
            transform: translateY(-2px);
        }

        .article img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }

        .article-details {
            flex-grow: 1;
        }

        .article-details h3 {
            color: #2c3e50;
            margin: 0 0 10px 0;
            font-size: 1.4em;
        }

        .article-details p {
            color: #666;
            margin: 5px 0;
            font-size: 1.1em;
        }

        .quantity-form {
            display: flex;
            align-items: center;
            margin: 15px 0;
            gap: 10px;
        }

        .quantity-input {
            width: 70px;
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-controls button {
            padding: 8px 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.2s;
        }

        .quantity-controls button:hover {
            background-color: #e9ecef;
        }

        .supprimer-article {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.2s;
        }

        .supprimer-article:hover {
            background-color: #c82333;
        }

        .total {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            text-align: right;
            font-size: 1.3em;
            color: #2c3e50;
        }

        .total span {
            font-weight: bold;
            color: #28a745;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 20px;
        }

        .vider-panier {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.2s;
        }

        .vider-panier:hover {
            background-color: #c82333;
        }

        .passer-commande {
            background-color: #28a745;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 1.1em;
            transition: background-color 0.2s;
            display: inline-block;
        }

        .passer-commande:hover {
            background-color: #218838;
        }

        .empty-cart {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 1.2em;
        }

        .empty-cart p {
            margin-bottom: 20px;
        }

        .continue-shopping {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.2s;
        }

        .continue-shopping:hover {
            background-color: #0056b3;
        }

        /* Style pour le message */
        .message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            font-size: 1.1em;
            animation: fadeOut 3s forwards;
            animation-delay: 2s;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>
<body>
    <?php include('en_teteC.php'); ?>
    <div class="panier-container">
        <h1>Votre Panier</h1>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo strpos($message, "✅") === 0 ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($panier)): ?>
            <div class="empty-cart">
                <p>Votre panier est vide.</p>
                <a href="Catalogue.php" class="continue-shopping">Continuer vos achats</a>
            </div>
        <?php else: ?>
            <?php $total = 0; ?>
            <?php foreach ($panier as $article): ?>
                <div class="article">
                    <img src="http://localhost/hydroculture_test/images/image_catal/<?php echo htmlspecialchars($article['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($article['nom'], ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="article-details">
                        <h3><?php echo htmlspecialchars($article['nom'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p>Prix unitaire: <?php echo number_format($article['prix'], 2, ',', ' '); ?> FCFA</p>

                        <form method="post" action="panier.php" class="quantity-form">
                            <input type="hidden" name="produit_id" value="<?php echo htmlspecialchars($article['id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="quantity-controls">
                                <label for="quantite">Quantité:</label>
                                <input type="number" name="quantite" class="quantity-input" value="<?php echo htmlspecialchars($article['quantite'], ENT_QUOTES, 'UTF-8'); ?>" min="1">
                                <button type="submit" name="mettre_a_jour_quantite">Mettre à jour</button>
                            </div>
                        </form>

                        <form method="post" action="panier.php">
                            <input type="hidden" name="produit_id" value="<?php echo htmlspecialchars($article['id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <button type="submit" name="supprimer_article" class="supprimer-article">Supprimer</button>
                        </form>
                    </div>
                    <?php $total += $article['prix'] * $article['quantite']; ?>
                </div>
            <?php endforeach; ?>

            <div class="total">
                Total: <span><?php echo number_format($total, 2, ',', ' '); ?> FCFA</span>
            </div>

            <div class="actions">
                <form method="post" action="panier.php">
                    <button type="submit" name="vider_panier" class="vider-panier">Vider le panier</button>
                </form>
                <a href="paiement.php" class="passer-commande">Passer à la caisse</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
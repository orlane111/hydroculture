<?php
session_start();
header('Content-Type: application/json');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
    exit();
}

require_once('config.php');

// Traitement de l'ajout au panier
if (isset($_POST['ajouter_panier'])) {
    try {
        // Débogage des données POST reçues
        error_log("=== DÉBUT DU PROCESSUS D'AJOUT AU PANIER ===");
        error_log("Données POST reçues : " . print_r($_POST, true));
        error_log("Session user_id : " . print_r($_SESSION["user_id"], true));
        
        $produit_id = isset($_POST['produit_id']) ? (int)$_POST['produit_id'] : 0;
        $quantite = isset($_POST['quantite']) ? (int)$_POST['quantite'] : 0;
        $user_id = isset($_SESSION["user_id"]) ? (int)$_SESSION["user_id"] : 0;

        error_log("Données traitées - User ID: " . $user_id . ", Produit ID: " . $produit_id . ", Quantité: " . $quantite);

        if ($produit_id <= 0 || $quantite <= 0 || $user_id <= 0) {
            error_log("Erreur: Données invalides");
            echo json_encode(['success' => false, 'message' => 'Données invalides']);
            exit();
        }

        $conn = new mysqli($host, $username, $password, $database, $port);
        if ($conn->connect_error) {
            throw new Exception("Erreur de connexion à la base de données");
        }
        
        $conn->set_charset("utf8");
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        error_log("Connexion à la base de données réussie");

        // Vérifier si le produit existe déjà dans le panier
        $sql = "SELECT quantite FROM panier WHERE id_utilisateur = ? AND id_produit = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Erreur lors de la préparation de la requête");
        }
        
        $stmt->bind_param("ii", $user_id, $produit_id);
        $stmt->execute();
        $result = $stmt->get_result();
        error_log("Recherche du produit dans le panier - Nombre de résultats: " . $result->num_rows);

        if ($result->num_rows > 0) {
            // Le produit existe déjà, mettre à jour la quantité
            $row = $result->fetch_assoc();
            $nouvelle_quantite = $row['quantite'] + $quantite;
            error_log("Produit déjà dans le panier. Mise à jour de la quantité: " . $nouvelle_quantite);

            $sql = "UPDATE panier SET quantite = ? WHERE id_utilisateur = ? AND id_produit = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erreur lors de la préparation de la requête UPDATE");
            }
            $stmt->bind_param("iii", $nouvelle_quantite, $user_id, $produit_id);
            error_log("Requête UPDATE préparée avec les paramètres: " . $nouvelle_quantite . ", " . $user_id . ", " . $produit_id);
        } else {
            // Le produit n'existe pas, l'ajouter au panier
            error_log("Nouveau produit ajouté au panier");
            $sql = "INSERT INTO panier (id_utilisateur, id_produit, quantite) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Erreur lors de la préparation de la requête INSERT");
            }
            $stmt->bind_param("iii", $user_id, $produit_id, $quantite);
            error_log("Requête INSERT préparée avec les paramètres: " . $user_id . ", " . $produit_id . ", " . $quantite);
        }

        if ($stmt->execute()) {
            error_log("Opération réussie");
            echo json_encode(['success' => true, 'message' => 'Produit ajouté au panier']);
        } else {
            error_log('Erreur SQL : ' . $stmt->error);
            echo json_encode(['success' => false, 'message' => 'Erreur SQL : ' . $stmt->error]);
            exit();
        }

        $stmt->close();
        $conn->close();
        error_log("=== FIN DU PROCESSUS D'AJOUT AU PANIER ===");

    } catch (Exception $e) {
        error_log("Erreur: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Une erreur est survenue: ' . $e->getMessage()]);
    }
    exit();
}

// Si on arrive ici, c'est que la requête n'était pas pour ajouter au panier
echo json_encode(['success' => false, 'message' => 'Requête invalide']);
exit();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <style>
        /* Styles CSS pour la page du panier */
        .panier-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .article {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }
        .article img {
            max-width: 80px;
            max-height: 80px;
            margin-right: 10px;
        }
        .article-details {
            flex-grow: 1;
        }
        .total {
            margin-top: 20px;
            font-weight: bold;
            text-align: right;
        }
        .quantity-form {
            display: flex;
            align-items: center;
        }
        .quantity-input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
        }
        .supprimer-article,
        .vider-panier,
        .passer-commande {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .passer-commande {
            background-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="panier-container">
        <h1>Votre Panier</h1>

        <?php if (empty($panier)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <?php $total = 0; ?>
            <?php foreach ($panier as $article): ?>
                <div class="article">
                    <img src="http://localhost/hydroculture_test/images/image_catal/<?php echo htmlspecialchars($article['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($article['nom'], ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="article-details">
                        <h3><?php echo htmlspecialchars($article['nom'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p>Prix: <?php echo htmlspecialchars($article['prix'], ENT_QUOTES, 'UTF-8'); ?> FCFA</p>

                        <!-- Formulaire pour mettre à jour la quantité -->
                        <form method="post" action="panier.php" class="quantity-form">
                            <input type="hidden" name="produit_id" value="<?php echo htmlspecialchars($article['id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <label for="quantite">Quantité:</label>
                            <input type="number" name="quantite" class="quantity-input" value="<?php echo htmlspecialchars($article['quantite'], ENT_QUOTES, 'UTF-8'); ?>" min="1">
                            <button type="submit" name="mettre_a_jour_quantite">Mettre à jour</button>
                        </form>

                        <!-- Formulaire pour supprimer l'article -->
                        <form method="post" action="panier.php">
                            <input type="hidden" name="produit_id" value="<?php echo htmlspecialchars($article['id'], ENT_QUOTES, 'UTF-8'); ?>">
                            <button type="submit" name="supprimer_article" class="supprimer-article">Supprimer</button>
                        </form>
                    </div>
                    <?php $total += $article['prix'] * $article['quantite']; ?>
                </div>
            <?php endforeach; ?>
            <div class="total">
                Total: <?php echo htmlspecialchars($total, ENT_QUOTES, 'UTF-8'); ?> FCFA
            </div>

            <!-- Formulaire pour vider le panier -->
            <form method="post" action="panier.php">
                <button type="submit" name="vider_panier" class="vider-panier">Vider le panier</button>
            </form>

            <!-- Lien pour passer à la caisse -->
            <a href="paiement.php" class="passer-commande">Passer à la caisse</a>
        <?php endif; ?>
    </div>
</body>
</html>
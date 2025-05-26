<?php
session_start();

// Vérification de la connexion et du rôle (Important !)
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "agriculteur") {
    header("Location: login.php"); // Rediriger si non connecté ou rôle incorrect
    exit();
}

require_once('config.php'); // Inclure les informations de connexion

$message = ""; // Message à afficher à l'utilisateur

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Valider les données (important pour la sécurité !)
    $nom = htmlspecialchars(trim($_POST["nom"])); // Nettoyer et valider
    $prix = filter_var($_POST["prix"], FILTER_VALIDATE_FLOAT); // Valider comme float
    $description = htmlspecialchars(trim($_POST["description"])); // Nettoyer et valider
    $stock = filter_var($_POST["stock"], FILTER_VALIDATE_INT); // Valider comme entier
    $categorie = htmlspecialchars(trim($_POST["categorie"])); // Nettoyer et valider

    // Gestion de l'image
    $image = $_FILES["image"];
    $image_name = $image["name"];
    $image_tmp_name = $image["tmp_name"];
    $image_error = $image["error"];
    $image_size = $image["size"];

    // Vérifications de l'image
    if ($image_error === 0) {
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION)); // Extension en minuscule
        $allowed_exts = array("jpg", "jpeg", "png", "gif");

        if (in_array($image_ext, $allowed_exts)) {
            if ($image_size <= 2000000) { // Limite de 2MB (ajuster si nécessaire)
                $new_image_name = uniqid("IMG-", true) . "." . $image_ext; // Nom unique
                $image_destination = "../../images/image_catal/" . $new_image_name; // Chemin de destination

                // ****************************************************************************************************
                // Ajout du code de débogage ici
                echo "Chemin du fichier temporaire : " . $image_tmp_name . "<br>";
                echo "Chemin de destination : " . $image_destination . "<br>";
                echo "Le dossier de destination existe : " . (is_dir(dirname($image_destination)) ? 'Oui' : 'Non') . "<br>";
                echo "Le fichier temporaire existe : " . (file_exists($image_tmp_name) ? 'Oui' : 'Non') . "<br>";
                echo "Erreurs de téléchargement : " . $image_error . "<br>"; // Affiche le code d'erreur de téléchargement

                // Afficher les erreurs PHP
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                // ****************************************************************************************************

                // Déplacer l'image
                if (move_uploaded_file($image_tmp_name, $image_destination)) {
                    // Insertion dans la base de données
                    try {
                        $conn = new mysqli($host, $username, $password, $database, $port);
                        $conn->set_charset("utf8");
                        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                    } catch (mysqli_sql_exception $e) {
                        die("❌ Erreur de connexion à la base de données. Veuillez vérifier vos paramètres.");
                    }

                    $sql = "INSERT INTO produits (nom, prix, description, image, stock, categorie, id_vendeur, date_ajout) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"; // Utilisation de requêtes préparées
                    $stmt = $conn->prepare($sql);

                    if ($stmt) {
                        // Récupérer l'ID de l'utilisateur connecté
                        $id_vendeur = $_SESSION["user_id"];

                        $stmt->bind_param("sdssisi", $nom, $prix, $description, $new_image_name, $stock, $categorie, $id_vendeur); // "sdssisi" : string, double, string, string, integer, string, integer
                        if ($stmt->execute()) {
                            $message = "✅ Produit ajouté avec succès !";
                        } else {
                            $message = "❌ Erreur lors de l'ajout du produit : " . $stmt->error;
                        }
                        $stmt->close();
                    } else {
                        $message = "❌ Erreur de préparation de la requête : " . $conn->error;
                    }

                    $conn->close();

                } else {
                    $message = "❌ Erreur lors du déplacement de l'image.";
                }
            } else {
                $message = "❌ L'image est trop volumineuse (max. 2MB).";
            }
        } else {
            $message = "❌ Format d'image non autorisé. Formats acceptés : JPG, JPEG, PNG, GIF.";
        }
    } else {
        $message = "❌ Erreur lors du téléchargement de l'image.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers votre fichier CSS -->
    <style>
        /* Styles CSS pour la page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select { /* Ajout de select pour le style */
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Important pour éviter que le padding n'élargisse l'input */
        }

        textarea {
            height: 100px;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        button[type="submit"] {
            background-color: #5cb85c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #4cae4c;
        }

        .message {
            text-align: center;
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
        }

        .success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }

        .error {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }
    </style>
</head>
<body>
    <?php include('en_tete_article.php'); ?>
    <div class="container">
        <h1>Ajouter un Produit</h1>

        <?php if ($message): ?>
            <div class="message <?php echo (strpos($message, "✅") === 0) ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <label for="nom">Nom du produit:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prix">Prix:</label>
            <input type="number" id="prix" name="prix" step="0.01" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" value="1" required>

            <label for="categorie">Catégorie:</label>
            <input type="text" id="categorie" name="categorie" required>


            <label for="image">Image du produit:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit">Ajouter le produit</button>
        </form>
    </div>
</body>
</html>
<?php
session_start(); // Démarre la session

// Configuration de la base de données (à adapter à vos paramètres)
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "hydroculture";
$port = 3308;

// Initialisation des variables
$message = "";

// Connexion à la base de données
try {
    $conn = new mysqli($host, $username, $password, $database, $port);
    $conn->set_charset("utf8");
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
} catch (mysqli_sql_exception $e) {
    $message = "❌ Erreur de connexion à la base de données. Veuillez vérifier vos paramètres.";
}

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($message)) {
    // Récupération et nettoyage des données
    $login = htmlspecialchars(trim($_POST["login"])); // Nom d'utilisateur ou email
    $password = $_POST["password"];

    // Validation
    if (empty($login) || empty($password)) {
        $message = "❌ Veuillez entrer votre nom d'utilisateur/email et votre mot de passe.";
    } else {
        // Requête SQL pour récupérer l'utilisateur par nom d'utilisateur ou email
        $sql = "SELECT id_vendeur, nom_utilisateur, email, mot_de_passe, role FROM utilisateurs WHERE nom_utilisateur = ? OR email = ?";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $login, $login);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                // Utilisateur trouvé
                $user = $result->fetch_assoc();

                // Vérification du mot de passe
                if (password_verify($password, $user["mot_de_passe"])) {
                    // Mot de passe correct
                    $_SESSION["user_id"] = $user["id_vendeur"]; // Stocke l'ID de l'utilisateur dans la session
                    $_SESSION["username"] = $user["nom_utilisateur"]; // Stocke le nom d'utilisateur
                    $_SESSION["role"] = $user["role"]; // Stocke le rôle

                    // Redirection en fonction du rôle
                    if ($_SESSION["role"] == "agriculteur") {
                        header("Location: ../../agriculteur/dashbord.php"); // Redirection vers indexA.php
                    } elseif ($_SESSION["role"] == "client") {
                        header("Location: ../../client/indexC.php"); // Redirection vers client/index.php (ou indexC.php)
                    } else {
                        // Rôle inconnu (gérer l'erreur)
                        $message = "❌ Rôle d'utilisateur inconnu. Veuillez contacter l'administrateur.";
                    }
                    exit();

                } else {
                    // Mot de passe incorrect
                    $message = "❌ Mot de passe incorrect.";
                }
            } else {
                // Utilisateur non trouvé
                $message = "❌ Nom d'utilisateur ou email incorrect.";
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $message = "❌ Erreur lors de la connexion : " . $e->getMessage();
        }
    }
}

// Fermeture de la connexion
if (isset($conn)) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Hydroculture225</title>
    <link rel="stylesheet" href="../css_files/loginstyle.css"> <!-- Remplacez par le bon chemin -->
    <style>
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
        }
        .message.error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <form action="" method="post">
            <p>
                <label for="login">Nom d'utilisateur ou Email :</label>
                <input type="text" id="login" name="login" required>
            </p>
            <p>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </p>

            <?php if (!empty($message)): ?>
                <p class="message error"><?php echo $message; ?></p>
            <?php endif; ?>

            <button type="submit">Se connecter</button>
        </form>
        <p>
            Pas encore inscrit ? <a href="instest.php">Inscrivez-vous</a>
        </p>
    </div>
</body>
</html>
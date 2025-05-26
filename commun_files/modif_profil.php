<?php
session_start();

// Vérification de la connexion
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Configuration de la base de données (à adapter à vos paramètres)
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "hydroculture";
$port = 3308;

// Connexion à la base de données
try {
    $conn = new mysqli($host, $username, $password, $database, $port);
    $conn->set_charset("utf8");
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
} catch (mysqli_sql_exception $e) {
    die("❌ Erreur de connexion à la base de données. Veuillez vérifier vos paramètres.");
}

// Récupération des informations de l'utilisateur (pour pré-remplir le formulaire)
$user_id = $_SESSION["user_id"];
$sql = "SELECT nom, prenom, email, contact, nom_utilisateur, role FROM utilisateurs WHERE id_vendeur = ?";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        die("❌ Utilisateur non trouvé.");
    }

    $stmt->close();
} catch (mysqli_sql_exception $e) {
    die("❌ Erreur lors de la récupération des informations de l'utilisateur : " . $e->getMessage());
}

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $prenom = htmlspecialchars(trim($_POST["prenom"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $contact = htmlspecialchars(trim($_POST["contact"]));
    $nom_utilisateur = htmlspecialchars(trim($_POST["nom_utilisateur"]));
    $role = htmlspecialchars(trim($_POST["role"]));

    // Validation des données (ajoutez vos propres règles de validation)
    if (empty($nom) || empty($prenom) || empty($email) || empty($contact) || empty($nom_utilisateur) || empty($role)) {
        $message = "❌ Veuillez remplir tous les champs obligatoires.";
    } else {
        // Préparation de la requête SQL de mise à jour
        $sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, email = ?, contact = ?, nom_utilisateur = ?, role = ? WHERE id_vendeur = ?";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $nom, $prenom, $email, $contact, $nom_utilisateur, $role, $user_id);
            $stmt->execute();

            // Mise à jour des informations de session (si nécessaire)
            $_SESSION["username"] = $nom_utilisateur;

            $message = "✅ Profil mis à jour avec succès. Vous allez être redirigé vers la page de connexion dans 2 secondes...";
            $redirect = true; // Indique qu'une redirection est nécessaire

        } catch (mysqli_sql_exception $e) {
            $message = "❌ Erreur lors de la mise à jour du profil : " . $e->getMessage();
            $redirect = false; // Pas de redirection en cas d'erreur
        } finally {
            $stmt->close();
        }
    }
} else {
    $redirect = false; // Pas de redirection si le formulaire n'est pas soumis
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
    <link rel="stylesheet" href="profil.css">
    <title>Modifier le profil</title>
    <style>
        /* Styles CSS (comme dans votre code précédent) */
    </style>
</head>
<body>
    <h1>Modifier votre profil</h1>

    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user["nom"]); ?>" required><br><br>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user["prenom"]); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>" required><br><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($user["contact"]); ?>" required><br><br>

        <label for="nom_utilisateur">Nom d'utilisateur:</label>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" value="<?php echo htmlspecialchars($user["nom_utilisateur"]); ?>" required><br><br>

        <label for="role">Rôle:</label>
        <select name="role" id="role" required>
            <option value="client" <?php if ($user["role"] == "client") echo "selected"; ?>>Client</option>
            <option value="agriculteur" <?php if ($user["role"] == "agriculteur") echo "selected"; ?>>Agriculteur</option>
        </select><br><br>

        <button type="submit">Enregistrer les modifications</button>
    </form>

    <a href="profil.php">Retour au profil</a>
    <a href="logout.php">Déconnexion</a>

    <?php if (isset($redirect) && $redirect): ?>
        <script>
            setTimeout(function() {
                window.location.href = "../autentification/php_files/logint.php";
            }, 2000); // 2000 millisecondes = 2 secondes
        </script>
    <?php endif; ?>
</body>
</html>
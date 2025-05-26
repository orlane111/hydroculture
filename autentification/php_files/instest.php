<?php
// Configuration de la base de données
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "hydroculture";
$port = 3308; // Définir le port explicitement

// Initialisation de la variable de message
$message = "";

// Fonction str_starts_with pour les versions de PHP < 8.0
if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool
    {
        return strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

// Connexion à la base de données
try {
    $conn = new mysqli($host, $username, $password, $database, $port);
    $conn->set_charset("utf8"); // Définir l'encodage des caractères
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Activer les rapports d'erreurs
} catch (mysqli_sql_exception $e) {
    $message = "❌ Erreur de connexion à la base de données. Veuillez vérifier vos paramètres de connexion.";
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($message)) { // Vérifier si la connexion a réussi
    // Récupération et nettoyage des données du formulaire
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $prenom = htmlspecialchars(trim($_POST["prenom"]));
    $username = htmlspecialchars(trim($_POST["username"]));
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $contact = htmlspecialchars(trim($_POST["contact"])); // Nettoyer le contact
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $choix = htmlspecialchars(trim($_POST["choix"])); // Nettoyer le choix

    // Validation des données
    if (empty($nom) || empty($prenom) || empty($username) || empty($email) || empty($contact) || empty($password) || empty($confirm_password)) {
        $message = "❌ Veuillez remplir tous les champs obligatoires.";
    } elseif (empty($email)) {
        $message = "❌ Veuillez entrer une adresse email.";
    } elseif (!$email) {
        $message = "❌ L'adresse e-mail que vous avez fournie n'est pas valide. Veuillez vérifier le format (par exemple, nom@domaine.com).";
    } elseif (strlen($email) > 255) {
        $message = "❌ L'adresse e-mail est trop longue. Veuillez utiliser une adresse de moins de 256 caractères.";
    } else {
        // Hachage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Préparation de la requête SQL
        $sql = "INSERT INTO utilisateurs (nom, prenom, nom_utilisateur, email, contact, mot_de_passe, role)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $nom, $prenom, $username, $email, $contact, $hashed_password, $choix);

            // Exécution de la requête
            if ($stmt->execute()) {
                // Redirection vers la page de connexion
                header("Location: logint.php");
                exit(); // Important d'ajouter exit() après la redirection
            } else {
                // Analyse de l'erreur MySQL pour identifier la cause
                if (strpos($conn->error, "Duplicate entry") !== false) {
                    if (strpos($conn->error, "nom_utilisateur") !== false) {
                        $message = "❌ Ce nom d'utilisateur est déjà utilisé. Veuillez en choisir un autre.";
                    } elseif (strpos($conn->error, "email") !== false) {
                        $message = "❌ Cette adresse e-mail est déjà utilisée. Si vous avez déjà un compte, veuillez vous connecter.";
                    } else {
                        $message = "❌ Une erreur s'est produite lors de l'enregistrement de vos informations. Veuillez réessayer.";
                    }
                } else {
                    $message = "❌ Une erreur s'est produite lors de l'enregistrement de vos informations. Veuillez réessayer.";
                }
            }

            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $message = "❌ Une erreur s'est produite lors de l'enregistrement de vos informations. Veuillez vérifier que le nom d'utilisateur ou l'adresse e-mail n'est pas déjà utilisé.";
        }
    }
}

// Fermeture de la connexion (si elle a été établie)
if (isset($conn)) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Hydroculture225</title>
    <link rel="stylesheet" href="../css_files/style_inscription.css">
</head>
<body>
    <div class="container">
        <!-- Partie gauche avec image et message de bienvenue -->
        <div class="left">
            <h1><span>Bienvenue</span> sur Hydroculture</h1>
        </div>

        <!-- Formulaire d'inscription -->
        <div class="right">
            <form action="" method="post">
                <p>
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required>
                </p>
                <p>
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : ''; ?>" required>
                </p>
                <p>
                    <label for="username">Nom d'utilisateur :</label>
                    <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                </p>
                <p>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </p>
                <p>
                    <label for="contact">Contact :</label>
                    <input type="tel" id="contact" name="contact" value="<?php echo isset($_POST['contact']) ? htmlspecialchars($_POST['contact']) : ''; ?>" required>
                </p>
                <p>
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                </p>
                <p>
                    <label for="confirm-password">Confirmation de mot de passe :</label>
                    <input type="password" id="confirm-password" name="confirm_password" required>
                </p>
                <fieldset>
                    <legend>Vous êtes :</legend>
                    <label for="client">
                        <input type="radio" id="client" name="choix" value="client" <?php echo (!isset($_POST['choix']) || $_POST['choix'] == 'client') ? 'checked' : ''; ?>>
                        Client
                    </label>
                    <label for="agriculteur">
                        <input type="radio" id="agriculteur" name="choix" value="agriculteur" <?php echo (isset($_POST['choix']) && $_POST['choix'] == 'agriculteur') ? 'checked' : ''; ?>>
                        Agriculteur
                    </label>
                </fieldset>

                <?php if (!empty($message)): ?>
                    <p class="message <?php echo (str_starts_with($message, "✅") ? 'success' : 'error'); ?>">
                        <?php echo $message; ?>
                    </p>
                <?php endif; ?>

                <div class="nom">
                    <button type="submit" class="button">Valider</button>
                </div>
                <p class="link">
                    Déjà inscrit ?
                    <a href="logint.php">Connectez-vous</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
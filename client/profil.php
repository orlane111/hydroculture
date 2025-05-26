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

// Récupération des informations de l'utilisateur
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
    <link rel="stylesheet" href="../commun_files/profil.css">
    <title>Profil</title>
</head>
<body>
<?php 
    include('en_teteC.php');
?>
    <h1>Votre Profil</h1>

    <p> <?php echo htmlspecialchars($user["nom"]); ?></p>
    <p> <?php echo htmlspecialchars($user["prenom"]); ?></p>
    <p> <?php echo htmlspecialchars($user["email"]); ?></p>
    <p> <?php echo htmlspecialchars($user["contact"]); ?></p>
    <p> <?php echo htmlspecialchars($user["nom_utilisateur"]); ?></p>
    <p> <?php echo htmlspecialchars($user["role"]); ?></p>

    <a href="../commun_files/modif_profil.php">Modifier le profil</a>
    <a href="../commun_files/logout.php">Déconnexion</a>
</body>
</html>
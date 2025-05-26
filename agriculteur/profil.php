<?php
session_start();

// Vérification de la connexion
if (!isset($_SESSION["user_id"])) {
    header("Location: ../autentification/php_files/logint.php");
    exit();
}

// Configuration de la base de données
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
        exit("Utilisateur non trouvé.");
    }

    $stmt->close();
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    exit("Erreur lors de la récupération des informations de l'utilisateur.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <style>
        :root {
            --primary-color: #2ecc71;
            --secondary-color: #66BB6A;
            --accent-color: #27ae60;
            --light-green: #E8F5E9;
            --dark-color: #212121;
            --light-color: #f8f9fa;
            --gray-color: #757575;
            --success-color: #43A047;
            --border-color: #e0e0e0;
            --shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: var(--light-color);
            color: var(--dark-color);
            line-height: 1.6;
            display: flex;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            width: 100%;
            background-color: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: var(--primary-color);
            color: white;
            padding: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            margin: 15px 0;
            display: block;
        }

        .sidebar a:hover {
            color: var(--light-green);
        }

        .content {
            flex: 1;
            padding: 40px;
        }

        h1 {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 24px 0;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
            border-radius: 10px 10px 0 0;
        }

        .profile-info {
            padding: 20px;
        }

        .info-row {
            display: flex;
            margin-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
        }

        .info-label {
            width: 150px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .info-value {
            flex: 1;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            background-color: var(--light-green);
        }

        .btn {
            padding: 12px 28px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
        }

        .btn-secondary {
            background-color: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn:hover {
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                padding: 10px;
            }

            .content {
                padding: 20px;
            }

            h1 {
                font-size: 1.5em;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-label {
                width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Agriculteur</h2>
        <i ><a class="fas fa-user " href="profil.php"> Mon Profil</a></i> 
        <i ><a class="fas fa-plus" href="produit.php"> Ajouter un produit</a></i>
        <i ><a class="fas fa-warehouse" href="produit.php"> Mes produits</a></i>
        <i ><a class="fas fa-warehouse" href="mes_ventes.php"> Mes ventes</a></i>
        <i ><a class="fas fa-sign-out-alt" href="../commun_files/logout.php">Déconnexion</a></i>
    </div>
    <div class="content">
        <h1>Votre Profil</h1>
        <div class="profile-info">
            <div class="info-row">
                <div class="info-label">Nom:</div>
                <div class="info-value"><?php echo htmlspecialchars($user["nom"]); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Prénom:</div>
                <div class="info-value"><?php echo htmlspecialchars($user["prenom"]); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value"><?php echo htmlspecialchars($user["email"]); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Contact:</div>
                <div class="info-value"><?php echo htmlspecialchars($user["contact"]); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Nom d'utilisateur:</div>
                <div class="info-value"><?php echo htmlspecialchars($user["nom_utilisateur"]); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Rôle:</div>
                <div class="info-value"><?php echo htmlspecialchars($user["role"]); ?></div>
            </div>
        </div>
        <div class="buttons">
            <a class="btn btn-primary" href="../commun_files/modif_profil.php">Modifier le profil</a>
            <a class="btn btn-secondary" href="../commun_files/logout.php">Déconnexion</a>
        </div>
    </div>
</body>
</html>
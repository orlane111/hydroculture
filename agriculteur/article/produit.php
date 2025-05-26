<?php
    require_once('config.php'); // Utilisation de require_once
    session_start(); // S'assurer que la session est démarrée

    // Vérification de la connexion et du rôle (Important !)
    if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "agriculteur") {
        header("Location: login.php"); // Rediriger si non connecté ou rôle incorrect
        exit();
    }

    // Initialiser la variable $sql
    $sql = "";

    // Récupérer les produits depuis la base de données
    try {
        $conn = new mysqli($host, $username, $password, $database, $port);
        $conn->set_charset("utf8");
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $sql = "SELECT id, nom, prix, image FROM produits"; // Remplacez "produits" par le nom de votre table
        $result = $conn->query($sql);

        $produits = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $produits[] = $row;
            }
        }

        $conn->close();

    } catch (mysqli_sql_exception $e) {
        // Gérer l'erreur de connexion de manière plus propre
        die("❌ Erreur de connexion à la base de données. Veuillez vérifier vos paramètres.  Assurez-vous que la base de données existe et que les informations de connexion sont correctes.");
    }
?>

<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Produits</title>
<link href="../agriculteur/teste/categorie.css" rel="stylesheet" type="text/css">
<link href="style.css" rel="stylesheet" type="text/css"> <!-- Lien vers un fichier CSS externe -->
</head>
<body>
<?php
    include('en_tete_article.php'); // Vérification de la session et du rôle dans ce fichier !
?>
    <div class="menu-container">
      <!-- Bouton hamburger -->
      <div class="menu-btn" id="menuBtn">
          <span></span>
          <span></span>
          <span></span>
      </div>

      <!-- Menu déroulant -->
      <div class="dropdown-menu" id="dropdownMenu">
          <ul>
              <li><a href="#">Accueil</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">Produits</a></li>
              <li><a href="#">Contact</a></li>
              <li><a href="#">À propos</a></li>
          </ul>
      </div>
  </div>

  <div class="add-product-button">
    <a href="ajouter_produit.php" class="btn-sell-product">Vendre un produit</a>
  </div>

  <main class="product-list">

      <?php foreach ($produits as $produit): ?>
          <div class="product-card">
              <img src="http://localhost/hydroculture_test/images/image_catal/<?php echo htmlspecialchars($produit['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($produit['nom'], ENT_QUOTES, 'UTF-8'); ?>">
              <h3><?php echo htmlspecialchars($produit['nom'], ENT_QUOTES, 'UTF-8'); ?></h3>
              <p><?php echo htmlspecialchars($produit['prix'], ENT_QUOTES, 'UTF-8'); ?> FCFA / pièce</p>

              <form method="POST" action="ajouter_panier.php">
                  <input type="hidden" name="produit_id" value="<?php echo htmlspecialchars($produit['id'], ENT_QUOTES, 'UTF-8'); ?>">
                  <input type="hidden" name="produit_nom" value="<?php echo htmlspecialchars($produit['nom'], ENT_QUOTES, 'UTF-8'); ?>">
                  <input type="hidden" name="produit_prix" value="<?php echo htmlspecialchars($produit['prix'], ENT_QUOTES, 'UTF-8'); ?>">
                  <input type="hidden" name="quantite" value="1">
                  <button type="submit" name="ajouter_panier" class="add-to-cart">Ajouter au panier</button>
              </form>
          </div>
      <?php endforeach; ?>

  </main>

  <footer class="secondary_header footer">
    <div class="copyright">&copy;2025 - <strong>Hydro Culture</strong></div>
  </footer>

  <script src="script.js"></script> <!-- Lien vers un fichier JavaScript externe -->
</body>
</html>
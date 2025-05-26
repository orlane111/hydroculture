<?php
    require_once('config.php');
    session_start();

    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }

    $sql = "";

    try {
        $conn = new mysqli($host, $username, $password, $database, $port);
        $conn->set_charset("utf8");
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $sql = "SELECT id, nom, prix, image FROM produits";
        $result = $conn->query($sql);

        $produits = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $produits[] = $row;
            }
        }

        $conn->close();

    } catch (mysqli_sql_exception $e) {
        die("❌ Erreur de connexion à la base de données. Veuillez vérifier vos paramètres.");
    }
?>

<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Produits</title>
<link href="style.css" rel="stylesheet" type="text/css">
<style>
/* Styles du modal */
.modal {
    display: none; /* Masqué par défaut */
    position: fixed; /* Rester en place */
    z-index: 1; /* Au-dessus des autres éléments */
    left: 0;
    top: 0;
    width: 100%; /* Plein écran */
    height: 100%; /* Plein écran */
    overflow: auto; /* Activer le défilement si nécessaire */
    background-color: rgba(0,0,0,0.4); /* Fond semi-transparent */
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* Centrer verticalement */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Ajuster la largeur */
    max-width: 500px;
    border-radius: 5px;
    position: relative;
}

.close {
    position: absolute;
    right: 10px;
    top: 0;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Styles du bouton hamburger */
.menu-btn {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 30px;
    height: 21px;
    cursor: pointer;
    position: relative;
    z-index: 100;
}

.menu-btn span {
    display: block;
    width: 100%;
    height: 3px;
    background-color: #333;
    transition: all 0.3s ease;
}

/* Animation du bouton quand le menu est ouvert */
.menu-btn.active span:nth-child(1) {
    transform: translateY(9px) rotate(45deg);
}

.menu-btn.active span:nth-child(2) {
    opacity: 0;
}

.menu-btn.active span:nth-child(3) {
    transform: translateY(-9px) rotate(-45deg);
}

/* Style du menu déroulant */
.dropdown-menu {
    position: absolute;
    top: 50px;
    left: 0;
    width: 200px;
    background-color: white;
    box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    border-radius: 5px;
    padding: 10px 0;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.dropdown-menu.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-menu ul {
    list-style: none;
}

.dropdown-menu li {
    padding: 10px 20px;
    transition: background-color 0.3s;
}

.dropdown-menu li:hover {
    background-color: #f0f0f0;
}

.dropdown-menu a {
    text-decoration: none;
    color: #333;
    font-size: 16px;
}

/* Conteneur pour le positionnement */
.menu-container {
    position: relative;
    display: inline-block;
}

/* Styles pour la liste de produits */
.product-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    padding: 20px;
}

.product-card {
    width: 250px;
    margin: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    text-align: center;
}

.product-card img {
    max-width: 100%;
    height: auto;
    margin-bottom: 10px;
}

.product-card h3 {
    font-size: 1.2em;
    margin-bottom: 5px;
}

.product-card p {
    font-size: 1em;
    color: #555;
}

.add-to-cart {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    margin-top: 10px;
}

.add-to-cart:hover {
    background-color: #3e8e41;
}

/* Styles pour le footer */
.footer {
    text-align: center;
    padding: 20px;
    background-color: #f0f0f0;
    border-top: 1px solid #ddd;
}

/* Styles pour le modal */
.modal-content {
    padding: 20px;
    max-width: 400px;
}

.product-details {
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
}

.quantity-selector {
    margin: 20px 0;
}

.quantity-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.quantity-controls button {
    width: 30px;
    height: 30px;
    border: 1px solid #ddd;
    background-color: #f8f9fa;
    border-radius: 5px;
    cursor: pointer;
    font-size: 18px;
}

.quantity-controls input {
    width: 60px;
    text-align: center;
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.total-price {
    margin: 20px 0;
    font-weight: bold;
    text-align: right;
}

.add-to-cart {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.add-to-cart:hover {
    background-color: #45a049;
}
</style>
</head>
<body>
<?php
    include('en_teteC.php');
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

  <main class="product-list">

      <?php foreach ($produits as $produit): ?>
          <div class="product-card">
              <img src="http://localhost/hydroculture_test/images/image_catal/<?php echo htmlspecialchars($produit['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($produit['nom'], ENT_QUOTES, 'UTF-8'); ?>">
              <h3><?php echo htmlspecialchars($produit['nom'], ENT_QUOTES, 'UTF-8'); ?></h3>
              <p><?php echo htmlspecialchars($produit['prix'], ENT_QUOTES, 'UTF-8'); ?> FCFA / pièce</p>

              <!-- Lien pour ouvrir le modal -->
              <button class="add-to-cart" onclick="openModal(<?php echo htmlspecialchars($produit['id'], ENT_QUOTES, 'UTF-8'); ?>, '<?php echo htmlspecialchars($produit['nom'], ENT_QUOTES, 'UTF-8'); ?>', '<?php echo htmlspecialchars($produit['prix'], ENT_QUOTES, 'UTF-8'); ?>')">Ajouter au panier</button>
          </div>
      <?php endforeach; ?>

  </main>

  <footer class="secondary_header footer">
    <div class="copyright">&copy;2025 - <strong>Hydro Culture</strong></div>
  </footer>

  <!-- Le Modal -->
  <div id="quantityModal" class="modal">
      <div class="modal-content">
          <span class="close" onclick="closeModal()">&times;</span>
          <h2>Choisir la quantité</h2>
          <div class="product-details">
              <p id="modal-product-name"></p>
              <p id="modal-product-price"></p>
          </div>
          <form method="POST" action="ajouter_panier.php" id="addToCartForm">
              <input type="hidden" id="modal_produit_id" name="produit_id" value="">
              <input type="hidden" id="modal_produit_nom" name="produit_nom" value="">
              <input type="hidden" id="modal_produit_prix" name="produit_prix" value="">
              
              <div class="quantity-selector">
                  <label for="quantite">Quantité:</label>
                  <div class="quantity-controls">
                      <button type="button" onclick="decreaseQuantity()">-</button>
                      <input type="number" id="quantite" name="quantite" value="1" min="1" required>
                      <button type="button" onclick="increaseQuantity()">+</button>
                  </div>
              </div>
              
              <div class="total-price">
                  <p>Total: <span id="total-price">0</span> FCFA</p>
              </div>
              
              <button type="submit" name="ajouter_panier" class="add-to-cart">Ajouter au panier</button>
          </form>
      </div>
  </div>

  <script>
    // Variables globales
    var modal = document.getElementById("quantityModal");
    var currentPrice = 0;
    var quantityInput = document.getElementById("quantite");

    // Fonction pour augmenter la quantité
    function increaseQuantity() {
        let currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
        updateTotal();
    }

    // Fonction pour diminuer la quantité
    function decreaseQuantity() {
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
            updateTotal();
        }
    }

    // Fonction pour mettre à jour le total
    function updateTotal() {
        const quantity = parseInt(quantityInput.value);
        const total = quantity * currentPrice;
        document.getElementById("total-price").textContent = total.toFixed(2);
    }

    // Functions to open and close the modal
    function openModal(produit_id, produit_nom, produit_prix) {
        console.log("Ouverture du modal pour le produit ID:", produit_id);
        console.log("Nom du produit:", produit_nom);
        console.log("Prix du produit:", produit_prix);
        
        document.getElementById("modal_produit_id").value = produit_id;
        document.getElementById("modal_produit_nom").value = produit_nom;
        document.getElementById("modal_produit_prix").value = produit_prix;
        
        // Afficher les détails du produit dans le modal
        document.getElementById("modal-product-name").textContent = produit_nom;
        document.getElementById("modal-product-price").textContent = produit_prix + " FCFA";
        
        // Stocker le prix pour les calculs
        currentPrice = parseFloat(produit_prix);
        
        // Réinitialiser la quantité à 1
        quantityInput.value = 1;
        
        // Mettre à jour le total
        updateTotal();
        
        console.log("Valeurs des champs cachés :");
        console.log("ID:", document.getElementById("modal_produit_id").value);
        console.log("Nom:", document.getElementById("modal_produit_nom").value);
        console.log("Prix:", document.getElementById("modal_produit_prix").value);
        
        modal.style.display = "block";
    }

    function closeModal() {
        modal.style.display = "none";
    }

    // Ajouter les écouteurs d'événements pour les boutons de quantité
    document.addEventListener('DOMContentLoaded', function() {
        // Écouter les changements de quantité
        quantityInput.addEventListener("input", updateTotal);
        
        // Écouter les clics sur les boutons + et -
        document.querySelector('.quantity-controls button:first-child').addEventListener('click', decreaseQuantity);
        document.querySelector('.quantity-controls button:last-child').addEventListener('click', increaseQuantity);
    });

    // Gestionnaire de soumission du formulaire
    document.getElementById("addToCartForm").addEventListener("submit", function(e) {
        e.preventDefault();
        console.log("Formulaire soumis");
        
        const formData = new FormData(this);
        formData.append('ajouter_panier', '1');
        console.log("Données du formulaire à envoyer:");
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        fetch('ajouter_panier.php', {
            method: 'POST',
            body: formData
        })
        .then(async response => {
            console.log("Statut de la réponse:", response.status);
            const contentType = response.headers.get("content-type");
            console.log("Type de contenu de la réponse:", contentType);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const text = await response.text();
            console.log("Réponse brute du serveur:", text);
            
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error("Erreur de parsing JSON:", e);
                console.error("Texte reçu:", text);
                throw new Error("Réponse invalide du serveur");
            }
        })
        .then(data => {
            console.log("Données parsées:", data);
            if (data.success) {
                alert(data.message);
                closeModal();
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                alert(data.message || "Une erreur est survenue");
            }
        })
        .catch(error => {
            console.error("Erreur détaillée:", error);
            alert("Une erreur est survenue lors de l'ajout au panier. Veuillez réessayer.");
        });
    });

    // Close the modal if the user clicks outside of it
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }
  </script>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Agriculteur</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            display: flex;
            min-height: 100vh;
            background: #f0f4f3;
        }
        .sidebar {
            width: 250px;
            background-color: #2f855a;
            color: white;
            padding: 20px;
        }
        .sidebar h2 {
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            margin: 15px 0;
            transition: 0.3s;
        }
        .sidebar a:hover {
            padding-left: 10px;
            color: #c6f6d5;
        }
        .content {
            flex: 1;
            padding: 40px;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .card h3 {
            margin-bottom: 10px;
        }

        form { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; }
        input, textarea, select {
            width: 100%; padding: 10px; margin: 10px 0;
            border: 1px solid #ccc; border-radius: 5px;
        }
        button { padding: 10px 20px; background-color: #2ecc71; color: white; border: none; border-radius: 5px; cursor: pointer; }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            background-color: #2f855a;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background-color: #276749;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Agriculteur</h2>
        <i ><a class="fas fa-user " href="profil.php"> Mon Profil</a></i> 
        <i ><a class="fas fa-plus" href="produit.php"> Ajouter un produit</a></i>
        <i ><a class="fas fa-warehouse" href="produit.php"> Mes produits</a></i>
        <i ><a class="fas fa-warehouse" href="mes_ventes.php"> Mes ventes</a></i>
        <i ><a class="fas fa-sign-out-alt" href="../commun_files/logout.php">Déconnexion</a></i> 
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="card" id="ajouter-produit">
            <h3>Ajouter un nouveau produit</h3>
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

    </div>

    
</body>
</html>

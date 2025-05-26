<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contenu Restreint</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #3e8e41;
        }

        #content {
            display: none;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Contenu Restreint</h2>
        <p>Veuillez vous connecter pour accéder au contenu.</p>
        <button onclick="location.href='../autentification/php_files/logint.php'">Se Connecter</button>

        <div id="content">
            <h3>Bienvenue !</h3>
            <p>Ceci est le contenu restreint auquel vous pouvez accéder après vous être connecté.</p>
        </div>
    </div>

    <script>
        // Dans une application réelle, vous vérifieriez si l'utilisateur est connecté
        // en utilisant du code côté serveur (par exemple, PHP, Python) et définiriez une variable JavaScript.
        // Pour cet exemple, nous allons simuler cela avec un simple indicateur.
        const isLoggedIn = false; // Remplacez par une vérification de connexion réelle

        if (isLoggedIn) {
            document.getElementById('content').style.display = 'block';
        }
    </script>
</body>
</html>
<?php

// Informations de connexion à la base de données
$host = "127.0.0.1";  // Adresse du serveur de base de données (localhost ou adresse IP)
$username = "root";     // Nom d'utilisateur de la base de données
$password = "";         // Mot de passe de la base de données
$database = "hydroculture"; // Nom de la base de données
$port = 3308;           // Port de la base de données (généralement 3306 pour MySQL)

// Autres constantes de configuration (facultatif)
define('SITE_NAME', 'Hydro Culture');
define('BASE_URL', 'http://localhost/hydroculture_test/'); // URL de base de votre site

// Activer/désactiver le mode débogage (pour afficher les erreurs)
define('DEBUG_MODE', true);

if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

?>
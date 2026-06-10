<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'litterature_marocaine');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_PORT', 4306); // DÉFINITION DU PORT


try {
    // Connexion à la base avec PDO
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);

    // Configuration pour afficher les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Définit le mode de récupération par défaut des résultats des requêtes en tableau associatif
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Affichage d'une erreur si la connexion échoue
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>


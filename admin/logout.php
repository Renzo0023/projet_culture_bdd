<?php
// admin/logout.php
session_start(); // Démarrer la session pour y accéder

// Détruire toutes les variables de session
$_SESSION = array();

// Supprimer le cookie de session si présent
// Ceci est important pour s'assurer que la session est complètement nettoyée côté client.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session côté serveur
session_destroy();

// Définir un message de succès qui sera affiché sur la page de connexion
$_SESSION['message'] = 'Vous avez été déconnecté avec succès.';

// Rediriger vers la page de connexion après la déconnexion
header('Location: login.php');
exit(); // Arrête l'exécution du script après la redirection
?>

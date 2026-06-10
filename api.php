<?php
// --- Configuration des en-têtes HTTP (CORS) ---
// Ces en-têtes sont cruciaux pour permettre à votre frontend (index.html) de communiquer
// avec ce backend, surtout s'ils sont hébergés sur des domaines ou ports différents.
header('Content-Type: application/json'); // Indique que la réponse sera au format JSON
// Access-Control-Allow-Origin: * : Permet à n'importe quel domaine d'accéder à cette API.
// Pour la production, il est fortement recommandé de remplacer * par le domaine exact de votre frontend (ex: 'http://votre-domaine.com').
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Méthodes HTTP autorisées
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // En-têtes autorisés dans les requêtes

// Gère la requête OPTIONS (pré-vol CORS)
// Les navigateurs envoient une requête OPTIONS avant une requête réelle (POST, PUT, DELETE)
// pour vérifier les permissions CORS. Si cette requête n'est pas gérée, la requête réelle échouera.
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // Répond avec un statut OK
    exit(); // Termine l'exécution du script
}

// --- Configuration de la Base de Données ---
// REMPLACEZ ces valeurs par les identifiants réels de votre base de données MySQL.
define('DB_SERVER', 'localhost');          // L'adresse de votre serveur de base de données (souvent 'localhost')
define('DB_USERNAME', 'root');     // VOTRE NOM D'UTILISATEUR DE BASE DE DONNÉES
define('DB_PASSWORD', ''); // VOTRE MOT DE PASSE DE BASE DE DONNÉES
define('DB_NAME', 'litterature_marocaine'); // Le nom de la base de données que vous avez créée
define('DB_PORT', 4306); // DÉFINITION DU PORT

// --- Connexion à la Base de Données ---
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

// Vérifie si la connexion à la base de données a échoué
if ($conn->connect_error) {
    http_response_code(500); // Code d'erreur HTTP 500 (Internal Server Error)
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

require_once 'crypto.php';

// --- Récupération des données de la requête ---
$method = $_SERVER['REQUEST_METHOD']; // Méthode HTTP de la requête (GET, POST, etc.)
// Décode le corps de la requête pour les requêtes POST (données JSON envoyées par le frontend)
$input = json_decode(file_get_contents('php://input'), true);

// Pour les formulaires HTML classiques (comme le formulaire de suppression) qui n'envoient pas de JSON
// PHP met les données POST dans $_POST. L'API utilise $input pour les requêtes JSON.
// Cette condition permet de gérer les deux types.
/* if ($method === 'POST' && !$input && isset($_POST['action'])) {
    $input = $_POST; // Utilise $_POST si le corps n'est pas JSON mais un formulaire classique
} */
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'] ?? null;
    // ...
}


// --- Gestion des Requêtes GET ---
// Utilisé pour récupérer des données (ex: liste d'auteurs, liste de romans).
if ($method === 'GET') {
    $action = $_GET['action'] ?? ''; // Récupère l'action demandée depuis l'URL

    switch ($action) {
        case 'authors':
            // Récupère tous les auteurs de la table 'auteurs'
            $sql = "SELECT id_auteur, nom, prenom, DATE_FORMAT(date_naissance, '%Y-%m-%d') as date_naissance, ville_origine, biographie FROM auteurs";
            $result = $conn->query($sql);
            $authors = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Ajoute chaque ligne au tableau des auteurs
                    $row['id_auteur'] = encryptId($row['id_auteur']);
                    $authors[] = $row;
                }
            }
            echo json_encode($authors); // Renvoie les auteurs au format JSON
            break;

        case 'novels':
            // Récupère tous les romans de la table 'romans'
            $sql = "
            SELECT
                r.id_roman,
                r.titre,
                r.annee_publication,
                r.resume,
                r.image_url,
                r.id_auteur,
                a.nom AS auteur_nom,
                a.prenom AS auteur_prenom
            FROM romans r
            JOIN auteurs a ON r.id_auteur = a.id_auteur
            ";
            $result = $conn->query($sql);
            $novels = [];
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Ajoute chaque ligne au tableau des romans
                    $row['id_roman'] = encryptId($row['id_roman']);
                    $row['id_auteur'] = encryptId($row['id_auteur']);
                    $novels[] = $row;
                }
            }
            echo json_encode($novels); // Renvoie les romans au format JSON
            break;

        case 'author_details': // Nouvelle action pour les détails d'un auteur
            $encryptedId = $_GET['id'] ?? null;
            $id = $encryptedId ? decryptId($encryptedId) : 0;
            if (is_int($id) && $id > 0) {
                $stmt = $conn->prepare("SELECT id_auteur, nom, prenom, DATE_FORMAT(date_naissance, '%Y-%m-%d') as date_naissance, ville_origine, biographie FROM auteurs WHERE id_auteur = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $author = $result->fetch_assoc();
                echo json_encode($author);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Invalid author ID.']);
            }
            break;

        case 'novel_details': // Nouvelle action pour les détails d'un roman
            $encryptedId = $_GET['id'] ?? null;
            $id = $encryptedId ? decryptId($encryptedId) : 0;
            if (is_int($id) && $id > 0) {
                $stmt = $conn->prepare("SELECT id_roman, titre, annee_publication, resume, id_auteur, image_url FROM romans WHERE id_roman = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $novel = $result->fetch_assoc();
                echo json_encode($novel);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Invalid novel ID.']);
            }
            break;

        default:
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid GET action.']);
            break;
    }
}

// --- Gestion des Requêtes POST ---
// Utilisé pour envoyer des données (ex: login, ajouter un auteur, ajouter un roman).
if ($method === 'POST' && $input) {
    $action = $input['action'] ?? ''; // Récupère l'action demandée depuis le corps JSON ou $_POST

    switch ($action) {
        case 'login':
            // Assurez-vous que la session est démarrée pour définir les variables de session.
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $username = $input['username'] ?? '';
            $password = $input['password'] ?? '';

            $stmt = $conn->prepare("SELECT id, username, password_hash FROM admins WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $admin = $result->fetch_assoc();
                if (password_verify($password, $admin['password_hash'])) {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    echo json_encode(['success' => true, 'message' => 'Connexion réussie.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Mot de passe incorrect.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé.']);
            }
            $stmt->close();

            break;

        case 'add_author':
            // Vérifier l'authentification admin avant d'autoriser l'ajout
            if (session_status() == PHP_SESSION_NONE) { session_start(); }
            if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
                http_response_code(403); // Forbidden
                echo json_encode(['success' => false, 'message' => 'Accès refusé. Vous devez être connecté en tant qu\'administrateur.']);
                exit();
            }

            // Récupère les données de l'auteur depuis le corps de la requête JSON
            $nom = $input['nom'] ?? '';
            $prenom = $input['prenom'] ?? null;
            $date_naissance = $input['date_naissance'] ?? null;
            $ville_origine = $input['ville_origine'] ?? null;
            $biographie = $input['biographie'] ?? null;

            // Prépare la requête SQL pour insérer un nouvel auteur (prévient les injections SQL)
            $stmt = $conn->prepare("INSERT INTO auteurs (nom, prenom, date_naissance, ville_origine, biographie) VALUES (?, ?, ?, ?, ?)");
            // 'sssss' indique les types de paramètres : s=string, i=integer, d=double, b=blob
            $stmt->bind_param("sssss", $nom, $prenom, $date_naissance, $ville_origine, $biographie);

            // Exécute la requête préparée
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Auteur ajouté avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Échec de l\'ajout de l\'auteur: ' . $stmt->error]);
            }
            $stmt->close(); // Ferme la déclaration préparée
            break;

        case 'add_novel':
            // Vérifier l'authentification admin avant d'autoriser l'ajout
            if (session_status() == PHP_SESSION_NONE) { session_start(); }
            if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
                http_response_code(403); // Forbidden
                echo json_encode(['success' => false, 'message' => 'Accès refusé. Vous devez être connecté en tant qu\'administrateur.']);
                exit();
            }

            // Récupère les données du roman depuis le corps de la requête JSON
            $titre = $input['titre'] ?? '';
            $annee_publication = $input['annee_publication'] ?? null;
            $resume = $input['resume'] ?? null;
            $id_auteur = $input['id_auteur'] ?? null;
            $image_url = $input['image_url'] ?? null;

            // Valide que l'ID de l'auteur est un entier
            $id_auteur = filter_var($id_auteur, FILTER_VALIDATE_INT);
            if ($id_auteur === false || $id_auteur === null) {
                echo json_encode(['success' => false, 'message' => 'ID d\'auteur invalide.']);
                break;
            }

            // Prépare la requête SQL pour insérer un nouveau roman
            $stmt = $conn->prepare("INSERT INTO romans (titre, annee_publication, resume, id_auteur, image_url) VALUES (?, ?, ?, ?, ?)");
            // 'sisss' : s=string (titre), i=integer (annee_publication), s=string (resume), i=integer (id_auteur), s=string (image_url)
            $stmt->bind_param("sisss", $titre, $annee_publication, $resume, $id_auteur, $image_url);

            // Exécute la requête préparée
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Roman ajouté avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Échec de l\'ajout du roman: ' . $stmt->error]);
            }
            $stmt->close(); // Ferme la déclaration préparée
            break;

        case 'update_author':
            // Vérification de l'authentification admin
            if (session_status() == PHP_SESSION_NONE) { session_start(); }
            if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Accès refusé.']);
                exit();
            }

            $id_auteur = $input['id_auteur'] ?? null;
            $nom = $input['nom'] ?? '';
            $prenom = $input['prenom'] ?? null;
            $date_naissance = $input['date_naissance'] ?? null;
            $ville_origine = $input['ville_origine'] ?? null;
            $biographie = $input['biographie'] ?? null;

            if (!$id_auteur || !filter_var($id_auteur, FILTER_VALIDATE_INT)) {
                echo json_encode(['success' => false, 'message' => 'ID d\'auteur invalide ou manquant.']);
                break;
            }

            $stmt = $conn->prepare("UPDATE auteurs SET nom = ?, prenom = ?, date_naissance = ?, ville_origine = ?, biographie = ? WHERE id_auteur = ?");
            $stmt->bind_param("sssssi", $nom, $prenom, $date_naissance, $ville_origine, $biographie, $id_auteur);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Auteur mis à jour avec succès.', 'author_id' => encryptId($id_auteur)]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Échec de la mise à jour de l\'auteur: ' . $stmt->error]);
            }
            $stmt->close();
            break;

        case 'delete_author':
            // Vérification de l'authentification admin
            if (session_status() == PHP_SESSION_NONE) { session_start(); }
            if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Accès refusé.']);
                exit();
            }
            
            $id_auteur = $input['id'] ?? null; // Utilisez 'id' car le formulaire de suppression l'envoie ainsi

            if (!$id_auteur || !filter_var($id_auteur, FILTER_VALIDATE_INT)) {
                echo json_encode(['success' => false, 'message' => 'ID d\'auteur invalide ou manquant.']);
                break;
            }

            $stmt = $conn->prepare("DELETE FROM auteurs WHERE id_auteur = ?");
            $stmt->bind_param("i", $id_auteur);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Auteur supprimé avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Échec de la suppression de l\'auteur: ' . $stmt->error]);
            }
            $stmt->close();
            break;
        
        case 'update_novel':
             // Vérification de l'authentification admin
             if (session_status() == PHP_SESSION_NONE) { session_start(); }
             if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
                 http_response_code(403);
                 echo json_encode(['success' => false, 'message' => 'Accès refusé.']);
                 exit();
             }

            $id_roman = $input['id_roman'] ?? null;
            $titre = $input['titre'] ?? '';
            $annee_publication = $input['annee_publication'] ?? null;
            $resume = $input['resume'] ?? null;
            $id_auteur = $input['id_auteur'] ?? null;
            $image_url = $input['image_url'] ?? null;

            if (!$id_roman || !filter_var($id_roman, FILTER_VALIDATE_INT)) {
                echo json_encode(['success' => false, 'message' => 'ID de roman invalide ou manquant.']);
                break;
            }
            if (!$id_auteur || !filter_var($id_auteur, FILTER_VALIDATE_INT)) {
                echo json_encode(['success' => false, 'message' => 'ID d\'auteur invalide ou manquant pour le roman.']);
                break;
            }

            $stmt = $conn->prepare("UPDATE romans SET titre = ?, annee_publication = ?, resume = ?, id_auteur = ?, image_url = ? WHERE id_roman = ?");
            $stmt->bind_param("sissis", $titre, $annee_publication, $resume, $id_auteur, $image_url, $id_roman);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Roman mis à jour avec succès.', 'novel_id' => encryptId($id_roman)]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Échec de la mise à jour du roman: ' . $stmt->error]);
            }
            $stmt->close();
            break;
 
         case 'delete_novel':
             // Vérification de l'authentification admin
             if (session_status() == PHP_SESSION_NONE) { session_start(); }
             if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
                 http_response_code(403);
                 echo json_encode(['success' => false, 'message' => 'Accès refusé.']);
                 exit();
             }
            
            $id_roman = $input['id'] ?? null; // Utilisez 'id' car le formulaire de suppression l'envoie ainsi

            if (!$id_roman || !filter_var($id_roman, FILTER_VALIDATE_INT)) {
                echo json_encode(['success' => false, 'message' => 'ID de roman invalide ou manquant.']);
                break;
            }

            $stmt = $conn->prepare("DELETE FROM romans WHERE id_roman = ?");
            $stmt->bind_param("i", $id_roman);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Roman supprimé avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Échec de la suppression du roman: ' . $stmt->error]);
            }
            $stmt->close();
             break;


        default:
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Action POST invalide.']);
            break;
    }
}

// Ferme la connexion à la base de données à la fin du script
$conn->close();
?>
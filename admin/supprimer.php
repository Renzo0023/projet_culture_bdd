<?php
// admin/supprimer.php
require_once __DIR__ . '/../includes/header.php'; // Inclut l'en-tête commun
require_once __DIR__ . '/../includes/db.php';     // Inclut la connexion à la base de données
require_once __DIR__ . '/../crypto.php';

// Vérifie si l'administrateur est connecté. Si non, redirige.
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    $_SESSION['message'] = 'Veuillez vous connecter pour supprimer des éléments.';
    header('Location: login.php');
    exit();
}

$type = $_GET['type'] ?? '';
$encrypted_id = $_GET['id'] ?? null;

$id = $encrypted_id ? decryptId($encrypted_id) : null;

// Vérifie si le type et l'ID sont valides
if (!in_array($type, ['auteur', 'roman']) || !$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    $_SESSION['message'] = 'Requête de suppression non valide.';
    header('Location: dashboard.php');
    exit();
}

// Récupère les détails de l'élément à supprimer pour affichage
try {
    if ($type === 'auteur') {
        $stmt = $pdo->prepare("SELECT nom, prenom FROM auteurs WHERE id_auteur = ?");
        $stmt->execute([$id]);
        $item_details = $stmt->fetch();
        if ($item_details) {
            $item_name = htmlspecialchars($item_details['prenom'] . ' ' . $item_details['nom']);
        }
    } else { // type === 'roman'
        $stmt = $pdo->prepare("SELECT titre FROM romans WHERE id_roman = ?");
        $stmt->execute([$id]);
        $item_details = $stmt->fetch();
        if ($item_details) {
            $item_name = htmlspecialchars($item_details['titre']);
        }
    }

    if (!$item_details) {
        $_SESSION['message'] = ucfirst($type) . ' introuvable pour la suppression.';
        header('Location: dashboard.php');
        exit();
    }

} catch (PDOException $e) {
    $_SESSION['message'] = 'Erreur lors de la récupération des détails: ' . $e->getMessage();
    header('Location: dashboard.php');
    exit();
}
?>

<div class="container mx-auto p-4 md:p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Confirmation de Suppression</h2>
    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200 max-w-xl mx-auto text-center">
        <p class="text-xl text-red-600 mb-6">Êtes-vous sûr de vouloir supprimer <?php echo ($type === 'auteur' ? 'l\'auteur' : 'le roman'); ?> "<?php echo $item_name; ?>" ?</p>
        <p class="text-gray-700 mb-8">Cette action est irréversible.</p>

        <form id="delete-form" class="inline-block" method="POST" action="/projet_culture_bdd/api.php">
            <input type="hidden" name="action" value="delete_<?php echo $type === 'auteur' ? 'author' : 'novel'; ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-full mr-4">Confirmer la suppression</button>
        </form>
        <a href="/projet_culture_bdd/admin/dashboard.php" class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300 ease-in-out">Annuler</a>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php'; // Inclut le pied de page commun
?>


<?php
// admin/modifier_auteur.php
require_once __DIR__ . '/../includes/header.php'; // Inclut l'en-tête commun
require_once __DIR__ . '/../includes/db.php';     // Inclut la connexion à la base de données
require_once __DIR__ . '/../crypto.php';

// Vérifie si l'administrateur est connecté. Si non, redirige.
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    $_SESSION['message'] = 'Veuillez vous connecter pour modifier un auteur.';
    header('Location: login.php');
    exit();
}

$author = null;
// Récupère l'ID de l'auteur depuis l'URL

$id_auteur = $_GET['id'] ?? null;
if ($id_auteur) {
    $id_auteur = decryptId($id_auteur);
}

// Vérifie si un ID d'auteur valide est fourni
if ($id_auteur && filter_var($id_auteur, FILTER_VALIDATE_INT)) {
    // Récupère les informations de l'auteur depuis la base de données
    $stmt = $pdo->prepare("SELECT id_auteur, nom, prenom, DATE_FORMAT(date_naissance, '%Y-%m-%d') as date_naissance, ville_origine, biographie FROM auteurs WHERE id_auteur = ?");
    $stmt->execute([$id_auteur]);
    $author = $stmt->fetch();

    if (!$author) {
        // Auteur non trouvé, définit un message d'erreur et redirige
        $_SESSION['message'] = 'Auteur introuvable.';
        header('Location: recherche.php?type=auteur'); // Redirige vers la page de recherche d'auteurs
        exit();
    }
} else {
    // ID d'auteur non valide ou manquant, définit un message d'erreur et redirige
    $_SESSION['message'] = 'ID d\'auteur non valide ou manquant.';
    header('Location: dashboard.php'); // Redirige vers le tableau de bord
    exit();
}
?>

<div class="container mx-auto p-4 md:p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Modifier Auteur: <?php echo htmlspecialchars($author['prenom'] . ' ' . $author['nom']); ?></h2>
    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200 max-w-xl mx-auto">

        <!-- Formulaire de modification d'auteur. Notez l'ID et l'attribut data-id pour le JS -->
        <form id="modify-author-form" class="space-y-4" data-author-id="<?php echo htmlspecialchars($author['id_auteur']); ?>">
            <p class="admin-message text-center mb-4"></p> <!-- Pour les messages de succès/erreur via JS -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($author['nom']); ?>" required />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($author['prenom']); ?>" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date_naissance">Date de naissance:</label>
                <input type="date" id="date_naissance" name="date_naissance" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($author['date_naissance']); ?>" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="ville_origine">Ville d'origine:</label>
                <input type="text" id="ville_origine" name="ville_origine" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($author['ville_origine']); ?>" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="biographie">Biographie:</label>
                <textarea id="biographie" name="biographie" class="shadow appearance-none border rounded w-full py-2 px-3 h-24"><?php echo htmlspecialchars($author['biographie']); ?></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300 transform hover:scale-105">Modifier Auteur</button>
                <a href="/projet_culture_bdd/auteur.php?id=<?php echo urlencode(encryptId($author['id_auteur'])); ?>" class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300 ease-in-out ml-4">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php'; // Inclut le pied de page commun
?>

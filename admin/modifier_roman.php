<?php
// admin/modifier_roman.php
require_once __DIR__ . '/../includes/header.php'; // Inclut l'en-tête commun
require_once __DIR__ . '/../includes/db.php';     // Inclut la connexion à la base de données
require_once __DIR__ . '/../crypto.php';

// Vérifie si l'administrateur est connecté. Si non, redirige.
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    $_SESSION['message'] = 'Veuillez vous connecter pour modifier un roman.';
    header('Location: login.php');
    exit();
}

$roman = null;
$authors = []; // Pour la liste déroulante des auteurs
$id_roman = $_GET['id'] ?? null;

if ($id_roman) {
    $id_roman = decryptId($id_roman);
}

// Récupère tous les auteurs pour la liste déroulante
try {
    $stmt_authors = $pdo->query("SELECT id_auteur, nom, prenom FROM auteurs ORDER BY nom ASC");
    $authors = $stmt_authors->fetchAll();
} catch (PDOException $e) {
    $_SESSION['message'] = 'Erreur lors du chargement des auteurs: ' . $e->getMessage();
    header('Location: dashboard.php'); // Ou gérer l'erreur autrement
    exit();
}


// Vérifie si un ID de roman valide est fourni
if ($id_roman && filter_var($id_roman, FILTER_VALIDATE_INT)) {
    // Récupère les informations du roman depuis la base de données
    $stmt = $pdo->prepare("SELECT id_roman, titre, annee_publication, resume, id_auteur, image_url FROM romans WHERE id_roman = ?");
    $stmt->execute([$id_roman]);
    $roman = $stmt->fetch();

    if (!$roman) {
        // Roman non trouvé, définit un message d'erreur et redirige
        $_SESSION['message'] = 'Roman introuvable.';
        header('Location: dashboard.php'); // Redirige vers le tableau de bord ou une liste de romans
        exit();
    }
} else {
    // ID de roman non valide ou manquant, définit un message d'erreur et redirige
    $_SESSION['message'] = 'ID de roman non valide ou manquant.';
    header('Location: dashboard.php'); // Redirige vers le tableau de bord
    exit();
}
?>

<div class="container mx-auto p-4 md:p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Modifier Roman: <?php echo htmlspecialchars($roman['titre']); ?></h2>
    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200 max-w-xl mx-auto">

        <!-- Formulaire de modification de roman. Notez l'ID et l'attribut data-id pour le JS -->
        <form id="modify-novel-form" class="space-y-4" data-novel-id="<?php echo htmlspecialchars($roman['id_roman']); ?>">
            <p class="admin-message text-center mb-4"></p> <!-- Pour les messages de succès/erreur via JS -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="titre">Titre:</label>
                <input type="text" id="titre" name="titre" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($roman['titre']); ?>" required />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="annee_publication">Année de publication:</label>
                <input type="number" id="annee_publication" name="annee_publication" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($roman['annee_publication']); ?>" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="resume">Résumé:</label>
                <textarea id="resume" name="resume" class="shadow appearance-none border rounded w-full py-2 px-3 h-24"><?php echo htmlspecialchars($roman['resume']); ?></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="id_auteur">Auteur:</label>
                <select id="id_auteur" name="id_auteur" class="shadow appearance-none border rounded w-full py-2 px-3 bg-white text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400" required>
                    <option value="">Sélectionnez un auteur</option>
                    <?php foreach ($authors as $author_option): ?>
                        <option value="<?php echo htmlspecialchars($author_option['id_auteur']); ?>"
                            <?php echo ($author_option['id_auteur'] == $roman['id_auteur']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($author_option['prenom'] . ' ' . $author_option['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image_url">URL Image (optionnel):</label>
                <input type="text" id="image_url" name="image_url" class="shadow appearance-none border rounded w-full py-2 px-3" value="<?php echo htmlspecialchars($roman['image_url']); ?>" />
                <?php if (!empty($roman['image_url'])): ?>
                    <div class="mt-2 text-center">
                        <img src="<?php echo htmlspecialchars($roman['image_url']); ?>" alt="Couverture actuelle" class="max-w-[150px] h-auto rounded-md shadow-md mx-auto" onerror="this.onerror=null;this.src='https://placehold.co/150x225/cccccc/333333?text=Image+manquante';"/>
                    </div>
                <?php endif; ?>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300 transform hover:scale-105">Modifier Roman</button>
                <a href="/projet_culture_bdd/roman.php?id=<?php echo urlencode(encryptId($roman['id_roman'])); ?>" class="inline-block bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300 ease-in-out ml-4">Annuler</a>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php'; // Inclut le pied de page commun
?>

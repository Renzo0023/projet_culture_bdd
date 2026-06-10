<?php
// admin/ajouter_roman.php
require_once __DIR__ . '/../includes/header.php'; // Inclut l'en-tête commun
require_once __DIR__ . '/../includes/db.php';

// Vérifie si l'administrateur est connecté. Si non, redirige.
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    $_SESSION['message'] = 'Veuillez vous connecter pour ajouter un roman.';
    header('Location: login.php');
    exit();
}

// Récupération des auteurs
$stmt = $pdo->query("
    SELECT id_auteur, nom, prenom
    FROM auteurs
    ORDER BY nom, prenom
");

$auteurs = $stmt->fetchAll();

?>

<div class="container mx-auto p-4 md:p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Ajouter un Nouveau Roman</h2>
    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200 max-w-xl mx-auto">

        <!-- Formulaire d'ajout de roman. L'ID 'add-novel-form' est crucial pour le js/script.js -->
        <form id="add-novel-form" method="post" class="space-y-4">
            <p class="admin-message text-center mb-4"></p> <!-- Pour les messages de succès/erreur via JS -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="titre">Titre:</label>
                <input type="text" id="titre" name="titre" class="shadow appearance-none border rounded w-full py-2 px-3" required />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="annee_publication">Année de publication:</label>
                <input type="number" id="annee_publication" name="annee_publication" class="shadow appearance-none border rounded w-full py-2 px-3" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="resume">Résumé:</label>
                <textarea id="resume" name="resume" class="shadow appearance-none border rounded w-full py-2 px-3 h-24"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="id_auteur">
                    Auteur :
                </label>

                <select
                    id="id_auteur"
                    name="id_auteur"
                    class="shadow appearance-none border rounded w-full py-2 px-3"
                    required
                >
                    <option value="">-- Sélectionner un auteur --</option>

                    <?php foreach ($auteurs as $auteur): ?>
                        <option value="<?= $auteur['id_auteur']; ?>">
                            <?= htmlspecialchars($auteur['prenom'] . ' ' . $auteur['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="image_url">URL Image (optionnel):</label>
                <input type="text" id="image_url" name="image_url" class="shadow appearance-none border rounded w-full py-2 px-3" />
            </div>
            <div class="admin-message text-center text-sm mt-2"></div>
            <div class="text-center">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full">Ajouter Roman</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php'; // Inclut le pied de page commun
?>

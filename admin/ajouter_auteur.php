<?php
// admin/ajouter_auteur.php
require_once __DIR__ . '/../includes/header.php'; // Inclut l'en-tête commun

// Vérifie si l'administrateur est connecté. Si non, redirige.
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    $_SESSION['message'] = 'Veuillez vous connecter pour ajouter un auteur.';
    header('Location: login.php');
    exit();
}
?>

<div class="container mx-auto p-4 md:p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Ajouter un Nouvel Auteur</h2>
    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200 max-w-xl mx-auto">

        <!-- Formulaire d'ajout d'auteur. L'ID 'add-author-form' est crucial pour le js/script.js -->
        <form id="add-author-form" method="post" class="space-y-4">
            <p class="admin-message text-center mb-4"></p> <!-- Pour les messages de succès/erreur via JS -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" class="shadow appearance-none border rounded w-full py-2 px-3" required />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" class="shadow appearance-none border rounded w-full py-2 px-3" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="date_naissance">Date de naissance:</label>
                <input type="date" id="date_naissance" name="date_naissance" class="shadow appearance-none border rounded w-full py-2 px-3" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="ville_origine">Ville d'origine:</label>
                <input type="text" id="ville_origine" name="ville_origine" class="shadow appearance-none border rounded w-full py-2 px-3" />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="biographie">Biographie:</label>
                <textarea id="biographie" name="biographie" class="shadow appearance-none border rounded w-full py-2 px-3 h-24"></textarea>
            </div>
            <div class="admin-message text-center text-sm mt-2"></div>
            <div class="text-center">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full">Ajouter Auteur</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php'; // Inclut le pied de page commun
?>

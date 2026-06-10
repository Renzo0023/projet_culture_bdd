<?php
// admin/dashboard.php
require_once __DIR__ . '/../includes/header.php'; // Inclut l'en-tête commun

// Vérifie si l'administrateur est connecté. Si non, redirige vers la page de connexion.
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    $_SESSION['message'] = 'Veuillez vous connecter pour accéder au tableau de bord.';
    header('Location: login.php');
    exit();
}

// Message de session après une action (ajout, modif, suppression)
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']); // Efface le message après l'avoir affiché
?>

<div class="container mx-auto p-4 md:p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Tableau de Bord Administrateur</h2>

    <?php if (!empty($message)): ?>
        <p class="admin-message text-center <?php echo strpos($message, 'succès') !== false ? 'text-green-600' : 'text-red-600'; ?> font-medium mb-4">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>

    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200 max-w-4xl mx-auto space-y-8">
        <p class="text-center text-green-700 text-xl font-semibold">Bienvenue dans votre panneau d'administration !</p>

        <!-- Section de gestion des Auteurs -->
        <div class="border-t pt-6">
            <h3 class="text-2xl font-semibold text-blue-600 mb-4 text-center">Gestion des Auteurs</h3>
            <div class="flex justify-center space-x-4">
                <a href="/projet_culture_bdd/admin/ajouter_auteur.php" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full">Ajouter un Auteur</a>
                <!-- Liens vers modifier/supprimer seront affichés dans une liste d'auteurs réels -->
                <a href="/projet_culture_bdd/admin/gerer.php?type=auteur" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-full">Gérer les Auteurs</a>
            </div>
            <!-- Ici, on pourrait lister les auteurs existants avec des liens modifier/supprimer -->
        </div>

        <!-- Section de gestion des Romans -->
        <div class="border-t pt-6">
            <h3 class="text-2xl font-semibold text-indigo-600 mb-4 text-center">Gestion des Romans</h3>
            <div class="flex justify-center space-x-4">
                <a href="/projet_culture_bdd/admin/ajouter_roman.php" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full">Ajouter un Roman</a>
                <!-- Liens vers modifier/supprimer seront affichés dans une liste de romans réels -->
                <a href="/projet_culture_bdd/admin/gerer.php?type=roman" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-full">Gérer les Romans</a>
            </div>
            <!-- Ici, on pourrait lister les romans existants avec des liens modifier/supprimer -->
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php'; // Inclut le pied de page commun
?>

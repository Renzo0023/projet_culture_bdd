<?php
require_once __DIR__ . '/../includes/header.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    header('Location: dashboard.php');
    exit();
}

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<div class="container mx-auto p-4 md:p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Administration</h2>
    <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200 max-w-xl mx-auto">
        <form id="admin-login-form" method="post" novalidate data-js="true" class="space-y-4">
            <h3 class="text-2xl font-semibold text-blue-700 mb-4 text-center">Connexion Administrateur</h3>

            <!-- Message PHP (ex: déconnexion réussie) -->
            <?php if (!empty($message)): ?>
                <p class="text-center font-medium text-green-600"><?php echo htmlspecialchars($message); ?></p>
            <?php endif; ?>

            <!-- Message JS (rempli dynamiquement) -->
            <p class="admin-message text-center text-sm font-medium"></p>

            <div>
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Nom d'utilisateur :</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400"
                />
            </div>
            <div>
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe :</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-400"
                />
            </div>

            <!-- Action envoyée dans le body JSON si JS actif -->
            <input type="hidden" name="action" value="login">

            <div class="text-center">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105"
                >
                    Se connecter
                </button>
            </div>
        </form>

        <!-- Fallback sans JS -->
        <noscript>
            <p class="text-center text-red-600 mt-4">JavaScript est requis pour se connecter. Veuillez l'activer.</p>
        </noscript>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

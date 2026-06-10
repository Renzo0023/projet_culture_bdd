<?php
// admin/gerer.php
require_once __DIR__ . '/../includes/header.php'; // Inclut l'en-tête commun
require_once __DIR__ . '/../includes/db.php';     // Inclut la connexion à la base de données

// Vérifie si l'administrateur est connecté. Si non, redirige.
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    $_SESSION['message'] = 'Veuillez vous connecter pour gérer les éléments.';
    header('Location: login.php');
    exit();
}

$type = $_GET['type'] ?? ''; // 'auteur' ou 'roman'
$items = [];
$pageTitle = '';
$addLink = '';
$entityNameSingular = '';
$entityNamePlural = '';

// Détermine le type de données à gérer
if ($type === 'auteur') {
    $pageTitle = 'Gérer les Auteurs';
    $addLink = '/projet_culture_bdd/admin/ajouter_auteur.php';
    $entityNameSingular = 'auteur';
    $entityNamePlural = 'auteurs';
    $sql = "SELECT id_auteur, nom, prenom, DATE_FORMAT(date_naissance, '%Y-%m-%d') as date_naissance, ville_origine FROM auteurs ORDER BY nom ASC";
} elseif ($type === 'roman') {
    $pageTitle = 'Gérer les Romans';
    $addLink = '/projet_culture_bdd/admin/ajouter_roman.php';
    $entityNameSingular = 'roman';
    $entityNamePlural = 'romans';
    // Jointure pour obtenir le nom de l'auteur
    $sql = "SELECT r.id_roman, r.titre, r.annee_publication, r.resume, r.image_url, a.prenom, a.nom
            FROM romans r
            JOIN auteurs a ON r.id_auteur = a.id_auteur
            ORDER BY r.titre ASC";
} else {
    $_SESSION['message'] = 'Type de gestion non valide.';
    header('Location: dashboard.php');
    exit();
}

// Récupère les éléments de la base de données
try {
    $stmt = $pdo->query($sql);
    $items = $stmt->fetchAll();
} catch (PDOException $e) {
    $_SESSION['message'] = 'Erreur lors du chargement des ' . $entityNamePlural . ': ' . $e->getMessage();
    header('Location: dashboard.php');
    exit();
}
?>

<div class="container mx-auto p-4 md:p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center"><?php echo $pageTitle; ?></h2>

    <div class="mb-6 text-center">
        <a href="<?php echo $addLink; ?>" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-full">Ajouter un <?php echo ucfirst($entityNameSingular); ?></a>
    </div>

    <?php if (empty($items)): ?>
        <p class="text-center text-gray-600 text-lg">Aucun <?php echo $entityNameSingular; ?> trouvé dans la base de données.</p>
    <?php else: ?>
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
            <input
                type="text"
                id="search-input-admin"
                placeholder="Rechercher un <?php echo $entityNameSingular; ?>..."
                class="w-full p-3 mb-6 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                data-search-type="<?php echo htmlspecialchars($type); ?>"
            />
            <div id="admin-results-container" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Les éléments seront générés ici par le JavaScript -->
                <p class="text-center text-gray-600">Chargement des données...</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php'; // Inclut le pied de page commun
?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInputAdmin = document.getElementById('search-input-admin');
        const adminResultsContainer = document.getElementById('admin-results-container');

        if (searchInputAdmin && adminResultsContainer) {
            const currentType = searchInputAdmin.dataset.searchType;
            let allItems = <?php echo json_encode($items); ?>; // Données initiales du PHP
            let allAuthors = []; // Pour les romans, afin de pouvoir chercher par nom d'auteur

            // Fonction pour afficher les éléments dans la liste d'administration
            function displayAdminItems(itemsToDisplay) {
                adminResultsContainer.innerHTML = ''; // Vide le conteneur

                if (itemsToDisplay.length === 0) {
                    adminResultsContainer.innerHTML = `<p class="text-center text-gray-600 text-lg">Aucun résultat trouvé pour cette recherche.</p>`;
                    return;
                }

                itemsToDisplay.forEach(item => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'bg-white rounded-xl shadow-md border border-gray-200 p-5 hover:shadow-xl transition-all duration-300';

                    if (currentType === 'auteur') {
                        itemDiv.innerHTML = `
                            <div class="flex justify-between items-start">

                                <div>
                                    <h3 class="text-xl font-bold text-blue-700">
                                        ${item.prenom} ${item.nom}
                                    </h3>

                                    <p class="text-gray-600 mt-2">
                                        📍 ${item.ville_origine || 'Origine inconnue'}
                                    </p>

                                    <p class="text-gray-500 text-sm">
                                        🎂 ${item.date_naissance || 'Date inconnue'}
                                    </p>
                                </div>

                                <div class="flex gap-2">
                                    <a href="/projet_culture_bdd/admin/modifier_auteur.php?id=${item.id_auteur}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow">
                                        Modifier
                                    </a>

                                    <a href="/projet_culture_bdd/admin/supprimer.php?type=auteur&id=${item.id_auteur}"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow">
                                        Supprimer
                                    </a>
                                </div>

                            </div>
                        `;
                    } else if (currentType === 'roman') {
                        // Pour les romans dans l'admin, les données déjà récupérées via PHP contiennent l'auteur
                        const authorName = item.prenom && item.nom ? `${item.prenom} ${item.nom}` : 'Auteur inconnu';
                        itemDiv.innerHTML = `
                            <div class="flex flex-col md:flex-row justify-between gap-5">

                                <div class="flex gap-4">

                                    <img
                                        src="${item.image_url || 'https://placehold.co/120x180'}"
                                        alt="${item.titre}"
                                        class="w-24 h-36 object-cover rounded-lg shadow-md"
                                        onerror="this.onerror=null;this.src='https://placehold.co/120x180';"
                                    >

                                    <div>

                                        <h3 class="text-xl font-bold text-indigo-700">
                                            ${item.titre}
                                        </h3>

                                        <p class="text-gray-600 mt-1">
                                            ✍️ ${authorName}
                                        </p>

                                        <p class="text-gray-500 text-sm">
                                            📅 ${item.annee_publication || 'Non renseignée'}
                                        </p>

                                        <p class="text-gray-700 mt-3 line-clamp-3">
                                            ${item.resume || 'Aucun résumé disponible'}
                                        </p>

                                    </div>

                                </div>

                                <div class="flex gap-2 self-start">

                                    <a href="/projet_culture_bdd/admin/modifier_roman.php?id=${item.id_roman}"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow">
                                        Modifier
                                    </a>

                                    <a href="/projet_culture_bdd/admin/supprimer.php?type=roman&id=${item.id_roman}"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow">
                                        Supprimer
                                    </a>

                                </div>

                            </div>
                            `;
                    }
                    adminResultsContainer.appendChild(itemDiv);
                });
            }

            // Écouteur d'événements pour la recherche dans le panneau d'administration
            searchInputAdmin.addEventListener('input', () => {
                const searchTerm = searchInputAdmin.value.toLowerCase();
                const filteredItems = allItems.filter(item => {
                    if (currentType === 'auteur') {
                        return item.nom.toLowerCase().includes(searchTerm) ||
                               (item.prenom && item.prenom.toLowerCase().includes(searchTerm)) ||
                               (item.ville_origine && item.ville_origine.toLowerCase().includes(searchTerm)) ||
                               (item.biographie && item.biographie.toLowerCase().includes(searchTerm));
                    } else if (currentType === 'roman') {
                        // Pour les romans, la recherche inclut le nom de l'auteur (même si l'auteur n'est pas directement dans 'item')
                        const authorFullName = item.prenom && item.nom ? `${item.prenom} ${item.nom}`.toLowerCase() : '';
                        return item.titre.toLowerCase().includes(searchTerm) ||
                               (item.resume && item.resume.toLowerCase().includes(searchTerm)) ||
                               authorFullName.includes(searchTerm);
                    }
                    return false;
                });
                displayAdminItems(filteredItems);
            });

            // Initialisation: charger les données
            // Si c'est une recherche de romans, nous devons d'abord charger tous les auteurs pour la recherche par nom d'auteur
            if (currentType === 'roman') {
                apiRequest('authors', 'GET').then(data => {
                    allAuthors = data; // Stocke les auteurs pour la fonction de filtrage
                    displayAdminItems(allItems); // Affiche les romans une fois les auteurs disponibles
                }).catch(error => {
                    console.error("Erreur lors du chargement des auteurs pour la page d'administration des romans:", error);
                    adminResultsContainer.innerHTML = `<p class="col-span-full text-center text-red-600 text-lg">Erreur lors du chargement des données. Veuillez recharger la page.</p>`;
                });
            } else {
                displayAdminItems(allItems); // Affiche les éléments directement (auteurs)
            }
        }
    });
</script>

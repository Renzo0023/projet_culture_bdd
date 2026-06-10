<?php
// recherche.php
require_once __DIR__ . '/includes/header.php'; // Inclut l'en-tête commun

$type = $_GET['type'] ?? 'auteur'; // Détermine le type de recherche (auteur ou roman)
$pageTitle = ($type === 'auteur') ? 'Liste des Auteurs' : 'Liste des Romans';
$placeholder = ($type === 'auteur') ? 'Rechercher un auteur...' : 'Rechercher un roman (titre, auteur, résumé)...';
$searchInputDataset = ($type === 'auteur') ? 'auteur' : 'roman';
// $searchInputDataset = ($type === 'auteur') ? 'authors' : 'novels';
$cardClasses = ($type === 'auteur') ? 'text-blue-700' : 'text-indigo-700'; // Couleur spécifique pour les titres de cartes

?>

<div class="container mx-auto p-4 md:p-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center"><?php echo $pageTitle; ?></h2>
    <input
        type="text"
        id="search-input"
        placeholder="<?php echo $placeholder; ?>"
        class="w-full p-3 mb-6 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        data-search-type="<?php echo $searchInputDataset; ?>"
    />
    <!-- Ce conteneur sera rempli par le JavaScript -->
    <div id="results-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <p class="col-span-full text-center text-gray-600 text-lg">Chargement des données...</p>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php'; // Inclut le pied de page commun
?>

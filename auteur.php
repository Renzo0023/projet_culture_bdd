<?php
// auteur.php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';
require_once 'crypto.php';

$author = null;
$novels_by_author = [];

// Vérifie si un ID est présent
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id_auteur = decryptId($_GET['id']);

    // Vérification stricte du résultat du déchiffrement
    if (is_numeric($id_auteur) && (int)$id_auteur > 0) {

        $id_auteur = (int)$id_auteur;

        // Récupère les détails de l'auteur
        $stmt = $pdo->prepare("
            SELECT
                id_auteur,
                nom,
                prenom,
                DATE_FORMAT(date_naissance, '%d/%m/%Y') as date_naissance_fr,
                ville_origine,
                biographie
            FROM auteurs
            WHERE id_auteur = ?
        ");

        $stmt->execute([$id_auteur]);
        $author = $stmt->fetch();

        if ($author) {

            // Récupère les romans de l'auteur
            $stmt_novels = $pdo->prepare("
                SELECT id_roman, titre, annee_publication, resume, image_url
                FROM romans
                WHERE id_auteur = ?
                ORDER BY annee_publication DESC
            ");

            $stmt_novels->execute([$id_auteur]);
            $novels_by_author = $stmt_novels->fetchAll();
        }
    }
}
?>

<div class="container mx-auto p-4 md:p-8">

    <?php if ($author): ?>

        <div class="bg-white p-8 rounded-lg shadow-xl border border-gray-200 mb-8 max-w-4xl mx-auto">

            <h2 class="text-4xl font-extrabold text-blue-800 mb-4 text-center">
                <?php echo htmlspecialchars($author['prenom'] . ' ' . $author['nom']); ?>
            </h2>

            <div class="text-gray-700 text-lg leading-relaxed">
                <p class="mb-2">
                    <strong class="text-blue-600">Date de naissance:</strong>
                    <?php echo htmlspecialchars($author['date_naissance_fr']); ?>
                </p>

                <p class="mb-2">
                    <strong class="text-blue-600">Ville d'origine:</strong>
                    <?php echo htmlspecialchars($author['ville_origine']); ?>
                </p>

                <p class="mb-4">
                    <strong class="text-blue-600">Biographie:</strong><br>
                    <?php echo nl2br(htmlspecialchars($author['biographie'])); ?>
                </p>
            </div>
        </div>

        <h3 class="text-3xl font-bold text-gray-800 mb-6 text-center">
            Romans de <?php echo htmlspecialchars($author['prenom'] . ' ' . $author['nom']); ?>
        </h3>

        <?php if (!empty($novels_by_author)): ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <?php foreach ($novels_by_author as $novel): ?>

                    <?php $romanId = encryptId($novel['id_roman']); ?>

                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200 flex flex-col items-center text-center">

                        <img
                            src="<?php echo htmlspecialchars($novel['image_url'] ?: 'https://placehold.co/100x150/cccccc/333333?text=Image+manquante'); ?>"
                            alt="Couverture de <?php echo htmlspecialchars($novel['titre']); ?>"
                            class="w-24 h-36 object-cover rounded-md mb-4 shadow-md"
                            onerror="this.onerror=null; this.src='https://placehold.co/100x150/cccccc/333333?text=Image+manquante';"
                        />

                        <h4 class="text-xl font-semibold text-indigo-700 mb-2">
                            <?php echo htmlspecialchars($novel['titre']); ?>
                        </h4>

                        <p class="text-gray-600 text-sm mb-3">
                            Année: <?php echo htmlspecialchars($novel['annee_publication']); ?>
                        </p>

                        <p class="text-gray-700 text-base line-clamp-3">
                            <?php echo htmlspecialchars($novel['resume']); ?>
                        </p>

                        <a href="/projet_culture_bdd/roman.php?id=<?php echo htmlspecialchars($romanId); ?>"
                           class="mt-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full text-sm transition-all duration-300 ease-in-out transform hover:scale-105 shadow">
                            Voir Détails
                        </a>

                    </div>

                <?php endforeach; ?>

            </div>

            <div class="text-center mt-8">
                <a href="/projet_culture_bdd/recherche.php?type=auteur"
                   class="inline-block bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300 ease-in-out">
                    Retour à la liste des auteurs
                </a>
            </div>

        <?php else: ?>

            <p class="text-center text-gray-600 text-lg">
                Aucun roman trouvé pour cet auteur.
            </p>

        <?php endif; ?>

        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>

            <div class="text-center mt-6">
                <a href="admin/modifier_auteur.php?id=<?php echo urlencode(encryptId($author['id_auteur'])); ?>"
                    class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-full">
                        Modifier cet auteur
                </a>

                <a href="admin/supprimer.php?type=auteur&id=<?php echo urlencode(encryptId($author['id_auteur'])); ?>"
                   class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300 ease-in-out">
                    Supprimer cet auteur
                </a>
            </div>

        <?php endif; ?>

    <?php else: ?>

        <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200 text-center max-w-xl mx-auto">

            <p class="text-red-600 text-xl font-semibold">Auteur introuvable.</p>

            <p class="text-gray-600 mt-4">
                L'ID d'auteur spécifié n'est pas valide ou n'existe pas.
            </p>

            <a href="/projet_culture_bdd/recherche.php?type=auteur"
               class="mt-6 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300 ease-in-out">
                Retour à la liste des auteurs
            </a>

        </div>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
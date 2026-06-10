<?php
// roman.php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/db.php';
require_once 'crypto.php';

$roman = null;
$auteur = null;

// Vérifie si un ID est présent
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id_roman = decryptId($_GET['id']);

    // Vérification du résultat du déchiffrement
    if (is_numeric($id_roman) && (int)$id_roman > 0) {

        $id_roman = (int)$id_roman;

        // Récupère le roman + auteur (jointure)
        $stmt = $pdo->prepare("
            SELECT
                r.id_roman,
                r.titre,
                r.annee_publication,
                r.resume,
                r.image_url,
                a.id_auteur,
                a.nom,
                a.prenom,
                a.ville_origine
            FROM romans r
            JOIN auteurs a ON r.id_auteur = a.id_auteur
            WHERE r.id_roman = ?
        ");

        $stmt->execute([$id_roman]);
        $roman = $stmt->fetch();

        if ($roman) {

            $auteur = [
                'id_auteur' => $roman['id_auteur'],
                'nom' => $roman['nom'],
                'prenom' => $roman['prenom'],
                'ville_origine' => $roman['ville_origine']
            ];
        }
    }
}
?>

<div class="container mx-auto p-4 md:p-8">

    <?php if ($roman): ?>

        <div class="bg-white p-8 rounded-lg shadow-xl border border-gray-200 mb-8 max-w-4xl mx-auto flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">

            <div class="md:w-1/3 flex-shrink-0">
                <img
                    src="<?php echo htmlspecialchars($roman['image_url'] ?: 'https://placehold.co/200x300/cccccc/333333?text=Image+manquante'); ?>"
                    alt="Couverture de <?php echo htmlspecialchars($roman['titre']); ?>"
                    class="w-full h-auto object-cover rounded-lg shadow-md max-w-[200px] md:max-w-none mx-auto"
                    onerror="this.onerror=null; this.src='https://placehold.co/200x300/cccccc/333333?text=Image+manquante';"
                />
            </div>

            <div class="md:w-2/3 text-center md:text-left">

                <h2 class="text-4xl font-extrabold text-indigo-800 mb-4">
                    <?php echo htmlspecialchars($roman['titre']); ?>
                </h2>

                <p class="text-xl text-gray-700 mb-2">
                    Par:
                    <a href="/projet_culture_bdd/auteur.php?id=<?php echo htmlspecialchars(encryptId($auteur['id_auteur'])); ?>"
                       class="text-blue-600 hover:underline">
                        <?php echo htmlspecialchars($auteur['prenom'] . ' ' . $auteur['nom']); ?>
                    </a>
                </p>

                <p class="text-gray-600 text-lg mb-4">
                    Année de publication:
                    <?php echo htmlspecialchars($roman['annee_publication']); ?>
                </p>

                <p class="text-gray-800 text-base leading-relaxed">
                    <?php echo nl2br(htmlspecialchars($roman['resume'])); ?>
                </p>

            </div>
        </div>

        <div class="text-center mt-8 flex justify-center gap-4">
            <a href="/projet_culture_bdd/recherche.php?type=roman"
            class="inline-block bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300 ease-in-out">
                Retour à la liste des romans
            </a>

            <!-- Bouton de suppression -->
             <?php if (!empty($_SESSION['admin_logged_in'])): ?>
                <a href="/projet_culture_bdd/admin/modifier_roman.php?id=<?php echo urlencode(encryptId($roman['id_roman'])); ?>"
                class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-full">
                    Modifier ce roman
                </a>

                <a href="/projet_culture_bdd/admin/supprimer.php?type=roman&id=<?php echo htmlspecialchars(encryptId($roman['id_roman'])); ?>"
                class="inline-block bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-full">
                    Supprimer ce roman
                </a>
            <?php endif; ?>
        </div>

    <?php else: ?>

        <div class="bg-white p-8 rounded-lg shadow-md border border-gray-200 text-center max-w-xl mx-auto">

            <p class="text-red-600 text-xl font-semibold">Roman introuvable.</p>

            <p class="text-gray-600 mt-4">
                L'ID de roman spécifié n'est pas valide ou n'existe pas.
            </p>

            <a href="/projet_culture_bdd/recherche.php?type=roman"
            class="inline-block bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full transition-all duration-300 ease-in-out">
                Retour à la liste des romans
            </a>

        </div>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
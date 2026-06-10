<?php
// includes/footer.php
?>
    </main>

    <!-- Fichier JavaScript personnalisé pour les interactions côté client -->
    <script src="/projet_culture_bdd/js/script.js"></script>
    <script>
        // Scripts JavaScript additionnels ou initialisations peuvent être placés ici.
        // Par exemple, si vous avez des messages flash de session à afficher.
        <?php if (isset($_SESSION['message'])): ?>
            // Détermine la couleur du message en fonction de son contenu
            const messageClass = '<?php echo strpos($_SESSION['message'], 'succès') !== false || strpos($_SESSION['message'], 'réussie') !== false ? 'bg-green-500' : 'bg-red-500'; ?>';
            const messageContainer = document.createElement('div');
            messageContainer.className = `fixed top-4 right-4 ${messageClass} text-white py-2 px-4 rounded-lg shadow-lg z-50`;
            messageContainer.textContent = '<?php echo addslashes($_SESSION['message']); ?>';
            document.body.appendChild(messageContainer);
            setTimeout(() => {
                messageContainer.remove();
            }, 3000); // Supprime le message après 3 secondes
            <?php unset($_SESSION['message']); // Supprime le message de la session ?>
        <?php endif; ?>
    </script>
</body>
</html>

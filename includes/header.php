<?php
// includes/header.php

// Démarrer la session PHP au tout début si ce n'est pas déjà fait
// C'est essentiel pour la gestion de l'authentification et des messages flash.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Littérature Marocaine</title>
    <!-- Chargement du CDN Tailwind CSS pour un stylisme rapide et réactif -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chargement de la police 'Inter' depuis Google Fonts pour une meilleure typographie -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Lien vers votre fichier CSS personnalisé (qui ne doit plus contenir de @apply) -->
    <link rel="stylesheet" href="/projet_culture_bdd/css/style.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* bg-gray-100 */
        }
        /* Styles pour les champs de formulaire, appliqués globalement via @apply ici pour fonctionner avec le CDN */
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="password"],
        textarea,
        select { /* Ajout de select pour uniformiser le style */
            @apply shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-blue-400;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Section de la barre de navigation (Navbar) -->
    <nav class="bg-gradient-to-r from-blue-600 to-indigo-700 p-4 shadow-lg rounded-b-lg">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <h1 class="text-white text-2xl md:text-3xl font-bold tracking-wide">Littérature Marocaine</h1>
            <div class="flex flex-wrap justify-center space-x-4 md:space-x-6">
                <!-- Liens de navigation publics -->
                <a href="/projet_culture_bdd/index.php" class="text-white hover:text-blue-200 text-lg font-medium transition duration-300 ease-in-out transform hover:scale-105 px-3 py-1 rounded-md">Accueil</a>
                <a href="/projet_culture_bdd/recherche.php?type=auteur" class="text-white hover:text-blue-200 text-lg font-medium transition duration-300 ease-in-out transform hover:scale-105 px-3 py-1 rounded-md">Auteurs</a>
                <a href="/projet_culture_bdd/recherche.php?type=roman" class="text-white hover:text-blue-200 text-lg font-medium transition duration-300 ease-in-out transform hover:scale-105 px-3 py-1 rounded-md">Romans</a>
                
                <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                    <!-- Liens pour les administrateurs connectés -->
                    <a href="/projet_culture_bdd/admin/dashboard.php" class="text-white hover:text-yellow-200 text-lg font-medium transition duration-300 ease-in-out transform hover:scale-105 px-3 py-1 rounded-md">Admin Dashboard</a>
                    <a href="/projet_culture_bdd/admin/logout.php" class="text-white hover:text-red-200 text-lg font-medium transition duration-300 ease-in-out transform hover:scale-105 px-3 py-1 rounded-md">Déconnexion</a>
                <?php else: ?>
                    <!-- Lien de connexion pour les non-administrateurs -->
                    <a href="/projet_culture_bdd/admin/login.php" class="text-white hover:text-green-200 text-lg font-medium transition duration-300 ease-in-out transform hover:scale-105 px-3 py-1 rounded-md">Connexion Admin</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="py-8 flex-grow">
        <!-- Le contenu spécifique de chaque page sera inséré ici -->

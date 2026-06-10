// js/script.js

console.log("SCRIPT.JS LOADED: DOMContentLoaded listener will be attached.");

    document.addEventListener('DOMContentLoaded', () => {
    console.log("DOMContentLoaded event fired. Script execution started.");

    // --- Fonctions Utilitaires Côté Client ---

    async function apiRequest(action, method, data = null) {
        let url = `/projet_culture_bdd/api.php?action=${action}`; 
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            }
        };

        if (method === 'POST') {
            if (!data) data = {};
            data.action = action;  // On ajoute explicitement l'action dans le corps JSON
            options.body = JSON.stringify(data);
        } else if (method === 'GET' && data) {
            const params = new URLSearchParams(data).toString();
            url = `${url}&${params}`;
        }

        try {
            console.log(`DEBUG: API Request - URL: ${url}, Method: ${method}, Data:`, data); //
            const response = await fetch(url, options);
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP Error ${response.status}: ${errorText}`);
            }
            //
            const jsonResponse = await response.json();
            console.log(`DEBUG: API Response for ${action}:`, jsonResponse); //
            return jsonResponse;
        } catch (error) {
            console.error('API_REQUEST_ERROR:', error);
            // Indiquez l'erreur dans l'interface utilisateur si possible
            return { success: false, message: error.message || "An unknown error occurred with API request." };
        }
    }

    // --- Gestion des formulaires d'administration ---
    // (Conservez les blocs de code pour ces formulaires depuis votre version complète de script.js)
    // Exemple (à remplacer par votre code complet pour ces blocs) :
    const adminLoginForm = document.getElementById('admin-login-form');
    if (adminLoginForm) {
        adminLoginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const username = e.target.username.value;
            const password = e.target.password.value;
            const result = await apiRequest('login', 'POST', { username, password });
            const messageDiv = adminLoginForm.querySelector('.admin-message');
            if (messageDiv) {
                messageDiv.className = `admin-message text-center font-medium ${result.success ? 'text-green-600' : 'text-red-600'}`;
                messageDiv.textContent = result.message;
                if (result.success) {
                    setTimeout(() => { window.location.href = '/projet_culture_bdd/admin/dashboard.php'; }, 1000);
                }
            }
        });
    }
 
    //
    const addAuthorForm = document.getElementById('add-author-form');
    if (addAuthorForm) {
        addAuthorForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const authorData = Object.fromEntries(formData.entries());
            const result = await apiRequest('add_author', 'POST', authorData);
            const messageDiv = addAuthorForm.querySelector('.admin-message');
            if (messageDiv) {
                messageDiv.className = `admin-message text-center font-medium ${result.success ? 'text-green-600' : 'text-red-600'}`;
                messageDiv.textContent = result.message;
                if (result.success) {

                    e.target.reset();

                    setTimeout(() => {

                        window.location.href =
                            '/projet_culture_bdd/admin/gerer.php?type=auteur';

                    }, 1500);
                }
            }
        });
    }

    const addNovelForm = document.getElementById('add-novel-form');
    if (addNovelForm) {
        addNovelForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const novelData = Object.fromEntries(formData.entries());
            const result = await apiRequest('add_novel', 'POST', novelData);
            const messageDiv = addNovelForm.querySelector('.admin-message');
            if (messageDiv) {
                messageDiv.className = `admin-message text-center font-medium ${result.success ? 'text-green-600' : 'text-red-600'}`;
                messageDiv.textContent = result.message;
                if (result.success) {

                    e.target.reset();

                    setTimeout(() => {

                        window.location.href =
                            '/projet_culture_bdd/admin/gerer.php?type=roman';

                    }, 1500);
                }
            }
        });
    }

    const modifyAuthorForm = document.getElementById('modify-author-form');
    if (modifyAuthorForm) {
        modifyAuthorForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const authorId = modifyAuthorForm.dataset.authorId;
            const formData = new FormData(e.target);
            const authorData = Object.fromEntries(formData.entries());
            authorData.id_auteur = authorId; 
            const result = await apiRequest('update_author', 'POST', authorData);
            const messageDiv = modifyAuthorForm.querySelector('.admin-message');
            if (messageDiv) {
                messageDiv.className =
                    `admin-message text-center font-medium ${
                        result.success ? 'text-green-600' : 'text-red-600'
                    }`;
                messageDiv.textContent = result.message;
                if (result.success) {
                    setTimeout(() => {
                        window.location.href =
                            `/projet_culture_bdd/auteur.php?id=${result.author_id}`;
                    }, 1500);
                }
            }
        });
    }

    const modifyNovelForm = document.getElementById('modify-novel-form');
    if (modifyNovelForm) {
        modifyNovelForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const novelId = modifyNovelForm.dataset.novelId;
            const formData = new FormData(e.target);
            const novelData = Object.fromEntries(formData.entries());
            novelData.id_roman = novelId; 
            const result = await apiRequest('update_novel', 'POST', novelData);
            const messageDiv = modifyNovelForm.querySelector('.admin-message');
            if (messageDiv) {
                messageDiv.className = `admin-message text-center font-medium ${result.success ? 'text-green-600' : 'text-red-600'}`;
                messageDiv.textContent = result.message;
                if (result.success) {
                    setTimeout(() => {
                        window.location.href =
                            `/projet_culture_bdd/roman.php?id=${result.novel_id}`;
                    }, 1500);
                }
            }
        });
    }

    // Gère le formulaire de suppression sur admin/supprimer.php
    const deleteForm = document.getElementById('delete-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const action = e.target.querySelector('input[name="action"]').value;
            const id = e.target.querySelector('input[name="id"]').value;

            // 🔥 FIX ICI : mapping explicite
            const type = (action === 'delete_author') ? 'auteur' : 'roman';

            const result = await apiRequest(action, 'POST', { id: id, type: type });

            let messageDiv = document.querySelector('.admin-message');
            if (!messageDiv) {
                messageDiv = document.createElement('p');
                messageDiv.className = 'text-center mb-4 admin-message';
                deleteForm.closest('.bg-white').prepend(messageDiv);
            }

            if (result.success) {
                messageDiv.className = 'text-center text-green-600 font-medium mb-4 admin-message';
                messageDiv.textContent = result.message;

                setTimeout(() => {
                    window.location.href =
                        (type === 'roman')
                            ? '/projet_culture_bdd/admin/gerer.php?type=roman'
                            : '/projet_culture_bdd/admin/gerer.php?type=auteur';
                }, 1200);

            } else {
                messageDiv.className = 'text-center text-red-600 font-medium mb-4 admin-message';
                messageDiv.textContent = result.message;
            }
        });
    }

    // --- Fonctionnalité de recherche dynamique (pour les pages publiques et admin/gerer.php) ---
    const searchInput = document.getElementById('search-input');
    const searchInputAdmin = document.getElementById('search-input-admin');
    const resultsContainer = document.getElementById('results-container');
    const adminResultsContainer = document.getElementById('admin-results-container');

    console.log("DEBUG: Public search elements check:", { searchInput, resultsContainer });
    console.log("DEBUG: Admin search elements check:", { searchInputAdmin, adminResultsContainer });

    function setupSearchFunctionality(inputElement, resultsContainerElement) {
        if (!inputElement || !resultsContainerElement) {
            console.log("DEBUG: setupSearchFunctionality: Missing input or container element. Exiting.");
            return;
        }

        let allItems = [];
        let allAuthors = []; 
        const searchType = inputElement.dataset.searchType; // This will be 'auteur' or 'roman'
        console.log(`DEBUG: setupSearchFunctionality started for data-search-type: ${searchType}`);

        async function loadItems() {
            console.log("DEBUG: loadItems: Attempting to fetch items...");
            try {
                // Si la page est de type 'roman', nous avons besoin des auteurs pour l'affichage et la recherche.
                // Note: La page 'gerer.php?type=roman' charge déjà l'auteur dans l'item roman,
                // mais pour 'recherche.php?type=roman', il faut charger les auteurs séparément.
                if (searchType === 'roman') { 
                    console.log("DEBUG: loadItems: Fetching authors for roman page...");
                    allAuthors = await apiRequest('authors', 'GET');
                    console.log("DEBUG: loadItems: Authors data loaded for roman page:", allAuthors);
                }
                
                // Détermine l'action API correcte en fonction du type de recherche (singulier vs pluriel attendu par l'API)
                const apiAction = (searchType === 'auteur') ? 'authors' : 'novels';
                console.log(`DEBUG: loadItems: Fetching main items with API action: ${apiAction}`);
                allItems = await apiRequest(apiAction, 'GET');
                console.log(`DEBUG: loadItems: Main items (${searchType}) loaded:`, allItems);
                
                displayItems(allItems, searchType, resultsContainerElement);
            } catch (error) {
                console.error("DEBUG: loadItems: Error during item loading:", error);
                resultsContainerElement.innerHTML = `<p class="col-span-full text-center text-red-600 text-lg">Erreur lors du chargement des données. Veuillez vérifier la console du navigateur.</p>`;
            }
        }

        function displayItems(items, type, container) {
            console.log(`DEBUG: displayItems: Starting display for type: ${type}, Number of items: ${items.length}`);
            container.innerHTML = ''; 

            if (items.length === 0) {
                console.log("DEBUG: displayItems: No items to display.");
                container.innerHTML = `<p class="col-span-full text-center text-gray-600 text-lg">Aucun résultat trouvé.</p>`;
                return;
            }

            const wrapperDiv = document.createElement('div');
            // Utilise la classe de grille pour les pages publiques, sinon un simple espacement pour l'admin
            wrapperDiv.className = (container.id === 'results-container') ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6' : 'space-y-4';
            
                items.forEach(item => {
                const itemCard = document.createElement('div');
                itemCard.className = 'bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200 flex flex-col w-full h-full';

                if (type === 'auteur') {
                    itemCard.innerHTML = `
                        <h3 class="text-xl font-semibold text-blue-700 mb-2 text-center">${item.prenom} ${item.nom}</h3>
                        <div class="text-gray-600 text-sm mb-3 text-left w-full">
                            <p class="mb-1"><strong class="text-gray-700">Né(e) le:</strong> ${item.date_naissance}</p>
                            <p><strong class="text-gray-700">Origine:</strong> ${item.ville_origine}</p>
                        </div>
                        <p class="text-gray-700 text-base flex-grow overflow-hidden line-clamp-3 text-left">${item.biographie}</p> 
                        <a href="/projet_culture_bdd/auteur.php?id=${item.id_auteur}" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full text-sm transition-all duration-300 ease-in-out transform hover:scale-105 shadow mx-auto">
                            Voir détails
                        </a>
                    `;
    
                } else if (type === 'roman') { 
                    // Logique d'affichage pour les romans
                    console.log("DEBUG: displayItems: Generating HTML for roman:", item.titre);
                    // Placeholder pour les images manquantes ou bloquées
                    const placeholderImageUrl = 'https://placehold.co/150x225/cccccc/333333?text=Image+manquante';
                    const imageUrl = item.image_url || placeholderImageUrl;

                    const author = allAuthors.find(a => a.id_auteur == item.id_auteur); 
                    const authorName = author ? `${author.prenom} ${author.nom}` : 'Auteur Inconnu';
                    
                    itemCard.innerHTML = `
                        <img src="${imageUrl}" alt="Couverture de ${item.titre}" class="w-32 h-48 object-cover rounded-md mb-4 shadow-md" onerror="this.onerror=null; this.src='${placeholderImageUrl}';"/>
                        <h3 class="text-xl font-semibold text-indigo-700 mb-2">${item.titre}</h3>
                        <p class="text-gray-600 text-sm mb-1">Par: ${authorName}</p>
                        <p class="text-gray-600 text-sm mb-3">Année: ${item.annee_publication}</p>
                        <p class="text-gray-700 text-base flex-grow overflow-hidden line-clamp-3">${item.resume}</p> 
                        <a href="/projet_culture_bdd/roman.php?id=${item.id_roman}" class="mt-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full text-sm transition-all duration-300 ease-in-out transform hover:scale-105 shadow">
                            Voir Détails
                        </a>
                    `;
                }
                container.appendChild(itemCard);
            });
            console.log("DEBUG: displayItems: Finished. Container updated.");
        }

        // Écouteur d'événements pour la recherche (sur l'input)
        inputElement.addEventListener('input', () => {
            console.log("DEBUG: Input event detected. Filtering items.");
            const searchTerm = inputElement.value.toLowerCase();
            const filteredItems = allItems.filter(item => {
                if (searchType === 'auteur') { 
                    return (item.nom && item.nom.toLowerCase().includes(searchTerm)) ||
                           (item.prenom && item.prenom.toLowerCase().includes(searchTerm)) ||
                           (item.ville_origine && item.ville_origine.toLowerCase().includes(searchTerm)) ||
                           (item.biographie && item.biographie.toLowerCase().includes(searchTerm));
                } else if (searchType === 'roman') { 
                    const author = allAuthors.find(a => a.id_auteur == item.id_auteur);
                    const authorName = author ? `${author.prenom} ${author.nom}`.toLowerCase() : '';
                    return (item.titre && item.titre.toLowerCase().includes(searchTerm)) ||
                           (item.resume && item.resume.toLowerCase().includes(searchTerm)) ||
                           authorName.includes(searchTerm);
                }
                return false;
            });
            displayItems(filteredItems, searchType, resultsContainerElement);
        });

        // Appel initial pour charger les données lorsque la page est prête
        loadItems();
    }

    // Initialisation des fonctionnalités de recherche pour les pages publiques et d'administration
    if (searchInput && resultsContainer) {
        setupSearchFunctionality(searchInput, resultsContainer);
    }
    if (searchInputAdmin && adminResultsContainer) {
        setupSearchFunctionality(searchInputAdmin, adminResultsContainer);
    }
});

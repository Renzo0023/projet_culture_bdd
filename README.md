# 📚 Base de Données Interactive sur le Roman Marocain d'Expression Française

Application web permettant de consulter, rechercher et administrer une base de données dédiée aux romans marocains d'expression française et à leurs auteurs.

Ce projet a été réalisé dans le cadre d'un travail universitaire autour des bases de données et du développement web, avec pour objectif de contribuer à la valorisation du patrimoine littéraire marocain francophone.

---

## 🎯 Objectifs

Cette plateforme vise à :

* Centraliser les informations sur les auteurs et romans marocains d'expression française.
* Faciliter l'accès à ces ressources grâce à une interface web moderne.
* Permettre une recherche dynamique des œuvres et des auteurs.
* Offrir un espace d'administration pour gérer les contenus.
* Illustrer l'utilisation des technologies web dans le domaine des humanités numériques.

---

## ✨ Fonctionnalités

### 👥 Interface publique

* Consultation des auteurs
* Consultation des romans
* Recherche dynamique en temps réel
* Affichage des détails d'un auteur
* Affichage des détails d'un roman
* Interface responsive

### 🔐 Interface d'administration

* Authentification sécurisée
* Tableau de bord administrateur
* Ajout d'auteurs
* Modification des auteurs
* Suppression des auteurs
* Ajout de romans
* Modification des romans
* Suppression des romans
* Recherche dynamique dans l'administration
* Messages de confirmation et de gestion des erreurs

---

## 🏗️ Architecture

Le projet repose sur une architecture MVC simplifiée.

```text
projet_culture_bdd/
│
├── admin/
├── css/
├── images/
├── includes/
├── js/
├── index.php
├── api.php
├── auteur.php
├── crypto.php
├── litterature_marocaine.sql
├── recherche.php
├── roman.php
└── README.md
```

### Architecture technique

* **Modèle :** Base de données MySQL
* **Vue :** HTML, CSS, TailwindCSS
* **Contrôleur :** API PHP utilisant PDO
* **Communication :** AJAX avec Fetch API et JSON

---

## 🗄️ Base de données

La base de données est organisée autour de trois entités principales :

### Table `admins`

Contient les informations d'authentification des administrateurs.
Les identifiants du compte dans la base de donnée sont admin et admin.

### Table `auteurs`

Stocke les informations relatives aux écrivains :

* Nom
* Prénom
* Biographie
* Ville d'origine
* Date de naissance
* Photo

### Table `romans`

Contient les informations sur les œuvres :

* Titre
* Résumé
* Année de publication
* Couverture
* Auteur associé

### Relations

```text
AUTEURS (1)
    |
    |
    +------< ROMANS (N)
```

Un auteur peut être associé à plusieurs romans.

---

## 🔒 Sécurité

Le projet intègre plusieurs bonnes pratiques :

* Utilisation de PDO et de requêtes préparées
* Protection contre les injections SQL
* Encodage des sorties HTML avec `htmlspecialchars()`
* Gestion des sessions PHP
* Validation côté client et côté serveur
* Réponses API au format JSON
* Gestion des erreurs avec `try...catch`

---

## 🛠️ Technologies utilisées

### Backend

* PHP
* PDO
* MySQL / MariaDB

### Frontend

* HTML5
* CSS3
* JavaScript
* TailwindCSS

### Communication

* AJAX
* Fetch API
* JSON

### Outils

* Visual Studio Code
* XAMPP
* phpMyAdmin

---

## 🚀 Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/Renzo0023/projet_culture_bdd.git
```

### 2. Copier le projet dans le serveur local

Exemple avec XAMPP :

```text
htdocs/
└── projet_culture_bdd/
```

### 3. Créer la base de données

Créer la base de données MySQL puis importer le fichier SQL fourni dans le projet.

### 4. Configurer la connexion

Modifier les paramètres de connexion dans le fichier de configuration :

```php
$host = "localhost";
$dbname = "nom_de_la_base";
$user = "root";
$password = "";
```

### 5. Lancer le projet

```text
http://localhost/projet_culture_bdd
```

---

## 📸 Aperçu

Vous pouvez ajouter ici quelques captures d'écran :

* Page d'accueil
* Recherche dynamique
* Liste des auteurs
* Liste des romans
* Tableau de bord administrateur
* Formulaires de gestion

---

## 📚 Ce que ce projet m'a apporté

Ce projet m'a permis de renforcer mes compétences sur :

* la modélisation d'une base de données relationnelle ;
* la conception d'une API PHP ;
* les échanges de données avec AJAX et JSON ;
* le développement d'interfaces responsives ;
* l'utilisation de TailwindCSS ;
* la gestion des opérations CRUD ;
* les bonnes pratiques de sécurité en développement web.

Il représente une expérience concrète mêlant culture, patrimoine et technologies web.

---

## 🔮 Perspectives d'amélioration

Plusieurs évolutions sont envisageables :

* Pagination des résultats
* Filtres avancés
* Ajout de contenus multimédias
* Gestion de plusieurs administrateurs
* Système de favoris
* API REST plus complète
* Déploiement en ligne
* Optimisation de l'expérience mobile

---

## 💡 Retour d'expérience

Au cours du développement, plusieurs difficultés techniques ont été rencontrées, notamment concernant la gestion des requêtes AJAX, le traitement des réponses JSON et la communication entre le client et le serveur.

Ce projet s'inscrit dans une démarche d'apprentissage et d'amélioration continue. Je reste ouvert à toute remarque, suggestion ou correction concernant :

* l'architecture de l'application ;
* la conception de la base de données ;
* la qualité du code ;
* les choix techniques ;
* les bonnes pratiques PHP et JavaScript ;
* les optimisations possibles.

Toute contribution ou retour d'expérience est le bienvenu.

---

## 👨‍💻 Auteurs

**Regis Epiphane ZONGO**
**Samson KLOUGAN**

Projet universitaire consacré à la valorisation numérique du patrimoine littéraire marocain d'expression française à travers une application web interactive.

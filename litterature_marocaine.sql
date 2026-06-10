-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:4306
-- Généré le : mar. 09 juin 2026 à 14:51
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `litterature_marocaine`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password_hash`) VALUES
(1, 'admin', '$2y$10$c2O4wmdvSfZc.cAimGI9h.mxA72pwnA88wEg2wB6vuTTHi5BMBV7K');

-- --------------------------------------------------------

--
-- Structure de la table `auteurs`
--

CREATE TABLE `auteurs` (
  `id_auteur` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `ville_origine` varchar(100) DEFAULT NULL,
  `biographie` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `auteurs`
--

INSERT INTO `auteurs` (`id_auteur`, `nom`, `prenom`, `date_naissance`, `ville_origine`, `biographie`) VALUES
(1, 'Chatt', 'Abdelkader', '1905-01-01', 'Fès', 'Considéré comme un précurseur de la littérature marocaine francophone.'),
(2, 'Sefrioui', 'Ahmed', '1915-01-01', 'Fès', 'Auteur du premier roman marocain francophone largement diffusé, La Boîte à merveilles.'),
(3, 'Chraïbi', 'Driss', '1926-07-15', 'El Jadida', 'Romancier et essayiste marocain, auteur de Le Passé simple.'),
(4, 'Ben Jelloun', 'Tahar', '1944-12-01', 'Fès', 'Prix Goncourt 1987, un des écrivains marocains les plus célèbres.'),
(5, 'Khair-Eddine', 'Mohammed', '1941-11-17', 'Tiznit', 'Poète et romancier engagé dans une écriture explosive et subversive.'),
(6, 'Khatibi', 'Abdelkébir', '1938-02-11', 'El Jadida', 'Sociologue, écrivain et critique littéraire marocain.'),
(7, 'Laâbi', 'Abdellatif', '1942-11-29', 'Fès', 'Poète, romancier et fondateur de la revue Souffles.'),
(8, 'Slimani', 'Leïla', '1981-10-03', 'Rabat', 'Prix Goncourt 2016 pour Chanson douce.'),
(9, 'Taïa', 'Abdellah', '1973-08-20', 'Salé', 'Premier écrivain marocain à assumer publiquement son homosexualité.'),
(10, 'Binebine', 'Mahi', '1959-01-01', 'Marrakech', 'Peintre et écrivain dont les romans sont traduits dans plusieurs langues.'),
(11, 'Berrada Berca', 'Lamia', NULL, 'Casablanca', 'Écrivaine engagée explorant l\'identité féminine et la société.'),
(12, 'Laroui', 'Fouad', '1958-08-12', 'Oujda', 'Écrivain, économiste et chroniqueur marocain.'),
(13, 'Trabelsi', 'Bahaa', NULL, 'Casablanca', 'Romancière contemporaine traitant des questions sociales.'),
(14, 'Mazini', 'Habib', NULL, 'Casablanca', 'Écrivain et professeur universitaire marocain.'),
(15, 'Najib', 'Abdelhak', NULL, 'Casablanca', 'Écrivain, journaliste et critique marocain.'),
(16, 'Elkourti', 'El Mehdi', NULL, 'Tanger', 'Écrivain de romans ésotériques et policiers.');

-- --------------------------------------------------------

--
-- Structure de la table `romans`
--

CREATE TABLE `romans` (
  `id_roman` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `annee_publication` int(11) DEFAULT NULL,
  `resume` text DEFAULT NULL,
  `id_auteur` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `romans`
--

INSERT INTO `romans` (`id_roman`, `titre`, `annee_publication`, `resume`, `id_auteur`, `image_url`) VALUES
(1, 'Mosaïques ternies', 1932, 'Considéré comme le tout premier roman marocain écrit en français.', 1, 'https://static.fnac-static.com/multimedia/FR/Images_Produits/FR/fnac.com/Visual_Principal_340/6/5/4/9782912728456/tsp20120924135036/Mosaiques-ternies.jpg'),
(2, 'La Boîte à merveilles', 1954, 'Roman autobiographique décrivant l\'enfance à Fès.', 2, 'https://1.bp.blogspot.com/-AGO1-J_OiHM/WnSJOFug14I/AAAAAAAAAu0/YnFmLc2WuXQgM4q2fbXpBtyOG7nDJzQfACPcBGAYYCw/s1600/maxresdefault.jpg'),
(3, 'Le Passé simple', 1954, 'Critique du système patriarcal et du choc des cultures.', 3, 'https://products-images.di-static.com/image/driss-chraibi-le-passe-simple/9782070377282-475x500-1.jpg'),
(4, 'Les Boucs', 1955, 'Dénonciation des conditions des immigrés nord-africains.', 3, 'https://www.anticariat-unu.ro/uploads/products/les-boucs-roman-par-driss-chraibi-1982-p311584-0.JPG'),
(5, 'La Civilisation ma mère', 1972, 'Hommage à la mère et à la condition féminine.', 3, 'https://m.media-amazon.com/images/I/81u+cNp5OXL._SL1500_.jpg'),
(6, 'L’Enfant de sable', 1985, 'Roman emblématique sur l\'identité et la féminité.', 4, 'https://www.babelio.com/couv/CVT_25443_1357313.jpg'),
(7, 'La Nuit sacrée', 1987, 'Suite de L’Enfant de sable, prix Goncourt.', 4, 'https://m.media-amazon.com/images/I/41sWh2+BqyL._SY445_SX342_.jpg'),
(8, 'Moha le fou, Moha le sage', 1978, 'Réflexion sur la société marocaine.', 4, 'https://www.label-emmaus.co/media/ext/540x540/d1kvfoyrif6wzg.cloudfront.net/assets/images/56/10735/none_a2e6df6ceeb33d6359f640276a1bba16_a2e6df6.JPEG'),
(9, 'Agadir', 1967, 'Roman poétique et politique sur le séisme d’Agadir.', 5, 'https://th.bing.com/th/id/OIP.UfSz7zxSNZdibEKCKOInewAAAA?rs=1&pid=ImgDetMain&cb=idpwebpc2'),
(10, 'Le Déterreur', 1973, 'Exploration du mythe et du politique.', 5, 'https://th.bing.com/th/id/OIP.q8s3Z-_TKZlZsA75czBwywHaLH?rs=1&pid=ImgDetMain&cb=idpwebpc2'),
(11, 'La Mémoire tatouée', 1971, 'Autobiographie romancée autour de l\'identité.', 6, 'https://gallica.bnf.fr/ark:/12148/bpt6k33943128/f7.medres'),
(12, 'Amour bilingue', 1982, 'Roman sur l’amour et la langue comme exil.', 6, 'https://imgv2-2-f.scribdassets.com/img/document/469270020/original/f49f17908d/1702765198?v=1'),
(13, 'Le Règne de Barbarie', 1976, 'Critique de la répression politique.', 7, 'https://cdn2.penguin.com.au/covers/original/9780984845316.jpg'),
(14, 'Chanson douce', 2016, 'Prix Goncourt, thriller psychologique.', 8, 'https://www.onlalu.com/wp-content/uploads/couvs/29/9782072764929-600x988.jpg'),
(15, 'Dans le jardin de l’ogre', 2014, 'Portrait d’une femme addict au sexe.', 8, 'https://th.bing.com/th/id/OIP.IFrOXcE70GL3aWT9tX1wawHaL_?rs=1&pid=ImgDetMain&cb=idpwebpc2'),
(16, 'Le Jour du roi', 2010, 'Sur l’amitié, le pouvoir et l’adolescence.', 9, 'https://4.bp.blogspot.com/-4Nq8y_lUiSE/T1M8a8jsGkI/AAAAAAAAAZ4/TkrGAA-vG98/w1200-h630-p-k-no-nu/Le_jour_du_roi.jpg'),
(17, 'Une mélancolie arabe', 2008, 'Autobiographie poétique sur l\'homosexualité.', 9, 'https://products-images.di-static.com/image/abdellah-taia-une-melancolie-arabe/9782020972338-475x500-1.jpg'),
(18, 'Les étoiles de Sidi Moumen', 2010, 'Fiction sur les attentats de Casablanca de 2003.', 10, 'https://qitab.ma/1814-home_default/les-etoiles-de-sidi-moumen.jpg'),
(19, 'Ce vain combat que tu livres au monde', 2016, 'Roman philosophique et introspectif.', 12, 'https://media.carrefour.fr/medias/0092648a0ba83a5b978f12d00c7fda59/p_540x540/12e49fd91f2940599ae2e7941c8e67ea-image.jpg'),
(20, 'Guerres d\'une vie ordinaire', 2012, 'Portrait de femme face aux oppressions sociales.', 11, 'https://i.ebayimg.com/images/g/29MAAOSwZb5kXRgc/s-l500.jpg'),
(21, 'La chaise du concierge', 2017, 'Roman sur la bureaucratie et le pouvoir local.', 13, 'https://products-images.di-static.com/image/bahaa-trabelsi-la-chaise-du-concierge/9789954168110-475x500-1.jpg'),
(22, 'Le croquis du destin', 2018, 'Fiction sur les destinées humaines.', 14, 'https://www.coupdesoleil-rhonealpes.fr/wp-content/uploads/2018/01/Croquis-du-destin-couv-redim.jpg'),
(23, 'Les Territoires de Dieu', 2020, 'Premier tome d’une trilogie mystique.', 15, 'https://mondearabe.fr/5095-thickbox_default/les-territoires-de-dieu.jpg'),
(28, 'Regardez-nous danser', 2022, 'Deuxième tome de la trilogie entamée avec \'Le Pays des autres\', évoquant la société marocaine post-indépendance.', 8, 'https://maisondulivre.ma/wp-content/uploads/2022/06/Screenshot-2022-06-23-at-18.55.22.png'),
(29, 'Le Pays des autres', 2020, 'Saga familiale inspirée de l\'histoire de ses grands-parents, début d\'une trilogie.', 8, 'https://static.fnac-static.com/multimedia/Images/FD/Comete/142268/CCP_IMG_ORIGINAL/1871655.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index pour la table `auteurs`
--
ALTER TABLE `auteurs`
  ADD PRIMARY KEY (`id_auteur`);

--
-- Index pour la table `romans`
--
ALTER TABLE `romans`
  ADD PRIMARY KEY (`id_roman`),
  ADD KEY `id_auteur` (`id_auteur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `auteurs`
--
ALTER TABLE `auteurs`
  MODIFY `id_auteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `romans`
--
ALTER TABLE `romans`
  MODIFY `id_roman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `romans`
--
ALTER TABLE `romans`
  ADD CONSTRAINT `romans_ibfk_1` FOREIGN KEY (`id_auteur`) REFERENCES `auteurs` (`id_auteur`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

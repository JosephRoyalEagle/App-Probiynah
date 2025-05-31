-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 30 mai 2025 à 05:06
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `approdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse_localisation_auto`
--

CREATE TABLE `adresse_localisation_auto` (
  `id_adlauto` int(200) NOT NULL,
  `libelle_adlauto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `approvisionnement_produits`
--

CREATE TABLE `approvisionnement_produits` (
  `id_approd` int(200) NOT NULL,
  `id_business` int(200) DEFAULT NULL,
  `id_prod` int(200) DEFAULT NULL,
  `prix_achat_approd` text DEFAULT NULL,
  `prix_vente_vip_approd` text DEFAULT NULL,
  `prix_vente_normal_approd` text DEFAULT NULL,
  `nombre_approd` text DEFAULT NULL,
  `type_offre_approd` text DEFAULT NULL,
  `date_approd` text DEFAULT NULL,
  `heure_approd` text DEFAULT NULL,
  `createur_approd` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `business`
--

CREATE TABLE `business` (
  `id_business` int(200) NOT NULL,
  `nom_business` text DEFAULT NULL,
  `type_business` text DEFAULT NULL,
  `description_business` text DEFAULT NULL,
  `adresse_business` text DEFAULT NULL,
  `etoile_business` text DEFAULT NULL,
  `datecreation_business` text DEFAULT NULL,
  `createur_business` int(200) DEFAULT NULL,
  `id_utilis` int(200) DEFAULT NULL,
  `id_pays` int(200) DEFAULT NULL,
  `id_ville` int(200) DEFAULT NULL,
  `id_commune` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `business_assets`
--

CREATE TABLE `business_assets` (
  `id_business_assets` int(200) NOT NULL,
  `id_business` int(200) DEFAULT NULL,
  `nomfichier_business_assets` text DEFAULT NULL,
  `dateinsertion_business_assets` text DEFAULT NULL,
  `createur_business_assets` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `carte_adresse`
--

CREATE TABLE `carte_adresse` (
  `id_cadress` int(200) NOT NULL,
  `id_pays` int(200) NOT NULL,
  `id_ville` int(200) NOT NULL,
  `id_commune` int(200) NOT NULL,
  `typeservice_cadress` text NOT NULL,
  `nbadulte_cadress` text DEFAULT NULL,
  `nbenfant_cadress` text DEFAULT NULL,
  `dateentree_cadress` text DEFAULT NULL,
  `heureentree_cadress` text DEFAULT NULL,
  `datesortie_cadress` text DEFAULT NULL,
  `heuresortie_cadress` text DEFAULT NULL,
  `typecommande_cadress` text DEFAULT NULL,
  `adresselivraison_cadress` text DEFAULT NULL,
  `id_tables` int(200) DEFAULT NULL,
  `id_utilis` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `categorie_produits`
--

CREATE TABLE `categorie_produits` (
  `id_cateprod` int(200) NOT NULL,
  `designation_cateprod` text DEFAULT NULL,
  `type_cateprod` text DEFAULT NULL,
  `dateinsertion_cateprod` text DEFAULT NULL,
  `heureinsertion_cateprod` text DEFAULT NULL,
  `createur_cateprod` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categorie_produits`
--

INSERT INTO `categorie_produits` (`id_cateprod`, `designation_cateprod`, `type_cateprod`, `dateinsertion_cateprod`, `heureinsertion_cateprod`, `createur_cateprod`) VALUES
(1, 'Liqueur', 'Boisson', '2025-05-28', '12h 07min 04s', 1),
(3, 'Pizza', 'Nourriture', '2025-05-28', '12h 15min 52s', 1),
(4, 'Hamberger', 'Nourriture', '2025-05-28', '12h 16min 04s', 1),
(5, 'Chawama', 'Nourriture', '2025-05-28', '12h 16min 17s', 1),
(6, 'Bierre', 'Boisson', '2025-05-28', '15h 14min 28s', 1);

-- --------------------------------------------------------

--
-- Structure de la table `charges`
--

CREATE TABLE `charges` (
  `id_charges` int(200) NOT NULL,
  `motif_charges` text DEFAULT NULL,
  `montant_charges` text DEFAULT NULL,
  `id_business` int(200) DEFAULT NULL,
  `dateinsertion_charges` text DEFAULT NULL,
  `heureinsertion_charges` text DEFAULT NULL,
  `createur_charges` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id_cmdes` int(200) NOT NULL,
  `code_cmdes` text DEFAULT NULL,
  `id_business` int(200) DEFAULT NULL,
  `id_utilis` int(200) DEFAULT NULL,
  `id_tables` int(200) DEFAULT NULL,
  `type_cmdes` text DEFAULT NULL,
  `statut_cmdes` text DEFAULT NULL,
  `adresse_livraison_cmdes` text DEFAULT NULL,
  `date_cmdes` text DEFAULT NULL,
  `heure_cmdes` text DEFAULT NULL,
  `methode_paiement_cmdes` text DEFAULT NULL,
  `montant_paye_cmdes` text DEFAULT NULL,
  `tel_paiement_cmdes` text DEFAULT NULL,
  `createur_cmdes` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `commune`
--

CREATE TABLE `commune` (
  `id_commune` int(200) NOT NULL,
  `nom_commune` text DEFAULT NULL,
  `dateinsertion_commune` text DEFAULT NULL,
  `heureinsertion_commune` text DEFAULT NULL,
  `id_ville` int(200) NOT NULL,
  `createur_commune` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `details_commandes`
--

CREATE TABLE `details_commandes` (
  `id_detcmdes` int(200) NOT NULL,
  `id_cmdes` int(200) DEFAULT NULL,
  `id_prod` int(200) DEFAULT NULL,
  `id_approd` int(200) DEFAULT NULL,
  `quantite_detcmdes` text DEFAULT NULL,
  `preferences_detcmdes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE `devis` (
  `id_devis` int(200) NOT NULL,
  `code_devis` text DEFAULT NULL,
  `termes_conditions_devis` text DEFAULT NULL,
  `reglement_conditions_devis` text DEFAULT NULL,
  `tva_devis` text DEFAULT NULL,
  `remise_devis` text DEFAULT NULL,
  `nom_offreur_devis` text DEFAULT NULL,
  `email_offreur_devis` text DEFAULT NULL,
  `tel_offreur_devis` text DEFAULT NULL,
  `adresse_offreur_devis` text DEFAULT NULL,
  `logo_offreur_devis` text DEFAULT NULL,
  `nom_client_devis` text DEFAULT NULL,
  `email_client_devis` text DEFAULT NULL,
  `tel_client_devis` text DEFAULT NULL,
  `adresse_client_devis` text DEFAULT NULL,
  `id_business` int(200) DEFAULT NULL,
  `dateinsertion_devis` text DEFAULT NULL,
  `heureinsertion_devis` text DEFAULT NULL,
  `createur_devis` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `devis_details`
--

CREATE TABLE `devis_details` (
  `id_devtails` int(200) NOT NULL,
  `id_devis` int(200) DEFAULT NULL,
  `description_devtails` text DEFAULT NULL,
  `prix_unitaire_devtails` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `id_pays` int(200) NOT NULL,
  `libelle_pays` text DEFAULT NULL,
  `codezip_pays` int(200) DEFAULT NULL,
  `dateinsertion_pays` text DEFAULT NULL,
  `heureinsertion_pays` text DEFAULT NULL,
  `createur_pays` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id_pays`, `libelle_pays`, `codezip_pays`, `dateinsertion_pays`, `heureinsertion_pays`, `createur_pays`) VALUES
(1, 'France', 33, '2025-05-28 17:48:34', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id_prod` int(200) NOT NULL,
  `nom_prod` text DEFAULT NULL,
  `description_prod` text DEFAULT NULL,
  `image_prod` text DEFAULT NULL,
  `dateinsertion_prod` text DEFAULT NULL,
  `heureinsertion_prod` text DEFAULT NULL,
  `createur_prod` int(200) DEFAULT NULL,
  `id_cateprod` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id_prod`, `nom_prod`, `description_prod`, `image_prod`, `dateinsertion_prod`, `heureinsertion_prod`, `createur_prod`, `id_cateprod`) VALUES
(4, 'Tequilla Bierre', 'Boisson 100% Alcool', 'img-prod-d3d9bea00bf7ed0bbde4f68c86971975b7fc6839.png', '2025-05-29', '23h 26min 10s', 1, 6),
(5, 'Castel Beer', 'Boisson De Grand Type', 'img-prod-e7c27b3a5e83c1e34b52c7fbce7e62c27c110244.jpg', '2025-05-30', '01h 38min 06s', 1, 6),
(6, 'Desperados Canette', 'Bierre Tres Cool', 'img-prod-fc13e7427d6966e78abf9f5803d644cbcd6882ef.jpeg', '2025-05-30', '01h 39min 20s', 1, 6);

-- --------------------------------------------------------

--
-- Structure de la table `service_clients`
--

CREATE TABLE `service_clients` (
  `id_servcli` int(200) NOT NULL,
  `nom_servcli` text DEFAULT NULL,
  `tel_servcli` text DEFAULT NULL,
  `id_business` int(200) DEFAULT NULL,
  `date_servcli` text DEFAULT NULL,
  `heure_servcli` text DEFAULT NULL,
  `createur_servcli` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `stock_alert`
--

CREATE TABLE `stock_alert` (
  `id_stockalert` int(200) NOT NULL,
  `id_business` int(200) DEFAULT NULL,
  `id_prod` int(200) DEFAULT NULL,
  `nombre_stockalert` text DEFAULT NULL,
  `date_maj_stockalert` text DEFAULT NULL,
  `heure_maj_stockalert` text DEFAULT NULL,
  `createur_stockalert` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `stock_produit`
--

CREATE TABLE `stock_produit` (
  `id_stockprod` int(200) NOT NULL,
  `id_business` int(200) DEFAULT NULL,
  `id_prod` int(200) DEFAULT NULL,
  `type_offre_stockprod` text DEFAULT NULL,
  `nombre_total_stockprod` text DEFAULT NULL,
  `date_maj_stockprod` text DEFAULT NULL,
  `heure_maj_stockprod` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `tables`
--

CREATE TABLE `tables` (
  `id_tables` int(200) NOT NULL,
  `id_business` int(200) DEFAULT NULL,
  `numero_tables` text DEFAULT NULL,
  `type_tables` text DEFAULT NULL,
  `dateinsertion_tables` text DEFAULT NULL,
  `heureinsertion_tables` text DEFAULT NULL,
  `liens_tables` text DEFAULT NULL,
  `createur_tables` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilis` int(200) NOT NULL,
  `nom_utilis` text DEFAULT NULL,
  `prenom_utilis` text DEFAULT NULL,
  `numero_utilis` text DEFAULT NULL,
  `motdepasse_utilis` text DEFAULT NULL,
  `role_utilis` text DEFAULT NULL,
  `statut_utilis` text DEFAULT NULL,
  `dateinscription_utilis` text DEFAULT NULL,
  `heureinscription_utilis` text DEFAULT NULL,
  `adresse_utilis` text DEFAULT NULL,
  `createur_utilis` int(200) DEFAULT NULL,
  `id_business` int(200) DEFAULT NULL,
  `avatar_utilis` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilis`, `nom_utilis`, `prenom_utilis`, `numero_utilis`, `motdepasse_utilis`, `role_utilis`, `statut_utilis`, `dateinscription_utilis`, `heureinscription_utilis`, `adresse_utilis`, `createur_utilis`, `id_business`, `avatar_utilis`) VALUES
(1, 'Jimok', 'Klohe Aries', '2250586899948', '$2y$12$i8Oj1WDL76MXJ3yoIbnHiuKag8sp0uprs4jmLhQIvB1bRpPZnCHjO', 'SAdmin', 'Actif', '2025-05-26', '07h 32min 39s', NULL, NULL, NULL, NULL),
(4, 'kassidy', 'Umariel Sariel', '2250748820709', '$2y$12$LLJZQ.9h7CpW38/Pj3h9h.ZBnntwtXitWHzCyGtfUtqF.6GhTYKoW', 'Gestionnaire', 'Actif', '2025-05-26', '17h 05min 09s', NULL, NULL, NULL, NULL),
(6, 'Dao', 'Gerrad Atanael', '2250544896587', '$2y$12$9cAtVrH.dBMOnziafWGZQ.BIpwbDviY8XngSasb6deRvkun7JrkKq', 'SAdmin', 'Actif', '2025-05-28', '12h 14min 46s', NULL, 1, NULL, NULL),
(7, 'Sierra', 'Lumael Famel', '2250788945756', '$2y$12$27./Li65zLv6hQsy1gHfvuak7.KT84rvy1U1igtrGr./rQaG4chAC', 'Client', 'Actif', '2025-05-29', '17h 59min 54s', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_logs`
--

CREATE TABLE `utilisateurs_logs` (
  `id_utilislogs` int(200) NOT NULL,
  `id_utilis` int(200) DEFAULT NULL,
  `ip_utilislogs` text DEFAULT NULL,
  `os_utilislogs` text DEFAULT NULL,
  `navigateur_utilislogs` text DEFAULT NULL,
  `date_utilislogs` text DEFAULT NULL,
  `heure_utilislogs` text NOT NULL,
  `token_utilislogs` text DEFAULT NULL,
  `expire_le_utilislogs` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs_logs`
--

INSERT INTO `utilisateurs_logs` (`id_utilislogs`, `id_utilis`, `ip_utilislogs`, `os_utilislogs`, `navigateur_utilislogs`, `date_utilislogs`, `heure_utilislogs`, `token_utilislogs`, `expire_le_utilislogs`) VALUES
(1, 1, '127.0.0.1', 'Linux', 'Firefox', '2025-05-26', '07h 32min 39s', '7c9b7e68a9cd116bbb6c5cefa2453987e88a34b5e024287b07e2f0efa0171b81d384159c75ca1042308f0afd8ba4ff8acf8d3336346734785c0ed6e298a921ed', '1750829559'),
(2, 1, '127.0.0.1', 'Linux', 'Firefox', '2025-05-26', '07h 38min 29s', '4d11282b22bff36e5cf22ec3316dc3414b8b1cb9ee91d05a1e6394a1fe41d085a0ac0241753032c9b0d7554c9a6b3606afba1b898c7eeeb46bb0c962f8e7f3b3', '1750829909'),
(4, 1, '127.0.0.1', 'Linux', 'Firefox', '2025-05-26', '12h 12min 57s', '81ef44d29b118fe2e6945358769d361c53cfb663925c4f39b26a90602faaf7bbbbebc26ba4fa760fb88730005961f7d18fafe0e5913e4523190b404029fbbcae', '1750846377'),
(6, 1, '127.0.0.1', 'Linux', 'Firefox', '2025-05-26', '18h 43min 34s', '1c4a2b77a09f2a2caed15c3389772df8ec300b86e5b246ee5ecba66b736099972f0d7bdaf37829c06caf1d83033b4e33db8c6f31f2507e9e2efe5e56ea71695c', '1750869814'),
(7, 1, '127.0.0.1', 'Linux', 'Firefox', '2025-05-27', '12h 30min 01s', '9f10b514108d6be074d10698a335c6f4fa42ed6dd7b7d4c66b64b93abcd0f0238ad0f83f160a4988cc3ac1c62f03fd1fe774d8aec0c4503d48e5f000fd131dc6', '1750933801'),
(10, 1, '127.0.0.1', 'Linux', 'Firefox', '2025-05-28', '11h 42min 52s', '6ec5c6301370fdaadd014eb38e2c81bfa7c9bb07fd03122802d55860796b1ac5a27b448a1c7311c2de27c8daeec7be183892c27a8668096c8730033835443c00', '1751017372'),
(13, 1, '127.0.0.1', 'Linux', 'Firefox', '2025-05-29', '19h 17min 00s', '521e7806131ecf413bbe0203446c611a6c1debdc54c46fe2c3fdddfc407af82adce55187e2a2795d95fbaa0dca7aa8ebeb831d6b102c1cd8981c29ed38d5820a', '1751131020'),
(14, 1, '127.0.0.1', 'Linux', 'Firefox', '2025-05-29', '22h 03min 36s', 'ff3c191500e032dbf278b621fd98b045c0c8ad254ee3eb1b4d7ecbc08ab0b04847cca27e358054dd04adaeede9c9e23eb29b6b7569a5df7d4058b4e2a4dbd03d', '1751141015'),
(15, 1, '::1', 'Linux', 'Chrome', '2025-05-29', '23h 51min 45s', '07730a003110b0562c649ef8cb2ceb6b2e0f23814465f275ef412c99dd24033e463566883d9c9da974d69101bd831ae89aac8a8082b670a9cd6569943e5463cd', '1751147505');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_sms`
--

CREATE TABLE `utilisateurs_sms` (
  `id_utilsms` int(200) NOT NULL,
  `id_utilis` int(200) DEFAULT NULL,
  `date_utilsms` text DEFAULT NULL,
  `heure_utilsms` text DEFAULT NULL,
  `nombre_utilsms` text DEFAULT NULL,
  `code_utilsms` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs_sms`
--

INSERT INTO `utilisateurs_sms` (`id_utilsms`, `id_utilis`, `date_utilsms`, `heure_utilsms`, `nombre_utilsms`, `code_utilsms`) VALUES
(1, 1, '2025-05-26', '11h 39min 14s', '1', 'ODX7');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id_ville` int(200) NOT NULL,
  `nom_ville` text DEFAULT NULL,
  `dateinsertion_ville` text DEFAULT NULL,
  `heureinsertion_ville` text DEFAULT NULL,
  `id_pays` int(200) NOT NULL,
  `createur_ville` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adresse_localisation_auto`
--
ALTER TABLE `adresse_localisation_auto`
  ADD PRIMARY KEY (`id_adlauto`);

--
-- Index pour la table `approvisionnement_produits`
--
ALTER TABLE `approvisionnement_produits`
  ADD PRIMARY KEY (`id_approd`);

--
-- Index pour la table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`id_business`);

--
-- Index pour la table `business_assets`
--
ALTER TABLE `business_assets`
  ADD PRIMARY KEY (`id_business_assets`);

--
-- Index pour la table `carte_adresse`
--
ALTER TABLE `carte_adresse`
  ADD PRIMARY KEY (`id_cadress`);

--
-- Index pour la table `categorie_produits`
--
ALTER TABLE `categorie_produits`
  ADD PRIMARY KEY (`id_cateprod`);

--
-- Index pour la table `charges`
--
ALTER TABLE `charges`
  ADD PRIMARY KEY (`id_charges`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id_cmdes`);

--
-- Index pour la table `commune`
--
ALTER TABLE `commune`
  ADD PRIMARY KEY (`id_commune`);

--
-- Index pour la table `details_commandes`
--
ALTER TABLE `details_commandes`
  ADD PRIMARY KEY (`id_detcmdes`);

--
-- Index pour la table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`id_devis`);

--
-- Index pour la table `devis_details`
--
ALTER TABLE `devis_details`
  ADD PRIMARY KEY (`id_devtails`);

--
-- Index pour la table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id_pays`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id_prod`);

--
-- Index pour la table `service_clients`
--
ALTER TABLE `service_clients`
  ADD PRIMARY KEY (`id_servcli`);

--
-- Index pour la table `stock_alert`
--
ALTER TABLE `stock_alert`
  ADD PRIMARY KEY (`id_stockalert`);

--
-- Index pour la table `stock_produit`
--
ALTER TABLE `stock_produit`
  ADD PRIMARY KEY (`id_stockprod`);

--
-- Index pour la table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id_tables`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilis`);

--
-- Index pour la table `utilisateurs_logs`
--
ALTER TABLE `utilisateurs_logs`
  ADD PRIMARY KEY (`id_utilislogs`);

--
-- Index pour la table `utilisateurs_sms`
--
ALTER TABLE `utilisateurs_sms`
  ADD PRIMARY KEY (`id_utilsms`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id_ville`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adresse_localisation_auto`
--
ALTER TABLE `adresse_localisation_auto`
  MODIFY `id_adlauto` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `approvisionnement_produits`
--
ALTER TABLE `approvisionnement_produits`
  MODIFY `id_approd` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `business`
--
ALTER TABLE `business`
  MODIFY `id_business` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `business_assets`
--
ALTER TABLE `business_assets`
  MODIFY `id_business_assets` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `carte_adresse`
--
ALTER TABLE `carte_adresse`
  MODIFY `id_cadress` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categorie_produits`
--
ALTER TABLE `categorie_produits`
  MODIFY `id_cateprod` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `charges`
--
ALTER TABLE `charges`
  MODIFY `id_charges` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id_cmdes` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commune`
--
ALTER TABLE `commune`
  MODIFY `id_commune` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `details_commandes`
--
ALTER TABLE `details_commandes`
  MODIFY `id_detcmdes` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `devis`
--
ALTER TABLE `devis`
  MODIFY `id_devis` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `devis_details`
--
ALTER TABLE `devis_details`
  MODIFY `id_devtails` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pays`
--
ALTER TABLE `pays`
  MODIFY `id_pays` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id_prod` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `service_clients`
--
ALTER TABLE `service_clients`
  MODIFY `id_servcli` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stock_alert`
--
ALTER TABLE `stock_alert`
  MODIFY `id_stockalert` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stock_produit`
--
ALTER TABLE `stock_produit`
  MODIFY `id_stockprod` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tables`
--
ALTER TABLE `tables`
  MODIFY `id_tables` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilis` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `utilisateurs_logs`
--
ALTER TABLE `utilisateurs_logs`
  MODIFY `id_utilislogs` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `utilisateurs_sms`
--
ALTER TABLE `utilisateurs_sms`
  MODIFY `id_utilsms` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `id_ville` int(200) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

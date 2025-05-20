-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 20 mai 2025 à 22:05
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
  `date_approd` text DEFAULT NULL,
  `createur_approd` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `business`
--

CREATE TABLE `business` (
  `id_business` int(200) NOT NULL,
  `nom_business` text DEFAULT NULL,
  `description_business` text DEFAULT NULL,
  `adresse_business` text DEFAULT NULL,
  `etoile_business` text DEFAULT NULL,
  `datecreation_business` text DEFAULT NULL,
  `createur_business` int(200) DEFAULT NULL,
  `id_business_assets` int(200) DEFAULT NULL,
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
  `type_business_assets` text DEFAULT NULL,
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
  `dateinsertion_cateprod` text DEFAULT NULL,
  `createur_cateprod` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `logo_offeur_devis` text DEFAULT NULL,
  `nom_client_devis` text DEFAULT NULL,
  `email_client_devis` text DEFAULT NULL,
  `tel_client_devis` text DEFAULT NULL,
  `adresse_client_devis` text DEFAULT NULL,
  `id_business` int(200) DEFAULT NULL,
  `dateinsertion_devis` text DEFAULT NULL,
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
  `createur_pays` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id_prod` int(200) NOT NULL,
  `nom_prod` text DEFAULT NULL,
  `description_prod` text DEFAULT NULL,
  `prix_vip_prod` text DEFAULT NULL,
  `prix_ordinaire_prod` text DEFAULT NULL,
  `type_prod` text DEFAULT NULL,
  `image_prod` text DEFAULT NULL,
  `dateinsertion_prod` text DEFAULT NULL,
  `createur_prod` int(200) DEFAULT NULL,
  `id_cateprod` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `service_clients`
--

CREATE TABLE `service_clients` (
  `id_servcli` int(200) NOT NULL,
  `nom_servcli` text DEFAULT NULL,
  `tel_servcli` text DEFAULT NULL,
  `id_business` int(200) DEFAULT NULL,
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
  `nombre_total_stockprod` text DEFAULT NULL,
  `date_maj_stockprod` text DEFAULT NULL
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
  `adresse_utilis` text DEFAULT NULL,
  `createur_utilis` int(200) DEFAULT NULL,
  `id_business` int(200) DEFAULT NULL,
  `avatar_utilis` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id_ville` int(200) NOT NULL,
  `nom_ville` text DEFAULT NULL,
  `dateinsertion_ville` text DEFAULT NULL,
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
  MODIFY `id_cateprod` int(200) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_pays` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id_prod` int(200) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_utilis` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `id_ville` int(200) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

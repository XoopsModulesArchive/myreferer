<?php declare(strict_types=1);

/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2004 <https://xoops.org>
 *
 * Module: myreferer 2.0
 * Licence : GPL
 * Authors :
 *           - solo (www.wolfpackclan.com/wolfactory)
 *            - DuGris (www.dugris.info)
 */
define('_MD_MYREFERER_NAME', 'myReferer');
define('_MD_MYREFERER_REFERER', 'Référants');
define('_MD_MYREFERER_HEADER', 'Référants de ');
define('_MD_MYREFERER_ROBOTS', 'Robots');
define('_MD_MYREFERER_PAGE', 'Pages');
define('_MD_MYREFERER_ENGINE', 'Moteurs de recherche');
define('_MD_MYREFERER_ENGINES', 'Moteurs');
define('_MD_MYREFERER_KEYWORDS', 'Mots clés');
define('_MD_MYREFERER_QUERY', 'Requêtes');
define('_MD_MYREFERER_USERS', 'Utilisateurs');
define('_MD_MYREFERER_METAKEYWORDS', 'Meta Keywords actuellements utilisés');
define('_MD_MYREFERER_KEYGEN', 'Générateur de Meta Keywords');
define('_MD_MYREFERER_CLEANER', 'Purge de la Base de données');
define('_MD_MYREFERER_UPDATED', 'Base de donnée mise à jour !');
define('_MD_MYREFERER_PREFERENCES', 'Préférences');
define('_MD_MYREFERER_INDEX', 'Aller au module');
define('_MD_MYREFERER_SEARCH', 'Chercher');
define('_MD_MYREFERER_HELP', 'Aide');
define('_MD_MYREFERER_TRANSFER', 'Remplacer les Metas Keywords actuels');
define('_MD_MYREFERER_CREDIT', ' est une creation originale de %s<br>avec la participation de %s');
define('_MD_MYREFERER_DATE', 'Dernières visites');
define('_MD_MYREFERER_TOP', 'Top');
define('_MD_MYREFERER_LETTERS', 'lettres');
define('_MD_MYREFERER_POP', 'Populaires');
define('_MD_MYREFERER_NEW', 'Nouveaux');
define('_MD_MYREFERER_RANDOM', 'Aléatoire');
define('_MD_MYREFERER_VISITS', 'visites');
define('_MD_MYREFERER_RANKING', 'Classé par ');
define('_MD_MYREFERER_ADMIN', 'Admin');
define('_MD_MYREFERER_DATATYPE', 'Choisissez un type de donnée');
define('_MD_MYREFERER_REPORT', 'Imprimer le rapport');
// define("_MD_MYREFERER_UPDATED",	"Referer updated");
define('_MD_MYREFERER_CLEANED', 'Données supprimées avec succès :');
define('_MD_MYREFERER_REMOVE', 'Seléction des données à supprimer');
define('_MD_MYREFERER_NOTUPDATED', 'Plus vieux que ');
define('_MD_MYREFERER_DAYS', 'jours');
define('_MD_MYREFERER_AND', 'et');
define('_MD_MYREFERER_ATLEAST', 'ayant maximum ');
define('_MD_MYREFERER_SUBMIT', 'Envoyer');
define('_MD_MYREFERER_WEEKS', 'semaines');
define('_MD_MYREFERER_ENTRIES', ' donnée(s)');
define('_MD_MYREFERER_STATS', 'Statistiques');
define('_MD_MYREFERER_WEEK', 'Semaine');
define('_MD_MYREFERER_ALL', 'Tous');
define('_MD_MYREFERER_LATEST', 'dernière entrée');
define('_MD_MYREFERER_NOVISIT', 'Pas de résultat à afficher');
define('_MD_MYREFERER_NODATAS', '/');
define('_MD_MYREFERER_ERROR', 'Vous devez sélectionner des données !');

define('_MD_MYREFERER_TOTAL', 'Total');
define('_MD_MYREFERER_VISIBLE', 'Visible');
define('_MD_MYREFERER_INVISIBLE', 'Invisible');
define('_MD_MYREFERER_UPDATE', 'Rafraîchir');
define('_MD_MYREFERER_DISPLAYED', 'Affiché');
define('_MD_MYREFERER_HIDDEN', 'Caché');
define('_MD_MYREFERER_UPDATED', 'Données mise à jour');
define('_MD_MYREFERER_NOTUPDATE', "La mise à jour des données n'a pas pu être efféctuée");

// Version 1.1
define('_MD_MYREFERER_UPDATE_MODULE', 'Mise à jour du module');

// upgrade
define('_MD_MYREFERER_UPGRADE_DB', 'Mise à jour de la base de donnée');
define('_MD_MYREFERER_UPGRADE_TO', 'Mise à jour myReferer version : %s');
define('_MD_MYREFERER_UPGRADE_OK', '<br><p><b>myReferer %u : <span style="color: #009900; ">Mise à jour effectuée avec succès</span></b>');
define('_MD_MYREFERER_UPGRADE_ERR', '<br><p><b>myReferer %u : <span style="color: #CC0000; ">Erreur lors de la mise à jour</span></b>');

// Config file
define('_MD_MYREFERER_CONFIG', 'Configuration');
define('_MD_MYREFERER_DBUPDATE', 'Base de donn&eacute;es mise &agrave; jour avec succ&egrave;s !');

// Tracker
define('_MD_MYREFERER_TRACKER_ON', "Activer l'envoi d'un mail lors du passage de ce robot");
define('_MD_MYREFERER_TRACKER_OFF', "Désactiver l'envoi d'un mail lors du passage de ce robot");

define('_MD_MYREFERER_USERVISIT_ON', "Activer l'enregistrement des pages pour ce membre");
define('_MD_MYREFERER_USERVISIT_OFF', "Désactiver l'enregistrement des pages pour ce membre");

// Permissions / blocks & groups
define('_MD_MYREFERER_PERMISSIONS', 'Permissions');
define('_MD_MYREFERER_PERMISSIONS_DSC', 'Permissions de voir');
define('_MD_MYREFERER_BLOCKS', 'Blocks & groupes');
define('_MD_MYREFERER_BLOCKS_DSC', 'Administraion des blocs');
define('_MD_MYREFERER_GROUPS_DSC', 'Administration des groupes');

// Stats keyword / query
define('_MD_MYREFERER_CLOSE', 'Fermer');
define('_MD_MYREFERER_MORE', 'Plus de statistiques');
define('_MD_MYREFERER_VISITORS', 'Visiteurs');
define('_MD_MYREFERER_MEMBERS', 'Membres');
define('_MD_MYREFERER_STATS_ID', 'Numéro (id)');
define('_MD_MYREFERER_STATS_TOTAL', 'Visites totales');
define('_MD_MYREFERER_STATS_WEEK', 'Visites cette semaine');
define('_MD_MYREFERER_STATS_FIRST', 'Pemière visite');
define('_MD_MYREFERER_STATS_LAST', 'Dernière visite');
define('_MD_MYREFERER_STATS_STATUS', 'Status');
define('_MD_MYREFERER_STATS_SIMILAR', 'Semblables');
define('_MD_MYREFERER_STATS_ENTRYPAGE', "Pages d'entrée");
define('_MD_MYREFERER_STATS_SAMEPAGE', 'dans les mêmes pages');

// delete text
define('_MD_MYREFERER_DELETE', 'Supprimer');
define('_MD_MYREFERER_DELETE_KEYWORD', 'Confirmez la suppression de ce Mot clé');
define('_MD_MYREFERER_DELETE_PAGE', 'Confirmez la suppression des données concernant cette Page');
define('_MD_MYREFERER_DELETE_QUERY', 'Confirmez la suppression de cette Requête');
define('_MD_MYREFERER_DELETE_REFERER', 'Confirmez la suppression de ce Référent');
define('_MD_MYREFERER_DELETE_ROBOT', 'Confirmez la suppression de ce Robot');
define('_MD_MYREFERER_DELETE_USER', 'Confirmez la suppression des données concernant cet Utilisateur');
define('_MD_MYREFERER_RESET_DATAS', 'Remettre à zéro les visites de la semaine');
define('_MD_MYREFERER_RESET_DATA', 'Confirmez la mise à zéro des visites de la semaine');
define('_MD_MYREFERER_RESET', 'Mettre à jour');

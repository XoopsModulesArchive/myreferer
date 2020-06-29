<?php
/**
* XOOPS - PHP Content Management System
* Copyright (c) 2004 <http://www.xoops.org/>
*
* Module: myReferer 2.0
* Licence : GPL
* Authors :
*           - solo (www.wolfpackclan.com/wolfactory)
*			- DuGris (www.dugris.info)
*/

define("_MI_MYREF_NAME",		"myReferer");
define("_MI_MYREF_DSC",			"Statistiques à propos des référants, moteurs de recherche et mots clés.");

// Menus
define("_MI_MYREF_ADMIN",		"Index");
define("_MI_MYREF_CONFIG",		"Configuration");
define("_MI_MYREF_META",		"Générateur de Meta");
define("_MI_MYREF_CLEAN",		"Purge Base de données");
define("_MI_MYREF_STATS",		"Statistiques");
define("_MI_MYREF_PERMS",		"Permissions");
define("_MI_MYREF_BLOCKS",		"Blocs & Groupes");

define("_MI_MYREF_HELP",		"Aide");

//  Blocks
define("_MI_MYREF_BLOC_ALLINFO",	"Dernières informations");
define("_MI_MYREF_BLOC_REFERER",	"Derniers référents");
define("_MI_MYREF_BLOC_ENGINE",		"Derniers Moteur de recherche");
define("_MI_MYREF_BLOC_KEYWORD",	"Derniers Mots clés");
define("_MI_MYREF_BLOC_QUERY",		"Dernières requêtes");
define("_MI_MYREF_BLOC_ROBOTS",		"Derniers Robots");
define("_MI_MYREF_BLOC_PAGES",		"Dernières pages");
define("_MI_MYREF_BLOC_USERS",		"Derniers Utilisateur");
define("_MI_MYREF_PAGECHCK",		"");

// Preferecnces
define("_MI_MYREF_BANNER",		"Afficher la bannière");
define("_MI_MYREF_BANNER_DSC",	"");
define("_MI_MYREF_TEXT",		"Texte");
define("_MI_MYREF_TEXT_DSC",		"Afficher un texte d'information");
define("_MI_MYREF_WELCOME",		"Voici toutes les informations relatives au trafic de ce site.");
define("_MI_MYREF_STARTDATE",		"Date de début");
define("_MI_MYREF_STARTDATE_DSC",	"Date de début pour les statistiques du compteur de visite. Ne modifier que lors d'une mise à jour des données.");
define("_MI_MYREF_ORDER",		"Ordre d'affichage");
define("_MI_MYREF_ORDER_REF",		"Référant");
define("_MI_MYREF_ORDER_DATE",	"Dernière visite");
define("_MI_MYREF_ORDER_VISIT",	"Visites");
define("_MI_MYREF_PERPAGE",		"Nombre de résultats");
define("_MI_MYREF_PERPAGE_DSC",	"Détermine le nombre de résultats à afficher par page.");
define("_MI_MYREF_TAG_NEW",		"Nouveau");
define("_MI_MYREF_TAG_NEW_DSC",	"1) Combien de temps le référant est considéré comme nouveau (en jours).<br />

2) Combien de visites avant qu'un référant ne s'affiche en partie publique ou utilisable dans le metagen.");
define("_MI_MYREF_TAG_POP",		"Populaire");
define("_MI_MYREF_TAG_POP_DSC",	"Combien de visites pour qu'un référant soit considéré comme populaire (en hits).");
define("_MI_MYREF_TODAY",		"Données du jour");
define("_MI_MYREF_TODAY_DSC",		"Couleur des dates pour les données actualisées, du jour.");
define("_MI_MYREF_TOOLD",		"Donnée périmées");
define("_MI_MYREF_TOOLD_DSC",		"Couleurs des dates pour les données périmées.");
define("_MI_MYREF_ALPHA",		"Liste alpha");
define("_MI_MYREF_DESCRIPTION",	"Afficher les statistiques pour les visiteurs.");

define("_MI_MYREF_PAGES",			"Pages");
define("_MI_MYREF_PAGES_HELP",			"Liste des pages vues par les visiteurs");

define("_MI_MYREF_KEYWORDS",		        "Mots clés");
define("_MI_MYREF_KEYWORDS_HELP",		        "Liste des mots clés employés pour accéder à ce site via les moteurs de recherche");

define("_MI_MYREF_QUERY",			"Requêtes");
define("_MI_MYREF_QUERY_HELP",			"Liste des requêtes utilisée dans les moteurs de recherche pour accéder à ce site");

define("_MI_MYREF_ROBOTS",			"Robots");
define("_MI_MYREF_ROBOTS_HELP",			"Liste se robots qui ont enregistré les pages du site");

define("_MI_MYREF_REFERER",	   		"Référant");
define("_MI_MYREF_REFERER_HELP",	        "Liste des sites qui pointent vers ce site");

define("_MI_MYREF_ENGINE",	  		"Moteur de recherche");
define("_MI_MYREF_ENGINE_HELP",	  		"Liste des moteurs de recherche qui génèrent du trafic vers ce site");

define("_MI_MYREF_USERVISIT", 		"Visite des membres");
define("_MI_MYREF_USERS", 		"Utilisateurs");
define("_MI_MYREF_BYMODULE_KEYWORD",    "Mots clés par modules/pages");
define("_MI_MYREF_BYMODULE_KEYWORD_HELP",    "Liste des mots clés employés par module et par page");

define("_MI_MYREF_BYMODULE_QUERY",	"Requêtes par modules/pages");
define("_MI_MYREF_BYMODULE_QUERY_HELP",	"Liste des requêtes employées par module et par page");

define("_MI_MYREF_BYREFERER",		"Référants par modules/pages");
define("_MI_MYREF_BYREFERER_HELP",		"Liste des référants par module et par page");

define("_MI_MYREF_DATE",	"Dernières visites");
define("_MI_MYREF_NEW",		"Nouveaux");
define("_MI_MYREF_TOP",		"Top");
define("_MI_MYREF_POP",		"Populaires");
define("_MI_MYREF_RANDOM",	"Aléatoire");

?>
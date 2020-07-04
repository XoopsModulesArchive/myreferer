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
define('_MI_MYREFERER_NAME', 'myReferer');
define('_MI_MYREFERER_DSC', 'Statistiques � propos des r�f�rants, moteurs de recherche et mots cl�s.');

// Menus
define('_MI_MYREFERER_ADMIN', 'Index');
define('_MI_MYREFERER_CONFIG', 'Configuration');
define('_MI_MYREFERER_META', 'G�n�rateur de Meta');
define('_MI_MYREFERER_CLEAN', 'Purge Base de donn�es');
define('_MI_MYREFERER_STATS', 'Statistiques');
define('_MI_MYREFERER_PERMS', 'Permissions');
define('_MI_MYREFERER_BLOCKS', 'Blocs & Groupes');

define('_MI_MYREFERER_HELP', 'Aide');

//  Blocks
define('_MI_MYREFERER_BLOC_ALLINFO', 'Derni�res informations');
define('_MI_MYREFERER_BLOC_REFERER', 'Derniers r�f�rents');
define('_MI_MYREFERER_BLOC_ENGINE', 'Derniers Moteur de recherche');
define('_MI_MYREFERER_BLOC_KEYWORD', 'Derniers Mots cl�s');
define('_MI_MYREFERER_BLOC_QUERY', 'Derni�res requ�tes');
define('_MI_MYREFERER_BLOC_ROBOTS', 'Derniers Robots');
define('_MI_MYREFERER_BLOC_PAGES', 'Derni�res pages');
define('_MI_MYREFERER_BLOC_USERS', 'Derniers Utilisateur');
define('_MI_MYREFERER_PAGECHCK', '');

// Preferecnces
define('_MI_MYREFERER_BANNER', 'Afficher la banni�re');
define('_MI_MYREFERER_BANNER_DSC', '');
define('_MI_MYREFERER_TEXT', 'Texte');
define('_MI_MYREFERER_TEXT_DSC', "Afficher un texte d'information");
define('_MI_MYREFERER_WELCOME', 'Voici toutes les informations relatives au trafic de ce site.');
define('_MI_MYREFERER_STARTDATE', 'Date de d�but');
define('_MI_MYREFERER_STARTDATE_DSC', "Date de d�but pour les statistiques du compteur de visite. Ne modifier que lors d'une mise � jour des donn�es.");
define('_MI_MYREFERER_ORDER', "Ordre d'affichage");
define('_MI_MYREFERER_ORDER_REF', 'R�f�rant');
define('_MI_MYREFERER_ORDER_DATE', 'Derni�re visite');
define('_MI_MYREFERER_ORDER_VISIT', 'Visites');
define('_MI_MYREFERER_PERPAGE', 'Nombre de r�sultats');
define('_MI_MYREFERER_PERPAGE_DSC', 'D�termine le nombre de r�sultats � afficher par page.');
define('_MI_MYREFERER_TAG_NEW', 'Nouveau');
define('_MI_MYREFERER_TAG_NEW_DSC', "1) Combien de temps le r�f�rant est consid�r� comme nouveau (en jours).<br>

2) Combien de visites avant qu'un r�f�rant ne s'affiche en partie publique ou utilisable dans le metagen.");
define('_MI_MYREFERER_TAG_POP', 'Populaire');
define('_MI_MYREFERER_TAG_POP_DSC', "Combien de visites pour qu'un r�f�rant soit consid�r� comme populaire (en hits).");
define('_MI_MYREFERER_TODAY', 'Donn�es du jour');
define('_MI_MYREFERER_TODAY_DSC', 'Couleur des dates pour les donn�es actualis�es, du jour.');
define('_MI_MYREFERER_TOOLD', 'Donn�e p�rim�es');
define('_MI_MYREFERER_TOOLD_DSC', 'Couleurs des dates pour les donn�es p�rim�es.');
define('_MI_MYREFERER_ALPHA', 'Liste alpha');
define('_MI_MYREFERER_DESCRIPTION', 'Afficher les statistiques pour les visiteurs.');

define('_MI_MYREFERER_PAGES', 'Pages');
define('_MI_MYREFERER_PAGES_HELP', 'Liste des pages vues par les visiteurs');

define('_MI_MYREFERER_KEYWORDS', 'Mots cl�s');
define('_MI_MYREFERER_KEYWORDS_HELP', 'Liste des mots cl�s employ�s pour acc�der � ce site via les moteurs de recherche');

define('_MI_MYREFERER_QUERY', 'Requ�tes');
define('_MI_MYREFERER_QUERY_HELP', 'Liste des requ�tes utilis�e dans les moteurs de recherche pour acc�der � ce site');

define('_MI_MYREFERER_ROBOTS', 'Robots');
define('_MI_MYREFERER_ROBOTS_HELP', 'Liste se robots qui ont enregistr� les pages du site');

define('_MI_MYREFERER_REFERER', 'R�f�rant');
define('_MI_MYREFERER_REFERER_HELP', 'Liste des sites qui pointent vers ce site');

define('_MI_MYREFERER_ENGINE', 'Moteur de recherche');
define('_MI_MYREFERER_ENGINE_HELP', 'Liste des moteurs de recherche qui g�n�rent du trafic vers ce site');

define('_MI_MYREFERER_USERVISIT', 'Visite des membres');
define('_MI_MYREFERER_USERS', 'Utilisateurs');
define('_MI_MYREFERER_BYMODULE_KEYWORD', 'Mots cl�s par modules/pages');
define('_MI_MYREFERER_BYMODULE_KEYWORD_HELP', 'Liste des mots cl�s employ�s par module et par page');

define('_MI_MYREFERER_BYMODULE_QUERY', 'Requ�tes par modules/pages');
define('_MI_MYREFERER_BYMODULE_QUERY_HELP', 'Liste des requ�tes employ�es par module et par page');

define('_MI_MYREFERER_BYREFERER', 'R�f�rants par modules/pages');
define('_MI_MYREFERER_BYREFERER_HELP', 'Liste des r�f�rants par module et par page');

define('_MI_MYREFERER_DATE', 'Derni�res visites');
define('_MI_MYREFERER_NEW', 'Nouveaux');
define('_MI_MYREFERER_TOP', 'Top');
define('_MI_MYREFERER_POP', 'Populaires');
define('_MI_MYREFERER_RANDOM', 'Al�atoire');

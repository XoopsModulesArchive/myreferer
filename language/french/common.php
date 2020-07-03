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

// myref_config table
define('_MYREFERER_KEYWORD_MIN', 'Taille minimum des mots-cl�s recherch�s');
define('_MYREFERER_KEYWORD_MIN_DSC', '');

define('_MYREFERER_KEYWORD_MAX', 'Taille maximum des mots-cl�s recherch�s');
define('_MYREFERER_KEYWORD_MAX_DSC', '');

define('_MYREFERER_MBCONVERT', 'Convertion des caract�res sp�ciaux');
define('_MYREFERER_MBCONVERT_DSC', '');

define('_MYREFERER_PUNCTATION', 'Conserver la ponctuation dans les mots-cl�s recherch�s');
define('_MYREFERER_PUNCTATION_DSC', '');

define('_MYREFERER_NUMBERS', 'Conserver les nombres dans les mots-cl�s recherch�s');
define('_MYREFERER_NUMBERS_DSC', '');

define('_MYREFERER_SMALLCAPS', 'Convertir les mots-cl�s recherch�s en minuscule');
define('_MYREFERER_SMALLCAPS_DSC', '');

define('_MYREFERER_KEYWORD_BLACKLIST', 'Liste des mots cl�s � exclure');
define('_MYREFERER_KEYWORD_BLACKLIST_DSC',
       'Sp�cifier les nots cl�s qui doivent �tre exclus.<br>Les mots cl�s doivent �tre s�par�s par <b><span style="color: #CC0000; ">|</span></b>.<br>par exemple : myreferer<b><span style="color: #CC0000; ">|</span></b>multiMenu');

define('_MYREFERER_MODULE_BLACKLIST', 'Liste des modules � exclure');
define('_MYREFERER_MODULE_BLACKLIST_DSC',
       'Sp�cifier le nom des modules qui doivent �tre exclus.<br>Les noms des r�pertoires doivent �tre s�par�s par <b><span style="color: #CC0000; ">|</span></b>.<br>par exemple : myreferer<b><span style="color: #CC0000; ">|</span></b>multiMenu');

define('_MYREFERER_SEARCH_BLACKLIST', 'Liste des moteurs de recherche � exclure');
define('_MYREFERER_SEARCH_BLACKLIST_DSC',
       'Sp�cifier les moteurs de recherche qui doivent �tre exclus.<br>Les moteurs de recherche doivent �tre s�par�s par <b><span style="color: #CC0000; ">|</span></b>.<br>par exemple : google.it<b><span style="color: #CC0000; ">|</span></b>sucheaol.aol.de');

define('_MYREFERER_REFERER_BLACKLIST', 'Liste des r�f�rants � exclure');
define('_MYREFERER_REFERER_BLACKLIST_DSC',
       'Sp�cifier les r�f�rents qui doivent �tre exclus.<br>Les r�f�rents doivent �tre s�par�s par <b><span style="color: #CC0000; ">|</span></b>.<br>par exemple : 127.0.0.1<b><span style="color: #CC0000; ">|</span></b>mail.google.com');

define('_MYREFERER_NEW_BOT_SMAIL', "Activer l'envoi d'un email pour le r�f�rencement par un nouveau robot");
define('_MYREFERER_NEW_BOT_SMAIL_DSC', '');

define('_MYREFERER_NEW_BOT_MAIL', "Adresse d'envoi des emails");
define('_MYREFERER_NEW_BOT_MAIL_DSC', "si vide, les emails seront envoy� � l'administrateur du site");

define('_MYREFERER_ROBOTS_BLACKLIST', 'Liste des robots � exclure');
define('_MYREFERER_ROBOTS_BLACKLIST_DSC',
       'Sp�cifier les robots qui doivent �tre exclus.<br>Les robots doivent �tre s�par�s par <b><span style="color: #CC0000; ">|</span></b>.<br>par exemple : googlebot<b><span style="color: #CC0000; ">|</span></b>msnbot');

define('_MYREFERER_PAGE_PROHIBIT', 'Page de redirection des robots prohib�s');
define('_MYREFERER_PAGE_PROHIBIT_DSC', '');

define('_MYREFERER_ROBOTS_PROHIBIT', 'Liste des robots prohib�s');
define('_MYREFERER_ROBOTS_PROHIBIT_DSC',
       "Cette option permettra d'interdire l'acc�s au site aux robots sp�cifi�s.<br>Les robots doivent �tre s�par�s par <b><span style=\"color: #CC0000; \">|</span></b>.<br>par exemple : fileDL.exe<b><span style=\"color: #CC0000; \">|</span></b>Lynx");

define('_MYREFERER_STATS_ALL', 'Tout');
define('_MYREFERER_STATS_TOP', 'Top');

define('_MYREFERER_STATS_PAGES', 'Pages - Afficher le top ');
define('_MYREFERER_STATS_PAGES_DSC', '');

define('_MYREFERER_STATS_QUERY', 'Mots cl�s - Afficher le top ');
define('_MYREFERER_STATS_QUERY_DSC', '');

define('_MYREFERER_STATS_QUERY_PAGES', 'Mots cl�s/Pages - Afficher le top ');
define('_MYREFERER_STATS_QUERY_PAGES_DSC', '');

define('_MYREFERER_STATS_REFERER', 'Referer - Afficher le top ');
define('_MYREFERER_STATS_REFERER_DSC', '');

define('_MYREFERER_STATS_REFERER_PAGES', 'Referer/Pages - Afficher le top ');
define('_MYREFERER_STATS_REFERER_PAGES_DSC', '');

define('_MYREFERER_STATS_ROBOTS', 'Robots - Afficher le top ');
define('_MYREFERER_STATS_ROBOTS_DSC', '');

define('_MYREFERER_STATS_ROBOTS_PAGES', 'Robots/Pages - Afficher le top ');
define('_MYREFERER_STATS_ROBOTS_PAGES_DSC', '');

define('_MYREFERER_STATS_USERS', 'Visiteurs - Afficher le top ');
define('_MYREFERER_STATS_USERS_DSC', '');

define('_MYREFERER_STATS_USERS_PAGES', 'Visiteurs/Pages - Afficher le top ');
define('_MYREFERER_STATS_USERS_PAGES_DSC', '');

define('_MYREFERER_COUNT_ADMIN', 'Compter les visites de(s) Webmaster(s)');
define('_MYREFERER_COUNT_ADMIN_DSC', '');

define('_MYREFERER_USER_VISIT', 'Enregistrer les pages vues ');
define('_MYREFERER_USER_VISIT_DSC', '');

define('_MYREFERER_SAVE_GROUP', 'Choisir les groupes');
define('_MYREFERER_SAVE_GROUP_DSC', '');

define('_MYREFERER_ADMIN_VISIT', 'Enregistrer les pages vues par le(s) Webmaster(s)');
define('_MYREFERER_ADMIN_VISIT_DSC', '');

define('_MYREFERER_KEYWORD', 'Configuration mots cl�s');
define('_MYREFERER_REFERER', 'Configuration r�f�rents');
define('_MYREFERER_ROBOTS', 'Configuration robots');
define('_MYREFERER_STATS', 'Configuration des statistiques');
define('_MYREFERER_USERVISIT', 'Configuration USER VISIT');

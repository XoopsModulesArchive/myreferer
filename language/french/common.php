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

// myref_config table
define("_MYREFERER_KEYWORD_MIN", "Taille minimum des mots-clés recherchés");
define("_MYREFERER_KEYWORD_MIN_DSC", "");

define("_MYREFERER_KEYWORD_MAX", "Taille maximum des mots-clés recherchés");
define("_MYREFERER_KEYWORD_MAX_DSC", "");

define("_MYREFERER_MBCONVERT", "Convertion des caractères spéciaux");
define("_MYREFERER_MBCONVERT_DSC", "");

define("_MYREFERER_PUNCTATION", "Conserver la ponctuation dans les mots-clés recherchés");
define("_MYREFERER_PUNCTATION_DSC", "");

define("_MYREFERER_NUMBERS", "Conserver les nombres dans les mots-clés recherchés");
define("_MYREFERER_NUMBERS_DSC", "");

define("_MYREFERER_SMALLCAPS", "Convertir les mots-clés recherchés en minuscule");
define("_MYREFERER_SMALLCAPS_DSC", "");

define("_MYREFERER_KEYWORD_BLACKLIST", "Liste des mots clés à exclure");
define("_MYREFERER_KEYWORD_BLACKLIST_DSC", "Spécifier les nots clés qui doivent être exclus.<br />Les mots clés doivent être séparés par <b><font color='#CC0000'>|</font></b>.<br />par exemple : myreferer<b><font color='#CC0000'>|</font></b>multiMenu");

define("_MYREFERER_MODULE_BLACKLIST", "Liste des modules à exclure");
define("_MYREFERER_MODULE_BLACKLIST_DSC", "Spécifier le nom des modules qui doivent être exclus.<br />Les noms des répertoires doivent être séparés par <b><font color='#CC0000'>|</font></b>.<br />par exemple : myreferer<b><font color='#CC0000'>|</font></b>multiMenu");

define("_MYREFERER_SEARCH_BLACKLIST", "Liste des moteurs de recherche à exclure");
define("_MYREFERER_SEARCH_BLACKLIST_DSC", "Spécifier les moteurs de recherche qui doivent être exclus.<br />Les moteurs de recherche doivent être séparés par <b><font color='#CC0000'>|</font></b>.<br />par exemple : google.it<b><font color='#CC0000'>|</font></b>sucheaol.aol.de");

define("_MYREFERER_REFERER_BLACKLIST", "Liste des référants à exclure");
define("_MYREFERER_REFERER_BLACKLIST_DSC", "Spécifier les référents qui doivent être exclus.<br />Les référents doivent être séparés par <b><font color='#CC0000'>|</font></b>.<br />par exemple : 127.0.0.1<b><font color='#CC0000'>|</font></b>mail.google.com");

define("_MYREFERER_NEW_BOT_SMAIL", "Activer l'envoi d'un email pour le référencement par un nouveau robot");
define("_MYREFERER_NEW_BOT_SMAIL_DSC", "");

define("_MYREFERER_NEW_BOT_MAIL", "Adresse d'envoi des emails");
define("_MYREFERER_NEW_BOT_MAIL_DSC", "si vide, les emails seront envoyé à l'administrateur du site");

define("_MYREFERER_ROBOTS_BLACKLIST", "Liste des robots à exclure");
define("_MYREFERER_ROBOTS_BLACKLIST_DSC", "Spécifier les robots qui doivent être exclus.<br />Les robots doivent être séparés par <b><font color='#CC0000'>|</font></b>.<br />par exemple : googlebot<b><font color='#CC0000'>|</font></b>msnbot");

define("_MYREFERER_PAGE_PROHIBIT", "Page de redirection des robots prohibés");
define("_MYREFERER_PAGE_PROHIBIT_DSC", "");

define("_MYREFERER_ROBOTS_PROHIBIT", "Liste des robots prohibés");
define("_MYREFERER_ROBOTS_PROHIBIT_DSC", "Cette option permettra d'interdire l'accès au site aux robots spécifiés.<br />Les robots doivent être séparés par <b><font color='#CC0000'>|</font></b>.<br />par exemple : fileDL.exe<b><font color='#CC0000'>|</font></b>Lynx");

define("_MYREFERER_STATS_ALL", "Tout");
define("_MYREFERER_STATS_TOP", "Top");

define("_MYREFERER_STATS_PAGES", "Pages - Afficher le top ");
define("_MYREFERER_STATS_PAGES_DSC", "");

define("_MYREFERER_STATS_QUERY", "Mots clés - Afficher le top ");
define("_MYREFERER_STATS_QUERY_DSC", "");

define("_MYREFERER_STATS_QUERY_PAGES", "Mots clés/Pages - Afficher le top ");
define("_MYREFERER_STATS_QUERY_PAGES_DSC", "");

define("_MYREFERER_STATS_REFERER", "Referer - Afficher le top ");
define("_MYREFERER_STATS_REFERER_DSC", "");

define("_MYREFERER_STATS_REFERER_PAGES", "Referer/Pages - Afficher le top ");
define("_MYREFERER_STATS_REFERER_PAGES_DSC", "");

define("_MYREFERER_STATS_ROBOTS", "Robots - Afficher le top ");
define("_MYREFERER_STATS_ROBOTS_DSC", "");

define("_MYREFERER_STATS_ROBOTS_PAGES", "Robots/Pages - Afficher le top ");
define("_MYREFERER_STATS_ROBOTS_PAGES_DSC", "");

define("_MYREFERER_STATS_USERS", "Visiteurs - Afficher le top ");
define("_MYREFERER_STATS_USERS_DSC", "");

define("_MYREFERER_STATS_USERS_PAGES", "Visiteurs/Pages - Afficher le top ");
define("_MYREFERER_STATS_USERS_PAGES_DSC", "");

define("_MYREFERER_COUNT_ADMIN","Compter les visites de(s) Webmaster(s)");
define("_MYREFERER_COUNT_ADMIN_DSC","");

define("_MYREFERER_USER_VISIT","Enregistrer les pages vues ");
define("_MYREFERER_USER_VISIT_DSC","");

define("_MYREFERER_SAVE_GROUP","Choisir les groupes");
define("_MYREFERER_SAVE_GROUP_DSC","");

define("_MYREFERER_ADMIN_VISIT","Enregistrer les pages vues par le(s) Webmaster(s)");
define("_MYREFERER_ADMIN_VISIT_DSC","");

define("_MYREFERER_KEYWORD" , "Configuration mots clés");
define("_MYREFERER_REFERER" , "Configuration référents");
define("_MYREFERER_ROBOTS" , "Configuration robots");
define("_MYREFERER_STATS" , "Configuration des statistiques");
define("_MYREFERER_USERVISIT" , "Configuration USER VISIT");
?>
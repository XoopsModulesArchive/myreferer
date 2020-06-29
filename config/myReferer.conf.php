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


// Compter les visites de(s) Webmaster(s)
$count_admin = 0;

// Liste des modules � exclure
$module_blacklist = "xoopsorgnews|xoops_redirect|user|search|notifications|viewpmsg|readpmsg";

// Taille minimum des mots-cl�s recherch�s
$keyword_min = 3;

// Taille maximum des mots-cl�s recherch�s
$keyword_max = 24;

// Conserver la ponctuation dans les mots-cl�s recherch�s
$punctation = 1;

// Conserver les nombres dans les mots-cl�s recherch�s
$numbers = 0;

// Convertir les mots-cl�s recherch�s en minuscule
$smallcaps = 1;

// Liste des mots cl�s � exclure
$keyword_blacklist = "pour|avec|dans|site";

// Liste des moteurs de recherche � exclure
$search_blacklist = "";

// Liste des r�f�rants � exclure
$referer_blacklist = "127.0.0.1|mail|xoopsorgnews|casino|online|rate|sex|insur|finance|viagra|drug|cialis|health|loan|credit|poker|pharma|institute|weight";

// Activer l'envoi d'un email pour le r�f�rencement par un nouveau robot
$new_bot_smail = 0;

// Adresse d'envoi des emails
$new_bot_mail = "";

// Liste des robots � exclure
$robots_blacklist = "W3C_Validator|Lynx|libwww-perl";

// Page de redirection des robots prohib�s
$page_prohibit = "modules/myReferer/norobot.html";

// Liste des robots prohib�s
$robots_prohibit = "";

// Enregistrer les pages vues 
$user_visit = 1;

// Choisir les groupes
$save_group = "2";

// Pages - Afficher le top 
$myref_pages_stats = 100;

// Mots cl�s - Afficher le top 
$myref_query_stats = 100;

// Mots cl�s/Pages - Afficher le top 
$myref_query_pages_stats = 100;

// Referer - Afficher le top 
$myref_referer_stats = 100;

// Referer/Pages - Afficher le top 
$myref_referer_pages_stats = 100;

// Robots - Afficher le top 
$myref_robots_stats = 100;

// Robots/Pages - Afficher le top 
$myref_robots_pages_stats = 100;

// Visiteurs - Afficher le top 
$myref_users_stats = 100;

// Visiteurs/Pages - Afficher le top 
$myref_users_pages_stats = 100;

?>
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
define("_MYREFERER_KEYWORD_MIN", "Keyword minimum size");
define("_MYREFERER_KEYWORD_MIN_DSC", "");

define("_MYREFERER_KEYWORD_MAX", "Keyword maximum size");
define("_MYREFERER_KEYWORD_MAX_DSC", "");

define("_MYREFERER_MBCONVERT", "Convert special caracters");
define("_MYREFERER_MBCONVERT_DSC", "");

define("_MYREFERER_PUNCTATION", "Keep punctuation");
define("_MYREFERER_PUNCTATION_DSC", "");

define("_MYREFERER_NUMBERS", "Keep numbers");
define("_MYREFERER_NUMBERS_DSC", "");

define("_MYREFERER_SMALLCAPS", "Convert to lowercase");
define("_MYREFERER_SMALLCAPS_DSC", "");

define("_MYREFERER_KEYWORD_BLACKLIST", "Keywords Blacklist");
define("_MYREFERER_KEYWORD_BLACKLIST_DSC", "Specify which keywords are blacklisted.<br />Keywords must be separated by  <b><font color='#CC0000'>|</font></b>.<br />For instance: myreferer<b><font color='#CC0000'>|</font></b>multiMenu");

define("_MYREFERER_MODULE_BLACKLIST", "Modules Blacklist");
define("_MYREFERER_MODULE_BLACKLIST_DSC", "Specify which modules are blacklisted.<br />Directories must be separated by  <b><font color='#CC0000'>|</font></b>.<br />For instance: myreferer<b><font color='#CC0000'>|</font></b>multiMenu");

define("_MYREFERER_SEARCH_BLACKLIST", "Search Engines Blacklist");
define("_MYREFERER_SEARCH_BLACKLIST_DSC", "Specify which search engines are blacklisted.<br />Search engine must be separated by  <b><font color='#CC0000'>|</font></b>.<br />For instance: google.it<b><font color='#CC0000'>|</font></b>sucheaol.aol.de");

define("_MYREFERER_REFERER_BLACKLIST", "Referers Blacklist");
define("_MYREFERER_REFERER_BLACKLIST_DSC", "Specify which referer are blacklisted.<br />Referers must be separated by  <b><font color='#CC0000'>|</font></b>.<br />For instance: 127.0.0.1<b><font color='#CC0000'>|</font></b>mail.google.com");

define("_MYREFERER_NEW_BOT_SMAIL", "Activate warning by mail when a new robot is visiting the site");
define("_MYREFERER_NEW_BOT_SMAIL_DSC", "");

define("_MYREFERER_NEW_BOT_MAIL", "Warning mail adresss");
define("_MYREFERER_NEW_BOT_MAIL_DSC", "If empty mails are sent to site admin");

define("_MYREFERER_ROBOTS_BLACKLIST", "Robots Blacklist");
define("_MYREFERER_ROBOTS_BLACKLIST_DSC", "Specify which robots are blacklisted.<br />Robots must be separated by  <b><font color='#CC0000'>|</font></b>.<br />For instance:  googlebot<b><font color='#CC0000'>|</font></b>msnbot");

define("_MYREFERER_PAGE_PROHIBIT", "Redirection page for blacklisted bots");
define("_MYREFERER_PAGE_PROHIBIT_DSC", "");

define("_MYREFERER_ROBOTS_PROHIBIT", "Forbiden robots");
define("_MYREFERER_ROBOTS_PROHIBIT_DSC", "This option allow to forbidden specified robots.<br />Robots must be separated by  <b><font color='#CC0000'>|</font></b>.<br />For instance: fileDL.exe<b><font color='#CC0000'>|</font></b>Lynx");

define("_MYREFERER_STATS_ALL", "All");
define("_MYREFERER_STATS_TOP", "Top");

define("_MYREFERER_STATS_PAGES", "Top Pages");
define("_MYREFERER_STATS_PAGES_DSC", "");

define("_MYREFERER_STATS_QUERY", "Top Keywords");
define("_MYREFERER_STATS_QUERY_DSC", "");

define("_MYREFERER_STATS_QUERY_PAGES", "Keywords/Pages ");
define("_MYREFERER_STATS_QUERY_PAGES_DSC", "");

define("_MYREFERER_STATS_REFERER", "Top Referers");
define("_MYREFERER_STATS_REFERER_DSC", "");

define("_MYREFERER_STATS_REFERER_PAGES", "Referer/Pages");
define("_MYREFERER_STATS_REFERER_PAGES_DSC", "");

define("_MYREFERER_STATS_ROBOTS", "Top Robots");
define("_MYREFERER_STATS_ROBOTS_DSC", "");

define("_MYREFERER_STATS_ROBOTS_PAGES", "Robots/Pages");
define("_MYREFERER_STATS_ROBOTS_PAGES_DSC", "");

define("_MYREFERER_STATS_USERS", "Visitors");
define("_MYREFERER_STATS_USERS_DSC", "");

define("_MYREFERER_STATS_USERS_PAGES", "Visitors/Pages");
define("_MYREFERER_STATS_USERS_PAGES_DSC", "");

define("_MYREFERER_COUNT_ADMIN","Count the visits of Webmaster(s) ");
define("_MYREFERER_COUNT_ADMIN_DSC","");

define("_MYREFERER_USER_VISIT","Record the pages seen");
define("_MYREFERER_USER_VISIT_DSC","");

define("_MYREFERER_SAVE_GROUP","Choose the groups");
define("_MYREFERER_SAVE_GROUP_DSC","");

define("_MYREFERER_ADMIN_VISIT","Record the pages seen by the Webmaster(s) ");
define("_MYREFERER_ADMIN_VISIT_DSC","");

define("_MYREFERER_KEYWORD" , "Keywords configuration");
define("_MYREFERER_REFERER" , "Referers configuration");
define("_MYREFERER_ROBOTS" , "Robots configuration");
define("_MYREFERER_STATS" , "Statistics configuration");
define("_MYREFERER_USERVISIT" , "USER VISIT Configuration");
?>
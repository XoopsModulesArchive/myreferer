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

include_once( 'admin_header.php');

// Activate php debug mode
error_reporting(E_ALL ^ E_NOTICE);

global $xoopsModule, $xoopsDB, $xoopsConfig;

echo "<h2><font color='#CC0000'>"._MD_MYREFERER_UPGRADE_DB."</font></h2>";

if (!myReferer_TableExists('myref_config')) {
	$ver = '1';
} else {
	$ver = myReferer_GetMeta( 'version' );
}

$mid = $xoopsModule->getVar('mid');
$ret = true;

$myReferer_Config_Handler = & xoops_getmodulehandler('myref_config', 'myReferer' );
$myReferer_Config_Handler->WriteConfigFile();
unset($myReferer_Config_Handler);

$config_file = XOOPS_ROOT_PATH . '/modules/myReferer/config/myReferer.conf.php';
if ( file_exists($config_file) ) {
	include_once( $config_file);
}

$version			= isset($version) ? $version : "1.0";
$lastraz			= isset($lastraz) ? $lastraz : date('W');
$count_admin		= isset($count_admin) ? $count_admin : 0;
//$user_visit			= isset($user_visit) ? $user_visit : 0;
$user_visit			= 0;
$save_group			= isset($save_group) ? addslashes( serialize(explode("|",$save_group)) ) : addslashes( serialize(array(0=>"2")) );
$module_blacklist	= isset($module_blacklist) ? $module_blacklist : "xoops_redirect|user|search|xoopsmembers|notifications|viewpmsg|readpmsg|myreferer|multiMenu|newbb|waiting|istats";
$keyword_min		= isset($keyword_min) ? $keyword_min : 3;
$keyword_max		= isset($keyword_mas) ? $keyword_mas : 24;
$punctation			= isset($punctation) ? $punctation : 1;
$numbers			= isset($numbers) ? $numbers : 0;
$smallcaps			= isset($smallcaps) ? $smallcaps : 0;
$keyword_blacklist	= isset($keyword_blacklist) ? $keyword_blacklist : "pour|avec|dans|site";
$search_blacklist	= isset($search_blacklist) ? $search_blacklist : "";
$referer_blacklist	= isset($referer_blacklist) ? $referer_blacklist : "127.0.0.1|mail";
$new_bot_smail		= isset($new_bot_smail) ? $new_bot_smail : 0;
$new_bot_mail		= isset($new_bot_mail) ? $new_bot_mail : "";
$robots_blacklist	= isset($robots_blacklist) ? $robots_blacklist : "W3C_Validator|Lynx|libwww-perl";
$page_prohibit		= isset($page_prohibit) ? $page_prohibit : "modules/myReferer/norobot.html";
$robots_prohibit	= isset($robots_prohibit) ? $robots_prohibit : "";
$myref_pages_stats			= isset($myref_pages_stats) ? $myref_pages_stats : 100;
$myref_query_stats			= isset($myref_query_stats) ? $myref_query_stats : 100;
$myref_query_pages_stats	= isset($myref_query_pages_stats) ? $myref_query_pages_stats : 100;
$myref_referer_stats		= isset($myref_referer_stats) ? $myref_referer_stats : 100;
$myref_referer_pages_stats	= isset($myref_referer_pages_stats) ? $myref_referer_pages_stats : 100;
$myref_robots_stats			= isset($myref_robots_stats) ? $myref_robots_stats : 100;
$myref_robots_pages_stats	= isset($myref_robots_pages_stats) ? $myref_robots_pages_stats : 100;
$myref_users_stats			= isset($myref_users_stats) ? $myref_users_stats : 100;
$myref_users_pages_stats	= isset($myref_users_pages_stats) ? $myref_users_pages_stats : 100;




switch($ver) {
	/**
	 * myReferer 1.0
	*/
    case '1':
    case '1.0':
        printf("<h3>". _MD_MYREFERER_UPGRADE_TO."</h3>", '1.0' );
        echo "<ul>";

        // Create table _myref_config
        if ( myReferer_TableExists('myref_config') && ret) {
        	$sql = 'DROP TABLE ' . $xoopsDB->prefix( 'myref_config' );
	        $ret = $ret && $xoopsDB->queryF($sql);
        }
        $table = $xoopsDB->prefix() . '_myref_config';
        $sql = 'CREATE TABLE ' . $table . ' (
			conf_id smallint(5) unsigned NOT NULL auto_increment,
			conf_name varchar(30) NOT NULL default "",
			conf_title varchar(30) NOT NULL default "",
			conf_value text NOT NULL,
			conf_desc varchar(50) NOT NULL default "",
			conf_formtype varchar(15) NOT NULL default "",
			conf_valuetype varchar(10) NOT NULL default "",
			conf_order smallint(5) unsigned NOT NULL default "0",
			PRIMARY KEY  (conf_id)
            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
        $ret = $ret && $xoopsDB->queryF($sql);
        echo "<li>Création de la table de configuration</li><ul>";

		// Add data into table
		if ( !myReferer_GetMeta( 'version' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "version", "", "' . $version . '", "", "hidden", "hidden", 0)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable version</li>";
        }
		if ( !myReferer_GetMeta( 'lastraz' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "lastraz", "", "' . $lastraz . '", "", "hidden", "hidden", 0)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable dernier RAZ</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
		if ( !myReferer_GetMeta( 'count_admin' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "count_admin", "_MYREFERER_COUNT_ADMIN", "' . $count_admin . '", "_MYREFERER_COUNT_ADMIN_DSC", "yesno", "int", 0)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable count_admin</li>";
        }
		if ( !myReferer_GetMeta( 'module_blacklist' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "module_blacklist", "_MYREFERER_MODULE_BLACKLIST", "' . $module_blacklist . '", "_MYREFERER_MODULE_BLACKLIST_DSC", "textarea", "text", 2)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable module_blacklist</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
		if ( !myReferer_GetMeta( 'insertBreak' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "", "_MYREFERER_KEYWORD", "", "", "insertBreak", "hidden", 100)';
	        $ret = $ret && $xoopsDB->queryF($sql);
        }
		if ( !myReferer_GetMeta( 'keyword_min' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "keyword_min", "_MYREFERER_KEYWORD_MIN", "' . $keyword_min . '", "_MYREFERER_KEYWORD_MIN_DSC", "text", "int", 101)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable keyword_min</li>";
        }
		if ( !myReferer_GetMeta( 'keyword_max' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "keyword_max", "_MYREFERER_KEYWORD_MAX", "' . $keyword_max . '", "_MYREFERER_KEYWORD_MAX_DSC", "text", "int", 102)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable keyword_max</li>";
        }
		if ( !myReferer_GetMeta( 'punctation' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "punctation", "_MYREFERER_PUNCTATION", "' . $punctation . '", "_MYREFERER_PUNCTATION_DSC", "yesno", "int", 103)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable punctation</li>";
        }
		if ( !myReferer_GetMeta( 'numbers' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "numbers", "_MYREFERER_NUMBERS", "' . $numbers . '", "_MYREFERER_NUMBERS_DSC", "yesno", "int", 104)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable numbers</li>";
        }
		if ( !myReferer_GetMeta( 'smallcaps' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "smallcaps", "_MYREFERER_SMALLCAPS", "' . $smallcaps . '", "_MYREFERER_SMALLCAPS_DSC", "yesno", "int", 105)';
	        $ret = $ret && $xoopsDB->queryF($sql);
        }
		if ( !myReferer_GetMeta( 'keyword_blacklist' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "keyword_blacklist", "_MYREFERER_KEYWORD_BLACKLIST", "' . $keyword_blacklist . '", "_MYREFERER_KEYWORD_BLACKLIST_DSC", "textarea", "text", 106)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable keyword_blacklist</li>";
        }
		if ( !myReferer_GetMeta( 'search_blacklist' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "search_blacklist", "_MYREFERER_SEARCH_BLACKLIST", "' . $search_blacklist . '", "_MYREFERER_SEARCH_BLACKLIST_DSC", "textarea", "text", 107)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable search_blacklist</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
		if ( !myReferer_GetMeta( 'insertBreak' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "", "_MYREFERER_REFERER", "", "", "insertBreak", "hidden", 200)';
	        $ret = $ret && $xoopsDB->queryF($sql);
        }
		if ( !myReferer_GetMeta( 'referer_blacklist' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "referer_blacklist", "_MYREFERER_REFERER_BLACKLIST", "' . $referer_blacklist . '", "_MYREFERER_REFERER_BLACKLIST_DSC", "textarea", "text", 201)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable referer_blacklist</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
		if ( !myReferer_GetMeta( 'insertBreak' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "", "_MYREFERER_ROBOTS", "", "", "insertBreak", "hidden", 300)';
	        $ret = $ret && $xoopsDB->queryF($sql);
        }
		if ( !myReferer_GetMeta( 'new_bot_smail' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "new_bot_smail", "_MYREFERER_NEW_BOT_SMAIL", "' . $new_bot_smail . '", "_MYREFERER_NEW_BOT_SMAIL_DSC", "yesno", "int", 301)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable new_bot_smail</li>";
        }
		if ( !myReferer_GetMeta( 'new_bot_mail' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "new_bot_mail", "_MYREFERER_NEW_BOT_MAIL", "' . $new_bot_mail . '", "_MYREFERER_NEW_BOT_MAIL_DSC", "text", "text", 302)';
	        $ret = $ret && $xoopsDB->queryF($sql);
        }
		if ( !myReferer_GetMeta( 'robots_blacklist' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "robots_blacklist", "_MYREFERER_ROBOTS_BLACKLIST", "' . $robots_blacklist . '", "_MYREFERER_ROBOTS_BLACKLIST_DSC", "textarea", "text", 303)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable robots_blacklist</li>";
        }
		if ( !myReferer_GetMeta( 'page_prohibit' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "page_prohibit", "_MYREFERER_PAGE_PROHIBIT", "' . $page_prohibit . '", "_MYREFERER_PAGE_PROHIBIT_DSC", "text", "text", 304)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable page_prohibit</li>";
        }
		if ( !myReferer_GetMeta( 'robots_prohibit' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "robots_prohibit", "_MYREFERER_ROBOTS_PROHIBIT", "' . $robots_prohibit . '", "_MYREFERER_ROBOTS_PROHIBIT_DSC", "textarea", "text", 305)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable robots_prohibit</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
		if ( !myReferer_GetMeta( 'insertBreak' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "", "_MYREFERER_USERVISIT", "", "", "insertBreak", "hidden", 100)';
	        $ret = $ret && $xoopsDB->queryF($sql);
        }
		if ( !myReferer_GetMeta( 'user_visit' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "user_visit", "_MYREFERER_USER_VISIT", "' . $user_visit . '", "_MYREFERER_USER_VISIT_DSC", "yesno", "int", 401)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable user_visit</li>";
        }

		if ( !myReferer_GetMeta( 'save_group' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "save_group", "_MYREFERER_SAVE_GROUP", "' . $save_group . '", "_MYREFERER_SAVE_GROUP_DSC", "select", "array", 402)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable save_group</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
		if ( !myReferer_GetMeta( 'insertBreak' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "", "_MYREFERER_STATS", "", "", "insertBreak", "hidden", 400)';
	        $ret = $ret && $xoopsDB->queryF($sql);
        }
		if ( !myReferer_GetMeta( 'myref_pages_stats' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myref_pages_stats", "_MYREFERER_STATS_PAGES", "' . $myref_pages_stats . '", "_MYREFERER_STATS_PAGES_DSC", "select", "int", 500)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable myref_pages_stats</li>";
        }
		if ( !myReferer_GetMeta( 'myref_query_stats' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myref_query_stats", "_MYREFERER_STATS_QUERY", "' . $myref_query_stats . '", "_MYREFERER_STATS_QUERY_DSC", "select", "int", 500)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable myref_query_stats</li>";
        }
		if ( !myReferer_GetMeta( 'myref_query_pages_stats' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myref_query_pages_stats", "_MYREFERER_STATS_QUERY_PAGES", "' . $myref_query_pages_stats . '", "_MYREFERER_STATS_QUERY_PAGES_DSC", "select", "int", 500)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable myref_query_pages_stats</li>";
        }
		if ( !myReferer_GetMeta( 'myref_referer_stats' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myref_referer_stats", "_MYREFERER_STATS_REFERER", "' . $myref_referer_stats . '", "_MYREFERER_STATS_REFERER_DSC", "select", "int", 500)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable myref_referer_stats</li>";
        }
		if ( !myReferer_GetMeta( 'myref_referer_pages_stats' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myref_referer_pages_stats", "_MYREFERER_STATS_REFERER_PAGES", "' . $myref_referer_pages_stats . '", "_MYREFERER_STATS_REFERER_PAGES_DSC", "select", "int", 500)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable myref_referer_pages_stats</li>";
        }
		if ( !myReferer_GetMeta( 'myref_robots_stats' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myref_robots_stats", "_MYREFERER_STATS_ROBOTS", "' . $myref_robots_stats . '", "_MYREFERER_STATS_ROBOTS_DSC", "select", "int", 500)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable myref_robots_stats</li>";
        }
		if ( !myReferer_GetMeta( 'myref_robots_pages_stats' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myref_robots_pages_stats", "_MYREFERER_STATS_ROBOTS_PAGES", "' . $myref_robots_pages_stats . '", "_MYREFERER_STATS_ROBOTS_PAGES_DSC", "select", "int", 500)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable myref_robots_pages_stats</li>";
        }
		if ( !myReferer_GetMeta( 'myref_users_stats' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myref_users_stats", "_MYREFERER_STATS_USERS", "' . $myref_users_stats . '", "_MYREFERER_STATS_USERS_DSC", "select", "int", 500)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable myref_users_stats</li>";
        }
		if ( !myReferer_GetMeta( 'myref_users_pages_stats' ) && ret ) {
	        $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myref_users_pages_stats", "_MYREFERER_STATS_USERS_PAGES", "' . $myref_users_pages_stats . '", "_MYREFERER_STATS_USERS_PAGES_DSC", "select", "int", 500)';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Ajout/Modification de la variable myref_users_pages_stats</li>";
        }
        echo "</ul>";
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_pages') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_pages';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(8) NOT NULL auto_increment,
				page text NOT NULL default "",
				visit int(8) NOT NULL default "0",
				visit_tmp int(8) NOT NULL default "0",
				startdate int(11) NOT NULL default "0",
				date int(11) NOT NULL default "0",
				hide tinyint(2) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_pages</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_pages_stats') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_pages_stats';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(8) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_pages_stats</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_query_stats') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_query_stats';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(8) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				queryid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_query_stats</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_query_pages') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_query_pages';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(11) NOT NULL auto_increment,
				queryid int(8) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				visit_tmp int(8) NOT NULL default "0",
				startdate int(11) NOT NULL default "0",
				date int(11) NOT NULL default "0",
				hide tinyint(2) NOT NULL default "0",
				tracker tinyint(2) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_query_pages</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_query_pages_stats') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_query_pages_stats';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(11) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				queryid int(8) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_query_pages_stats</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_referer_stats') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_referer_stats';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(8) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				refererid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_referer_stats</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_referer_pages') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_referer_pages';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(11) NOT NULL auto_increment,
				refererid int(8) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				visit_tmp int(8) NOT NULL default "0",
				startdate int(11) NOT NULL default "0",
				date int(11) NOT NULL default "0",
				hide tinyint(2) NOT NULL default "0",
				tracker tinyint(2) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_referer_pages</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_referer_pages_stats') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_referer_pages_stats';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(11) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				refererid int(8) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_referer_pages_stats</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_robots_stats') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_robots_stats';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(8) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				robotsid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_robots_stats</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_robots_pages') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_robots_pages';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(11) NOT NULL auto_increment,
				robotsid int(8) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				visit_tmp int(8) NOT NULL default "0",
				startdate int(11) NOT NULL default "0",
				date int(11) NOT NULL default "0",
				hide tinyint(2) NOT NULL default "0",
				tracker tinyint(2) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_robots_pages</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_robots_pages_stats') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_robots_pages_stats';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(11) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				robotsid int(8) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_robots_pages_stats</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_users') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_users';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(8) NOT NULL auto_increment,
				user int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				visit_tmp int(8) NOT NULL default "0",
				startdate int(11) NOT NULL default "0",
				date int(11) NOT NULL default "0",
				hide tinyint(2) NOT NULL default "0",
				tracker tinyint(2) NOT NULL default "1",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_users</li>";
        } else {
        	$table = $xoopsDB->prefix() . '_myref_users';
        	if ( !myReferer_FieldnameExists('myref_users', 'tracker') && ret ) {
	        	$sql = 'ALTER TABLE ' . $table . ' ADD tracker TINYINT(2) NOT NULL DEFAULT "1"';
		        $ret = $ret && $xoopsDB->queryF($sql);
	    	    echo "<li>Modification de la table myref_users</li>";
            }
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_users_stats') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_users_stats';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(8) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				usersid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_users_stats</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_users_pages') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_users_pages';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(11) NOT NULL auto_increment,
				usersid int(8) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				visit_tmp int(8) NOT NULL default "0",
				startdate int(11) NOT NULL default "0",
				date int(11) NOT NULL default "0",
				hide tinyint(2) NOT NULL default "0",
				tracker tinyint(2) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_users_pages</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( !myReferer_TableExists('myref_users_pages_stats') && ret ) {
	        $table = $xoopsDB->prefix() . '_myref_users_pages_stats';
	        $sql = 'CREATE TABLE ' . $table . ' (
				id int(11) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				usersid int(8) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myReferer - solo (http://www.wolfpackclan.com)\' ';
	        $ret = $ret && $xoopsDB->queryF($sql);
	        echo "<li>Création de la table myref_users_pages_stats</li>";
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( myReferer_TableExists('myref_query') && ret ) {
	        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myref_query') . ' COMMENT = "myReferer - solo (http://www.wolfpackclan.com)"';
    	    $ret = $ret && $xoopsDB->queryF($sql);
        }

		if ( myReferer_FieldnameExists('myref_query', 'query') && ret ) {
	        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myref_query') . ' CHANGE query query VARCHAR(255) NOT NULL DEFAULT ""';
    	    $ret = $ret && $xoopsDB->queryF($sql);
        }
		if ( !myReferer_FieldnameExists('myref_query', 'keyword') && ret) {
	        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myref_query') . ' ADD keyword TINYINT(2) DEFAULT "1" AFTER query';
    	    $ret = $ret && $xoopsDB->queryF($sql);
        }
		if ( !myReferer_FieldnameExists('myref_query', 'visit_tmp') && ret ) {
	        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myref_query') . ' ADD visit_tmp INT(8) DEFAULT "0" AFTER visit' ;
    	    $ret = $ret && $xoopsDB->queryF($sql);
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( myReferer_TableExists('myref_referer') && ret ) {
	        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myref_referer') . ' COMMENT = "myReferer - solo (http://www.wolfpackclan.com)"';
    	    $ret = $ret && $xoopsDB->queryF($sql);
        }

		if ( !myReferer_FieldnameExists('myref_referer', 'visit_tmp') && ret ) {
	        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myref_referer') . ' ADD visit_tmp INT(8) DEFAULT "0" AFTER visit' ;
    	    $ret = $ret && $xoopsDB->queryF($sql);
        }
// ----------------------------------------------------------------------------------------------------------------- //
        if ( myReferer_TableExists('myref_robots') && ret ) {
	        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myref_robots') . ' COMMENT = "myReferer - solo (http://www.wolfpackclan.com)"';
    	    $ret = $ret && $xoopsDB->queryF($sql);
        }

		if ( !myReferer_FieldnameExists('myref_robots', 'visit_tmp') && ret) {
	        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myref_robots') . ' ADD visit_tmp INT(8) DEFAULT "0" AFTER visit' ;
    	    $ret = $ret && $xoopsDB->queryF($sql);
        }
		if ( !myReferer_FieldnameExists('myref_robots', 'tracker') && ret) {
	        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myref_robots') . ' ADD tracker TINYINT(2) DEFAULT "0" ' ;
    	    $ret = $ret && $xoopsDB->queryF($sql);
        }
        echo "</ul>";
        break;

	/**
	 * myReferer 2.0
	*/
    case '2':
        break;
}

$newversion = round($xoopsModule->getVar('version') / 100, 2);
//if successful, update myReferer__meta table with new ver
if ($ret) {
	printf(_MD_MYREFERER_UPGRADE_OK, $newversion);
	$ret = myReferer_SetMeta('version', $newversion);
} else {
	printf(_MD_MYREFERER_UPGRADE_ERR, $newversion);
}

echo "<br /><br /><a href='" . XOOPS_URL . "/modules/myReferer/admin/index.php'>" . _BACK . "</a>";

$myReferer_Config_Handler = & xoops_getmodulehandler('myref_config', 'myReferer' );
$myReferer_Config_Handler->WriteConfigFile();
unset($myReferer_Config_Handler);

xoops_cp_footer();
?>
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

use XoopsModules\Myreferer\Helper;
use XoopsModules\Myreferer\Utility;

require_once __DIR__ . '/admin_header.php';

// Activate php debug mode
error_reporting(E_ALL ^ E_NOTICE);

global $xoopsModule, $xoopsDB, $xoopsConfig;
$helper = Helper::getInstance();

echo '<h2><span style="color: #CC0000; ">' . _MD_MYREFERER_UPGRADE_DB . '</span></h2>';

if (!Utility::existTable('myreferer_config')) {
    $ver = '1';
} else {
    $ver = Utility::getMeta('version');
}

$mid = $xoopsModule->getVar('mid');
$ret = true;

$configHandler = $helper->getHandler('Config');
$configHandler->WriteConfigFile();
unset($configHandler);

$config_file = XOOPS_ROOT_PATH . '/modules/myreferer/config/myreferer.conf.php';
if (file_exists($config_file)) {
    require_once $config_file;
}

$version     = $version ?? '1.0';
$lastraz     = $lastraz ?? date('W');
$count_admin = $count_admin ?? 0;
//$user_visit			= isset($user_visit) ? $user_visit : 0;
$user_visit                    = 0;
$save_group                    = isset($save_group) ? addslashes(serialize(explode('|', $save_group))) : addslashes(serialize([0 => '2']));
$module_blacklist              = $module_blacklist ?? 'xoops_redirect|user|search|xoopsmembers|notifications|viewpmsg|readpmsg|myreferer|multiMenu|newbb|waiting|istats';
$keyword_min                   = $keyword_min ?? 3;
$keyword_max                   = $keyword_mas ?? 24;
$punctation                    = $punctation ?? 1;
$numbers                       = $numbers ?? 0;
$smallcaps                     = $smallcaps ?? 0;
$keyword_blacklist             = $keyword_blacklist ?? 'pour|avec|dans|site';
$search_blacklist              = $search_blacklist ?? '';
$referer_blacklist             = $referer_blacklist ?? '127.0.0.1|mail';
$new_bot_smail                 = $new_bot_smail ?? 0;
$new_bot_mail                  = $new_bot_mail ?? '';
$robots_blacklist              = $robots_blacklist ?? 'W3C_Validator|Lynx|libwww-perl';
$page_prohibit                 = $page_prohibit ?? 'modules/myreferer/norobot.html';
$robots_prohibit               = $robots_prohibit ?? '';
$myreferer_pages_stats         = $myreferer_pages_stats ?? 100;
$myreferer_query_stats         = $myreferer_query_stats ?? 100;
$myreferer_query_pages_stats   = $myreferer_query_pages_stats ?? 100;
$myreferer_referer_stats       = $myreferer_referer_stats ?? 100;
$myreferer_referer_pages_stats = $myreferer_referer_pages_stats ?? 100;
$myreferer_robots_stats        = $myreferer_robots_stats ?? 100;
$myreferer_robots_pages_stats  = $myreferer_robots_pages_stats ?? 100;
$myreferer_users_stats         = $myreferer_users_stats ?? 100;
$myreferer_users_pages_stats   = $myreferer_users_pages_stats ?? 100;

switch ($ver) {
    /**
     * myreferer 1.0
     */
    case '1':
    case '1.0':
        printf('<h3>' . _MD_MYREFERER_UPGRADE_TO . '</h3>', '1.0');
        echo '<ul>';

        // Create table _myref_config
        if (Utility::existTable('myreferer_config') && ret) {
            $sql = 'DROP TABLE ' . $xoopsDB->prefix('myreferer_config');

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        $table = $xoopsDB->prefix() . '_myref_config';
        $sql   = 'CREATE TABLE ' . $table . ' (
			conf_id smallint(5) unsigned NOT NULL auto_increment,
			conf_name varchar(30) NOT NULL default "",
			conf_title varchar(30) NOT NULL default "",
			conf_value text NOT NULL,
			conf_desc varchar(50) NOT NULL default "",
			conf_formtype varchar(15) NOT NULL default "",
			conf_valuetype varchar(10) NOT NULL default "",
			conf_order smallint(5) unsigned NOT NULL default "0",
			PRIMARY KEY  (conf_id)
            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';
        $ret   = $ret && $xoopsDB->queryF($sql);
        echo '<li>Création de la table de configuration</li><ul>';

        // Add data into table
        if (!Utility::getMeta('version') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "version", "", "' . $version . '", "", "hidden", "hidden", 0)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable version</li>';
        }
        if (!Utility::getMeta('lastraz') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "lastraz", "", "' . $lastraz . '", "", "hidden", "hidden", 0)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable dernier RAZ</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::getMeta('count_admin') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "count_admin", "_MYREFERER_COUNT_ADMIN", "' . $count_admin . '", "_MYREFERER_COUNT_ADMIN_DSC", "yesno", "int", 0)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable count_admin</li>';
        }
        if (!Utility::getMeta('module_blacklist') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "module_blacklist", "_MYREFERER_MODULE_BLACKLIST", "' . $module_blacklist . '", "_MYREFERER_MODULE_BLACKLIST_DSC", "textarea", "text", 2)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable module_blacklist</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::getMeta('insertBreak') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "", "_MYREFERER_KEYWORD", "", "", "insertBreak", "hidden", 100)';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        if (!Utility::getMeta('keyword_min') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "keyword_min", "_MYREFERER_KEYWORD_MIN", "' . $keyword_min . '", "_MYREFERER_KEYWORD_MIN_DSC", "text", "int", 101)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable keyword_min</li>';
        }
        if (!Utility::getMeta('keyword_max') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "keyword_max", "_MYREFERER_KEYWORD_MAX", "' . $keyword_max . '", "_MYREFERER_KEYWORD_MAX_DSC", "text", "int", 102)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable keyword_max</li>';
        }
        if (!Utility::getMeta('punctation') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "punctation", "_MYREFERER_PUNCTATION", "' . $punctation . '", "_MYREFERER_PUNCTATION_DSC", "yesno", "int", 103)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable punctation</li>';
        }
        if (!Utility::getMeta('numbers') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "numbers", "_MYREFERER_NUMBERS", "' . $numbers . '", "_MYREFERER_NUMBERS_DSC", "yesno", "int", 104)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable numbers</li>';
        }
        if (!Utility::getMeta('smallcaps') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "smallcaps", "_MYREFERER_SMALLCAPS", "' . $smallcaps . '", "_MYREFERER_SMALLCAPS_DSC", "yesno", "int", 105)';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        if (!Utility::getMeta('keyword_blacklist') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "keyword_blacklist", "_MYREFERER_KEYWORD_BLACKLIST", "' . $keyword_blacklist . '", "_MYREFERER_KEYWORD_BLACKLIST_DSC", "textarea", "text", 106)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable keyword_blacklist</li>';
        }
        if (!Utility::getMeta('search_blacklist') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "search_blacklist", "_MYREFERER_SEARCH_BLACKLIST", "' . $search_blacklist . '", "_MYREFERER_SEARCH_BLACKLIST_DSC", "textarea", "text", 107)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable search_blacklist</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::getMeta('insertBreak') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "", "_MYREFERER_REFERER", "", "", "insertBreak", "hidden", 200)';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        if (!Utility::getMeta('referer_blacklist') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "referer_blacklist", "_MYREFERER_REFERER_BLACKLIST", "' . $referer_blacklist . '", "_MYREFERER_REFERER_BLACKLIST_DSC", "textarea", "text", 201)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable referer_blacklist</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::getMeta('insertBreak') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "", "_MYREFERER_ROBOTS", "", "", "insertBreak", "hidden", 300)';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        if (!Utility::getMeta('new_bot_smail') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "new_bot_smail", "_MYREFERER_NEW_BOT_SMAIL", "' . $new_bot_smail . '", "_MYREFERER_NEW_BOT_SMAIL_DSC", "yesno", "int", 301)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable new_bot_smail</li>';
        }
        if (!Utility::getMeta('new_bot_mail') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "new_bot_mail", "_MYREFERER_NEW_BOT_MAIL", "' . $new_bot_mail . '", "_MYREFERER_NEW_BOT_MAIL_DSC", "text", "text", 302)';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        if (!Utility::getMeta('robots_blacklist') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "robots_blacklist", "_MYREFERER_ROBOTS_BLACKLIST", "' . $robots_blacklist . '", "_MYREFERER_ROBOTS_BLACKLIST_DSC", "textarea", "text", 303)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable robots_blacklist</li>';
        }
        if (!Utility::getMeta('page_prohibit') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "page_prohibit", "_MYREFERER_PAGE_PROHIBIT", "' . $page_prohibit . '", "_MYREFERER_PAGE_PROHIBIT_DSC", "text", "text", 304)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable page_prohibit</li>';
        }
        if (!Utility::getMeta('robots_prohibit') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "robots_prohibit", "_MYREFERER_ROBOTS_PROHIBIT", "' . $robots_prohibit . '", "_MYREFERER_ROBOTS_PROHIBIT_DSC", "textarea", "text", 305)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable robots_prohibit</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::getMeta('insertBreak') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "", "_MYREFERER_USERVISIT", "", "", "insertBreak", "hidden", 100)';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        if (!Utility::getMeta('user_visit') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "user_visit", "_MYREFERER_USER_VISIT", "' . $user_visit . '", "_MYREFERER_USER_VISIT_DSC", "yesno", "int", 401)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable user_visit</li>';
        }

        if (!Utility::getMeta('save_group') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "save_group", "_MYREFERER_SAVE_GROUP", "' . $save_group . '", "_MYREFERER_SAVE_GROUP_DSC", "select", "array", 402)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable save_group</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::getMeta('insertBreak') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "", "_MYREFERER_STATS", "", "", "insertBreak", "hidden", 400)';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        if (!Utility::getMeta('myreferer_pages_stats') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myreferer_pages_stats", "_MYREFERER_STATS_PAGES", "' . $myreferer_pages_stats . '", "_MYREFERER_STATS_PAGES_DSC", "select", "int", 500)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable myreferer_pages_stats</li>';
        }
        if (!Utility::getMeta('myreferer_query_stats') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myreferer_query_stats", "_MYREFERER_STATS_QUERY", "' . $myreferer_query_stats . '", "_MYREFERER_STATS_QUERY_DSC", "select", "int", 500)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable myreferer_query_stats</li>';
        }
        if (!Utility::getMeta('myreferer_query_pages_stats') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myreferer_query_pages_stats", "_MYREFERER_STATS_QUERY_PAGES", "' . $myreferer_query_pages_stats . '", "_MYREFERER_STATS_QUERY_PAGES_DSC", "select", "int", 500)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable myreferer_query_pages_stats</li>';
        }
        if (!Utility::getMeta('myreferer_referer_stats') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myreferer_referer_stats", "_MYREFERER_STATS_REFERER", "' . $myreferer_referer_stats . '", "_MYREFERER_STATS_REFERER_DSC", "select", "int", 500)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable myreferer_referer_stats</li>';
        }
        if (!Utility::getMeta('myreferer_referer_pages_stats') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myreferer_referer_pages_stats", "_MYREFERER_STATS_REFERER_PAGES", "' . $myreferer_referer_pages_stats . '", "_MYREFERER_STATS_REFERER_PAGES_DSC", "select", "int", 500)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable myreferer_referer_pages_stats</li>';
        }
        if (!Utility::getMeta('myreferer_robots_stats') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myreferer_robots_stats", "_MYREFERER_STATS_ROBOTS", "' . $myreferer_robots_stats . '", "_MYREFERER_STATS_ROBOTS_DSC", "select", "int", 500)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable myreferer_robots_stats</li>';
        }
        if (!Utility::getMeta('myreferer_robots_pages_stats') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myreferer_robots_pages_stats", "_MYREFERER_STATS_ROBOTS_PAGES", "' . $myreferer_robots_pages_stats . '", "_MYREFERER_STATS_ROBOTS_PAGES_DSC", "select", "int", 500)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable myreferer_robots_pages_stats</li>';
        }
        if (!Utility::getMeta('myreferer_users_stats') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myreferer_users_stats", "_MYREFERER_STATS_USERS", "' . $myreferer_users_stats . '", "_MYREFERER_STATS_USERS_DSC", "select", "int", 500)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable myreferer_users_stats</li>';
        }
        if (!Utility::getMeta('myreferer_users_pages_stats') && ret) {
            $sql = 'INSERT INTO ' . $table . ' VALUES (0, "myreferer_users_pages_stats", "_MYREFERER_STATS_USERS_PAGES", "' . $myreferer_users_pages_stats . '", "_MYREFERER_STATS_USERS_PAGES_DSC", "select", "int", 500)';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Ajout/Modification de la variable myreferer_users_pages_stats</li>';
        }
        echo '</ul>';
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_pages') && ret) {
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
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_pages</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_pages_stats') && ret) {
            $table = $xoopsDB->prefix() . '_myref_pages_stats';

            $sql = 'CREATE TABLE ' . $table . ' (
				id int(8) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_pages_stats</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_query_stats') && ret) {
            $table = $xoopsDB->prefix() . '_myref_query_stats';

            $sql = 'CREATE TABLE ' . $table . ' (
				id int(8) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				queryid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_query_stats</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_query_pages') && ret) {
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
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_query_pages</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_query_pages_stats') && ret) {
            $table = $xoopsDB->prefix() . '_myref_query_pages_stats';

            $sql = 'CREATE TABLE ' . $table . ' (
				id int(11) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				queryid int(8) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_query_pages_stats</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_referer_stats') && ret) {
            $table = $xoopsDB->prefix() . '_myref_referer_stats';

            $sql = 'CREATE TABLE ' . $table . ' (
				id int(8) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				refererid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_referer_stats</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_referer_pages') && ret) {
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
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_referer_pages</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_referer_pages_stats') && ret) {
            $table = $xoopsDB->prefix() . '_myref_referer_pages_stats';

            $sql = 'CREATE TABLE ' . $table . ' (
				id int(11) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				refererid int(8) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_referer_pages_stats</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_robots_stats') && ret) {
            $table = $xoopsDB->prefix() . '_myref_robots_stats';

            $sql = 'CREATE TABLE ' . $table . ' (
				id int(8) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				robotsid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_robots_stats</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_robots_pages') && ret) {
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
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_robots_pages</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_robots_pages_stats') && ret) {
            $table = $xoopsDB->prefix() . '_myref_robots_pages_stats';

            $sql = 'CREATE TABLE ' . $table . ' (
				id int(11) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				robotsid int(8) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_robots_pages_stats</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_users') && ret) {
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
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_users</li>';
        } else {
            $table = $xoopsDB->prefix() . '_myref_users';

            if (!Utility::existFieldname('myreferer_users', 'tracker') && ret) {
                $sql = 'ALTER TABLE ' . $table . ' ADD tracker TINYINT(2) NOT NULL DEFAULT "1"';

                $ret = $ret && $xoopsDB->queryF($sql);

                echo '<li>Modification de la table myreferer_users</li>';
            }
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_users_stats') && ret) {
            $table = $xoopsDB->prefix() . '_myref_users_stats';

            $sql = 'CREATE TABLE ' . $table . ' (
				id int(8) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				usersid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_users_stats</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_users_pages') && ret) {
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
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_users_pages</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (!Utility::existTable('myreferer_users_pages_stats') && ret) {
            $table = $xoopsDB->prefix() . '_myref_users_pages_stats';

            $sql = 'CREATE TABLE ' . $table . ' (
				id int(11) NOT NULL auto_increment,
				year int(4) NOT NULL default "0",
				week int(2) NOT NULL default "0",
				usersid int(8) NOT NULL default "0",
				pagesid int(8) NOT NULL default "0",
				visit int(8) NOT NULL default "0",
				PRIMARY KEY  (id)
	            ) COMMENT=\'myreferer - solo (http://www.wolfpackclan.com)\' ';

            $ret = $ret && $xoopsDB->queryF($sql);

            echo '<li>Création de la table myreferer_users_pages_stats</li>';
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (Utility::existTable('myreferer_query') && ret) {
            $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myreferer_query') . ' COMMENT = "myreferer - solo (http://www.wolfpackclan.com)"';

            $ret = $ret && $xoopsDB->queryF($sql);
        }

        if (Utility::existFieldname('myreferer_query', 'query') && ret) {
            $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myreferer_query') . ' CHANGE query query VARCHAR(255) NOT NULL DEFAULT ""';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        if (!Utility::existFieldname('myreferer_query', 'keyword') && ret) {
            $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myreferer_query') . ' ADD keyword TINYINT(2) DEFAULT "1" AFTER query';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        if (!Utility::existFieldname('myreferer_query', 'visit_tmp') && ret) {
            $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myreferer_query') . ' ADD visit_tmp INT(8) DEFAULT "0" AFTER visit';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (Utility::existTable('myreferer_referer') && ret) {
            $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myreferer_referer') . ' COMMENT = "myreferer - solo (http://www.wolfpackclan.com)"';

            $ret = $ret && $xoopsDB->queryF($sql);
        }

        if (!Utility::existFieldname('myreferer_referer', 'visit_tmp') && ret) {
            $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myreferer_referer') . ' ADD visit_tmp INT(8) DEFAULT "0" AFTER visit';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        // ----------------------------------------------------------------------------------------------------------------- //
        if (Utility::existTable('myreferer_robots') && ret) {
            $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myreferer_robots') . ' COMMENT = "myreferer - solo (http://www.wolfpackclan.com)"';

            $ret = $ret && $xoopsDB->queryF($sql);
        }

        if (!Utility::existFieldname('myreferer_robots', 'visit_tmp') && ret) {
            $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myreferer_robots') . ' ADD visit_tmp INT(8) DEFAULT "0" AFTER visit';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        if (!Utility::existFieldname('myreferer_robots', 'tracker') && ret) {
            $sql = 'ALTER TABLE ' . $xoopsDB->prefix('myreferer_robots') . ' ADD tracker TINYINT(2) DEFAULT "0" ';

            $ret = $ret && $xoopsDB->queryF($sql);
        }
        echo '</ul>';
        break;
    /**
     * myreferer 2.0
     */
    case '2':
        break;
}

$newversion = round($xoopsModule->getVar('version') / 100, 2);
//if successful, update myreferer__meta table with new ver
if ($ret) {
    printf(_MD_MYREFERER_UPGRADE_OK, $newversion);

    $ret = Utility::setMeta('version', $newversion);
} else {
    printf(_MD_MYREFERER_UPGRADE_ERR, $newversion);
}

echo "<br><br><a href='" . XOOPS_URL . "/modules/myreferer/admin/index.php'>" . _BACK . '</a>';

$configHandler = $helper->getHandler('Config');
$configHandler->WriteConfigFile();
unset($configHandler);

xoops_cp_footer();

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

$adminmenu[0]['title'] = _MI_MYREF_ADMIN;
$adminmenu[0]['link'] = "admin/index.php";
$adminmenu[1]['title'] = _MI_MYREF_USERVISIT;
$adminmenu[1]['link'] = "admin/stats_visitors.php";
$adminmenu[2]['title'] = _MI_MYREF_CONFIG;
$adminmenu[2]['link'] = "admin/config.php";
$adminmenu[3]['title'] = _MI_MYREF_META;
$adminmenu[3]['link'] = "admin/meta.php";
$adminmenu[4]['title'] = _MI_MYREF_CLEAN;
$adminmenu[4]['link'] = "admin/clean.php";
$adminmenu[5]['title'] = _MI_MYREF_STATS;
$adminmenu[5]['link'] = "admin/stats.php";
$adminmenu[6]['title'] = _MI_MYREF_PERMS;
$adminmenu[6]['link'] = "admin/permissions.php";
$adminmenu[7]['title'] = _MI_MYREF_BLOCKS;
$adminmenu[7]['link'] = "admin/myblocksadmin.php";

if (isset($xoopsModule)) {
	$headermenu[0]['title'] = _PREFERENCES;
	$headermenu[0]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid');

	$headermenu[1]['title'] = _MD_MYREFERER_INDEX;
	$headermenu[1]['link'] = XOOPS_URL . '/modules/myReferer/';

	$headermenu[2]['title'] = _MD_MYREFERER_UPDATE_MODULE;
	$headermenu[2]['link'] = XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module=" . $xoopsModule->getVar('dirname');

	$headermenu[3]['title'] = _MI_MYREF_HELP;
	$headermenu[3]['link'] = "help.php";
}

$statmenu[0]['title'] = _MI_MYREF_PAGES;
$statmenu[0]['link'] = "admin/stats_pages.php";
$statmenu[1]['title'] = _MI_MYREF_KEYWORDS;
$statmenu[1]['link'] = "admin/stats_keyword.php";
$statmenu[2]['title'] = _MI_MYREF_QUERY;
$statmenu[2]['link'] = "admin/stats_query.php";
$statmenu[3]['title'] = _MI_MYREF_ROBOTS;
$statmenu[3]['link'] = "admin/stats_robots.php";
$statmenu[4]['title'] = _MI_MYREF_REFERER;
$statmenu[4]['link'] = "admin/stats_referer.php?engine=0";
$statmenu[5]['title'] = _MI_MYREF_ENGINE;
$statmenu[5]['link'] = "admin/stats_referer.php?engine=1";
$statmenu[6]['title'] = _MI_MYREF_BYMODULE_KEYWORD;
$statmenu[6]['link'] = "admin/stats_modules.php?keyword=1";
$statmenu[7]['title'] = _MI_MYREF_BYMODULE_QUERY;
$statmenu[7]['link'] = "admin/stats_modules.php?keyword=0";
$statmenu[8]['title'] = _MI_MYREF_BYREFERER;
$statmenu[8]['link'] = "admin/stats_modules_referer.php";

$metamenu[0]['title'] = _MI_MYREF_DATE;
$metamenu[0]['link'] = "admin/meta.php?ord=date&meta_limit=100";
$metamenu[1]['title'] = _MI_MYREF_NEW;
$metamenu[1]['link'] = "admin/meta.php?ord=new&meta_limit=100";
$metamenu[2]['title'] = _MI_MYREF_TOP;
$metamenu[2]['link'] = "admin/meta.php?ord=visit&meta_limit=100";
$metamenu[3]['title'] = _MI_MYREF_POP;
$metamenu[3]['link'] = "admin/meta.php?ord=pop&meta_limit=100";
$metamenu[4]['title'] = _MI_MYREF_RANDOM;
$metamenu[4]['link'] = "admin/meta.php?ord=random&meta_limit=100";
?>
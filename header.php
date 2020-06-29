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

include_once ('../../mainfile.php');
include_once ( XOOPS_ROOT_PATH . '/header.php');
include_once ( XOOPS_ROOT_PATH . '/class/pagenav.php' );
include_once ( XOOPS_ROOT_PATH . '/modules/myReferer/include/functions_myreferer.php' );


$myts =& MyTextSanitizer::getInstance();

// New options
$new = explode("|",$xoopsModuleConfig['tag_new']);
if ( count($new) < 2 ) { $new[0] = 7; $new[1] = 1; }
$more = 'AND hide = 0 AND visit >= '.$new[1];

// Module Banner
if ( $xoopsModuleConfig['banner'] ) {
	$banner = '<img src="images/banner.gif" alt="'.$xoopsModule -> getVar('name').'">';
} else {
	$banner = '';
}

$startart	= isset( $_GET['startart'] ) ? intval( $_GET['startart'] ) : 0;
$display	= isset( $_GET['display'] ) ? intval( $_GET['display'] ) : 0;
$op			= isset( $_GET['op'] ) ? intval( $_GET['op'] ) : 0;
$ord		= isset($_GET["ord"]) ? $_GET["ord"] : $xoopsModuleConfig['order'];
$letter		= isset($_GET["letter"]) ? $_GET["letter"] : _ALL;

// Navigation links
if ( $ord == 'alpha' ) {

	$nav_referer = 'referer.php?ord='.$xoopsModuleConfig['order'].'&op=0';
	$nav_engine = 'referer.php?ord='.$xoopsModuleConfig['order'].'&op=1';
	$nav_keyword = 'query.php?ord='.$xoopsModuleConfig['order'].'&op=1';
	$nav_query = 'query.php?ord='.$xoopsModuleConfig['order'].'&op=0';
	$nav_robot = 'spider.php?ord='.$xoopsModuleConfig['order'];
	$nav_users = 'users.php?ord='.$xoopsModuleConfig['order'];
	$nav_page = 'page.php?ord='.$xoopsModuleConfig['order'];

    $xoopsOption['template_main'] = 'myreferer_alpha.html';
    $xoopsModuleConfig['perpage'] = '0';
    $startart = '0';

//    $xoopsTpl->assign("nav_letters", 'test');
    $xoopsTpl->assign("nav_letters", myReferer_letters( $letter , $op) );
    if ($letter == _ALL) {
	    $whereletter = "";
    } elseif ($letter == _MYREFERER_OTHERS) {
	    $whereletter = "";
        for ($i=48; $i<=57; $i++) {
		    $whereletter .= " AND query NOT LIKE '" . chr($i) . "%'";
        }
        for ($i=65; $i<=90; $i++) {
		    $whereletter .= " AND query NOT LIKE '" . chr($i) . "%'";
        }
    } else {
	    $whereletter = " AND query LIKE '$letter%'";
    }
} else {
	$nav_referer = 'referer.php?ord='.$ord.'&op=0';
	$nav_engine = 'referer.php?ord='.$ord.'&op=1';
	$nav_keyword = 'query.php?ord='.$ord.'&op=1';
	$nav_query = 'query.php?ord='.$ord.'&op=0';
	$nav_robot = 'spider.php?ord='.$ord;
	$nav_users = 'users.php?ord='.$ord;
	$nav_page = 'page.php?ord='.$ord;

	if ( basename($_SERVER['PHP_SELF']) == "index.php" ) {
		$xoopsOption['template_main'] = 'myreferer_summary.html';
    } else {
		$xoopsOption['template_main'] = 'myreferer_index.html';
    }
}

$nav_index = 'index.php';

$count		= $startart;

if ($ord	== 'visit')		{ $order = 'visit DESC'; }
if ($ord	== 'alpha')		{ $order = 'query ASC'; }
if ($ord	== 'date')		{ $order = 'date DESC'; }

switch ( basename($_SERVER['PHP_SELF']) ) {
	case 'referer.php':
	if ($ord	== 'referer')	{ $order = 'referer ASC'; }
    break;

	case 'spider.php':
	if ($ord	== 'referer')	{ $order = 'robots ASC'; }
    break;

	case 'query.php':
	if ($ord	== 'referer')	{ $order = 'query ASC'; }
    break;

	case 'page.php':
	if ($ord	== 'referer')	{ $order = 'page ASC'; }
    break;

	case 'users.php':
	if ($ord	== 'referer')	{ $order = 'user ASC'; }
    break;
}



$xoopsTpl->assign("nav_referer", 	$nav_referer);
$xoopsTpl->assign("nav_engine", 	$nav_engine);
$xoopsTpl->assign("nav_keyword", 	$nav_keyword);
$xoopsTpl->assign("nav_query", 		$nav_query);
$xoopsTpl->assign("nav_robot", 		$nav_robot);
$xoopsTpl->assign("nav_users", 		$nav_users);
$xoopsTpl->assign("nav_page", 		$nav_page);
$xoopsTpl->assign("nav_index", 		$nav_index);

// Various Header informations
$xoopsTpl->assign("banner", 	$banner);
$xoopsTpl->assign("title", 		$myts->makeTareaData4Show( $xoopsModule -> getVar('name') ));
$xoopsTpl->assign("text", 		$myts->makeTareaData4Show( $xoopsModuleConfig['text'] ));

// Language datas
$xoopsTpl->assign("referer", 	_MYREFERER_REFERER);
$xoopsTpl->assign("engine", 	_MYREFERER_ENGINE);
$xoopsTpl->assign("query", 	_MYREFERER_QUERY);
$xoopsTpl->assign("keyword",	_MYREFERER_KEYWORD);
$xoopsTpl->assign("robot", 	_MYREFERER_ROBOT);
$xoopsTpl->assign("users", 	_MYREFERER_USERS);
$xoopsTpl->assign("page", 	_MYREFERER_PAGE);
$xoopsTpl->assign("visit", 	_MYREFERER_VISIT);
$xoopsTpl->assign("date", 	_MYREFERER_DATE);
$xoopsTpl->assign("more", 	_MYREFERER_MORE);
$xoopsTpl->assign("summary", 	_MYREFERER_SUMMARY);

if (myReferer_checkRight(1) ) { $xoopsTpl->assign("numrows_referer",	'1'); }
if (myReferer_checkRight(2) ) { $xoopsTpl->assign("numrows_engine",	'1'); }
if (myReferer_checkRight(3) ) { $xoopsTpl->assign("numrows_keyword",	'1'); }
if (myReferer_checkRight(4) ) { $xoopsTpl->assign("numrows_query",	'1'); }
if (myReferer_checkRight(5) ) { $xoopsTpl->assign("numrows_robots",	'1'); }
if (myReferer_checkRight(6) ) { $xoopsTpl->assign("numrows_pages",	'1'); }
if (myReferer_checkRight(7) ) { $xoopsTpl->assign("numrows_users",	'1'); }
?>
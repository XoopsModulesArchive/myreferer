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

include_once( '../../../mainfile.php');
include_once( '../../../include/cp_header.php');
include_once( '../../../include/functions.php');
include_once( XOOPS_ROOT_PATH . '/class/xoopsmodule.php');
include_once( XOOPS_ROOT_PATH . '/class/xoopsformloader.php' );
include_once( XOOPS_ROOT_PATH . '/class/module.errorhandler.php');
$eh = new ErrorHandler;

include_once( XOOPS_ROOT_PATH .'/modules/myReferer/class/myReferer_configs.php' );
include_once( XOOPS_ROOT_PATH .'/modules/myReferer/include/functions_myreferer.php' );

if ( file_exists(XOOPS_ROOT_PATH . '/modules/myReferer/language/' . $xoopsConfig['language'] . '/common.php') ) {
	include_once(XOOPS_ROOT_PATH . '/modules/myReferer/language/' . $xoopsConfig['language'] . '/common.php');
} else {
	include_once(XOOPS_ROOT_PATH .'/modules/myReferer/language/english/common.php');
}

if ( !ereg( "detail", basename($_SERVER['PHP_SELF']) ) ) {
	xoops_cp_header();
	echo '<style type="text/css">';
	echo 'th a:link {text-decoration: none; color: #ffff00; font-weight: bold; background-color: transparent;}';
	echo 'th a:active {text-decoration: none; color: #ffffff; font-weight: bold; background-color: transparent;}';
	echo 'th a:visited {text-decoration: none; color: #ffff00; font-weight: bold; background-color: transparent;}';
	echo 'th a:hover {text-decoration: none; color: #ff0000; font-weight: bold; background-color: transparent;}';
	echo '</style>';
}
?>
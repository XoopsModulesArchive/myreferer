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

include_once( "admin_header.php" );
$myts =& MyTextSanitizer::getInstance();

//$guide = _MD_MYREFERER_GUIDE;
//$guide = $myts->makeTareaData4Show($guide);

myReferer_adminmenu(-1, _MD_MYREFERER_HELP);
OpenTable();
$helpfile = XOOPS_ROOT_PATH . '/modules/myReferer/language/' . $xoopsConfig['language'] . '/help.html';
if ( file_exists($helpfile) ) {
	include_once ( $helpfile );
} else {
	include_once ( XOOPS_ROOT_PATH . '/modules/myReferer/language/english/help.html' );
}

//echo $guide;
CloseTable();
include_once( 'admin_footer.php' );
?>
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

if (!defined("XOOPS_ROOT_PATH")) { die("XOOPS root path not defined"); }

function a_page_check_show() {
      $block = array();
	$block['rec'] = '<a href="'.XOOPS_URL.'/modules/myReferer/rec.php">Track this page</a>';

	return $block;
}


?>
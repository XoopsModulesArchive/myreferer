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

include("admin_header.php");

if (!isset($_POST["op"])) {
    $op = isset($_GET["op"]) ? $_GET["op"] : "";
} else {
    $op = $_POST["op"];
}

if ( $op ) {
	if ( $op == "query" ) { 	$where =  "query = '".$myrow["query"]."'"; 	}
	if ( $op == "robots" ) { 	$where =  "robots = '".$myrow["robots"]."'"; 	}
	if ( $op == "referer" ) { 	$where =  "referer = '".$myrow["referer"]."'"; 	}

	// Calcule of the current week
	// This week
	$week = date('W');
	$week_day = ( $week*7 ) - 5;
	$this_week = mktime(0,0,0, 1, $week_day, date('Y'));

	$sql = "	UPDATE " . $xoopsDB->prefix("myref_").$op." SET visit_tmp = 0 WHERE date < $this_week  ";

	if ( $xoopsDB->queryF($sql) == '' ) {
		redirect_header('index.php', 1, _MD_MYREFERER_UPDATED);
		exit();
	} else {
		redirect_header('index.php', 1, _MD_MYREFERER_ALREADYUPDATED);
		exit();
	}
} else {
	redirect_header('index.php', 1, _MD_MYREFERER_ERROR);
	exit();
}
?>
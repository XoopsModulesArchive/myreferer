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
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

$query = "	SELECT * FROM ".$xoopsDB->prefix("myref_users_pages_stats")."
		WHERE $where $where_week AND query LIKE '%$search%' AND keyword = 0
		ORDER BY $ordre $sort_ordre";
// $counter = $xoopsDB->queryF($query);
// $count = mysql_NumRows( $counter );
$result = $xoopsDB->queryF($query);


myReferer_adminmenu(5, _MD_MYREFERER_STATS);
OpenTable();
echo 'Stats';
	while ( $myrow = $xoopsDB->fetchArray($result) ) {
         echo $myrow['usersid'];
        }


CloseTable();
include_once( 'admin_footer.php' );
?>
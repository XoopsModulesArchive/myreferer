<?php

/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2004 <https://xoops.org>
 *
 * Module: myReferer 2.0
 * Licence : GPL
 * Authors :
 *           - solo (www.wolfpackclan.com/wolfactory)
 *            - DuGris (www.dugris.info)
 */
require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

$query = '	SELECT * FROM ' . $xoopsDB->prefix('myref_users_pages_stats') . "
		WHERE $where $where_week AND query LIKE '%$search%' AND keyword = 0
		ORDER BY $ordre $sort_ordre";
// $counter = $xoopsDB->queryF($query);
// $count = @mysqli_num_rows( $counter );
$result = $xoopsDB->queryF($query);

// Utility::getAdminMenu(5, _MD_MYREFERER_STATS);
OpenTable();
echo 'Stats';
while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
    echo $myrow['usersid'];
}

CloseTable();
require_once __DIR__ . '/admin_footer.php';

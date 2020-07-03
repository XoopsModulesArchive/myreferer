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
require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));

/*
 $query = "	SELECT * FROM ".$xoopsDB->prefix("myreferer_query_pages_stats")."
        WHERE year=2006 AND week=18
        ORDER BY visit DESC";
*/
$year       = '2020';
$week_title = '';
$results    = '';
for ($week = 1; $week <= 52; $week++) {
    $query = '   SELECT f.id, f.year, f.week, f.queryid, f.pagesid, f.visit, m.id, m.query, m.visit as visit_now, m.visit_tmp, m.hide FROM ' . $xoopsDB->prefix('myreferer_query_pages_stats') . ' f LEFT JOIN ' . $xoopsDB->prefix('myreferer_query') . " m on f.id = m.id
                WHERE f.year=$year AND f.week=$week AND m.keyword=1 ORDER BY f.visit DESC";

    $result = $xoopsDB->queryF($query);

    $week_title .= "<th style='align:center;'>" . _MD_MYREFERER_WEEK . ' <b>' . $week . '</b></th>
                   ';

    $i = 1;

    $results .= "<td style='vertical-align:top;'>
                          ";

    if ($xoopsDB->fetchArray($result)) {
        $results .= '<table>';

        while (false !== ($myrow = $xoopsDB->fetchArray($result))) {  // if results
            $results .= '<tr><td><nobr>' . $myrow['query'] . ' <b>' . $myrow['visit'] . '</b> (' . $myrow['visit_now'] . ')</nobr></td></tr>
                          ';
        } // while each results

        $results .= '</table>';
    } else { // if no results
        $results .= _MD_MYREFERER_NODATAS;
    }

    $result .= '</td>';
} //for 52 weeks

// Utility::getAdminMenu(5, _MD_MYREFERER_STATS);
OpenTable();
echo 'Stats';

echo "
          <table border='0' cellpadding='4' cellspacing='1' class='bg2' width='90%'>
          <tr class='bg3'>
                " . $week_title . '
          </tr>
          ';
echo "<tr class='bg4'>";
echo ".$results.";
echo '</tr>';
echo '</table>';

CloseTable();
require_once __DIR__ . '/admin_footer.php';

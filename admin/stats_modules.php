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

use XoopsModules\Myreferer\Utility;

require __DIR__ . '/admin_header.php';

xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));

//require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

$keyword = $_POST['keyword'] ?? ($_GET['keyword'] ?? 1);

$op = $_POST['op'] ?? ($_GET['op'] ?? '');

$search = $_POST['search'] ?? ($_GET['search'] ?? '');

$week = $_POST['week'] ?? ($_GET['week'] ?? 0);
if ($week) {
    $where_week = 'AND visit_tmp > 0';

    $all = '';
}

// $this_date = date('m'); $this_name = _MD_MYREFERER_MONTH; // Month
$this_date = date('W');
$this_name = _MD_MYREFERER_WEEK; // Week
//   $this_date = date('z'); $this_name = _MD_MYREFERER_DAY; // Day of th year

if ('blacklist' === $op) {
    $all = '<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '" align="absmiddle">&nbsp;';

    if (1 == $week) {
        $all .= "$this_name : $this_date";
    } else {
        $all .= _MD_MYREFERER_ALL;
    }

    $black = '<a href="stats_modules.php?keyword=' . $keyword . '&ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=&startart=' . $startart . '">
			<img src="../assets/images/icon/all.gif" alt="' . _MD_MYREFERER_ALL . '" align="absmiddle"></a>';

    $black .= '<a href="stats_modules.php?keyword=' . $keyword . '&ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=whitelist&startart=' . $startart . '">
			<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '" align="absmiddle"></a>';

    $where = 'hide = 1';
} elseif ('whitelist' === $op) {
    $all = '<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '" align="absmiddle">&nbsp;';

    if (1 == $week) {
        $all .= "$this_name : $this_date";
    } else {
        $all .= _MD_MYREFERER_ALL;
    }

    $black = '<a href="stats_modules.php?keyword=' . $keyword . '&ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=&startart=' . $startart . '">
			<img src="../assets/images/icon/all.gif" alt="' . _MD_MYREFERER_ALL . '" align="absmiddle"></a>';

    $black .= '<a href="stats_modules.php?keyword=' . $keyword . '&ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=blacklist&startart=' . $startart . '">
			<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '" align="absmiddle"></a>';

    $where = 'hide = 0';
} else {
    $all = '<img src="../assets/images/icon/all.gif" alt="' . _MD_MYREFERER_ALL . '" align="absmiddle">&nbsp;';

    if (1 == $week) {
        $all .= "$this_name : $this_date";
    } else {
        $all .= _MD_MYREFERER_ALL;
    }

    $black = '<a href="stats_modules.php?keyword=' . $keyword . '&ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=whitelist&startart=' . $startart . '">
			<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '" align="absmiddle"></a>';

    $black .= '<a href="stats_modules.php?keyword=' . $keyword . '&ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=blacklist&startart=' . $startart . '">
			<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '" align="absmiddle"></a>';

    $where = 'hide >= 0';
}

// Utility::getAdminMenu(0, _MD_MYREFERER_STATS);
if (1 == $keyword) {
    Utility::getStatMenu(6, '');
} else {
    Utility::getStatMenu(7, '');
}
OpenTable();

// Display informations
echo "<table width='100%'><tr><td>";
echo '<b>' . $xoopsConfig['sitename'] . "</b><br><a href='stats_modules.php?keyword=$keyword&ord=$ord&search=$search&week=&op=$op&startart=$startart'>" . _MD_MYREFERER_ALL
     . "</a> | <a href='stats_modules.php?keyword=$keyword&ord=$ord&search=$search&week=1$&op=$op&startart=$startart'>$this_name : $this_date </a> | $black";
echo "</td><td align='right'>";
Utility::search($ord, $search, $engine, $week, $startart);
echo '</td></tr></table>';
// Display informations

// Queries
// Query total
$sql    = 'SELECT page, query, hide FROM ' . $xoopsDB->prefix('myreferer_query') . " WHERE
		keyword=$keyword AND $where $where_week AND query LIKE '%$search%' ORDER BY page ASC";
$result = $xoopsDB->query($sql);

$counter = $xoopsDB->queryF($sql);
$count   = @mysqli_num_rows($counter);

if (0 == $count) {
    echo _MD_MYREFERER_NOVISIT . '<p>';
} else {
    $head = 1;

    echo "<br><div style='text-align:center;'><b>$all</b></div>";

    echo '<table cellpadding="1" cellspacing="1" border="0" class="bg2" width="98%"><tr><th colspan="2">
		  <a href="' . XOOPS_URL . '" target="_blank">Home</a>
	      </th></tr><tr><td>';

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $count++;

        $li_in = ', ';

        if ($myrow['hide']) {
            $font_in = '<span style="color: #ff0000; ">';
        } else {
            $font_in = '<span style="color: #008000; ">';
        }

        if ($page != $myrow['page']) {
            $page = str_replace(XOOPS_URL, '', 'http://' . $myrow['page']);

            $page = str_replace('/modules', '', $page);

            $page = explode('/', $page);

            $page_url = explode('PHPSESSID', $myrow['page']);

            $page1_tmp = $page[1];

            if ($page_tmp != $page[1] and '' != $page[1]) {
                echo '</td><td>' . $count . '</td></tr>';

                echo '<tr class="bg3"><th colspan="3"><a href="' . XOOPS_URL . '/modules/' . $page[1] . '/" target="_blank">' . mb_strtoupper($page[1]) . '</a></th></tr>';

                $page_tmp = $page[1];

                $count = 0;

                $head = 1;
            }

            if (!$head) {
                echo '</td><td>' . $count . '</td></tr>';
            }

            $head = 0;

            $li_in = '<tr class="bg4"><td align="left"><a href="http://' . $myrow['page'] . '" target="_blank" title="' . $myrow['page'] . '">/' . $page[1] . '/' . $page[2] . '</td><td>';

            $count = 0;
        }

        echo $li_in . $font_in . $myrow['query'] . '</font>';

        $page = $myrow['page'];
    }

    if (!$head) {
        echo '</td><td>' . $count . '</td></tr>';
    }
}
echo '</td></tr></table>';
CloseTable();
require_once __DIR__ . '/admin_footer.php';

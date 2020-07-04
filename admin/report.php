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

// include("admin_header.php");
//require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
// $startart = isset( $_GET['startart'] ) ? intval( $_GET['startart'] ) : 0;
// error_reporting(E_ALL ^ E_NOTICE);

require_once dirname(__DIR__, 3) . '/mainfile.php';
require_once dirname(__DIR__, 3) . '/include/cp_header.php';

$startart = $_POST['startart'] ?? ($_GET['startart'] ?? 0);
$id       = $_POST['id'] ?? ($_GET['id'] ?? '');

$op = $_POST['op'] ?? ($_GET['op'] ?? '');

$ord = $_POST['ord'] ?? ($_GET['ord'] ?? '');

$search = $_POST['search'] ?? ($_GET['search'] ?? '');

$week = $_POST['week'] ?? ($_GET['week'] ?? 0);

$engine = $_POST['engine'] ?? ($_GET['engine'] ?? '0');

$sql = $_POST['sql'] ?? ($_GET['sql'] ?? 0);
$and = '';

if (1 == $engine) {
    $and = ' AND engine=1';

    $data = 'referer';

    $title = _MD_MYREFERER_ENGINE;
} elseif (0 == $engine) {
    $and .= ' AND engine=0';

    $data = 'referer';

    $title = _MD_MYREFERER_REFERER;
}
if ('myreferer_query' === $sql) {
    $and = ' AND keyword=0';

    $data = 'query';

    $title = _MD_MYREFERER_QUERY;
} elseif ('myreferer_keywords' === $sql) {
    $and = ' AND keyword=1';

    $sql = 'myreferer_query';

    $data = 'query';

    $title = _MD_MYREFERER_KEYWORDS;
}
if ('myreferer_robots' === $sql) {
    $data = 'robots';

    $and = '';

    $title = _MD_MYREFERER_ROBOTS;
}
if ('myreferer_users' === $sql) {
    $data = 'user';

    $and = '';

    $title = _MD_MYREFERER_USERS;
}

$this_date = date('W');
$this_name = _MD_MYREFERER_WEEK; // Week
$all       = _MD_MYREFERER_ALL;

if ($week) {
    $where_week = 'AND visit_tmp > 0';

    $all = '';
} else {
    $where_week = '';
}
if ('blacklist' === $op) {
    $where = 'hide = 1';
} elseif ('whitelist' === $op) {
    $where = 'hide = 0';
} else {
    $where = 'hide >= 0';
}

if ('' == $ord) {
    $ordre = 'visit_tmp';

    $sort_ordre = 'DESC';

    $ord_text = _MD_MYREFERER_VISITS . ' / ' . _MD_MYREFERER_WEEK;
}
if ('1' == $ord) {
    $ordre = 'id';

    $sort_ordre = 'DESC';

    $ord_text = _MD_MYREFERER_LATEST;
}
if ('2' == $ord) {
    $ordre = $xoopsModuleConfig['order'];

    $sort_ordre = 'DESC';

    $ord_text = _MD_MYREFERER_VISITS;
}
if ('3' == $ord) {
    $ordre = 'query';

    $sort_ordre = 'ASC';

    $ord_text = _MD_MYREFERER_KEYWORDS;
}
if ('4' == $ord) {
    $ordre = 'date';

    $sort_ordre = 'DESC';

    $ord_text = _MD_MYREFERER_DATE;
}

$query   = '	SELECT * FROM ' . $xoopsDB->prefix($sql) . "
		WHERE $where $where_week AND $data LIKE '%$search%' $and
		ORDER BY $ordre $sort_ordre";
$counter = $xoopsDB->queryF($query);
$count   = @mysqli_num_rows($counter);

if (0 == $count) {
    echo _MD_MYREFERER_NOVISIT . '<p>';
} else {
    $result = $xoopsDB->queryF($query, $xoopsModuleConfig['perpage'], $startart);

    //	$pagenav = new \XoopsPageNav( $count, $xoopsModuleConfig['perpage'], $startart, 'startart', 'ord='.$ord.'&search='.$search.'&week='.$week.'&op='.$op );

    echo '<html>';

    echo '<head>';

    echo "<link rel='stylesheet' type='text/css' media='all' href='http://www.arma-sa.com/xoops.css'>";

    echo "<link rel='stylesheet' type='text/css' media='all' href='http://www.arma-sa.com/modules/system/style.css'>";

    echo '<style type="text/css">';

    echo 'body {font-size: 12px; }';

    echo 'td {font-size: 10px; }';

    echo '</style>';

    echo '</head>';

    echo '<body>';

    echo "<div style='text-align:center;'>" . _MD_MYREFERER_WEEK . " <b>$this_date</b> (" . date(l) . ' ' . formatTimestamp(time()) . ')</div>';

    echo "<div style='text-align:center;'><b>$all</b> " . _MD_MYREFERER_RANKING . " <b>$ord_text</b> ($count)</div>";

    echo '<p>';

    echo "<div align='center'>
		  <table border='1' cellpadding='2' cellspacing='0' class='bg2' width='600px'>
          <tr class='bg3'>
          <th style='align:center;'>N°</th>
          <th style='align:center;'>" . _MD_MYREFERER_WEEK . ' (' . _MD_MYREFERER_VISITS . ")</th>
          <th style='align:center;'>" . $title . " </th>
          <th style='align:center;'>" . _MD_MYREFERER_DATE . '</th>
          </tr>';

    $i = $startart;

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        if ($myrow['date']) {
            $data_date = formatTimestamp($myrow['date'], 'W');
        } else {
            $date = _MD_MYREFERER_NOVISITYET;
        }

        if ($myrow['startdate']) {
            $startdate = formatTimestamp($myrow['startdate'], 'm');
        } else {
            $startdate = _MD_MYREFERER_NOVISITYET;
        }

        if ('1' == $ord) {
            $time = $myrow['startdate'];
        } else {
            $time = $myrow['date'];
        }

        if ($this_date == $data_date) {
            $bg = "class='bg4'";
        } else {
            $bg = "style='background-color:#EEE; color:#999;'";
        }

        $i++;

        if ('user' === $data) {
            $myrow[$data] = XoopsUser::getUnameFromId($myrow[$data]);
        }

        echo "<tr $bg>
              <td align='center'>       $i</td>
              <td align='center'>       <b>" . $myrow['visit_tmp'] . '</b> (' . $myrow['visit'] . ")	</td>
              <td align='center'>       " . $myrow[$data] . "</td>
              <td align='center'>       " . formatTimestamp($time) . '	</td>
              </tr>';
    }

    echo '</table></div>';

    echo "<br>\n";

    echo '</body>';

    echo '</html>';
}

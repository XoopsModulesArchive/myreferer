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

use XoopsModules\Myreferer\Utility;

require_once __DIR__ . '/admin_header.php';

$id = $_POST['id'] ?? ($_GET['id'] ?? '');

$op = $_POST['op'] ?? ($_GET['op'] ?? '');

$confirm = $_POST['confirm'] ?? ($_GET['confirm'] ?? 0);

// Delete operation
if ('del' === $op && $id) {
    if ($confirm) {
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_robots') . " WHERE id = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_robots_stats') . " WHERE robotsid = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_robots_pages') . " WHERE robotsid = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_robots_pages_stats') . " WHERE robotsid = '$id' ";
        $xoopsDB->queryF($sql);

        echo "<script type='text/javascript'>\n";
        echo "self.close();\n";
        echo '</script>';
    } else {
        require_once __DIR__ . '/detail_header.php';

        $sql    = 'SELECT robots FROM ' . $xoopsDB->prefix('myref_robots') . " WHERE id=$id";
        $result = $xoopsDB->query($sql);
        [$name] = $xoopsDB->fetchRow($result);
        $name = Utility::getRobotName($name);

        xoops_confirm(['op' => $op, 'id' => $id, 'confirm' => 1, 'ord' => $ord, 'search' => $search, 'week' => $week, 'start' => $start], 'detail_robots.php', _MD_MYREFERER_DELETE_ROBOT . ' <br>' . '<br>' . $name . '<br>', _MD_MYREFERER_DELETE);

        require_once __DIR__ . '/detail_footer.php';
        exit();
    }
}

// Hide/Show operation
if (('h' === $op || 'd' === $op) and $id) {
    if ('d' === $op) {
        $hide = 0;
    } else {
        $hide = 1;
    }
    $sql = 'UPDATE ' . $xoopsDB->prefix('myref_robots') . " SET hide = '$hide' WHERE id = '$id'";
    $xoopsDB->queryF($sql);
}

// Tracker on/off operation
if (('tracker_on' === $op || 'tracker_off' === $op) and $id) {
    if ('tracker_on' === $op) {
        $tracker = 1;
    } else {
        $tracker = 0;
    }
    $sql = 'UPDATE ' . $xoopsDB->prefix('myref_robots') . " SET tracker = '$tracker' WHERE id = '$id'";
    $xoopsDB->queryF($sql);
}

// $this_date = date('W'); $this_name = _MD_MYREFERER_WEEK; // Week
$query   = 'SELECT * FROM ' . $xoopsDB->prefix('myref_robots') . " WHERE id = '$id'";
$counter = $xoopsDB->queryF($query);
$count   = @mysqli_num_rows($counter);

require_once __DIR__ . '/detail_header.php';

if (0 == $count) {
    echo '<div align="center">' . _MD_MYREFERER_NOVISIT . '</div>';
} else {
    $result = $xoopsDB->queryF($query);
    $myrow  = $xoopsDB->fetchArray($result);

    // Admin
    $delete = "<a href='detail_robots.php?op=del&id=" . $myrow['id'] . "'>
			<img src='../assets/images/icon/delete.gif' alt='" . _DELETE . "'></a>";

    if ($myrow['hide']) {
        $status = '&nbsp;<a href="detail_robots.php?op=d&id=' . $myrow['id'] . '">
				<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '"></a>';
    } else {
        $status = '&nbsp;<a href="detail_robots.php?op=h&id=' . $myrow['id'] . '">
				<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '"></a>';
    }

    if (1 == $myrow['tracker']) {
        $tracker = '&nbsp;<a href="detail_robots.php?op=tracker_off&id=' . $myrow['id'] . '">
				<img src="../assets/images/icon/tracker_off.gif" alt="' . _MD_MYREFERER_TRACKER_OFF . '" valign="absmiddle"></a>';
    } else {
        $tracker = '&nbsp;<a href="detail_robots.php?op=tracker_on&id=' . $myrow['id'] . '">
				<img src="../assets/images/icon/tracker_on.gif" alt="' . _MD_MYREFERER_TRACKER_ON . '" valign="absmiddle"></a>';
    }

    echo '<div align="right" style="border:1px; padding:2px; "><b>' . _MD_MYREFERER_ADMIN . '</b>' . $status . '&nbsp;' . $tracker . '&nbsp;' . $delete . '</div>';
    // Admin

    echo '<div align="center">
    	  <table width="100%" border="1" cellspacing="0" cellpadding="2">
          <tr class="bg3">
          <th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_STATS . '</b></th>
          </tr>';

    if (1 == $myrow['tracker']) {
        $tracker = '<img src="../assets/images/icon/tracker_on.gif" alt="' . _MD_MYREFERER_TRACKER_OFF . '" valign="absmiddle">';
    } else {
        $tracker = '<img src="../assets/images/icon/tracker_off.gif" alt="' . _MD_MYREFERER_TRACKER_ON . '" valign="absmiddle">';
    }

    if ($myrow['hide']) {
        $status = '<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '">';
    } else {
        $status = '<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '">';
    }

    // Display weekly stats about visits and limit number to 2
    $robot_name = Utility::getRobotName($myrow['robots']);
    $robot_url  = Utility::getRobotUrl($myrow['robots']);

    $visit     = $myrow['visit'];
    $page      = $myrow['page'];
    $date      = $myrow['date'];
    $startdate = $myrow['startdate'];

    $total_day = ($date - $startdate) / (60 * 60 * 24);
    $day_stat  = ($visit / $total_day);
    $tmp       = explode('.', $day_stat);
    if ($tmp[1]) {
        $tmp[1] = '.' . mb_substr($tmp[1], 0, 2);
    }
    $day_stat = abs($tmp[0] . $tmp[1]);

    if ($day_stat <= $visit and $day_stat > 0) {
        $stats = '<nobr>' . $visit . ' [' . $day_stat . '&nbsp;/&nbsp;' . _DAY . ']</nobr>';
    } else {
        $stats = '<b>' . $visit . '</b>';
    }

    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_ROBOTS . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $robot_name . ' - ' . robot_url . '</td></tr>';
    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_ID . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow['id'] . '</td></tr>';
    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $stats . '</td></tr>';
    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow['visit_tmp'] . '</td></tr>';
    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_FIRST . '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow['startdate']) . '</td></tr>';
    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST . '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($date) . '</td></tr>';
    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_STATUS . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $status . '&nbsp;' . $tracker . '</td></tr>';

    // pages viewed
    $page_query = 'SELECT f.robotsid, f.pagesid, p.page, f.visit, f.visit_tmp, f.date, p.hide FROM ' . $xoopsDB->prefix('myref_robots_pages') . ' f LEFT JOIN ' . $xoopsDB->prefix('myref_pages') . ' p on f.pagesid = p.id
                  WHERE f.robotsid = ' . $myrow['id'] . ' ORDER BY f.visit_tmp';

    $page_result = $xoopsDB->queryF($page_query);

    echo '<tr><th colspan="3" style="align:center;"><b>' . _MD_MYREFERER_PAGE . '</b></th></tr>';
    echo '<tr><td colspan="3" style="text-align:left;">';
    while (false !== ($page_myrow = $xoopsDB->fetchArray($page_result))) {
        if ($page_myrow['hide']) {
            $font_in = '<span style="color: #ff0000; ">';
        } else {
            $font_in = '<span style="color: #008000; ">';
        }
        preg_match('/(' . str_replace('/', "\/", XOOPS_URL) . ')(.*)/i', 'http://' . $page_myrow['page'], $pages);

        echo '<a target="thepage" href="http://' . $page_myrow['page'] . '">' . $font_in . $pages[2] . '</font></a> [' . $page_myrow['visit_tmp'] . '/<b>' . $page_myrow['visit'] . '</b>]&nbsp;(' . formatTimestamp($page_myrow['date']) . ')<br> ';
    }

    echo '</tr>';
    echo '</table>';
} // if result

require_once __DIR__ . '/detail_footer.php';

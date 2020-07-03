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

require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
// $startart = isset( $_GET['startart'] ) ? intval( $_GET['startart'] ) : 0;

$startart = $_POST['startart'] ?? ($_GET['startart'] ?? 0);
$id       = $_POST['id'] ?? ($_GET['id'] ?? '');

$op = $_POST['op'] ?? ($_GET['op'] ?? '');

$ord = $_POST['ord'] ?? ($_GET['ord'] ?? '');

$search = $_POST['search'] ?? ($_GET['search'] ?? '');

$week = $_POST['week'] ?? ($_GET['week'] ?? 0);

$confirm = $_POST['confirm'] ?? ($_GET['confirm'] ?? 0);

// Delete operation
if ('del' === $op and $id) {
    if ($confirm) {
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_robots') . " WHERE id = '$id' ";

        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_robots_stats') . " WHERE robotsid = '$id' ";

        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_robots_pages') . " WHERE robotsid = '$id' ";

        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_robots_pages_stats') . " WHERE robotsid = '$id' ";

        $xoopsDB->queryF($sql);

        redirect_header('stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=&startart=' . $startart, 1, _MD_MYREFERER_CLEANED);

        exit();
    }

    // Utility::getAdminMenu(0, _MD_MYREFERER_STATS);

    $sql = 'SELECT robots FROM ' . $xoopsDB->prefix('myreferer_robots') . " WHERE id=$id";

    $result = $xoopsDB->query($sql);

    [$name] = $xoopsDB->fetchRow($result);

    $name = Utility::getRobotName($name);

    xoops_confirm(['op'      => $op,
                   'id'      => $id,
                   'confirm' => 1,
                   'ord'     => $ord,
                   'search'  => $search,
                   'week'    => $week,
                   'start'   => $start
                  ], 'stats_robots.php', _MD_MYREFERER_DELETE_ROBOT . ' <br>' . '<br>' . $name . '<br>', _MD_MYREFERER_DELETE);

    xoops_cp_footer();

    exit();
}

// Hide/Show operation
if (('h' === $op or 'd' === $op) and $id) {
    if ('d' === $op) {
        $hide = 1;
    } else {
        $hide = 0;
    }

    $sql = 'UPDATE ' . $xoopsDB->prefix('myreferer_robots') . " SET hide = '$hide' WHERE id = '$id'";

    $xoopsDB->queryF($sql);

    redirect_header('stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=whitelist&startart=' . $startart, 1, _MD_MYREFERER_UPDATED, true);

    exit();
}

// Tracker on/off operation
if (('tracker_on' === $op or 'tracker_off' === $op) and $id) {
    if ('tracker_on' === $op) {
        $tracker = 1;
    } else {
        $tracker = 0;
    }

    $sql = 'UPDATE ' . $xoopsDB->prefix('myreferer_robots') . " SET tracker = '$tracker' WHERE id = '$id'";

    $xoopsDB->queryF($sql);

    redirect_header('stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=whitelist&startart=' . $startart, 1, _MD_MYREFERER_UPDATED, true);

    exit();
}

// $this_date = date('m'); $this_name = _MD_MYREFERER_MONTH; // Month
$this_date = date('W');
$this_name = _MD_MYREFERER_WEEK; // Week
//   $this_date = date('z'); $this_name = _MD_MYREFERER_DAY; // Day of th year

$this_week = date('W');
$all       = _MD_MYREFERER_ALL;
if ($week) {
    $where_week = 'AND visit_tmp > 0';

    $all = '';
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
    $ordre = 'robots';

    $sort_ordre = 'ASC';

    $ord_text = _MD_MYREFERER_ROBOTS;
}
if ('4' == $ord) {
    $ordre = 'date';

    $sort_ordre = 'DESC';

    $ord_text = _MD_MYREFERER_DATE;
}

if ('blacklist' === $op) {
    $all = '<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '" align="absmiddle">&nbsp;';

    if (1 == $week) {
        $all .= "$this_name : $this_date";
    } else {
        $all .= _MD_MYREFERER_ALL;
    }

    $black = '<a href="stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=&startart=' . $startart . '">
    		<img src="../assets/images/icon/all.gif" alt="' . _MD_MYREFERER_ALL . '" align="absmiddle"></a>&nbsp;';

    $black .= '<a href="stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=whitelist&startart=' . $startart . '">
			<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '" align="absmiddle"></a>&nbsp;';
} elseif ('whitelist' === $op) {
    $all = '<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '" align="absmiddle">&nbsp;';

    if (1 == $week) {
        $all .= "$this_name : $this_date";
    } else {
        $all .= _MD_MYREFERER_ALL;
    }

    $black = '<a href="stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=&startart=' . $startart . '">
    		<img src="../assets/images/icon/all.gif" alt="' . _MD_MYREFERER_ALL . '" align="absmiddle"></a>&nbsp;';

    $black .= '<a href="stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=blacklist&startart=' . $startart . '">
			<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '" align="absmiddle"></a>';
} else {
    $all = '<img src="../assets/images/icon/all.gif" alt="' . _MD_MYREFERER_ALL . '" align="absmiddle">&nbsp;';

    if (1 == $week) {
        $all .= "$this_name : $this_date";
    } else {
        $all .= _MD_MYREFERER_ALL;
    }

    $black = '<a href="stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=whitelist&startart=' . $startart . '">
			<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '" align="absmiddle"></a>&nbsp;';

    $black .= '<a href="stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=blacklist&startart=' . $startart . '">
			<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '" align="absmiddle"></a>';
}

// Utility::getAdminMenu(0, _MD_MYREFERER_STATS);
Utility::getStatMenu(3, '');
OpenTable();

// Display informations
echo "<table width='100%'><tr><td>";
echo '<b>' . $xoopsConfig['sitename'] . "</b><br><a href='stats_robots.php?ord=$ord&search=$search&week=0&op=$op&startart=$startart'>" . _MD_MYREFERER_ALL . "</a> | <a href='stats_robots.php?ord=$ord&search=$search&week=1&op=$op&startart=$startart'>"
     . _MD_MYREFERER_WEEK . " : $this_week </a> | $black";
echo "</td><td align='right'>";
Utility::search($ord, $search, $engine, $week, $startart);
echo '</td></tr></table>';
// Display informations

$query = 'SELECT * FROM ' . $xoopsDB->prefix('myreferer_robots') . "
	WHERE $where $where_week AND ( ref_url LIKE '%$search%' OR robots LIKE '%$search%' )
	ORDER BY $ordre $sort_ordre";

$counter = $xoopsDB->queryF($query);
$count   = @mysqli_num_rows($counter);

if (0 == $count) {
    echo _MD_MYREFERER_NOVISIT . '<p>';
} else {
    $result = $xoopsDB->queryF($query, $xoopsModuleConfig['perpage'], $startart);

    $pagenav = new XoopsPageNav($count, $xoopsModuleConfig['perpage'], $startart, 'startart', 'ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=' . $op);

    echo "<br><div style='text-align:center;'><b>$all</b> " . _MD_MYREFERER_RANKING . " <b>$ord_text</b> ($count)</div>";

    echo "<a
             onclick=\"pop=window.open('', 'wclose', 'width=800, height=600, dependent=yes, toolbar=no, menubar=yes, status=no, scrollbars=yes, resizable=yes, titlebar=yes, left=160, top=160', 'false'); pop.focus(); \"
             target='wclose'
             href='report.php?sql=myref_robots&ord=$ord&search=$search&week=$week&op=$op&startart=$startart'
             title='" . _MD_MYREFERER_REPORT . "'>" . _MD_MYREFERER_REPORT . '</a>';

    echo "<div style='text-align:right; width:95%;'>" . $pagenav->renderNav() . '</div>';

    echo "<div align='center'>
		  <table border='0' cellpadding='4' cellspacing='1' class='bg2' width='90%'>
          <tr class='bg3'>
          <th style='align:center;'><a href='stats_robots.php?ord=1&search=$search&week=$week&op=$op&startart=$startart' title='" . _MD_MYREFERER_RANKING . _MD_MYREFERER_LATEST . "'>		N°			</a></th>
          <th style='align:center;'><nobr>
          <a href='stats_robots.php?ord=&search=$search&week=$week&op=$op&startart=$startart' title='" . _MD_MYREFERER_RANKING . _MD_MYREFERER_VISITS . ' ' . _MD_MYREFERER_WEEK . "'>	" . _MD_MYREFERER_WEEK . "</a>
          (<a href='stats_robots.php?ord=2&search=$search&week=$week&op=$op&startart=$startart' title='" . _MD_MYREFERER_RANKING . _MD_MYREFERER_VISITS . ' ' . _MD_MYREFERER_ALL . "'>	" . _MD_MYREFERER_VISITS . "</a> ) </nobr>
          </th>
          <th style='align:center;'><a href='stats_robots.php?ord=3&search=$search&week=$week&op=$op&startart=$startart' title='" . _MD_MYREFERER_RANKING . _MD_MYREFERER_ROBOTS . "'>	" . _MD_MYREFERER_ROBOTS . "</a></th>
          <th style='align:center;'><a href='stats_robots.php?ord=4&search=$search&week=$week&op=$op&startart=$startart' title='" . _MD_MYREFERER_RANKING . _MD_MYREFERER_DATE . "'>	" . _MD_MYREFERER_DATE . "	</a></th>
          <th style='align:center;'><b>" . _MD_MYREFERER_ADMIN . '</b></th>
          </tr>';

    // Get flag list

    //define the path as relative

    $path = '../assets/images/logos/robots';

    //using the opendir function

    $dir_handle = @opendir($path) || exit("Unable to open $path");

    // echo "Directory Listing of $path<br>";

    $pattern_robot = [];

    //running the while loop

    while ($file = readdir($dir_handle)) {
        if ('.' !== $file && '..' !== $file) {
            $file = str_replace('robot_', '', $file);

            $file = str_replace('.png', '', $file);

            $pattern_robots[] = $file;
        }
    }

    //closing the directory

    closedir($dir_handle);

    $i = $startart;

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        if ($myrow['date']) {
            $date = formatTimestamp($myrow['date'], 'm');

            $date_week = formatTimestamp($myrow['date'], 'W');

            $date_month = formatTimestamp($myrow['date'], 'F');
        } else {
            $date = _MD_MYREFERER_NOVISITYET;
        }

        if ($myrow['startdate']) {
            $startdate = formatTimestamp($myrow['startdate'], 'm');

            $startdate_week = formatTimestamp($myrow['startdate'], 'W');

            $startdate_month = formatTimestamp($myrow['startdate'], 'F');
        } else {
            $startdate = _MD_MYREFERER_NOVISITYET;
        }

        $page = str_replace(XOOPS_URL, '', 'http://' . $myrow['page']);

        $robot = addslashes($myrow['robots']);

        $robotName = Utility::getRobotName($robot);

        $robotUrl = Utility::getRobotUrl($robot);

        require __DIR__ . '/robots_pics.php';

        if ('' != $robotUrl) {
            $robotName = "<a href='$robotUrl' title='" . $myrow['robots'] . "' title='" . $myrow['robots'] . "' target='_blank'>$robotName</a>";
        } else {
            $robotName = $myrow['robots'];
        }

        $robotName = '<a href="stats_robots.php?search=' . $robotIcon . '">
                            <img src="../assets/images/logos/robots/robot_' . $robotIcon . '.png" alt="' . $robotIcon . '"></a> ' . $robotName;

        $detail = "<a onclick=\"window.open('', 'wclose', 'width=800, height=500, toolbar=no, scrollbars=yes, status=no, resizable=no, fullscreen=no, titlebar=no, left=10, top=10', 'false')\"  href='detail_robots.php?id=" . $myrow['id'] . "' target='wclose'>
				<img src='../assets/images/icon/detail.gif' alt='" . _MD_MYREFERER_MORE . "'></a>";

        $delete = "<a href='stats_robots.php?ord=$ord&search=$search&week=$week&op=del&id=" . $myrow['id'] . "'>
				<img src='../assets/images/icon/delete.gif' alt='" . _DELETE . "' valign='absmiddle'></a>";

        if ($myrow['hide']) {
            $status = '&nbsp;<a href="stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=h&startart=' . $startart . '&id=' . $myrow['id'] . '">
					<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '" valign="absmiddle"></a>';
        } else {
            $status = '&nbsp;<a href="stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=d&startart=' . $startart . '&id=' . $myrow['id'] . '">
					<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '" valign="absmiddle"></a>';
        }

        if (1 == $myrow['tracker']) {
            $tracker = '&nbsp;<a href="stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=tracker_off&startart=' . $startart . '&id=' . $myrow['id'] . '">
					<img src="../assets/images/icon/tracker_on.gif" alt="' . _MD_MYREFERER_TRACKER_OFF . '" valign="absmiddle"></a>';
        } else {
            $tracker = '&nbsp;<a href="stats_robots.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=tracker_on&startart=' . $startart . '&id=' . $myrow['id'] . '">
					<img src="../assets/images/icon/tracker_off.gif" alt="' . _MD_MYREFERER_TRACKER_ON . '" valign="absmiddle"></a>';
        }

        if ('1' == $ord) {
            $time = $startdate;
        } else {
            $time = $date;
        }

        if ($this_week == $date_week) {
            $bg = "class='bg4'";
        } else {
            $bg = "style='background-color:#CCC; color:#666;'";
        }

        $i++;

        echo "<tr $bg >
				  <td align='center'>	$i	</td>
                  <td align='center'><b>" . $myrow['visit_tmp'] . '</b> (' . $myrow['visit'] . ")	</td>
                  <td align='left'>		$robotName 	</td>
                  <td align='center'>	$time	</td>
                  <td align='center'>	<nobr>$detail&nbsp;$delete&nbsp;$status&nbsp;$tracker</nobr>	</td>
                  </tr>";
    }

    echo '</table></div>';

    echo '<div style="text-align:center;">' . $pagenav->renderNav() . '</div>';

    echo "<br>\n";
}

CloseTable();
require_once __DIR__ . '/admin_footer.php';

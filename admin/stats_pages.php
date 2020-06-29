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

require __DIR__ . '/admin_header.php';

xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));

require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
// $startart = isset( $_GET['startart'] ) ? intval( $_GET['startart'] ) : 0;
error_reporting(E_ALL ^ E_NOTICE);

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
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_pages') . " WHERE id = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_pages_stats') . " WHERE pagesid = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_query_pages') . " WHERE pagesid = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_query_pages_stats') . " WHERE pagesid = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_referer_pages') . " WHERE pagesid = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_referer_pages_stats') . " WHERE pagesid = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_robots_pages') . " WHERE pagesid = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_robots_pages_stats') . " WHERE pagesid = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_users_pages') . " WHERE pagesid = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_users_pages_stats') . " WHERE pagesid = '$id' ";
        $xoopsDB->queryF($sql);

        redirect_header('stats_pages.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=&startart=' . $startart, 1, _MD_MYREFERER_CLEANED);
        exit();
    }
    // Utility::getAdminMenu(0, _MD_MYREFERER_STATS);

    $sql    = 'SELECT page FROM ' . $xoopsDB->prefix('myref_pages') . " WHERE id=$id";
    $result = $xoopsDB->query($sql);
    [$name] = $xoopsDB->fetchRow($result);
    preg_match('/(' . str_replace('/', "\/", XOOPS_URL) . ')(.*)/i', 'http://' . $name, $mypage);
    $name = $mypage[2];

    xoops_confirm(['op' => $op, 'id' => $id, 'confirm' => 1, 'ord' => $ord, 'search' => $search, 'week' => $week, 'start' => $start], 'stats_pages.php', _MD_MYREFERER_DELETE_PAGE . ' <br>' . '<br>' . $name . '<br>', _MD_MYREFERER_DELETE);

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
    $sql = 'UPDATE ' . $xoopsDB->prefix('myref_pages') . " SET hide = '$hide' WHERE id = '$id'";
    $xoopsDB->queryF($sql);

    redirect_header('stats_pages.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=whitelist&startart=' . $startart, 0, _MD_MYREFERER_UPDATED, true);
    exit();
}

// $this_date = date('m'); $this_name = _MD_MYREFERER_MONTH; // Month
$this_date = date('W');
$this_name = _MD_MYREFERER_WEEK; // Week
//   $this_date = date('z'); $this_name = _MD_MYREFERER_DAY; // Day of th year

$all = _MD_MYREFERER_ALL;

if ($week) {
    $where_week = 'AND visit_tmp > 0';
    $all        = '';
}
if ('blacklist' === $op) {
    $where = 'hide = 1';
} elseif ('whitelist' === $op) {
    $where = 'hide = 0';
} else {
    $where = 'hide >= 0';
}

if ('' == $ord) {
    $ordre      = 'visit_tmp';
    $sort_ordre = 'DESC';
    $ord_text   = _MD_MYREFERER_VISITS . ' / ' . _MD_MYREFERER_WEEK;
}
if ('1' == $ord) {
    $ordre      = 'id';
    $sort_ordre = 'DESC';
    $ord_text   = _MD_MYREFERER_LATEST;
}
if ('2' == $ord) {
    $ordre      = $xoopsModuleConfig['order'];
    $sort_ordre = 'DESC';
    $ord_text   = _MD_MYREFERER_VISITS;
}
if ('3' == $ord) {
    $ordre      = 'page';
    $sort_ordre = 'ASC';
    $ord_text   = _MD_MYREFERER_PAGE;
}
if ('4' == $ord) {
    $ordre      = 'date';
    $sort_ordre = 'DESC';
    $ord_text   = _MD_MYREFERER_DATE;
}

if ('blacklist' === $op) {
    $all = '<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '" align="absmiddle">&nbsp;';
    if (1 == $week) {
        $all .= "$this_name : $this_date";
    } else {
        $all .= _MD_MYREFERER_ALL;
    }
    $black = '<a href="stats_pages.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=&startart=' . $startart . '">
    		<img src="../assets/images/icon/all.gif" alt="' . _MD_MYREFERER_ALL . '" align="absmiddle"></a>&nbsp;';

    $black .= '<a href="stats_pages.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=whitelist&startart=' . $startart . '">
			<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '" align="absmiddle"></a>&nbsp;';
} elseif ('whitelist' === $op) {
    $all = '<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '" align="absmiddle">&nbsp;';
    if (1 == $week) {
        $all .= "$this_name : $this_date";
    } else {
        $all .= _MD_MYREFERER_ALL;
    }
    $black = '<a href="stats_pages.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=&startart=' . $startart . '">
    		<img src="../assets/images/icon/all.gif" alt="' . _MD_MYREFERER_ALL . '" align="absmiddle"></a>&nbsp;';

    $black .= '<a href="stats_pages.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=blacklist&startart=' . $startart . '">
			<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '" align="absmiddle"></a>';
} else {
    $all = '<img src="../assets/images/icon/all.gif" alt="' . _MD_MYREFERER_ALL . '" align="absmiddle">&nbsp;';
    if (1 == $week) {
        $all .= "$this_name : $this_date";
    } else {
        $all .= _MD_MYREFERER_ALL;
    }
    $black = '<a href="stats_pages.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=whitelist&startart=' . $startart . '">
			<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '" align="absmiddle"></a>&nbsp;';

    $black .= '<a href="stats_pages.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=blacklist&startart=' . $startart . '">
			<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '" align="absmiddle"></a>';
}

// Utility::getAdminMenu(0, _MD_MYREFERER_STATS);
Utility::getStatMenu(0, '');
OpenTable();

// Display informations
echo "<table width='100%'><tr><td>";
echo '<b>' . $xoopsConfig['sitename'] . "</b><br><a href='stats_pages.php?ord=$ord&search=$search&week=0&op=$op&startart=$startart'>" . _MD_MYREFERER_ALL . "</a> | <a href='stats_pages.php?ord=$ord&search=$search&week=1&op=$op&startart=$startart'>$this_name : $this_date </a> | $black";
echo "</td><td align='right'>";
Utility::search($ord, $search, $engine, $week, $startart);
echo '</td></tr></table>';
// Display informations

$pages = '	SELECT * FROM ' . $xoopsDB->prefix('myref_pages') . "
		WHERE $where $where_week AND page LIKE '%$search%'
		ORDER BY $ordre $sort_ordre";

$counter = $xoopsDB->queryF($pages);
$count   = @mysqli_num_rows($counter);

if (0 == $count) {
    echo _MD_MYREFERER_NOVISIT . '<p>';
} else {
    $result  = $xoopsDB->queryF($pages, $xoopsModuleConfig['perpage'], $startart);
    $pagenav = new \XoopsPageNav($count, $xoopsModuleConfig['perpage'], $startart, 'startart', 'ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=' . $op);

    echo "<br><div style='text-align:center;'><b>$all</b> " . _MD_MYREFERER_RANKING . " <b>$ord_text</b> ($count)</div>";
    echo "<div style='text-align:right; width:95%;'>" . $pagenav->renderNav() . '</div>';
    echo "<div align='center'>
		  <table border='0' cellpadding='4' cellspacing='1' class='bg2' width='90%'>
          <tr class='bg3'>
          <th style='align:center;'><a href='stats_pages.php?ord=1&search=$search&week=$week&op=$op&startart=$startart' title='" . _MD_MYREFERER_RANKING . _MD_MYREFERER_LATEST . "'>		N°			</a></th>
          <th style='align:center;'>
          <a href='stats_pages.php?ord=&search=$search&week=$week&op=$op&startart=$startart' title='" . _MD_MYREFERER_RANKING . _MD_MYREFERER_VISITS . ' ' . _MD_MYREFERER_WEEK . "'>	" . _MD_MYREFERER_WEEK . "</a>
          (<a href='stats_pages.php?ord=2&search=$search&week=$week&op=$op&startart=$startart' title='" . _MD_MYREFERER_RANKING . _MD_MYREFERER_VISITS . ' ' . _MD_MYREFERER_ALL . "'>	" . _MD_MYREFERER_VISITS . "</a> )
          </th>
          <th style='align:center;'><a href='stats_pages.php?ord=3&search=$search&week=$week&op=$op&startart=$startart' title='" . _MD_MYREFERER_RANKING . _MD_MYREFERER_PAGE . "'>	" . _MD_MYREFERER_PAGE . "</a></th>
          <th style='align:center;'><a href='stats_pages.php?ord=4&search=$search&week=$week&op=$op&startart=$startart' title='" . _MD_MYREFERER_RANKING . _MD_MYREFERER_DATE . "'>	" . _MD_MYREFERER_DATE . "	</a></th>
          <th style='align:center;'><b>" . _MD_MYREFERER_ADMIN . '</b></th>
          </tr>';

    $i = $startart;
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        if ($myrow['date']) {
            //			$data_date = formatTimestamp($myrow["date"],'m');
            $data_date = formatTimestamp($myrow['date'], 'W');
            //			$data_date = formatTimestamp($myrow["date"],'z');
            // 			$data_date = formatTimestamp($myrow["date"],'r');
        } else {
            $date = _MD_MYREFERER_NOVISITYET;
        }

        if ($myrow['startdate']) {
            $startdate = formatTimestamp($myrow['startdate'], 'm');
        } else {
            $startdate = _MD_MYREFERER_NOVISITYET;
        }

        preg_match('/(' . str_replace('/', "\/", XOOPS_URL) . ')(.*)/i', 'http://' . $myrow['page'], $mypage);
        $thepage = $mypage[2];
        if (preg_match("/(.*)(\?xoops_redirect)(.*)/i", $mypage[2], $tmppage)) {
            $thepage = $tmppage[1];
        }

        $detail = "<a onclick=\"window.open('', 'wclose', 'width=800, height=500, toolbar=no, scrollbars=yes, status=no, resizable=no, fullscreen=no, titlebar=no, left=10, top=10', 'false')\"  href='detail_pages.php?id=" . $myrow['id'] . "' target='wclose'>
				<img src='../assets/images/icon/detail.gif' alt='" . _MD_MYREFERER_MORE . "'></a>";
        $delete = "<a href='stats_pages.php?ord=$ord&search=$search&week=$week&op=del&id=" . $myrow['id'] . "'>
				<img src='../assets/images/icon/delete.gif' alt='" . _DELETE . "'></a>";

        if ($myrow['hide']) {
            $status = '&nbsp;<a href="stats_pages.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=h&startart=' . $startart . '&id=' . $myrow['id'] . '">
					<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '"></a>';
        } else {
            $status = '&nbsp;<a href="stats_pages.php?ord=' . $ord . '&search=' . $search . '&week=' . $week . '&op=d&startart=' . $startart . '&id=' . $myrow['id'] . '">
					<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '"></a>';
        }

        if ('1' == $ord) {
            $time = $myrow['startdate'];
        } else {
            $time = $myrow['date'];
        }
        // setlocale('LC_TIME', 'french');

        if ($this_date == $data_date) {
            $bg = "class='bg4'";
        } else {
            $bg = "style='background-color:#EEE; color:#999;'";
        }

        $i++;
        if (mb_strlen($thepage) > 60) {
            $thepage = mb_substr($thepage, 0, 60) . '[...]';
        }
        echo "<tr $bg>
           	  <td align='center'>	$i</a></td>
              <td align='center'><b>" . $myrow['visit_tmp'] . '</b> (' . $myrow['visit'] . ")	</td>
              <td align='left'><a href='http://" . $myrow['page'] . "' title='" . $myrow['page'] . "' target='_blank'>" . $thepage . "</a></td>
              <td align='center'>	" . formatTimestamp($time) . "	</td>
              <td align='center'>	<nobr>$detail&nbsp;$delete&nbsp;$status</nobr>	</td>
              </tr>";
    }
    echo '</table></div>';
    echo '<div style="text-align:center;">' . $pagenav->renderNav() . '</div>';
    echo "<br>\n";
}
CloseTable();

require_once __DIR__ . '/admin_footer.php';

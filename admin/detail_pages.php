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
require_once __DIR__ . '/admin_header.php';

$id = $_POST['id'] ?? ($_GET['id'] ?? '');

$op = $_POST['op'] ?? ($_GET['op'] ?? '');

$confirm = $_POST['confirm'] ?? ($_GET['confirm'] ?? 0);

// Delete operation
if ('del' === $op and $id) {
    if ($confirm) {
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_pages') . " WHERE id = '$id' ";

        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_pages_stats') . " WHERE pagesid = '$id' ";

        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_query_pages') . " WHERE pagesid = '$id' ";

        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_query_pages_stats') . " WHERE pagesid = '$id' ";

        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_referer_pages') . " WHERE pagesid = '$id' ";

        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_referer_pages_stats') . " WHERE pagesid = '$id' ";

        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_robots_pages') . " WHERE pagesid = '$id' ";

        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_robots_pages_stats') . " WHERE pagesid = '$id' ";

        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_users_pages') . " WHERE pagesid = '$id' ";

        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_users_pages_stats') . " WHERE pagesid = '$id' ";

        $xoopsDB->queryF($sql);

        echo "<script type='text/javascript'>\n";

        echo "self.close();\n";

        echo '</script>';
    } else {
        require_once __DIR__ . '/detail_header.php';

        $sql = 'SELECT page FROM ' . $xoopsDB->prefix('myreferer_pages') . " WHERE id=$id";

        $result = $xoopsDB->query($sql);

        [$name] = $xoopsDB->fetchRow($result);

        preg_match('/(' . str_replace('/', "\/", XOOPS_URL) . ')(.*)/i', 'http://' . $name, $mypage);

        $name = $mypage[2];

        xoops_confirm(['op'      => $op,
                       'id'      => $id,
                       'confirm' => 1,
                       'ord'     => $ord,
                       'search'  => $search,
                       'week'    => $week,
                       'start'   => $start
                      ], 'detail_pages.php', _MD_MYREFERER_DELETE_PAGE . ' <br>' . '<br>' . $name . '<br>', _MD_MYREFERER_DELETE);

        require_once __DIR__ . '/detail_footer.php';

        exit();
    }
}

// Hide/Show operation
if (('h' === $op || 'd' === $op) && $id) {
    if ('d' === $op) {
        $hide = 0;
    } else {
        $hide = 1;
    }

    $sql = 'UPDATE ' . $xoopsDB->prefix('myreferer_pages') . " SET hide = '$hide' WHERE id = '$id'";

    $xoopsDB->queryF($sql);
}

// $this_date = date('W'); $this_name = _MD_MYREFERER_WEEK; // Week
$pages = 'SELECT * FROM ' . $xoopsDB->prefix('myreferer_pages') . " WHERE id = '$id' ORDER BY date DESC";

$counter = $xoopsDB->queryF($pages);
$count   = @mysqli_num_rows($counter);

require_once __DIR__ . '/detail_header.php';

if (0 == $count) {
    echo '<div align="center">' . _MD_MYREFERER_NOVISIT . '</div>';
} else {
    $result = $xoopsDB->queryF($pages);

    $myrow = $xoopsDB->fetchArray($result);

    $members = 'SELECT count(r.id) AS nb, sum(p.visit) AS visit, sum(p.visit_tmp) AS visit_tmp, r.startdate, p.date  FROM ' . $xoopsDB->prefix('myreferer_users_pages') . ' p LEFT JOIN ' . $xoopsDB->prefix('myreferer_users') . " r on r.id = p.usersid
                    WHERE p.pagesid = '$id'
                    GROUP BY p.pagesid
                    ORDER BY r.date DESC";

    $result_members = $xoopsDB->queryF($members);

    $myrow_members = $xoopsDB->fetchArray($result_members);

    $referer = 'SELECT count(r.id) AS nb, sum(p.visit) AS visit, sum(p.visit_tmp) AS visit_tmp, r.startdate, p.date  FROM ' . $xoopsDB->prefix('myreferer_referer_pages') . ' p LEFT JOIN ' . $xoopsDB->prefix('myreferer_referer') . " r on r.id = p.refererid
                    WHERE r.engine=0 AND p.pagesid = '$id'
                    GROUP BY p.pagesid
                    ORDER BY r.date DESC";

    $result_referer = $xoopsDB->queryF($referer);

    $myrow_referer = $xoopsDB->fetchArray($result_referer);

    $search = 'SELECT count(r.id) AS nb, sum(p.visit) AS visit, sum(p.visit_tmp) AS visit_tmp, r.startdate, p.date  FROM ' . $xoopsDB->prefix('myreferer_referer_pages') . ' p LEFT JOIN ' . $xoopsDB->prefix('myreferer_referer') . " r on r.id = p.refererid
                    WHERE r.engine=1 AND p.pagesid = '$id'
                    GROUP BY p.pagesid
                    ORDER BY r.date DESC";

    $result_search = $xoopsDB->queryF($search);

    $myrow_search = $xoopsDB->fetchArray($result_search);

    $keyword = 'SELECT count(r.id) AS nb, sum(p.visit) AS visit, sum(p.visit_tmp) AS visit_tmp, r.startdate, p.date  FROM ' . $xoopsDB->prefix('myreferer_query_pages') . ' p LEFT JOIN ' . $xoopsDB->prefix('myreferer_query') . " r on r.id = p.queryid
                    WHERE r.keyword=1 AND p.pagesid = '$id'
                    GROUP BY p.pagesid
                    ORDER BY r.date DESC";

    $result_keyword = $xoopsDB->queryF($keyword);

    $myrow_keyword = $xoopsDB->fetchArray($result_keyword);

    $query = 'SELECT count(r.id) AS nb, sum(p.visit) AS visit, sum(p.visit_tmp) AS visit_tmp, r.startdate, p.date  FROM ' . $xoopsDB->prefix('myreferer_query_pages') . ' p LEFT JOIN ' . $xoopsDB->prefix('myreferer_query') . " r on r.id = p.queryid
                    WHERE r.keyword=0 AND p.pagesid = '$id'
                    GROUP BY p.pagesid
                    ORDER BY r.date DESC";

    $result_query = $xoopsDB->queryF($query);

    $myrow_query = $xoopsDB->fetchArray($result_query);

    $robots = 'SELECT count(r.id) AS nb, sum(p.visit) AS visit, sum(p.visit_tmp) AS visit_tmp, r.startdate, p.date  FROM ' . $xoopsDB->prefix('myreferer_robots_pages') . ' p LEFT JOIN ' . $xoopsDB->prefix('myreferer_robots') . " r on r.id = p.robotsid
                    WHERE p.pagesid = '$id'
                    GROUP BY p.pagesid
                    ORDER BY p.pagesid, r.date DESC";

    $result_robots = $xoopsDB->queryF($robots);

    $myrow_robots = $xoopsDB->fetchArray($result_robots);

    // Admin

    $delete = "<a href='detail_pages.php?op=del&id=" . $myrow['id'] . "'>
			<img src='../assets/images/icon/delete.gif' alt='" . _DELETE . "'></a>";

    if ($myrow['hide']) {
        $status = '&nbsp;<a href="detail_pages.php?op=d&id=' . $myrow['id'] . '">
				<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '"></a>';
    } else {
        $status = '&nbsp;<a href="detail_pages.php?op=h&id=' . $myrow['id'] . '">
				<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '"></a>';
    }

    echo '<div align="right" style="border:1px; padding:2px; "><b>' . _MD_MYREFERER_ADMIN . '</b>' . $status . '&nbsp;' . $delete . '</div>';

    // Admin

    echo '<div align="center">
    	  <table width="100%" border="1" cellspacing="0" cellpadding="2">
          <tr class="bg3">
          <th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_STATS . '</b></th>
          </tr>';

    if ($myrow['hide']) {
        $status = '<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_HIDDEN . '">';
    } else {
        $status = '<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '">';
    }

    // Display weekly stats about visits and limit number to 2

    $visit = $myrow['visit'];

    $page = $myrow['page'];

    $date = $myrow['date'];

    $startdate = $myrow['startdate'];

    $total_day = ($date - $startdate) / (60 * 60 * 24);

    $day_stat = $visit / $total_day;

    $tmp = explode('.', $day_stat);

    if ($tmp[1]) {
        $tmp[1] = '.' . mb_substr($tmp[1], 0, 2);
    }

    $day_stat = abs($tmp[0] . $tmp[1]);

    if ($day_stat <= $visit and $day_stat > 0) {
        $stats = '<nobr>' . $visit . ' [' . $day_stat . '&nbsp;/&nbsp;' . _DAY . ']</nobr>';
    } else {
        $stats = '<b>' . $visit . '</b>';
    }

    preg_match('/(' . str_replace('/', "\/", XOOPS_URL) . ')(.*)/i', 'http://' . $myrow['page'], $mypage);

    $thepage = $mypage[2];

    if (preg_match("/(.*)(\?xoops_redirect)(.*)/i", $mypage[2], $tmppage)) {
        $thepage = $tmppage[1];
    }

    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_PAGE . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $thepage . '</td></tr>';

    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_ID . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow['id'] . '</td></tr>';

    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $stats . '</td></tr>';

    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow['visit_tmp'] . '</td></tr>';

    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_FIRST . '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow['startdate']) . '</td></tr>';

    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST . '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow['date']) . '</td></tr>';

    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_STATUS . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $status . '</td></tr>';

    // visitors

    $other_visit = $myrow['visit'];

    if (0 != @mysqli_num_rows($result_members)) {
        $other_visit -= $myrow_members['visit'];
    }

    if (0 != @mysqli_num_rows($result_referer)) {
        $other_visit -= $myrow_referer['visit'];
    }

    if (0 != @mysqli_num_rows($result_search)) {
        $other_visit -= $myrow_search['visit'];
    }

    if (0 != @mysqli_num_rows($result_keyword)) {
        $other_visit -= $myrow_keyword['visit'];
    }

    if (0 != @mysqli_num_rows($result_query)) {
        $other_visit -= $myrow_query['visit'];
    }

    if (0 != @mysqli_num_rows($result_robots)) {
        $other_visit -= $myrow_robots['visit'];
    }

    $other_visit_tmp = $myrow['visit_tmp'];

    if (0 != @mysqli_num_rows($result_members)) {
        $other_visit_tmp -= $myrow_members['visit_tmp'];
    }

    if (0 != @mysqli_num_rows($result_referer)) {
        $other_visit_tmp -= $myrow_referer['visit_tmp'];
    }

    if (0 != @mysqli_num_rows($result_search)) {
        $other_visit_tmp -= $myrow_search['visit_tmp'];
    }

    if (0 != @mysqli_num_rows($result_keyword)) {
        $other_visit_tmp -= $myrow_keyword['visit_tmp'];
    }

    if (0 != @mysqli_num_rows($result_query)) {
        $other_visit_tmp -= $myrow_query['visit_tmp'];
    }

    if (0 != @mysqli_num_rows($result_robots)) {
        $other_visit_tmp -= $myrow_robots['visit_tmp'];
    }

    // members

    echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_MEMBERS;

    if (0 != @mysqli_num_rows($result_referer)) {
        echo '&nbsp;[' . $myrow_referer['nb'] . ']</b></th></tr>';

        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_members['visit'] . '</td></tr>';

        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_members['visit_tmp'] . '</td></tr>';

        //		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow_referer['date']) .'</td></tr>';
    } else {
        echo '</b></th></tr>';

        echo '<tr><td colspan="3"><nobr><b>' . _MD_MYREFERER_NOVISIT . '</b></nobr></td></tr>';
    }

    echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_VISITORS . '</b></th></tr>';

    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $other_visit . '</td></tr>';

    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $other_visit_tmp . '</td></tr>';

    // referers

    echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_REFERER;

    if (0 != @mysqli_num_rows($result_referer)) {
        echo '&nbsp;[' . $myrow_referer['nb'] . ']</b></th></tr>';

        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_referer['visit'] . '</td></tr>';

        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_referer['visit_tmp'] . '</td></tr>';

        //		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow_referer['date']) .'</td></tr>';
    } else {
        echo '</b></th></tr>';

        echo '<tr><td colspan="3"><nobr><b>' . _MD_MYREFERER_NOVISIT . '</b></nobr></td></tr>';
    }

    // search engine

    echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_ENGINE;

    if (0 != @mysqli_num_rows($result_search)) {
        echo '&nbsp;[' . $myrow_search['nb'] . ']</b></th></tr>';

        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_search['visit'] . '</td></tr>';

        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_search['visit_tmp'] . '</td></tr>';

        //		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow_search['date']) .'</td></tr>';
    } else {
        echo '</b></th></tr>';

        echo '<tr><td colspan="3"><nobr><b>' . _MD_MYREFERER_NOVISIT . '</b></nobr></td></tr>';
    }

    // Keyword

    echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_KEYWORDS;

    if (0 != @mysqli_num_rows($result_keyword)) {
        echo '&nbsp;[' . $myrow_keyword['nb'] . ']</b></th></tr>';

        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_keyword['visit'] . '</td></tr>';

        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_keyword['visit_tmp'] . '</td></tr>';

        //		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow_keyword['date']) .'</td></tr>';
    } else {
        echo '</b></th></tr>';

        echo '<tr><td colspan="3"><nobr><b>' . _MD_MYREFERER_NOVISIT . '</b></nobr></td></tr>';
    }

    // query

    echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_QUERY;

    if (0 != @mysqli_num_rows($result_query)) {
        echo '&nbsp;[' . $myrow_query['nb'] . ']</b></th></tr>';

        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_query['visit'] . '</td></tr>';

        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_query['visit_tmp'] . '</td></tr>';

        //		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow_query['date']) .'</td></tr>';
    } else {
        echo '</b></th></tr>';

        echo '<tr><td colspan="3"><nobr><b>' . _MD_MYREFERER_NOVISIT . '</b></nobr></td></tr>';
    }

    // robots

    echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_ROBOTS;

    if (0 != @mysqli_num_rows($result_robots)) {
        echo '&nbsp;[' . $myrow_robots['nb'] . ']</b></th></tr>';

        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_robots['visit'] . '</td></tr>';

        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_robots['visit_tmp'] . '</td></tr>';

        //		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow_robots['date']) .'</td></tr>';
    } else {
        echo '</b></th></tr>';

        echo '<tr><td colspan="3"><nobr><b>' . _MD_MYREFERER_NOVISIT . '</b></nobr></td></tr>';
    }

    echo '</table>';
} // if result

require_once __DIR__ . '/detail_footer.php';

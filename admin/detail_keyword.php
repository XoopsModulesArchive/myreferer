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
require_once __DIR__ . '/admin_header.php';

$id = $_POST['id'] ?? ($_GET['id'] ?? '');

$op = $_POST['op'] ?? ($_GET['op'] ?? '');

$confirm = $_POST['confirm'] ?? ($_GET['confirm'] ?? 0);

// Delete operation
if ('del' === $op and $id) {
    if ($confirm) {
        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_query') . " WHERE id = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_query_stats') . " WHERE queryid = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_query_pages') . " WHERE queryid = '$id' ";
        $xoopsDB->queryF($sql);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix('myref_query_pages_stats') . " WHERE queryid = '$id' ";
        $xoopsDB->queryF($sql);

        echo "<script type='text/javascript'>\n";
        echo "self.close();\n";
        echo '</script>';
    } else {
        require_once __DIR__ . '/detail_header.php';
        $sql    = 'SELECT query FROM ' . $xoopsDB->prefix('myref_query') . " WHERE id=$id";
        $result = $xoopsDB->query($sql);
        [$name] = $xoopsDB->fetchRow($result);

        xoops_confirm(['op' => $op, 'id' => $id, 'confirm' => 1, 'ord' => $ord, 'search' => $search, 'week' => $week, 'start' => $start], 'detail_keyword.php', _MD_MYREFERER_DELETE_KEYWORD . ' <br>' . '<br>' . $name . '<br>', _MD_MYREFERER_DELETE);

        require_once __DIR__ . '/detail_footer.php';
        exit();
    }
}

// Hide/Show operation
if (('h' === $op or 'd' === $op) and $id) {
    if ('d' === $op) {
        $hide = 0;
    } else {
        $hide = 1;
    }
    $sql = 'UPDATE ' . $xoopsDB->prefix('myref_query') . " SET hide = '$hide' WHERE id = '$id'";
    $xoopsDB->queryF($sql);
}

// $this_date = date('W'); $this_name = _MD_MYREFERER_WEEK; // Week
$query   = 'SELECT * FROM ' . $xoopsDB->prefix('myref_query') . " WHERE id = '$id'";
$counter = $xoopsDB->queryF($query);
$count   = @mysqli_num_rows($counter);

require_once __DIR__ . '/detail_header.php';

if (0 == $count) {
    echo '<div align="center">' . _MD_MYREFERER_NOVISIT . '</div>';
} else {
    $result = $xoopsDB->queryF($query);
    $myrow  = $xoopsDB->fetchArray($result);

    // Admin
    $delete = "<a href='detail_keyword.php?op=del&id=" . $myrow['id'] . "'>
			<img src='../assets/images/icon/delete.gif' alt='" . _DELETE . "'></a>";

    if ($myrow['hide']) {
        $status = '&nbsp;<a href="detail_keyword.php?op=d&id=' . $myrow['id'] . '">
				<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_DISPLAYED . '"></a>';
    } else {
        $status = '&nbsp;<a href="detail_keyword.php?op=h&id=' . $myrow['id'] . '">
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
    $visit     = $myrow['visit'];
    $page      = $myrow['page'];
    $keyword   = $myrow['query'];
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

    if (1 == $myrow['keyword']) {
        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_KEYWORDS . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $keyword . '</td></tr>';
    } else {
        echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_QUERY . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $keyword . '</td></tr>';
    }
    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_ID . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow['id'] . '</td></tr>';
    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $stats . '</td></tr>';
    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow['visit_tmp'] . '</td></tr>';
    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_FIRST . '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow['startdate']) . '</td></tr>';
    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST . '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($date) . '</td></tr>';
    echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_STATUS . '</b></nobr></td><td colspan="2" style="text-align:left;">' . $status . '</td></tr>';

    // Similar Keywords
    $other_query = 'SELECT id, keyword, query, visit, visit_tmp, hide FROM ' . $xoopsDB->prefix('myref_query') . '
  					WHERE id!=' . $myrow['id'] . "
                    AND query LIKE '%$keyword%'
                    AND keyword = " . $myrow['keyword'] . '
                    ORDER BY query';

    $other_result = $xoopsDB->queryF($other_query);

    echo '<tr><th style="align:center;"><b>' . _MD_MYREFERER_STATS_SIMILAR . '</b></th>';
    echo '    <th style="align:center;"><b>' . _MD_MYREFERER_STATS_ENTRYPAGE . '</b></th>';
    echo '    <th style="align:center;"><b>' . _MD_MYREFERER_STATS_SAMEPAGE . '</b></th>';
    echo '</tr><td style="text-align:left; vertical-align:top; ">';

    while (false !== ($other_myrow = $xoopsDB->fetchArray($other_result))) {
        if ($other_myrow['hide']) {
            $font_in = '<span style="color: #ff0000; ">';
        } else {
            $font_in = '<span style="color: #008000; ">';
        }
        echo '<a href="detail_keyword.php?id=' . $other_myrow['id'] . '">' . $font_in . $other_myrow['query'] . '</font></a> [' . $other_myrow['visit_tmp'] . '/<b>' . $other_myrow['visit'] . '</b>]<br> ';
    }

    // Same page
    $page_query = 'SELECT f.queryid, f.pagesid, m.id, m.page, f.visit, f.visit_tmp, m.hide FROM ' . $xoopsDB->prefix('myref_query_pages') . ' f LEFT JOIN ' . $xoopsDB->prefix('myref_pages') . ' m on f.pagesid = m.id
                  WHERE f.queryid = ' . $myrow['id'] . ' ORDER BY m.hide, m.page';

    $page_result = $xoopsDB->queryF($page_query);

    echo '</td><td style="text-align:left; vertical-align:top;">';
    while (false !== ($page_myrow = $xoopsDB->fetchArray($page_result))) {
        $pagesid[] = $page_myrow['pagesid'];

        if ($page_myrow['hide']) {
            $font_in = '<span style="color: #ff0000; ">';
        } else {
            $font_in = '<span style="color: #008000; ">';
        }
        preg_match('/(' . str_replace('/', "\/", XOOPS_URL) . ')(.*)/i', 'http://' . $page_myrow['page'], $pages);

        echo '<a target="thepage" href="http://' . $page_myrow['page'] . '">' . $font_in . $pages[2] . '</font></a> [' . $page_myrow['visit_tmp'] . '/<b>' . $page_myrow['visit'] . '</b>]<br> ';
    }

    // Same page keywords
    echo '</td><td style="text-align:left; vertical-align:top;">';

    $all_query = 'SELECT DISTINCT m.id, m.query, m.hide, sum(f.visit_tmp) AS visit_tmp, sum(f.visit) AS visit FROM ' . $xoopsDB->prefix('myref_query_pages') . ' f LEFT JOIN ' . $xoopsDB->prefix('myref_query') . ' m on f.queryid = m.id
                  WHERE f.pagesid in (' . implode(',', $pagesid) . ') AND
                  m.id!= ' . $myrow['id'] . ' AND
                  keyword=' . $myrow['keyword'] . '
                  GROUP BY m.id ORDER BY m.hide, m.query';

    $all_result = $xoopsDB->queryF($all_query);
    while (false !== ($all_myrow = $xoopsDB->fetchArray($all_result))) {
        if ($all_myrow['hide']) {
            $font_in = '<span style="color: #ff0000; ">';
        } else {
            $font_in = '<span style="color: #008000; ">';
        }

        echo '<a href="detail_keyword.php?id=' . $all_myrow['id'] . '">' . $font_in . $all_myrow['query'] . '</font></a> [' . $all_myrow['visit_tmp'] . '/<b>' . $all_myrow['visit'] . '</b>]<br> ';
    }

    echo '</tr>';
    echo '</table>';
} // if result

require_once __DIR__ . '/detail_footer.php';

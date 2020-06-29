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

// General settings
require_once __DIR__ . '/header.php';

$current = _MYREFERER_ROBOT;
$xoopsTpl->assign('current', _MYREFERER_ROBOT);
$xoopsTpl->assign('xoops_pagetitle', _MYREFERER_ROBOT);

if (Utility::checkRight(5)) {
    // Query : display referers or robots
    $sql = 'SELECT id, robots, ref_url, page, visit, startdate, date, hide
		FROM ' . $xoopsDB->prefix('myref_robots') . "
		WHERE hide = 0 $more
		ORDER BY $order";

    $result = $xoopsDB->queryF($sql, $xoopsModuleConfig['perpage'], $startart);
    while (list($id, $robots, $ref_url, $page, $visit, $startdate, $date, $hide) = $xoopsDB->fetchRow($result)) {
        $info = [];

        // Module icon
        // Popularity
        if ($visit > ($xoopsModuleConfig['tag_pop'] * 5)) {
            $pop = '&nbsp;<img src="images/icon/pop.gif" alt="' . $visit . ' ' . _READS . '">';
        } else {
            $pop = '';
        }

        // Recent
        $startingdate = (time() - (86400 * $new[0]));
        if ($startingdate < $date and $visit <= $new[1]) {
            $new_icon = '&nbsp;<img src="images/icon/new.gif" alt="">';
        } else {
            $new_icon = '';
        }

        $count++;
        $today  = time() - 86400;
        $recent = time() - (86400 * $new[0]);
        if ($date >= $recent) {
            $color  = '';
            $format = '';
        } else {
            $color  = $xoopsModuleConfig['toold'];
            $format = 'italic';
        }
        if ($date >= $today) {
            $color  = $xoopsModuleConfig['today'];
            $format = 'bold';
        }

        $robot_name = Utility::getRobotName($robots);
        $ref_url    = Utility::getRobotUrl($robots);

        // Display weekly stats about visits and limit number to 2
        $total_day = ($date - $startdate) / (60 * 60 * 24);
        $day_stat  = 0;
        if (0 != $total_day) {
            $day_stat = ($visit / $total_day);
            $tmp      = explode('.', $day_stat);
            if (count($tmp) > 1) {
                $tmp[1]   = '.' . mb_substr($tmp[1], 0, 2);
                $day_stat = abs($tmp[0] . $tmp[1]);
            }
        }

        // Compile results of query

        $info['id']          = $id;
        $info['count']       = $count;
        $info['referer']     = $robot_name;
        $info['alt_referer'] = $robots;
        $info['icon']        = $new_icon . $pop;
        $info['ref_url']     = $ref_url;
        $info['page']        = 'http://' . $page;
        if ($day_stat <= $visit and $day_stat > 0) {
            $info['visit'] = '<b>' . $visit . '</b><br><nobr>[' . $day_stat . '&nbsp;/&nbsp;' . _DAY . ']</nobr>';
        } else {
            $info['visit'] = '<b>' . $visit . '</b>';
        }
        $info['date'] = '<div style="color:' . $color . '; font-weight:' . $format . '">' . formatTimestamp($date, 'm') . '</div>';

        $xoopsTpl->append('infos', $info);
        unset($info);
    }

    // Query on counter result
    $result = $xoopsDB->queryF(
        'SELECT COUNT(id)
		FROM ' . $xoopsDB->prefix('myref_robots') . "
		WHERE hide = 0 $more"
    );

    [$numrows] = $xoopsDB->fetchRow($result);

    // Counter
    $xoopsTpl->assign('numrows', $count . ' / ' . $numrows . '&nbsp;' . $current);
    $pagenav = new \XoopsPageNav($numrows, $xoopsModuleConfig['perpage'], $startart, 'startart', 'ord=' . $ord . '&op=' . $op);
    $xoopsTpl->assign('pagenav', $pagenav->renderNav());
    $xoopsTpl->assign('navlink', 'spider.php?op=' . $op . '&startart=' . $startart);
    $xoopsTpl->assign('pages', _MYREFERER_PAGES);
} else {
    $xoopsTpl->assign('numrows', '');
}

// Admin link
if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
    $admin = '<a href="admin/clean.php"><img src="images/icon/trash.gif" alt="' . _DELETE . '"></a>&nbsp;
			  <a href="admin/stats_robots.php"><img src="images/icon/detail.gif" alt="' . _MYREFERER_STATS . '"></a>&nbsp;
			  <a href="admin/config.php"><img src="images/icon/config.gif" alt="' . _MYREFERER_CONFIG . '"></a>&nbsp;
	<a href="../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid') . '">
	<img src="images/icon/edit.gif" alt="' . _PREFERENCES . '"></a>';
} else {
    $admin = '';
}
$xoopsTpl->assign('admin', $admin);
// Admin link

require_once XOOPS_ROOT_PATH . '/footer.php';

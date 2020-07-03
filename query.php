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

if ($op) {
    $current = _MYREFERER_KEYWORD;
} else {
    $current = _MYREFERER_QUERY;
}
$xoopsTpl->assign('current', $current);
$xoopsTpl->assign('xoops_pagetitle', $current);
if ($op) {
    $current = '<a href="query.php?ord=alpha&op=' . $op . '">' . $current . '</a>';
} else {
    $current = '<a href="query.php?ord=alpha&op=' . $op . '">' . $current . '</a>';
}

if ((Utility::checkRight(3) && 1 == $op) || (Utility::checkRight(4) && 0 == $op)) {
    $form_letter  = '';
    $first_letter = '';
    // Query : display queries
    $sql = 'SELECT id, query, page, visit, startdate, date
		FROM ' . $xoopsDB->prefix('myref_query') . "
		WHERE keyword = $op $more $whereletter
		ORDER BY $order";

    $result = $xoopsDB->queryF($sql, $xoopsModuleConfig['perpage'], $startart);
    while (list($id, $query, $page, $visit, $startdate, $date) = $xoopsDB->fetchRow($result)) {
        $info = [];

        // Module icon
        // Popularity
        if ($visit > $xoopsModuleConfig['tag_pop']) {
            $pop = '&nbsp;<img src="images/icon/pop.gif" alt="' . $visit . ' ' . _READS . '">';
        } else {
            $pop = '';
        }

        // Recent
        $startingdate = time() - (86400 * $new[0]);
        if ($startingdate < $date and $visit <= $new[1]) {
            $new_icon = '&nbsp;<img src="images/icon/new.gif" alt="new">';
        } else {
            $new_icon = '';
        }

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

        if ('alpha' === $ord) {
            $letter = mb_strtolower(mb_substr($query, 0, 1));
            $letter = preg_replace('/&(.)(grave|acute|circ|cedil|ring|tilde|uml);/', 'e', $letter);
            $letter = strtr($letter, 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ', 'aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn');

            if ($letter != $form_letter) {
                $first_letter = '<h3>' . $letter . '</h3>';
                $visit        = '[' . $visit . '] ';
            } else {
                $first_letter = '';
                $visit        = '<br>[' . $visit . '] ';
            }
            $form_letter = $letter;
        } else {
            $count++;
        }

        if ($page) {
            $page = 'http://' . $page;
        }

        // Compile results of query
        $info['id']           = $id;
        $info['count']        = $count;
        $info['referer']      = $query;
        $info['first_letter'] = $first_letter;
        $info['ref_url']      = '';
        $info['page']         = $page;
        $info['icon']         = $new_icon . $pop;

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
		FROM ' . $xoopsDB->prefix('myref_query') . "
		WHERE keyword = $op $more"
    );

    [$numrows] = $xoopsDB->fetchRow($result);

    if ('alpha' === $ord) {
        $count = $numrows;
    }

    // Counter & page nav
    $xoopsTpl->assign('numrows', $count . ' / ' . $numrows . '&nbsp;' . $current);
    $xoopsTpl->assign('limit', $numrows / 4);
    $pagenav = new XoopsPageNav($numrows, $xoopsModuleConfig['perpage'], $startart, 'startart', 'ord=' . $ord);
    $xoopsTpl->assign('pagenav', $pagenav->renderNav());
    $xoopsTpl->assign('navlink', 'query.php?op=' . $op . '&startart=' . $startart);
    $xoopsTpl->assign('pages', '<a href="query.php?ord=alpha">' . _MYREFERER_PAGES . '</a>');
} else {
    $xoopsTpl->assign('numrows', '');
}

// Admin link
if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
    $admin = '<a href="admin/clean.php"><img src="images/icon/trash.gif" alt="' . _DELETE . '"></a>&nbsp;';
    if (1 == $op) {
        $admin .= '<a href="admin/stats_keyword.php"><img src="images/icon/detail.gif" alt="' . _MYREFERER_STATS . '"></a>&nbsp;';
    } else {
        $admin .= '<a href="admin/stats_query.php"><img src="images/icon/detail.gif" alt="' . _MYREFERER_STATS . '"></a>&nbsp;';
    }
    $admin .= '<a href="admin/config.php"><img src="images/icon/config.gif" alt="' . _MYREFERER_CONFIG . '"></a>&nbsp;
	<a href="../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid') . '">
	<img src="images/icon/edit.gif" alt="' . _PREFERENCES . '"></a>';
} else {
    $admin = '';
}
$xoopsTpl->assign('admin', $admin);
// Admin link

require_once XOOPS_ROOT_PATH . '/footer.php';

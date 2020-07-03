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
    $current = _MYREFERER_ENGINE;
} else {
    $current = _MYREFERER_REFERER;
}
$xoopsTpl->assign('current', $current);
$xoopsTpl->assign('xoops_pagetitle', $current);

if ((Utility::checkRight(1) && 1 == $op) || (Utility::checkRight(2) && 0 == $op)) {
    // Query : display referers or engine
    $sql = 'SELECT id, engine, referer, ref_url, page, visit, startdate, date, hide
		FROM ' . $xoopsDB->prefix('myref_referer') . "
		WHERE engine = $op $more
		ORDER BY $order";

    $result = $xoopsDB->queryF($sql, $xoopsModuleConfig['perpage'], $startart);
    while (list($id, $engine, $referer, $ref_url, $page, $visit, $startdate, $date, $hide) = $xoopsDB->fetchRow($result)) {
        $info = [];

        // Module icon
        // Popularity
        if ($visit > $xoopsModuleConfig['tag_pop']) {
            $pop = '&nbsp;<img src="images/icon/pop.gif" alt="' . $visit . ' ' . _READS . '">';
        } else {
            $pop = '';
        }

        // Recent
        $startingdate = (time() - (86400 * $new[0]));
        if ($startingdate < $date and $visit <= $new[1]) {
            $new_icon = '&nbsp;<img src="images/icon/new.gif" alt="new">';
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

        // Keywords
        $url_array = parse_url($ref_url);
        if (array_key_exists('query', $url_array)) {
            parse_str($url_array['query'], $variables);
        }

        $variables['p']         = $variables['p'] ?? '';
        $variables['q']         = $variables['q'] ?? '';
        $variables['searchfor'] = $variables['searchfor'] ?? '';
        $variables['keywords']  = $variables['keywords'] ?? '';
        $variables['query']     = $variables['query'] ?? '';

        if ($variables['p'] or $variables['q'] or $variables['keywords'] or $variables['query'] or $variables['searchfor']) {
            // les mots clé se trouvent dans l'url
            $keywords1 = urldecode($variables['q']);
            $keywords2 = urldecode($variables['p']);
            $keywords3 = urldecode($variables['searchfor']);
            $keywords4 = urldecode($variables['query']);
            $keywords5 = urldecode($variables['keywords']);
            $infos     = $keywords1 . $keywords2 . $keywords3 . $keywords4 . $keywords5;
        } else {
            $infos = $ref_url;
        }

        // Compile results of query
        $info['id']          = $id;
        $info['count']       = $count;
        $info['engine']      = $engine;
        $info['icon']        = $new_icon . $pop;
        $info['referer']     = $referer;
        $info['alt_referer'] = $infos;
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
		FROM ' . $xoopsDB->prefix('myref_referer') . "
		WHERE engine = $op $more"
    );

    [$numrows] = $xoopsDB->fetchRow($result);

    // Counter
    $xoopsTpl->assign('numrows', $count . ' / ' . $numrows . '&nbsp;' . $current);
    $pagenav = new XoopsPageNav($numrows, $xoopsModuleConfig['perpage'], $startart, 'startart', 'ord=' . $ord . '&op=' . $op);
    $xoopsTpl->assign('pagenav', $pagenav->renderNav());
    $xoopsTpl->assign('navlink', 'referer.php?op=' . $op . '&startart=' . $startart);
    $xoopsTpl->assign('pages', _MYREFERER_PAGES);
} else {
    $xoopsTpl->assign('numrows', '');
}

// Admin link
if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
    $admin = '<a href="admin/clean.php"><img src="images/icon/trash.gif" alt="' . _DELETE . '"></a>&nbsp;';
    $admin .= '<a href="admin/stats_referer.php?engine=' . $op . '"><img src="images/icon/detail.gif" alt="' . _MYREFERER_STATS . '"></a>&nbsp;';
    $admin .= '<a href="admin/config.php"><img src="images/icon/config.gif" alt="' . _MYREFERER_CONFIG . '"></a>&nbsp;
	<a href="../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid') . '">
	<img src="images/icon/edit.gif" alt="' . _PREFERENCES . '"></a>';
} else {
    $admin = '';
}
$xoopsTpl->assign('admin', $admin);
// Admin link

require_once XOOPS_ROOT_PATH . '/footer.php';

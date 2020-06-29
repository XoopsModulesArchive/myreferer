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
$xoopsTpl->assign('current', _MYREFERER_SUMMARY);
$xoopsTpl->assign('xoops_pagetitle', _MYREFERER_SUMMARY);

if (Utility::checkRight(1)) {
    // Referer
    // Query : display referers or engine
    $sql_referer = 'SELECT id, engine, referer, ref_url, page, visit, date
		FROM ' . $xoopsDB->prefix('myref_referer') . "
		WHERE engine = 0 AND referer != '' $more
		ORDER BY $order";

    $result = $xoopsDB->queryF($sql_referer, 10, 0);
    while (list($id, $engine, $referer, $ref_url, $page, $visit, $date) = $xoopsDB->fetchRow($result)) {
        $info_referer = [];

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

        // Compile results of query

        $info_referer['id']          = $id;
        $info_referer['count']       = $count;
        $info_referer['engine']      = $engine;
        $info_referer['referer']     = $referer;
        $info_referer['alt_referer'] = $ref_url;
        $info_referer['ref_url']     = $ref_url;
        $info_referer['page']        = 'http://' . $page;
        $info_referer['visit']       = $visit;
        $info_referer['date']        = '<div style="color:' . $color . '; font-weight:' . $format . '">' . formatTimestamp($date, 'm') . '</div>';
        $xoopsTpl->append('infos_referer', $info_referer);
        unset($info_referer);
    }

    // Query on counter result
    $count_referer = $xoopsDB->queryF(
        'SELECT COUNT(id)
		FROM ' . $xoopsDB->prefix('myref_referer') . "
		WHERE engine = 0 AND referer != '' $more"
    );

    [$numrows] = $xoopsDB->fetchRow($count_referer);

    // Counter
    $xoopsTpl->assign('numrows_referer', $numrows);
} else {
    $xoopsTpl->assign('numrows_referer', '');
}

if (Utility::checkRight(2)) {
    $count = 0;
    // Engine
    // Query : display referers or engine
    $sql_referer = 'SELECT id, engine, referer, ref_url, page, visit, date
		FROM ' . $xoopsDB->prefix('myref_referer') . "
		WHERE engine = 1 AND referer != '' $more
		ORDER BY $order";

    $result = $xoopsDB->queryF($sql_referer, 10, 0);
    while (list($id, $engine, $referer, $ref_url, $page, $visit, $date) = $xoopsDB->fetchRow($result)) {
        $info_engine = [];

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
        $info_engine['id']          = $id;
        $info_engine['count']       = $count;
        $info_engine['referer']     = $referer;
        $info_engine['alt_referer'] = $infos;
        $info_engine['ref_url']     = $ref_url;
        $info_engine['page']        = 'http://' . $page;
        $info_engine['visit']       = $visit;
        $info_engine['date']        = '<div style="color:' . $color . '; font-weight:' . $format . '">' . formatTimestamp($date, 'm') . '</div>';
        $xoopsTpl->append('infos_engine', $info_engine);
        unset($info_engine);
    }

    // Query on counter result
    $count_referer = $xoopsDB->queryF(
        'SELECT COUNT(id)
		FROM ' . $xoopsDB->prefix('myref_referer') . "
		WHERE engine = 1 AND referer != '' $more"
    );
    [$numrows] = $xoopsDB->fetchRow($count_referer);
    // Counter
    $xoopsTpl->assign('numrows_engine', $numrows);
} else {
    $xoopsTpl->assign('numrows_engine', '');
}

if (Utility::checkRight(3)) {
    $count = 0;
    // Queries
    // Query : display referers or engine
    $sql_query = 'SELECT id, query, visit, date
		FROM ' . $xoopsDB->prefix('myref_query') . "
		WHERE keyword=1 AND query != '' $more
		ORDER BY $order";
    $result    = $xoopsDB->queryF($sql_query, 10, 0);
    while (list($id, $query, $visit, $date) = $xoopsDB->fetchRow($result)) {
        $info_keywords = [];

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

        // Compile results of query
        $info_keywords['id']      = $id;
        $info_keywords['count']   = $count;
        $info_keywords['referer'] = $query;
        //		$info_keywords['referer'] = mb_convert_encoding($query, "", "auto");
        $info_keywords['visit'] = $visit;
        $info_keywords['date']  = '<div style="color:' . $color . '; font-weight:' . $format . '">' . formatTimestamp($date, 'm') . '</div>';
        $xoopsTpl->append('infos_keyword', $info_keywords);
        unset($info_query);
    }

    // Query on counter result
    $count_keywords = $xoopsDB->queryF(
        'SELECT COUNT(id)
		FROM ' . $xoopsDB->prefix('myref_query') . "
		WHERE keyword=1 AND query != '' $more"
    );

    [$numrows] = $xoopsDB->fetchRow($count_keywords);

    // Counter
    $xoopsTpl->assign('numrows_keyword', $numrows);
} else {
    $xoopsTpl->assign('numrows_keyword', '');
}

if (Utility::checkRight(4)) {
    $count = 0;
    // Queries
    // Query : display referers or engine
    $sql_query = 'SELECT id, query, visit, date
		FROM ' . $xoopsDB->prefix('myref_query') . "
		WHERE keyword=0 AND query != '' $more
		ORDER BY $order";
    $result    = $xoopsDB->queryF($sql_query, 10, 0);
    while (list($id, $query, $visit, $date) = $xoopsDB->fetchRow($result)) {
        $info_query = [];

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

        // Compile results of query
        $info_query['id']      = $id;
        $info_query['count']   = $count;
        $info_query['referer'] = $query;
        //		$info_query['referer'] = mb_convert_encoding($query, "", "auto");
        $info_query['visit'] = $visit;
        $info_query['date']  = '<div style="color:' . $color . '; font-weight:' . $format . '">' . formatTimestamp($date, 'm') . '</div>';
        $xoopsTpl->append('infos_query', $info_query);
        unset($info_query);
    }

    // Query on counter result
    $count_query = $xoopsDB->queryF(
        'SELECT COUNT(id)
		FROM ' . $xoopsDB->prefix('myref_query') . "
		WHERE keyword=0 AND query != '' $more"
    );

    [$numrows] = $xoopsDB->fetchRow($count_query);

    // Counter
    $xoopsTpl->assign('numrows_query', $numrows);
} else {
    $xoopsTpl->assign('numrows_query', '');
}

if (Utility::checkRight(5)) {
    $count = 0;
    // Bots
    // Query : display referers or engine
    $sql_robots = 'SELECT id, robots, visit, date
		FROM ' . $xoopsDB->prefix('myref_robots') . "
		WHERE robots != '' $more
		ORDER BY $order";

    $result = $xoopsDB->queryF($sql_robots, 10, 0);
    while (list($id, $robots, $visit, $date) = $xoopsDB->fetchRow($result)) {
        $info_robots = [];

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

        // Compile results of robots
        $info_robots['id']          = $id;
        $info_robots['count']       = $count;
        $info_robots['referer']     = $robot_name;
        $info_robots['alt_referer'] = $robots;
        $info_robots['ref_url']     = $ref_url;
        $info_robots['visit']       = $visit;
        $info_robots['date']        = '<div style="color:' . $color . '; font-weight:' . $format . '">' . formatTimestamp($date, 'm') . '</div>';
        $xoopsTpl->append('infos_robots', $info_robots);
        unset($info_robots);
    }

    // Query on counter result
    $count_robots = $xoopsDB->queryF(
        'SELECT COUNT(id)
		FROM ' . $xoopsDB->prefix('myref_robots') . "
		WHERE robots != '' $more"
    );
    [$numrows] = $xoopsDB->fetchRow($count_robots);

    // Counter
    $xoopsTpl->assign('numrows_robots', $numrows);
} else {
    $xoopsTpl->assign('numrows_robots', '');
}

if (Utility::checkRight(6)) {
    $count = 0;
    // Pages
    // Query : display referers or engine
    $sql_pages = 'SELECT id, page, visit, date
		FROM ' . $xoopsDB->prefix('myref_pages') . "
		WHERE page != '' $more
		ORDER BY $order";

    $result = $xoopsDB->queryF($sql_pages, 10, 0);
    while (list($id, $pages, $visit, $date) = $xoopsDB->fetchRow($result)) {
        $info_pages = [];

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

        preg_match('/(' . str_replace('/', "\/", XOOPS_URL) . ')(.*)/i', 'http://' . $pages, $mypage);
        $page_name = $mypage[2];
        $ref_url   = 'http://' . $pages;

        // Compile results of pages
        $info_pages['id']          = $id;
        $info_pages['count']       = $count;
        $info_pages['referer']     = $ref_url;
        $info_pages['alt_referer'] = $page_name;
        $info_pages['ref_url']     = $ref_url;
        $info_pages['visit']       = $visit;
        $info_pages['date']        = '<div style="color:' . $color . '; font-weight:' . $format . '">' . formatTimestamp($date, 'm') . '</div>';
        $xoopsTpl->append('infos_pages', $info_pages);
        unset($info_pages);
    }

    // Query on counter result
    $count_pages = $xoopsDB->queryF(
        'SELECT COUNT(id)
		FROM ' . $xoopsDB->prefix('myref_pages') . "
		WHERE page != '' $more"
    );
    [$numrows] = $xoopsDB->fetchRow($count_pages);

    // Counter
    $xoopsTpl->assign('numrows_pages', $numrows);
} else {
    $xoopsTpl->assign('numrows_pages', '');
}

if (Utility::checkRight(7)) {
    $count = 0;
    global $XoopsUser;
    // Users
    // Query : display users
    $sql_users = 'SELECT id, user, visit, date
		FROM ' . $xoopsDB->prefix('myref_users') . "
		WHERE user != '' $more
		ORDER BY $order";

    $result = $xoopsDB->queryF($sql_users, 10, 0);
    while (list($id, $users, $visit, $date) = $xoopsDB->fetchRow($result)) {
        $info_users = [];

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

        //		$robot_name = Utility::getRobotName($users);
        //		$ref_url = Utility::getRobotUrl($users);

        // Compile results of users
        $info_users['id']          = $id;
        $info_users['count']       = $count;
        $info_users['referer']     = \XoopsUser::getUnameFromId($users);
        $info_users['alt_referer'] = $users;
        $info_users['ref_url']     = XOOPS_URL . '/userinfo.php?uid=' . $users;
        $info_users['visit']       = $visit;
        $info_users['date']        = '<div style="color:' . $color . '; font-weight:' . $format . '">' . formatTimestamp($date, 'm') . '</div>';
        $xoopsTpl->append('infos_users', $info_users);
        unset($info_users);
    }

    // Query on counter result
    $count_users = $xoopsDB->queryF(
        'SELECT COUNT(id)
		FROM ' . $xoopsDB->prefix('myref_users') . "
		WHERE user != '' $more"
    );
    [$numrows] = $xoopsDB->fetchRow($count_users);

    // Counter
    $xoopsTpl->assign('numrows_users', $numrows);
} else {
    $xoopsTpl->assign('numrows_users', '');
}

require_once XOOPS_ROOT_PATH . '/footer.php';

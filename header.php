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

use XoopsModules\Myreferer\Helper;
use XoopsModules\Myreferer\Utility;

include __DIR__ . '/preloads/autoloader.php';

require dirname(dirname(__DIR__)) . '/mainfile.php';
require XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

$moduleDirName = basename(__DIR__);

$helper = Helper::getInstance();

$modulePath = XOOPS_ROOT_PATH . '/modules/' . $moduleDirName;

$myts = \MyTextSanitizer::getInstance();

// Load language files
$helper->loadLanguage('main');

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    require $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new XoopsTpl();
}

// New options
$new = explode('|', $xoopsModuleConfig['tag_new']);
if (count($new) < 2) {
    $new[0] = 7;
    $new[1] = 1;
}
$more = 'AND hide = 0 AND visit >= ' . $new[1];

// Module Banner
if ($xoopsModuleConfig['banner']) {
    $banner = '<img src="images/banner.gif" alt="' . $xoopsModule->getVar('name') . '">';
} else {
    $banner = '';
}

$startart = isset($_GET['startart']) ? (int)$_GET['startart'] : 0;
$display  = isset($_GET['display']) ? (int)$_GET['display'] : 0;
$op       = isset($_GET['op']) ? (int)$_GET['op'] : 0;
$ord      = $_GET['ord'] ?? $xoopsModuleConfig['order'];
$letter   = $_GET['letter'] ?? _ALL;

// Navigation links
if ('alpha' === $ord) {
    $nav_referer = 'referer.php?ord=' . $xoopsModuleConfig['order'] . '&op=0';
    $nav_engine  = 'referer.php?ord=' . $xoopsModuleConfig['order'] . '&op=1';
    $nav_keyword = 'query.php?ord=' . $xoopsModuleConfig['order'] . '&op=1';
    $nav_query   = 'query.php?ord=' . $xoopsModuleConfig['order'] . '&op=0';
    $nav_robot   = 'spider.php?ord=' . $xoopsModuleConfig['order'];
    $nav_users   = 'users.php?ord=' . $xoopsModuleConfig['order'];
    $nav_page    = 'page.php?ord=' . $xoopsModuleConfig['order'];

    $GLOBALS['xoopsOption']['template_main'] = 'myreferer_alpha.html';
    $xoopsModuleConfig['perpage']            = '0';
    $startart                                = '0';

    //    $xoopsTpl->assign("nav_letters", 'test');
    $xoopsTpl->assign('nav_letters', Utility::letters($letter, $op));
    if (_ALL == $letter) {
        $whereletter = '';
    } elseif (_MYREFERER_OTHERS == $letter) {
        $whereletter = '';
        for ($i = 48; $i <= 57; $i++) {
            $whereletter .= " AND query NOT LIKE '" . chr($i) . "%'";
        }
        for ($i = 65; $i <= 90; $i++) {
            $whereletter .= " AND query NOT LIKE '" . chr($i) . "%'";
        }
    } else {
        $whereletter = " AND query LIKE '$letter%'";
    }
} else {
    $nav_referer = 'referer.php?ord=' . $ord . '&op=0';
    $nav_engine  = 'referer.php?ord=' . $ord . '&op=1';
    $nav_keyword = 'query.php?ord=' . $ord . '&op=1';
    $nav_query   = 'query.php?ord=' . $ord . '&op=0';
    $nav_robot   = 'spider.php?ord=' . $ord;
    $nav_users   = 'users.php?ord=' . $ord;
    $nav_page    = 'page.php?ord=' . $ord;

    if ('index.php' === basename($_SERVER['SCRIPT_NAME'])) {
        $GLOBALS['xoopsOption']['template_main'] = 'myreferer_summary.html';
    } else {
        $GLOBALS['xoopsOption']['template_main'] = 'myreferer_index.html';
    }
}

$nav_index = 'index.php';

$count = $startart;

if ('visit' === $ord) {
    $order = 'visit DESC';
}
if ('alpha' === $ord) {
    $order = 'query ASC';
}
if ('date' === $ord) {
    $order = 'date DESC';
}

switch (basename($_SERVER['SCRIPT_NAME'])) {
    case 'referer.php':
        if ('referer' === $ord) {
            $order = 'referer ASC';
        }
        break;
    case 'spider.php':
        if ('referer' === $ord) {
            $order = 'robots ASC';
        }
        break;
    case 'query.php':
        if ('referer' === $ord) {
            $order = 'query ASC';
        }
        break;
    case 'page.php':
        if ('referer' === $ord) {
            $order = 'page ASC';
        }
        break;
    case 'users.php':
        if ('referer' === $ord) {
            $order = 'user ASC';
        }
        break;
}

$xoopsTpl->assign('nav_referer', $nav_referer);
$xoopsTpl->assign('nav_engine', $nav_engine);
$xoopsTpl->assign('nav_keyword', $nav_keyword);
$xoopsTpl->assign('nav_query', $nav_query);
$xoopsTpl->assign('nav_robot', $nav_robot);
$xoopsTpl->assign('nav_users', $nav_users);
$xoopsTpl->assign('nav_page', $nav_page);
$xoopsTpl->assign('nav_index', $nav_index);

// Various Header informations
$xoopsTpl->assign('banner', $banner);
$xoopsTpl->assign('title', $myts->displayTarea($xoopsModule->getVar('name')));
$xoopsTpl->assign('text', $myts->displayTarea($xoopsModuleConfig['text']));

// Language datas
$xoopsTpl->assign('referer', _MYREFERER_REFERER);
$xoopsTpl->assign('engine', _MYREFERER_ENGINE);
$xoopsTpl->assign('query', _MYREFERER_QUERY);
$xoopsTpl->assign('keyword', _MYREFERER_KEYWORD);
$xoopsTpl->assign('robot', _MYREFERER_ROBOT);
$xoopsTpl->assign('users', _MYREFERER_USERS);
$xoopsTpl->assign('page', _MYREFERER_PAGE);
$xoopsTpl->assign('visit', _MYREFERER_VISIT);
$xoopsTpl->assign('date', _MYREFERER_DATE);
$xoopsTpl->assign('more', _MYREFERER_MORE);
$xoopsTpl->assign('summary', _MYREFERER_SUMMARY);

if (Utility::checkRight(1)) {
    $xoopsTpl->assign('numrows_referer', '1');
}
if (Utility::checkRight(2)) {
    $xoopsTpl->assign('numrows_engine', '1');
}
if (Utility::checkRight(3)) {
    $xoopsTpl->assign('numrows_keyword', '1');
}
if (Utility::checkRight(4)) {
    $xoopsTpl->assign('numrows_query', '1');
}
if (Utility::checkRight(5)) {
    $xoopsTpl->assign('numrows_robots', '1');
}
if (Utility::checkRight(6)) {
    $xoopsTpl->assign('numrows_pages', '1');
}
if (Utility::checkRight(7)) {
    $xoopsTpl->assign('numrows_users', '1');
}

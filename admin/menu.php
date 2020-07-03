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

use Xmf\Module\Admin;
use XoopsModules\Myreferer\Helper;

include dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
$helper = Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

$pathIcon32 = Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    //    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
    $pathModIcon32 = $helper->url($helper->getModule()->getInfo('modicons32'));
}

$adminmenu[] = [
    'title' => _MI_MYREFERER_MENU_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => _MI_MYREFERER_ADMIN,
    'link'  => 'admin/main.php',
    'icon'  => $pathIcon32 . '/dashboard.png',
];

$adminmenu[] = [
    'title' => _MI_MYREFERER_USERVISIT,
    'link'  => 'admin/stats_visitors.php',
    'icon'  => $pathIcon32 . '/users.png',
];

$adminmenu[] = [
    'title' => _MI_MYREFERER_CONFIG,
    'link'  => 'admin/config.php',
    'icon'  => $pathIcon32 . '/manage.png',
];

$adminmenu[] = [
    'title' => _MI_MYREFERER_META,
    'link'  => 'admin/meta.php',
    'icon'  => $pathIcon32 . '/type.png',
];

$adminmenu[] = [
    'title' => _MI_MYREFERER_CLEAN,
    'link'  => 'admin/clean.php',
    'icon'  => $pathIcon32 . '/exec.png',
];

$adminmenu[] = [
    'title' => _MI_MYREFERER_STATS,
    'link'  => 'admin/stats.php',
    'icon'  => $pathIcon32 . '/stats.png',
];

$adminmenu[] = [
    'title' => _MI_MYREFERER_PERMS,
    'link'  => 'admin/permissions.php',
    'icon'  => $pathIcon32 . '/permissions.png',
];

// Blocks Admin

$adminmenu[] = [
    'title' => _MI_MYREFERER_BLOCKS,
    'link'  => 'admin/myblocksadmin.php',
    'icon'  => $pathIcon32 . '/block.png',
];

$adminmenu[] = [
    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS'),
    'link'  => 'admin/blocksadmin.php',
    'icon'  => $pathIcon32 . '/block.png',
];

$adminmenu[] = [
    'title' => _MI_MYREFERER_MENU_ABOUT,
    'link' => 'admin/about.php',
    'icon' => $pathIcon32 . '/about.png',
];


//-------------- headermenu -------------------//

if (isset($xoopsModule)) {
    $headermenu[] = [
        'title' => _PREFERENCES,
        'link'  => '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid'),
    ];

    $headermenu[] = [
        'title' => _MD_MYREFERER_INDEX,
        'link'  => XOOPS_URL . '/modules/myreferer/',
    ];

    $headermenu[] = [
        'title' => _MD_MYREFERER_UPDATE_MODULE,
        'link'  => XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $xoopsModule->getVar('dirname'),
    ];

    $headermenu[] = [
        'title' => _MI_MYREFERER_HELP,
        'link'  => 'help.php',
    ];
}

//-------------- statmenu -------------------//

$statmenu[] = [
    'title' => _MI_MYREFERER_PAGES,
    'link'  => 'admin/stats_pages.php',
];

$statmenu[] = [
    'title' => _MI_MYREFERER_KEYWORDS,
    'link'  => 'admin/stats_keyword.php',
];

$statmenu[] = [
    'title' => _MI_MYREFERER_QUERY,
    'link'  => 'admin/stats_query.php',
];

$statmenu[] = [
    'title' => _MI_MYREFERER_ROBOTS,
    'link'  => 'admin/stats_robots.php',
];

$statmenu[] = [
    'title' => _MI_MYREFERER_REFERER,
    'link'  => 'admin/stats_referer.php?engine=0',
];

$statmenu[] = [
    'title' => _MI_MYREFERER_ENGINE,
    'link'  => 'admin/stats_referer.php?engine=1',
];

$statmenu[] = [
    'title' => _MI_MYREFERER_BYMODULE_KEYWORD,
    'link'  => 'admin/stats_modules.php?keyword=1',
];

$statmenu[] = [
    'title' => _MI_MYREFERER_BYMODULE_QUERY,
    'link'  => 'admin/stats_modules.php?keyword=0',
];

$statmenu[] = [
    'title' => _MI_MYREFERER_BYREFERER,
    'link'  => 'admin/stats_modules_referer.php',

];

//-------------- metamenu -------------------//
$metamenu[] = [
    ['title' => _MI_MYREFERER_DATE, 'link' => 'admin/meta.php?ord=date&meta_limit=100',],
    ['title' => _MI_MYREFERER_NEW, 'link' => 'admin/meta.php?ord=new&meta_limit=100',],
    ['title' => _MI_MYREFERER_TOP, 'link' => 'admin/meta.php?ord=visit&meta_limit=100',],
    ['title' => _MI_MYREFERER_POP, 'link' => 'admin/meta.php?ord=pop&meta_limit=100',],
    ['title' => _MI_MYREFERER_RANDOM, 'link' => 'admin/meta.php?ord=random&meta_limit=100',],
];


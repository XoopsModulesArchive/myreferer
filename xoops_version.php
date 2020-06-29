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

$moduleDirName      = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

// ------------------- Informations ------------------- //
$modversion = [
    'version'             => 3.01,
    'module_status'       => 'Alpha 8',
    'release_date'        => '2020/06/28',
    'name'                => _MI_MYREFERER_NAME,
    'description'         => _MI_MYREFERER_DSC,
    'official'            => 0,
    //1 indicates official XOOPS module supported by XOOPS Dev Team, 0 means 3rd party supported
    'author'              => 'Solo, DuGris, Mamba, Zyspec',
    'credits'             => 'XOOPS Development Team',
    'author_mail'         => 'author-email',
    'author_website_url'  => 'https://xoops.org',
    'author_website_name' => 'XOOPS',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html/',
    // ------------------- Folders & Files -------------------
    'release_info'        => 'Changelog',
    'release_file'        => XOOPS_URL . "/modules/$moduleDirName/docs/changelog.txt",

    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . "/modules/$moduleDirName/docs/install.txt",
    // images
    'image'               => 'assets/images/logoModule.png',
    'dirname'             => $moduleDirName,
    //Frameworks
    //    'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
    //    'sysicons16'          => 'Frameworks/moduleclasses/icons/16',
    //    'sysicons32'          => 'Frameworks/moduleclasses/icons/32',
    // Local path icons
    'modicons16'          => 'assets/images/icons/16',
    'modicons32'          => 'assets/images/icons/32',
    //About
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb/viewforum.php?forum=28/',
    'support_name'        => 'Support Forum',
    'submit_bug'          => 'https://github.com/XoopsModules25x/' . $moduleDirName . '/issues',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    // ------------------- Min Requirements -------------------
    'min_php'             => '7.1',
    'min_xoops'           => '2.5.10',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.5'],
    // ------------------- Admin Menu -------------------
    'system_menu'         => 1,
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // ------------------- Main Menu -------------------
    'hasMain'             => 1,
    // ------------------- Install/Update -------------------
    'onInstall'           => 'include/oninstall.php',
    'onUpdate'            => 'include/onupdate.php',
    //  'onUninstall'         => 'include/onuninstall.php',
    // -------------------  PayPal ---------------------------
    'paypal'              => [
        'business'      => 'xoopsfoundation@gmail.com',
        'item_name'     => 'Donation : ' . _MI_MYREFERER_NAME,
        'amount'        => 0,
        'currency_code' => 'USD',
    ],
    // ------------------- Search ---------------------------
    'hasSearch'           => 1,
    'search'              => [
        'file' => 'include/search.inc.php',
        'func' => 'pedigree_search',
    ],
    // ------------------- Comments -------------------------
    'hasComments'         => 1,
    'comments'            => [
        'pageName'     => 'dog.php',
        'itemName'     => 'id',
        'callbackFile' => 'include/comment_functions.php',
        'callback'     => [
            'approve' => 'picture_comments_approve',
            'update'  => 'picture_comments_update',
        ],
    ],
    // ------------------- Mysql -----------------------------
    'sqlfile'             => ['mysql' => 'sql/mysql.sql'],
    // ------------------- Tables ----------------------------
    'tables'              => [
        $moduleDirName . '_' . 'config',
        $moduleDirName . '_' . 'pages',
        $moduleDirName . '_' . 'pages_stats',
        $moduleDirName . '_' . 'referer',
        $moduleDirName . '_' . 'referer_pages',
        $moduleDirName . '_' . 'referer_pages_stats',
        $moduleDirName . '_' . 'referer_stats',
        $moduleDirName . '_' . 'robots',
        $moduleDirName . '_' . 'robots_pages',
        $moduleDirName . '_' . 'robots_pages_stats',
        $moduleDirName . '_' . 'myref_robots_stats',
        $moduleDirName . '_' . 'myref_query',
        $moduleDirName . '_' . 'myref_query_pages',
        $moduleDirName . '_' . 'myref_query_pages_stats',
        $moduleDirName . '_' . 'myref_query_stats',
        $moduleDirName . '_' . 'myref_users',
        $moduleDirName . '_' . 'myref_users_stats',
        $moduleDirName . '_' . 'myref_users_pages',
        $moduleDirName . '_' . 'myref_users_pages_stats',
    ],
];

// ------------------- Templates ------------------- //

$modversion['templates'][] = [
    ['file' => 'myreferer_head.tpl', 'description' => ''],
    ['file' => 'myreferer_foot.tpl', 'description' => ''],
    ['file' => 'myreferer_index.tpl', 'description' => ''],
    ['file' => 'myreferer_summary.tpl', 'description' => ''],
    ['file' => 'myreferer_alpha.tpl', 'description' => ''],
];

// ------------------- Help files ------------------- //
$modversion['help']        = 'page=help';
$modversion['helpsection'] = [
    ['name' => _MI_MYREFERER_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_MYREFERER_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_MYREFERER_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_MYREFERER_SUPPORT, 'link' => 'page=support'],
];

// ------------------- Submenus ------------------- //
global $xoopsUser, $xoopsModule, $xoopsModuleConfig;
if ($xoopsModule && 'myreferer' === $xoopsModule->getVar('dirname')) {
    $subcount = 1;
    if (Utility::checkRight(1)) {
        $modversion['sub'][$subcount]['name'] = _MI_MYREFERER_REFERER;
        $modversion['sub'][$subcount]['url']  = 'referer.php?op=0';
        $subcount++;
    }
    if (Utility::checkRight(2)) {
        $modversion['sub'][$subcount]['name'] = _MI_MYREFERER_ENGINE;
        $modversion['sub'][$subcount]['url']  = 'referer.php?op=1';
        $subcount++;
    }
    if (Utility::checkRight(3)) {
        $modversion['sub'][$subcount]['name'] = _MI_MYREFERER_KEYWORDS;
        $modversion['sub'][$subcount]['url']  = 'query.php';
        $subcount++;
    }
    if (Utility::checkRight(4)) {
        $modversion['sub'][$subcount]['name'] = _MI_MYREFERER_QUERY;
        $modversion['sub'][$subcount]['url']  = 'query.php';
        $subcount++;
    }
    if (Utility::checkRight(5)) {
        $modversion['sub'][$subcount]['name'] = _MI_MYREFERER_ROBOTS;
        $modversion['sub'][$subcount]['url']  = 'spider.php';
        $subcount++;
    }

    $modversion['sub'][$subcount]['name'] = _MI_MYREFERER_ALPHA;
    $modversion['sub'][$subcount]['url']  = 'query.php?ord=alpha';
    $subcount++;
}

// ------------------- Blocks ------------------- //
$modversion['blocks'][] = [
    'file'        => 'block.php',
    'name'        => _MI_MYREFERER_BLOC_ALLINFO,
    'description' => '',
    'show_func'   => 'a_myrefererAll_show',
    'edit_func'   => 'a_myrefererAll_edit',
    'options'     => '1,2,3,4,5,6|new|3|10|0',
    'template'    => 'myreferer_block_01.tpl',

];

$modversion['blocks'][] = [
    'file'        => 'block.php',
    'name'        => _MI_MYREFERER_BLOC_REFERER,
    'description' => '',
    'show_func'   => 'a_myreferer_show',
    'edit_func'   => 'a_myreferer_edit',
    'options'     => 'referer|new|3|10|20',
    'template'    => 'myreferer_block_02.tpl',

];

$modversion['blocks'][] = [
    'file'        => 'block.php',
    'name'        => _MI_MYREFERER_BLOC_ENGINE,
    'description' => '',
    'show_func'   => 'a_myreferer_show',
    'edit_func'   => 'a_myreferer_edit',
    'options'     => 'engine|new|3|10|20',
    'template'    => 'myreferer_block_02.tpl',

];

$modversion['blocks'][] = [
    'file'        => 'block.php',
    'name'        => _MI_MYREFERER_BLOC_KEYWORD,
    'description' => '',
    'show_func'   => 'a_myreferer_show',
    'edit_func'   => 'a_myreferer_edit',
    'options'     => 'keyword|new|3|10|20',
    'template'    => 'myreferer_block_02.tpl',

];

$modversion['blocks'][] = [
    'file'        => 'block.php',
    'name'        => _MI_MYREFERER_BLOC_QUERY,
    'description' => '',
    'show_func'   => 'a_myreferer_show',
    'edit_func'   => 'a_myreferer_edit',
    'options'     => 'query|new|3|10|20',
    'template'    => 'myreferer_block_02.tpl',

];

$modversion['blocks'][] = [
    'file'        => 'block.php',
    'name'        => _MI_MYREFERER_BLOC_ROBOTS,
    'description' => '',
    'show_func'   => 'a_myreferer_show',
    'edit_func'   => 'a_myreferer_edit',
    'options'     => 'robots|new|3|10|20',
    'template'    => 'myreferer_block_02.tpl',

];

$modversion['blocks'][] = [
    'file'        => 'block.php',
    'name'        => _MI_MYREFERER_BLOC_PAGES,
    'description' => '',
    'show_func'   => 'a_myreferer_show',
    'edit_func'   => 'a_myreferer_edit',
    'options'     => 'pages|new|3|10|20',
    'template'    => 'myreferer_block_02.tpl',

];

$modversion['blocks'][] = [
    'file'        => 'block.php',
    'name'        => _MI_MYREFERER_BLOC_USERS,
    'description' => '',
    'show_func'   => 'a_myreferer_show',
    'edit_func'   => 'a_myreferer_edit',
    'options'     => 'users|date DESC|3|10|20',
    'template'    => 'myreferer_block_02.tpl',
];

// ------------------- Config Options ------------------- //
$modversion['config'][] = [
    'name'        => 'banner',
    'title'       => '_MI_MYREFERER_BANNER',
    'description' => '_MI_MYREFERER_BANNER_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => '1',

];

$modversion['config'][] = [
    'name'        => 'text',
    'title'       => '_MI_MYREFERER_TEXT',
    'description' => '_MI_MYREFERER_TEXT_DSC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => _MI_MYREFERER_WELCOME,

];

$modversion['config'][] = [
    'name'        => 'order',
    'title'       => '_MI_MYREFERER_ORDER',
    'description' => '_MI_MYREFERER_ORDER_DSC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'visit',
    'options'     => ['_MI_MYREFERER_ORDER_VISIT' => 'visit', '_MI_MYREFERER_ORDER_REF' => 'referer', '_MI_MYREFERER_ORDER_DATE' => 'date'],

];

$modversion['config'][] = [
    'name'        => 'perpage',
    'title'       => '_MI_MYREFERER_PERPAGE',
    'description' => '_MI_MYREFERER_PERPAGE_DSC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 30,
    'options'     => ['10' => 10, '20' => 20, '30' => 30, '40' => 40, '50' => 50, '100' => 100],

];

$modversion['config'][] = [
    'name'        => 'tag_new',
    'title'       => '_MI_MYREFERER_TAG_NEW',
    'description' => '_MI_MYREFERER_TAG_NEW_DSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '7|1',

];

$modversion['config'][] = [
    'name'        => 'tag_pop',
    'title'       => '_MI_MYREFERER_TAG_POP',
    'description' => '_MI_MYREFERER_TAG_POP_DSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => '50',

];

$modversion['config'][] = [
    'name'        => 'today',
    'title'       => '_MI_MYREFERER_TODAY',
    'description' => '_MI_MYREFERER_TODAY',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '#AAAA00',

];

$modversion['config'][] = [
    'name'        => 'toold',
    'title'       => '_MI_MYREFERER_TOOLD',
    'description' => '_MI_MYREFERER_TOOLD',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => '#AA0000',
];

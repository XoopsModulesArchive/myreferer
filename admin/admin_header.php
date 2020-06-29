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

require dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
//require $GLOBALS['xoops']->path('www/class/xoopsformloader.php');
require dirname(__DIR__) . '/include/common.php';

$moduleDirName = basename(dirname(__DIR__));

/** @var \XoopsModules\Myreferer\Helper $helper */
$helper = Helper::getInstance();

/** @var \Xmf\Module\Admin $adminObject */
$adminObject = Admin::getInstance();

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('common');
$helper->loadLanguage('main');

//--------------------------------------------------

if (!preg_match('/detail/', basename($_SERVER['SCRIPT_NAME']))) {
    //    xoops_cp_header();
    echo '<style type="text/css">';
    echo 'th a:link {text-decoration: none; color: #ffff00; font-weight: bold; background-color: transparent;}';
    echo 'th a:active {text-decoration: none; color: #ffffff; font-weight: bold; background-color: transparent;}';
    echo 'th a:visited {text-decoration: none; color: #ffff00; font-weight: bold; background-color: transparent;}';
    echo 'th a:hover {text-decoration: none; color: #ff0000; font-weight: bold; background-color: transparent;}';
    echo '</style>';
}

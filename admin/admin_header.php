<?php

declare(strict_types=1);

/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2004 <https://xoops.org>
 *
 * Module: myreferer 2.0
 * Licence : GPL
 * Authors : solo (www.wolfpackclan.com/wolfactory)
 * Authors : DuGris (www.dugris.info)
 */

use Xmf\Module\Admin;
use XoopsModules\Myreferer\Helper;

include dirname(__DIR__) . '/preloads/autoloader.php';

require dirname(__DIR__, 3) . '/include/cp_header.php';

require $GLOBALS['xoops']->path('www/class/xoopsformloader.php');
require dirname(__DIR__) . '/include/common.php';

$moduleDirName = basename(dirname(__DIR__));

$helper = Helper::getInstance();

/** @var Admin $adminObject */
$adminObject = Admin::getInstance();

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('common');
$helper->loadLanguage('main');

if (false === mb_strpos(basename($_SERVER['SCRIPT_NAME']), 'detail')) {
    echo '<style type="text/css">';
    echo 'th a:link {text-decoration: none; color: #ffff00; font-weight: bold; background-color: transparent;}';
    echo 'th a:active {text-decoration: none; color: #ffffff; font-weight: bold; background-color: transparent;}';
    echo 'th a:visited {text-decoration: none; color: #ffff00; font-weight: bold; background-color: transparent;}';
    echo 'th a:hover {text-decoration: none; color: #ff0000; font-weight: bold; background-color: transparent;}';
    echo '</style>';
}

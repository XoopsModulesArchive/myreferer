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
require dirname(dirname(dirname(__DIR__))) . '/mainfile.php';
if (!defined('XOOPS_ROOT_PATH')) {
    exit('XOOPS root path not defined');
}

$confirm = isset($confirm) ? 1 : 0;
if ($confirm) {
    if (myreferer_reset()) {
        redirect_header('index.php', 1, sprintf(_MD_MYREFERER_UPDATED, ''));
    } else {
        redirect_header('index.php', 1, sprintf(_MD_MYREFERER_NOTUPDATED, ''));
    }

    exit();
}
require_once __DIR__ . '/admin_header.php';
xoops_confirm(['', '', 'confirm' => 1, ''], 'reset.php', _MD_MYREFERER_RESET_DATA, _MD_MYREFERER_RESET);
require_once __DIR__ . '/admin_footer.php';

/**
 * Restoring visit_tmp by 0
 */
function myreferer_reset()
{
    global $xoopsDB;

    // get table list (xoops_version.php)
    require_once XOOPS_ROOT_PATH . '/modules/myreferer/language/english/modinfo.php';
    require_once XOOPS_ROOT_PATH . '/modules/myreferer/xoops_version.php';

    foreach ($modversion['tables'] as $table) {
        $sql = 'UPDATE ' . $xoopsDB->prefix($table) . ' SET visit_tmp = 0 WHERE visit_tmp !=0';
        $xoopsDB->queryF($sql);
    }

    return true;
}

require_once __DIR__ . '/admin_footer.php';

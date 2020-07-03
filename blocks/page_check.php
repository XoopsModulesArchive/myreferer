<?php declare(strict_types=1);

/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2004 <https://xoops.org>
 *
 * Module: myreferer 2.0
 * Licence : GPL
 * Authors :
 *           - solo (www.wolfpackclan.com/wolfactory)
 *            - DuGris (www.dugris.info)
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit('XOOPS root path not defined');
}

/**
 * @return array
 */
function a_page_check_show()
{
    $block = [];

    $block['rec'] = '<a href="' . XOOPS_URL . '/modules/myreferer/rec.php">Track this page</a>';

    return $block;
}

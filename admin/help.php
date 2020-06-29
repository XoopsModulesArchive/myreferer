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

require_once __DIR__ . '/admin_header.php';
$myts = \MyTextSanitizer::getInstance();

//$guide = _MD_MYREFERER_GUIDE;
//$guide = $myts->displayTarea($guide);

// Utility::getAdminMenu(-1, _MD_MYREFERER_HELP);
OpenTable();
$helpfile = XOOPS_ROOT_PATH . '/modules/myreferer/language/' . $xoopsConfig['language'] . '/help.html';
if (file_exists($helpfile)) {
    require_once $helpfile;
} else {
    require_once XOOPS_ROOT_PATH . '/modules/myreferer/language/english/help.html';
}

//echo $guide;
CloseTable();
require_once __DIR__ . '/admin_footer.php';

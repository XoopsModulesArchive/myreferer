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
require_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));

if (!is_object($xoopsUser) || (is_object($xoopsUser) && !$xoopsUser->isAdmin())) {
    redirect_header('<script>javascript:history.go(-1)</script>', 1, _NOPERM);
    exit;
}

$op = '';

foreach ($_POST as $k => $v) {
    ${$k} = $v;
}

foreach ($_GET as $k => $v) {
    ${$k} = $v;
}

$myts = \MyTextSanitizer::getInstance();
// Utility::getAdminMenu(6, _MD_MYREFERER_PERMISSIONS);

$item_list_view = [];
$block_view     = [];
echo "<h3 style='color: #2F5376; font-weight: bold; font-size: 14px; margin: 6px 0 0 0; '>" . _MD_MYREFERER_PERMISSIONS_DSC . '</h3>';
$form_view = new XoopsGroupPermForm('', $xoopsModule->getVar('mid'), 'myReferer_wiew', '');
$form_view->addItem(1, _MD_MYREFERER_REFERER);
$form_view->addItem(2, _MD_MYREFERER_ENGINE);
$form_view->addItem(3, _MD_MYREFERER_KEYWORDS);
$form_view->addItem(4, _MD_MYREFERER_QUERY);
$form_view->addItem(5, _MD_MYREFERER_ROBOTS);
$form_view->addItem(6, _MD_MYREFERER_PAGE);
$form_view->addItem(7, _MD_MYREFERER_USERS);

echo $form_view->render();

require_once __DIR__ . '/admin_footer.php';

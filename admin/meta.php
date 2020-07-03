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

use XoopsModules\Myreferer\Utility;

require __DIR__ . '/admin_header.php';

xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));

// require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
$ord = $_POST['ord'] ?? ($_GET['ord'] ?? $xoopsModuleConfig['order']);

$keywords = $_POST['meta_keywords'] ?? ($_GET['meta_keywords'] ?? '');

$meta_limit = $_POST['meta_limit'] ?? ($_GET['meta_limit'] ?? '100');

if ('transfer' === $ord) {
    $sql = 'UPDATE ' . $xoopsDB->prefix('config') . "SET conf_value = '$keywords' WHERE conf_id = 38";

    $xoopsDB->queryF($sql);

    redirect_header('meta.php', 1, _MD_MYREFERER_UPDATED);

    exit();
}

$pop = $xoopsModuleConfig['tag_pop'] / 10;
// $meta_limit = 100;

$metamenu = 0;
if ('date' === $ord or 'referer' === $ord) {
    $name = _MD_MYREFERER_DATE;

    $ord = 'date DESC';

    $where = 'AND visit > 1';

    $metamenu = 0;
}
if ('new' === $ord) {
    $name = _MD_MYREFERER_NEW;

    $ord = 'date DESC';

    $where = 'AND visit = 1';

    $metamenu = 1;
}
if ('visit' === $ord) {
    $name = _MD_MYREFERER_TOP . ' ' . $meta_limit;

    $ord = 'visit_tmp DESC';

    $where = 'AND visit > 1';

    $metamenu = 2;
}
if ('pop' === $ord) {
    $name = _MD_MYREFERER_POP . ' (> ' . $pop . ' hits)';

    $ord = 'visit DESC';

    $where = 'AND visit >= ' . $pop;

    $metamenu = 3;
}

if ('random' === $ord) {
    $metamenu = 4;

    $name = _MD_MYREFERER_RANDOM;

    $ord = 'date DESC';

    $where = 'AND visit > 1';

    $result = $xoopsDB->queryF('SELECT COUNT(*) FROM ' . $xoopsDB->prefix('myreferer_query') . " WHERE hide = 0  AND keyword = 1 $where");

    [$total] = $xoopsDB->fetchRow($result);

    $total -= $meta_limit;

    try {
        $rand = random_int(0, $total);
    } catch (\Throwable $e) {
    }
} else {
    $rand = '';
}

// Start queries
$sql1    = 'SELECT conf_value FROM ' . $xoopsDB->prefix('config') . ' WHERE conf_id = 38';
$result1 = $xoopsDB->queryF($sql1);
while (list($query1) = $xoopsDB->fetchRow($result1)) {
    $meta_keywords = $query1;
}

$sql    = 'SELECT query FROM ' . $xoopsDB->prefix('myreferer_query') . " WHERE hide = 0 AND keyword = 1 $where ORDER BY $ord";
$result = $xoopsDB->queryF($sql, $meta_limit, $rand);
while (list($query) = $xoopsDB->fetchRow($result)) {
    $i++;

    if ($i > 1) {
        $coma = ', ';
    }

    $keywords .= $coma . $query;
}
$keywords_count = mb_strlen($keywords);

// Utility::getAdminMenu(3, _MD_MYREFERER_KEYGEN);
Utility::getMetaMenu($metamenu, '');
//require_once ("../include/nav.php");
OpenTable();

echo '<div align="center"><h3>' . _MD_MYREFERER_RANKING . ' : ' . $name . '</h3></div>';
echo '<div align="center"><h5>' . _MD_MYREFERER_KEYWORDS . ' : ' . $i . ' (' . $keywords_count . ' ' . _MD_MYREFERER_LETTERS . ') </h5></div>';
echo '<form action="meta.php?ord=transfer" method=post>';
echo '<div align="center"><textarea name="meta_keywords" rows="5" cols="300">';
echo $keywords;
echo '</textarea></div>';

echo '<p><div align="center">
	  <INPUT type="submit" name="' . _MD_MYREFERER_TRANSFER . '" value="' . _MD_MYREFERER_TRANSFER . '">
      <p>
      <img src="../assets/images/transfert.gif" alt="' . _MD_MYREFERER_TRANSFER . '"></input></div>';

echo '</form>';

echo '<div align="center">' . _MD_MYREFERER_METAKEYWORDS . ' (' . mb_strlen($meta_keywords) . ' ' . _MD_MYREFERER_LETTERS . ')</div><p>';
echo '<div align="center"><textarea name="" rows="5" cols="300">';
echo $meta_keywords;
echo '</textarea></div>';

CloseTable();
require_once __DIR__ . '/admin_footer.php';

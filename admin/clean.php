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

require __DIR__ . '/admin_header.php';

xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));

$word = $_POST['word'] ?? ($_GET['word'] ?? '');

$ord = $_POST['ord'] ?? ($_GET['ord'] ?? '');

$data = $_POST['data'] ?? ($_GET['data'] ?? '0');

$visit = $_POST['visit'] ?? ($_GET['visit'] ?? '0');

$date = $_POST['date'] ?? ($_GET['date'] ?? '');

if ($data) {
    $date  = time() - (86400 * $date);
    $datas = implode(', ', $data);
    if (preg_match('/myref_pages/', $datas)) {
        $datas .= ', myref_query_pages, myref_referer_pages, myref_robots_pages, myref_users_pages';
    }
    $array  = explode(', ', $datas);
    $result = '<p>' . _MD_MYREFERER_CLEANED;
    $i      = 2;

    foreach ($array as $datas) {
        if ('myref_engine' === $datas) {
            $datas = 'myref_referer';
            $where = 'engine = 1 AND';
        } elseif ('myref_referer' === $datas) {
            $where = 'engine = 0 AND';
        } else {
            $where = '';
        }

        if ($word) {
            $data_type = preg_replace('myref_', '', $datas);
            if ('users' === $data_type) {
                $data_type = 'user';
            }
            if ('pages' === $data_type) {
                $data_type = 'page';
            }
            if ('referer' === $data_type) {
                $data_type = 'ref_url';
            }
            $word_replace = "$data_type LIKE '%$word%' AND ";
        }

        // echo '<br>données = '.$datas.'<br>visit = '.$visit.'<br>date = '.$date;
        $sql = 'SELECT COUNT(*) FROM ' . $xoopsDB->prefix($datas) . "
				WHERE $word_replace $where visit <= '$visit' AND date <= '$date'";

        $count = $xoopsDB->queryF($sql);
        [$total] = $xoopsDB->fetchRow($count);

        $sql = 'DELETE FROM ' . $xoopsDB->prefix($datas) . "
			WHERE $word_replace $where visit <= '$visit' AND date <= '$date'";

        $xoopsDB->queryF($sql);

        $result .= '<div align="center">' . $datas . ' : <b>' . $total . _MD_MYREFERER_ENTRIES . '</b></div>';
        if ($total) {
            $i += 2;
        }
    }
    redirect_header('clean.php', $i, _MD_MYREFERER_UPDATED . $result);
    exit();
}

if ('clean' === $ord) {
    redirect_header('clean.php', 1, _MD_MYREFERER_ERROR);
    exit();
}

// Utility::getAdminMenu(4, _MD_MYREFERER_CLEANER);
//require_once ("../include/nav.php");
OpenTable();
echo '<div align="center">';
echo '<div align="center"><h1>' . _MD_MYREFERER_CLEANER . '</h1></div>';
echo '<form action="clean.php?ord=clean" method=post>';
echo '<table border="0" width="600"><tr><td>';

echo '<div align="left"><b>1) <u>' . _MD_MYREFERER_DATATYPE . '</u></b><p>';
echo '<form>
      <input type="checkbox" name="data[]" value="myref_referer">&nbsp;' . _MD_MYREFERER_REFERER . '</input><br>
      <input type="checkbox" name="data[]" value="myref_engine">&nbsp;' . _MD_MYREFERER_ENGINE . '</input><br>
      <input type="checkbox" name="data[]" value="myref_robots">&nbsp;' . _MD_MYREFERER_ROBOTS . '</input><br>
      <input type="checkbox" name="data[]" value="myref_query">&nbsp;' . _MD_MYREFERER_KEYWORDS . '</input><br>
      <input type="checkbox" name="data[]" value="myref_users">&nbsp;' . _MD_MYREFERER_USERS . '</input><br>
      <input type="checkbox" name="data[]" value="myref_pages">&nbsp;' . _MD_MYREFERER_PAGE . '</input><br>';
echo '</div>';

echo '</td><td>';

echo '<div align="left">';
echo '<b>2) <u>' . _MD_MYREFERER_REMOVE . '</u></b><p>';
echo _MD_MYREFERER_NOTUPDATED . '<select name="date">
     <option value="0"> ' . _ALL . '</option>
     <option value="1">' . _DAY . '</option>
     <option value="3">3 ' . _MD_MYREFERER_DAYS . '</option>
     <option value="7" selected>' . _WEEK . '</option>
     <option value="14">2 ' . _MD_MYREFERER_WEEKS . '</option>
     <option value="30">' . _MONTH . '</option>
     </select>';

echo '<p>' . _MD_MYREFERER_AND . '<p>';
echo _MD_MYREFERER_ATLEAST . '&nbsp;&nbsp;<select name="visit">
     <option value="9999999">' . _ALL . '</option>
     <option value="1" selected>1</option>
     <option value="5">10</option>
     <option value="7">25</option>
     <option value="14">50</option>
     <option value="30">100</option>
     </select>&nbsp;' . _MD_MYREFERER_VISITS;

echo '<p>';
echo '' . _MD_MYREFERER_KEYWORDS . '&nbsp;:&nbsp;<input name="word">';

echo '</div>';
echo '</td><tr></table>';
echo '<p><input type="submit" name="" value="' . _MD_MYREFERER_SUBMIT . '">';
echo '</form></div>';

CloseTable();
require_once __DIR__ . '/admin_footer.php';

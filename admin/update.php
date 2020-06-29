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

$op = $_POST['op'] ?? ($_GET['op'] ?? '');

if ($op) {
    if ('query' === $op) {
        $where = "query = '" . $myrow['query'] . "'";
    }
    if ('robots' === $op) {
        $where = "robots = '" . $myrow['robots'] . "'";
    }
    if ('referer' === $op) {
        $where = "referer = '" . $myrow['referer'] . "'";
    }

    // Calcule of the current week
    // This week
    $week      = date('W');
    $week_day  = ($week * 7) - 5;
    $this_week = mktime(0, 0, 0, 1, $week_day, date('Y'));

    $sql = '	UPDATE ' . $xoopsDB->prefix('myref_') . $op . " SET visit_tmp = 0 WHERE date < $this_week  ";

    if ('' == $xoopsDB->queryF($sql)) {
        redirect_header('index.php', 1, _MD_MYREFERER_UPDATED);
        exit();
    }
    redirect_header('index.php', 1, _MD_MYREFERER_ALREADYUPDATED);
    exit();
}
redirect_header('index.php', 1, _MD_MYREFERER_ERROR);
exit();

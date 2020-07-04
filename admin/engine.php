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
require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
$startart = isset($_GET['startart']) ? (int)$_GET['startart'] : 0;

$ord = $_POST['ord'] ?? ($_GET['ord'] ?? '');

if ('3' == $ord) {
    $ordre = 'referer';

    $sort_ordre = 'ASC';

    $ord_text = _MD_MYREFERER_REFERER;
}
if ('4' == $ord) {
    $ordre = 'page';

    $sort_ordre = 'ASC';

    $ord_text = _MD_MYREFERER_PAGE;
}
if ('2' == $ord) {
    $ordre = 'visit';

    $sort_ordre = 'DESC';

    $ord_text = _MD_MYREFERER_VISITS;
}
if ('' == $ord) {
    $ordre = 'date';

    $sort_ordre = 'DESC';

    $ord_text = _MD_MYREFERER_DATE;
}
if ('del' === $ord) {
    $id = $_GET['id'] ?? '';

    $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_referer') . " WHERE id = $id";

    $xoopsDB->queryF($sql);

    redirect_header('engine.php', 1, _MD_MYREFERER_DELETED);

    exit();
}
if ('clean' === $ord) {
    $id = $_GET['id'] ?? '';

    //	$clean_days = (time()-(86400) );

    $clean_days = time();

    $sql = 'DELETE FROM ' . $xoopsDB->prefix('myreferer_referer') . " WHERE date < $clean_days AND engine = '1'";

    $xoopsDB->queryF($sql);

    redirect_header('engine.php', 1, _MD_MYREFERER_CLEANED);

    exit();
}

require_once dirname(__DIR__) . '/include/nav.php';
OpenTable();
echo _MD_MYREFERER_HEADER . ' <b>' . $xoopsConfig['sitename'] . '</b> <br>';

$result  = $xoopsDB->query('SELECT id, engine, referer, left(page, 64) as xpage, ref_url, page, visit, date FROM ' . $xoopsDB->prefix('myreferer_referer') . " WHERE engine = '1' ORDER BY $ordre $sort_ordre");
$referer = @mysqli_num_rows($result);

if (0 == $referer) {
    echo _MD_MYREFERER_NOVISIT . '<p>';
} else {
    echo _MD_MYREFERER_ENGINE . " <b>$referer</b><p>
		 <div style=\"text-align: center;\">" . _MD_MYREFERER_RANKING . " <b>$ord_text</b></div><br>";

    echo "<div align='center'>
		  <table border='0' cellpadding='4' cellspacing='1' class='bg2' width='100%'>
          <tr class='bg3'>
          <td><center><b>						N°				</b></center></td>
          <td><center><b><a href='engine.php?ord=2'>	" . _MD_MYREFERER_VISITS . "	</a></b></center></td>
          <td style=\"text-align: center;\"><b><a href='engine.php?ord=3'>	" . _MD_MYREFERER_REFERER . "><b><a href='engine.php?ord=4'>	" . _MD_MYREFERER_PAGE . "	</a></b></td>
          <td style=\"text-align: center;\"><b><a href='engine.php'>		" . _MD_MYREFERER_DATE . '	</a></b></td>
          <td style="text-align: center;"><b>					' . _MD_MYREFERER_ADMIN . '	    </b></td>
          </tr>';

    $i = 0;

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $date = $myrow['date'];

        $page = str_replace(XOOPS_URL, '', 'http://' . $myrow['xpage']);

        $ref_url = $myrow['ref_url'];

        // on récupère la QUERY_STRING du REFERER

        $url_array = parse_url($ref_url);

        parse_str($url_array['query'], $variables);

        // les mots clé se trouvent dans la variable 'q', 'p', 'searchfor et 'keywords'

        $keywords1 = urldecode($variables['q']);

        $keywords2 = urldecode($variables['p']);

        $keywords3 = urldecode($variables['searchfor']);

        $keywords4 = urldecode($variables['query']);

        $keywords5 = urldecode($variables['keywords']);

        $query = $keywords1 . $keywords2 . $keywords3 . $keywords4 . $keywords5;

        $referers = str_replace('www.', '', $myrow['referer']);

        $referers = "<a href='$ref_url' title='$query' target='_blank'>$referers<br>($query)</a>";

        $i++;

        echo "<tr class='bg1'>
        	  <td align='center'>	$i						</td>
              <td align='center'>	" . $myrow['visit'] . "					</td>
              <td align='left'>		$referers					</td>
              <td align='left'>		<a href='http://" . $myrow['page'] . "' title='" . $myrow['xpage'] . "' target='_blank'>$page</a>					</td>
              <td>				" . formatTimestamp($date, 'm') . "	</td>
              <td align='center'>	<a href='engine.php?ord=del&id=" . $myrow['id'] . "'>
              <img src='../assets/images/icon/delete.gif' alt='" . _DELETE . "'></a>
              </td>
              </tr>";
    }

    echo '</table></div>';

    //	$pagenav = new \XoopsPageNav( $i, 10, $startart, 'startart', 'page=' . $id );

    //	echo '<div style="text-align:center;">' . $pagenav -> renderNav() . '</div>';

    echo "<br>\n";

    echo "<p align='right'>
    	  <a href='engine.php?ord=clean'>" . _MD_MYREFERER_CLEAN . ' 7&nbsp;' . _MD_MYREFERER_DAYS . " <img src='../assets/images/icon/delete.gif' alt='" . _DELETE . "'></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>";
}

CloseTable();
require_once __DIR__ . '/admin_footer.php';

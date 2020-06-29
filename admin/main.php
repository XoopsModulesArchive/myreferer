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

use XoopsModules\Myreferer\Utility;

require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));

// Pages
// Pagestotal
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_pages'));
[$pages_total] = $xoopsDB->fetchRow($result);

// Pagesonline
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_pages') . ' WHERE hide = 0');
[$pages_on] = $xoopsDB->fetchRow($result);

// Pagesoffline
$pages_off = abs($pages_total - $pages_on);

// Keywords
// Keywordstotal
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_query') . ' WHERE keyword = 1');
[$keywords_total] = $xoopsDB->fetchRow($result);

// Keywordsonline
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_query') . ' WHERE keyword = 1 AND hide = 0');
[$keywords_on] = $xoopsDB->fetchRow($result);

// Keywordsoffline
$keywords_off = abs($keywords_total - $keywords_on);

// Queries
// Query total
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_query') . ' WHERE keyword = 0');
[$query_total] = $xoopsDB->fetchRow($result);

// Query online
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_query') . ' WHERE keyword = 0 AND hide = 0');
[$query_on] = $xoopsDB->fetchRow($result);

// Query offline
$query_off = abs($query_total - $query_on);

// Bots
// Bots total
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_robots') . " WHERE robots != ''");
[$robots_total] = $xoopsDB->fetchRow($result);

// Bots online
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_robots') . " WHERE robots != '' AND hide = 0");
[$robots_on] = $xoopsDB->fetchRow($result);

// Bots offline
$robots_off = abs($robots_total - $robots_on);

// Référent
// Référent total
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_referer') . " WHERE referer != '' AND engine = 0");
[$referer_total] = $xoopsDB->fetchRow($result);

// Référent online
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_referer') . " WHERE referer != '' AND engine = 0 AND hide = 0");
[$referer_on] = $xoopsDB->fetchRow($result);

// Référent offline
$referer_off = abs($referer_total - $referer_on);

// Search engine
// Search engine total
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_referer') . " WHERE referer != '' AND engine = 1");
[$engine_total] = $xoopsDB->fetchRow($result);

// Référent online
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_referer') . " WHERE referer != '' AND engine = 1 AND hide = 0");
[$engine_on] = $xoopsDB->fetchRow($result);

// Référent offline
$engine_off = abs($engine_total - $engine_on);

// Members
// Memberstotal
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_users') . ' WHERE user!=0');
[$members_total] = $xoopsDB->fetchRow($result);

// Membersonline
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_users') . ' WHERE user!=0 and hide = 0');
[$members_on] = $xoopsDB->fetchRow($result);

// Membersoffline
$members_off = abs($members_total - $members_on);

// Utility::getAdminMenu(0, _MD_MYREFERER_STATS);
//require_once ("../include/nav.php");
Utility::getStatMenu(-1, '');
OpenTable();
//require_once ("../include/statnav.php");

// Spiders
echo '<div style="align:center;"><table width="600px" cellpadding="4" cellspacing="1" class="bg2">
	 <tr class="bg3">
      <th width="10%" align="center"> ' . _MD_MYREFERER_TOTAL . '</th>
      <th width="10%" align="center"> <a href="stats_pages.php?week=0">			' . _MD_MYREFERER_PAGE . '</a></th>
      <th width="10%" align="center"> <a href="stats_keyword.php?week=0">			' . _MD_MYREFERER_KEYWORDS . '</a></th>
      <th width="10%" align="center"> <a href="stats_query.php?week=0">			' . _MD_MYREFERER_QUERY . '</a></th>
      <th width="10%" align="center"> <a href="stats_robots.php?week=0">			' . _MD_MYREFERER_ROBOTS . '</a></th>
      <th width="10%" align="center"> <a href="stats_referer.php?engine=0&week=0">	' . _MD_MYREFERER_REFERER . '</a></th>
      <th width="10%" align="center"> <a href="stats_referer.php?engine=1&week=0">	' . _MD_MYREFERER_ENGINES . '</a></th>
      <th width="10%" align="center"> <a href="stats_visitors.php?week=0">			' . _MD_MYREFERER_MEMBERS . '</a></th>
      </tr>
      <tr class="bg4">
      <td align="center">	<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_VISIBLE . '">	</td>
      <td align="right"> <a href="stats_pages.php?op=whitelist&week=0">			' . $pages_on . '	</a></td>
      <td align="right"> <a href="stats_keyword.php?op=whitelist&week=0">			' . $keywords_on . '	</a></td>
      <td align="right"> <a href="stats_query.php?op=whitelist&week=0">			' . $query_on . '	</a></td>
      <td align="right"> <a href="stats_robots.php?op=whitelist&week=0">			' . $robots_on . '	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=0&op=whitelist&week=0">	' . $referer_on . '	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=1&op=whitelist&week=0">	' . $engine_on . '	</a></td>
      <td align="right"> <a href="stats_visitors.php?op=whitelist&week=0">			' . $members_on . '	</a></td>
      </tr>
      <tr class="bg4">
      <td align="center">	<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_INVISIBLE . '">	</td>
      <td align="right"> <a href="stats_pages.php?op=blacklist&week=0">			' . $pages_off . '	</a></td>
      <td align="right"> <a href="stats_keyword.php?op=blacklist&week=0">			' . $keywords_off . '	</a></td>
      <td align="right"> <a href="stats_query.php?op=blacklist&week=0">			' . $query_off . '	</a></td>
      <td align="right"> <a href="stats_robots.php?op=blacklist&week=0">			' . $robots_off . '	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=0&op=blacklist&week=0">	' . $referer_off . '	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=1&op=blacklist&week=0">	' . $engine_off . '	</a></td>
      <td align="right"> <a href="stats_visitors.php?op=blacklist&week=0">			' . $members_off . '	</a></td>
      </tr>
      <tr class="bg4">
      <td align="center"><b>' . _MD_MYREFERER_TOTAL . '</b></td>
      <td align="right"><b>' . $pages_total . '	</b></td>
      <td align="right"><b>' . $keywords_total . '	</b></td>
      <td align="right"><b>' . $query_total . '	</b></td>
      <td align="right"><b>' . $robots_total . '	</b></td>
      <td align="right"><b>' . $referer_total . '</b></td>
      <td align="right"><b>' . $engine_total . '	</b></td>
      <td align="right"><b>' . $members_total . '	</b></td>
      </tr>
      </table>';

// CloseTable();

echo '<p>';

// Pages
// Pagestotal
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_pages') . ' WHERE visit_tmp > 0');
[$pages_total] = $xoopsDB->fetchRow($result);

// Pagesonline
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_pages') . ' WHERE hide = 0 AND visit_tmp > 0 ');
[$pages_on] = $xoopsDB->fetchRow($result);

// Pagesoffline
$pages_off = abs($pages_total - $pages_on);

// Keywords
// Keywords total
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_query') . ' WHERE keyword = 1 AND visit_tmp > 0 ');
[$keywords_total] = $xoopsDB->fetchRow($result);

// Keywords online
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_query') . ' WHERE keyword = 1 AND hide = 0 AND visit_tmp > 0 ');
[$keywords_on] = $xoopsDB->fetchRow($result);

// Keywords offline
$keywords_off = abs($keywords_total - $keywords_on);

// Queries
// Query total
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_query') . ' WHERE keyword = 0 AND visit_tmp > 0 ');
[$query_total] = $xoopsDB->fetchRow($result);

// Query online
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_query') . ' WHERE keyword = 0 AND hide = 0 AND visit_tmp > 0 ');
[$query_on] = $xoopsDB->fetchRow($result);

// Query offline
$query_off = abs($query_total - $query_on);

// Bots
// Bots total
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_robots') . " WHERE robots != '' AND visit_tmp > 0 ");
[$robots_total] = $xoopsDB->fetchRow($result);

// Bots online
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_robots') . " WHERE robots != '' AND hide = 0 AND visit_tmp > 0 ");
[$robots_on] = $xoopsDB->fetchRow($result);

// Bots offline
$robots_off = abs($robots_total - $robots_on);

// Référent
// Référent total
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_referer') . " WHERE referer != '' AND engine = 0 AND visit_tmp > 0 ");
[$referer_total] = $xoopsDB->fetchRow($result);

// Référent online
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_referer') . " WHERE referer != '' AND engine = 0 AND hide = 0 AND visit_tmp > 0 ");
[$referer_on] = $xoopsDB->fetchRow($result);

// Référent offline
$referer_off = abs($referer_total - $referer_on);

// Search engine
// Search engine total
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_referer') . " WHERE referer != '' AND engine = 1 AND visit_tmp > 0 ");
[$engine_total] = $xoopsDB->fetchRow($result);

// Référent online
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_referer') . " WHERE referer != '' AND engine = 1 AND hide = 0 AND visit_tmp > 0 ");
[$engine_on] = $xoopsDB->fetchRow($result);

// Référent offline
$engine_off = abs($engine_total - $engine_on);

// Members
// Memberstotal
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_users') . ' WHERE user!=0 AND visit_tmp > 0');
[$members_total] = $xoopsDB->fetchRow($result);

// Membersonline
$result = $xoopsDB->queryF('SELECT COUNT(id) FROM ' . $xoopsDB->prefix('myref_users') . ' WHERE user!=0 and hide = 0 AND visit_tmp > 0');
[$members_on] = $xoopsDB->fetchRow($result);

// Membersoffline
$members_off = abs($members_total - $members_on);

// require_once ("../include/nav.php");

// OpenTable();
// require_once ("../include/statnav.php");
// Spiders
echo '<table width="600px" cellpadding="4" cellspacing="1" class="bg2" >
	  <tr class="bg3">
      <th width="10%" align="center"> ' . _MD_MYREFERER_WEEK . '</th>
      <th width="10%" align="center"> <a href="stats_pages.php?week=1">	' . _MD_MYREFERER_PAGE . '</a></th>
      <th width="10%" align="center"> <a href="stats_keyword.php?week=1">	' . _MD_MYREFERER_KEYWORDS . '</a></th>
      <th width="10%" align="center"> <a href="stats_query.php?week=1">	' . _MD_MYREFERER_QUERY . '</a></th>
      <th width="10%" align="center"> <a href="stats_robots.php?week=1">	' . _MD_MYREFERER_ROBOTS . '</a></th>
      <th width="10%" align="center"> <a href="stats_referer.php?week=1&engine=0">	' . _MD_MYREFERER_REFERER . '</a></th>
      <th width="10%" align="center"> <a href="stats_referer.php?week=1&engine=1">	' . _MD_MYREFERER_ENGINES . '</a></th>
      <th width="10%" align="center"> <a href="stats_visitors.php?week=1">	' . _MD_MYREFERER_MEMBERS . '</a></th>
      </tr>
      <tr class="bg4">
      <td align="center">	<img src="../assets/images/icon/on.gif" alt="' . _MD_MYREFERER_VISIBLE . '">	</td>
      <td align="right"> <a href="stats_pages.php?op=whitelist&week=1">		' . $pages_on . '	</a></td>
      <td align="right"> <a href="stats_keyword.php?op=whitelist&week=1">		' . $keywords_on . '	</a></td>
      <td align="right"> <a href="stats_query.php?op=whitelist&week=1">			' . $query_on . '	</a></td>
      <td align="right"> <a href="stats_robots.php?op=whitelist&week=1">		' . $robots_on . '	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=0&op=whitelist&week=1">	' . $referer_on . '	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=1&op=whitelist&week=1">	' . $engine_on . '	</a></td>
      <td align="right"> <a href="stats_visitors.php?op=whitelist&week=1">	' . $members_on . '	</a></td>
      </tr>
      <tr class="bg4">
      <td align="center">	<img src="../assets/images/icon/off.gif" alt="' . _MD_MYREFERER_INVISIBLE . '">	</td>
      <td align="right"> <a href="stats_pages.php?op=blacklist&week=1">		' . $pages_off . '	</a></td>
      <td align="right"> <a href="stats_keyword.php?op=blacklist&week=1">		' . $keywords_off . '	</a></td>
      <td align="right"> <a href="stats_query.php?op=blacklist&week=1">			' . $query_off . '	</a></td>
      <td align="right"> <a href="stats_robots.php?op=blacklist&week=1">		' . $robots_off . '	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=0&op=blacklist&week=1">	' . $referer_off . '	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=1&op=blacklist&week=1">	' . $engine_off . '	</a></td>
      <td align="right"> <a href="stats_visitors.php?op=blacklist&week=1">	' . $members_off . '	</a></td>
      </tr>
      <tr class="bg4">
      <td align="center"><b>' . _MD_MYREFERER_TOTAL . '</b></td>
      <td align="right"><b>' . $pages_total . '</b>	</td>
      <td align="right"><b>' . $keywords_total . '</b>	</td>
      <td align="right"><b>' . $query_total . '</b>		</td>
      <td align="right"><b>' . $robots_total . '</b>	</td>
      <td align="right"><b>' . $referer_total . '</b>	</td>
      <td align="right"><b>' . $engine_total . '</b>	</td>
      <td align="right"><b>' . $members_total . '</b>	</td>
      </tr>
      </table>
      <p>
      <a href="reset.php">' . _MD_MYREFERER_RESET_DATAS . '</a>
      </div>';

CloseTable();
require_once __DIR__ . '/admin_footer.php';

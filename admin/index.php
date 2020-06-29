<?php
/**
* XOOPS - PHP Content Management System
* Copyright (c) 2004 <http://www.xoops.org/>
*
* Module: myReferer 2.0
* Licence : GPL
* Authors :
*           - solo (www.wolfpackclan.com/wolfactory)
*			- DuGris (www.dugris.info)
*/

include("admin_header.php");
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

// Pages
// Pagestotal
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_pages") );
list( $pages_total ) = $xoopsDB->fetchRow($result);

// Pagesonline
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_pages")." WHERE hide = 0");
list( $pages_on ) = $xoopsDB->fetchRow($result);

// Pagesoffline
$pages_off = abs($pages_total - $pages_on);

// Keywords
// Keywordstotal
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_query")." WHERE keyword = 1");
list( $keywords_total ) = $xoopsDB->fetchRow($result);

// Keywordsonline
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_query")." WHERE keyword = 1 AND hide = 0");
list( $keywords_on ) = $xoopsDB->fetchRow($result);

// Keywordsoffline
$keywords_off = abs($keywords_total - $keywords_on);

// Queries
// Query total
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_query")." WHERE keyword = 0");
list( $query_total ) = $xoopsDB->fetchRow($result);

// Query online
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_query")." WHERE keyword = 0 AND hide = 0");
list( $query_on ) = $xoopsDB->fetchRow($result);

// Query offline
$query_off = abs($query_total - $query_on);

// Bots
// Bots total
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_robots")." WHERE robots != ''");
list( $robots_total ) = $xoopsDB->fetchRow($result);

// Bots online
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_robots")." WHERE robots != '' AND hide = 0");
list( $robots_on ) = $xoopsDB->fetchRow($result);

// Bots offline
$robots_off = abs($robots_total - $robots_on);

// R�f�rent
// R�f�rent total
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_referer")." WHERE referer != '' AND engine = 0");
list( $referer_total ) = $xoopsDB->fetchRow($result);

// R�f�rent online
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_referer")." WHERE referer != '' AND engine = 0 AND hide = 0");
list( $referer_on ) = $xoopsDB->fetchRow($result);

// R�f�rent offline
$referer_off = abs($referer_total - $referer_on);

// Search engine
// Search engine total
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_referer")." WHERE referer != '' AND engine = 1");
list( $engine_total ) = $xoopsDB->fetchRow($result);

// R�f�rent online
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_referer")." WHERE referer != '' AND engine = 1 AND hide = 0");
list( $engine_on ) = $xoopsDB->fetchRow($result);

// R�f�rent offline
$engine_off = abs($engine_total - $engine_on);

// Members
// Memberstotal
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_users") ." WHERE user!=0");
list( $members_total ) = $xoopsDB->fetchRow($result);

// Membersonline
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_users")." WHERE user!=0 and hide = 0");
list( $members_on ) = $xoopsDB->fetchRow($result);

// Membersoffline
$members_off = abs($members_total - $members_on);

myReferer_adminmenu(0, _MD_MYREFERER_STATS);
//include_once ("../include/nav.php");
myReferer_statmenu(-1, '');
OpenTable();
//include_once ("../include/statnav.php");

// Spiders
echo '<div style="align:center;"><table width="600px" cellpadding="4" cellspacing="1" class="bg2">
	 <tr class="bg3">
      <th width="10%" align="center"> '._MD_MYREFERER_TOTAL.'</th>
      <th width="10%" align="center"> <a href="stats_pages.php?week=0">			'._MD_MYREFERER_PAGE.'</a></th>
      <th width="10%" align="center"> <a href="stats_keyword.php?week=0">			'._MD_MYREFERER_KEYWORDS.'</a></th>
      <th width="10%" align="center"> <a href="stats_query.php?week=0">			'._MD_MYREFERER_QUERY.'</a></th>
      <th width="10%" align="center"> <a href="stats_robots.php?week=0">			'._MD_MYREFERER_ROBOTS.'</a></th>
      <th width="10%" align="center"> <a href="stats_referer.php?engine=0&week=0">	'._MD_MYREFERER_REFERER.'</a></th>
      <th width="10%" align="center"> <a href="stats_referer.php?engine=1&week=0">	'._MD_MYREFERER_ENGINES.'</a></th>
      <th width="10%" align="center"> <a href="stats_visitors.php?week=0">			'._MD_MYREFERER_MEMBERS.'</a></th>
      </tr>
      <tr class="bg4">
      <td align="center">	<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_VISIBLE.'" />	</td>
      <td align="right"> <a href="stats_pages.php?op=whitelist&week=0">			'.$pages_on.'	</a></td>
      <td align="right"> <a href="stats_keyword.php?op=whitelist&week=0">			'.$keywords_on.'	</a></td>
      <td align="right"> <a href="stats_query.php?op=whitelist&week=0">			'.$query_on.'	</a></td>
      <td align="right"> <a href="stats_robots.php?op=whitelist&week=0">			'.$robots_on.'	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=0&op=whitelist&week=0">	'.$referer_on.'	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=1&op=whitelist&week=0">	'.$engine_on.'	</a></td>
      <td align="right"> <a href="stats_visitors.php?op=whitelist&week=0">			'.$members_on.'	</a></td>
      </tr>
      <tr class="bg4">
      <td align="center">	<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_INVISIBLE.'" />	</td>
      <td align="right"> <a href="stats_pages.php?op=blacklist&week=0">			'.$pages_off.'	</a></td>
      <td align="right"> <a href="stats_keyword.php?op=blacklist&week=0">			'.$keywords_off.'	</a></td>
      <td align="right"> <a href="stats_query.php?op=blacklist&week=0">			'.$query_off.'	</a></td>
      <td align="right"> <a href="stats_robots.php?op=blacklist&week=0">			'.$robots_off.'	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=0&op=blacklist&week=0">	'.$referer_off.'	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=1&op=blacklist&week=0">	'.$engine_off.'	</a></td>
      <td align="right"> <a href="stats_visitors.php?op=blacklist&week=0">			'.$members_off.'	</a></td>
      </tr>
      <tr class="bg4">
      <td align="center"><b>'._MD_MYREFERER_TOTAL.'</b></td>
      <td align="right"><b>'.$pages_total.'	</b></td>
      <td align="right"><b>'.$keywords_total.'	</b></td>
      <td align="right"><b>'.$query_total.'	</b></td>
      <td align="right"><b>'.$robots_total.'	</b></td>
      <td align="right"><b>'.$referer_total.'</b></td>
      <td align="right"><b>'.$engine_total.'	</b></td>
      <td align="right"><b>'.$members_total.'	</b></td>
      </tr>
      </table>';

// CloseTable();

echo '<p />';

// Pages
// Pagestotal
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_pages") . " WHERE visit_tmp > 0" );
list( $pages_total ) = $xoopsDB->fetchRow($result);

// Pagesonline
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_pages")." WHERE hide = 0 AND visit_tmp > 0 ");
list( $pages_on ) = $xoopsDB->fetchRow($result);

// Pagesoffline
$pages_off = abs($pages_total - $pages_on);

// Keywords
// Keywords total
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_query")." WHERE keyword = 1 AND visit_tmp > 0 ");
list( $keywords_total ) = $xoopsDB->fetchRow($result);

// Keywords online
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_query")." WHERE keyword = 1 AND hide = 0 AND visit_tmp > 0 ");
list( $keywords_on ) = $xoopsDB->fetchRow($result);

// Keywords offline
$keywords_off = abs($keywords_total - $keywords_on);


// Queries
// Query total
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_query")." WHERE keyword = 0 AND visit_tmp > 0 ");
list( $query_total ) = $xoopsDB->fetchRow($result);

// Query online
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_query")." WHERE keyword = 0 AND hide = 0 AND visit_tmp > 0 ");
list( $query_on ) = $xoopsDB->fetchRow($result);

// Query offline
$query_off = abs($query_total - $query_on);

// Bots
// Bots total
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_robots")." WHERE robots != '' AND visit_tmp > 0 ");
list( $robots_total ) = $xoopsDB->fetchRow($result);

// Bots online
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_robots")." WHERE robots != '' AND hide = 0 AND visit_tmp > 0 ");
list( $robots_on ) = $xoopsDB->fetchRow($result);

// Bots offline
$robots_off = abs($robots_total - $robots_on);

// R�f�rent
// R�f�rent total
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_referer")." WHERE referer != '' AND engine = 0 AND visit_tmp > 0 ");
list( $referer_total ) = $xoopsDB->fetchRow($result);

// R�f�rent online
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_referer")." WHERE referer != '' AND engine = 0 AND hide = 0 AND visit_tmp > 0 ");
list( $referer_on ) = $xoopsDB->fetchRow($result);

// R�f�rent offline
$referer_off = abs($referer_total - $referer_on);

// Search engine
// Search engine total
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_referer")." WHERE referer != '' AND engine = 1 AND visit_tmp > 0 ");
list( $engine_total ) = $xoopsDB->fetchRow($result);

// R�f�rent online
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_referer")." WHERE referer != '' AND engine = 1 AND hide = 0 AND visit_tmp > 0 ");
list( $engine_on ) = $xoopsDB->fetchRow($result);

// R�f�rent offline
$engine_off = abs($engine_total - $engine_on);

// Members
// Memberstotal
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_users") ." WHERE user!=0 AND visit_tmp > 0");
list( $members_total ) = $xoopsDB->fetchRow($result);

// Membersonline
$result = $xoopsDB -> queryF( "SELECT COUNT(id) FROM " . $xoopsDB->prefix("myref_users")." WHERE user!=0 and hide = 0 AND visit_tmp > 0");
list( $members_on ) = $xoopsDB->fetchRow($result);

// Membersoffline
$members_off = abs($members_total - $members_on);

// include_once ("../include/nav.php");

// OpenTable();
// include_once ("../include/statnav.php");
// Spiders
echo '<table width="600px" cellpadding="4" cellspacing="1" class="bg2" >
	  <tr class="bg3">
      <th width="10%" align="center"> '._MD_MYREFERER_WEEK.'</th>
      <th width="10%" align="center"> <a href="stats_pages.php?week=1">	'._MD_MYREFERER_PAGE.'</a></th>
      <th width="10%" align="center"> <a href="stats_keyword.php?week=1">	'._MD_MYREFERER_KEYWORDS.'</a></th>
      <th width="10%" align="center"> <a href="stats_query.php?week=1">	'._MD_MYREFERER_QUERY.'</a></th>
      <th width="10%" align="center"> <a href="stats_robots.php?week=1">	'._MD_MYREFERER_ROBOTS.'</a></th>
      <th width="10%" align="center"> <a href="stats_referer.php?week=1&engine=0">	'._MD_MYREFERER_REFERER.'</a></th>
      <th width="10%" align="center"> <a href="stats_referer.php?week=1&engine=1">	'._MD_MYREFERER_ENGINES.'</a></th>
      <th width="10%" align="center"> <a href="stats_visitors.php?week=1">	'._MD_MYREFERER_MEMBERS.'</a></th>
      </tr>
      <tr class="bg4">
      <td align="center">	<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_VISIBLE.'" />	</td>
      <td align="right"> <a href="stats_pages.php?op=whitelist&week=1">		'.$pages_on.'	</a></td>
      <td align="right"> <a href="stats_keyword.php?op=whitelist&week=1">		'.$keywords_on.'	</a></td>
      <td align="right"> <a href="stats_query.php?op=whitelist&week=1">			'.$query_on.'	</a></td>
      <td align="right"> <a href="stats_robots.php?op=whitelist&week=1">		'.$robots_on.'	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=0&op=whitelist&week=1">	'.$referer_on.'	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=1&op=whitelist&week=1">	'.$engine_on.'	</a></td>
      <td align="right"> <a href="stats_visitors.php?op=whitelist&week=1">	'.$members_on.'	</a></td>
      </tr>
      <tr class="bg4">
      <td align="center">	<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_INVISIBLE.'" />	</td>
      <td align="right"> <a href="stats_pages.php?op=blacklist&week=1">		'.$pages_off.'	</a></td>
      <td align="right"> <a href="stats_keyword.php?op=blacklist&week=1">		'.$keywords_off.'	</a></td>
      <td align="right"> <a href="stats_query.php?op=blacklist&week=1">			'.$query_off.'	</a></td>
      <td align="right"> <a href="stats_robots.php?op=blacklist&week=1">		'.$robots_off.'	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=0&op=blacklist&week=1">	'.$referer_off.'	</a></td>
      <td align="right"> <a href="stats_referer.php?engine=1&op=blacklist&week=1">	'.$engine_off.'	</a></td>
      <td align="right"> <a href="stats_visitors.php?op=blacklist&week=1">	'.$members_off.'	</a></td>
      </tr>
      <tr class="bg4">
      <td align="center"><b>'._MD_MYREFERER_TOTAL.'</b></td>
      <td align="right"><b>'.$pages_total.'</b>	</td>
      <td align="right"><b>'.$keywords_total.'</b>	</td>
      <td align="right"><b>'.$query_total.'</b>		</td>
      <td align="right"><b>'.$robots_total.'</b>	</td>
      <td align="right"><b>'.$referer_total.'</b>	</td>
      <td align="right"><b>'.$engine_total.'</b>	</td>
      <td align="right"><b>'.$members_total.'</b>	</td>
      </tr>
      </table>
      <p />
      <a href="reset.php">'._MD_MYREFERER_RESET_DATAS.'</a>
      </div>';

CloseTable();
include_once( 'admin_footer.php' );
?>
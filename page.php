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

// General settings
include_once("header.php");

$current = _MYREFERER_PAGE;
$xoopsTpl->assign("current", 			_MYREFERER_PAGE);
$xoopsTpl->assign('xoops_pagetitle',	_MYREFERER_PAGE);


if ( myReferer_checkRight(6) ) {
	// Query : page
	$sql = "SELECT id, page, visit, startdate, date, hide
		FROM ".$xoopsDB->prefix("myref_pages")."
		WHERE page != '' $more
		ORDER BY $order";

    $result = $xoopsDB->queryF($sql, $xoopsModuleConfig['perpage'], $startart );
	while(list( $id, $page, $visit, $startdate, $date, $hide) = $xoopsDB->fetchRow($result)) {
		$info = array();

		// Module icon
		// Popularity
		if ( $visit > ($xoopsModuleConfig['tag_pop'] * 5) ) {
			$pop = '&nbsp;<img src="images/icon/pop.gif" alt="'.$visit.' '._READS.'" />';
		} else {
			$pop = '';
        }

		// Recent
		$startingdate = (time()-(86400 * $new[0] ));
		if ( $startingdate < $date AND $visit <= $new[1] ) {
			$new_icon = '&nbsp;<img src="images/icon/new.gif" alt="" />';
		} else {
			$new_icon = '';
        }

		$count++;
		$today = time()-(86400);
		$recent = time()-(86400 * $new[0] );
		if ( $date >= $recent ) { $color = ''; $format = ''; } else { $color = $xoopsModuleConfig['toold']; $format = 'italic'; }
		if ( $date >= $today ) { $color = $xoopsModuleConfig['today']; $format = 'bold'; }

		preg_match("/(" . str_replace("/", "\/", XOOPS_URL) . ")(.*)/i", 'http://'.$page, $mypage);
		$page_name = $mypage[2];
		$ref_url = 'http://' . $page;

		// Display weekly stats about visits and limit number to 2
		$total_day = ($date - $startdate) / (60 * 60 * 24);
        $day_stat = 0;
        if ($total_day != 0) {
			$day_stat = ( $visit / $total_day );
			$tmp = explode('.', $day_stat);
			if( count($tmp)>1 ) {
				$tmp[1] = '.'.substr ( $tmp[1] , 0 , 2 );
				$day_stat = abs($tmp[0].$tmp[1]);
			}
        }

		// Compile results of query

		$info['id'] = 	$id;
		$info['count'] = 	$count;
		$info['referer'] = $page_name;
		$info['alt_referer'] = $ref_url;
		$info['icon'] = 	$new_icon.$pop;
		$info['ref_url'] = $ref_url;
		$info['page'] = 	'http://'.$page;
		if ( $day_stat <= $visit AND $day_stat > 0) {
			$info['visit'] = '<b>'.$visit.'</b><br /><nobr>['.$day_stat.'&nbsp;/&nbsp;'._DAY.']</nobr>';
		} else {
			$info['visit'] = '<b>'.$visit.'</b>';
		}
		$info['date'] = '<div style="color:'.$color.'; font-weight:'.$format.'">'.formatTimestamp($date,'m').'</div>';

		$xoopsTpl->append('infos', $info);
		unset($info);
	}

	// Query on counter result
	$result = $xoopsDB -> queryF( "SELECT COUNT(id)
		FROM " . $xoopsDB->prefix("myref_pages")."
		WHERE page!= '' $more");

    list( $numrows ) = $xoopsDB->fetchRow($result);

	// Counter
	$xoopsTpl->assign("numrows", 	$count.' / '.$numrows.'&nbsp;'.$current );
	$pagenav = new XoopsPageNav( $numrows, $xoopsModuleConfig['perpage'], $startart, 'startart', 'ord='.$ord.'&op='.$op);
	$xoopsTpl->assign('pagenav', $pagenav->renderNav());
	$xoopsTpl->assign('navlink', 'page.php?op='.$op.'&startart='.$startart);
	$xoopsTpl->assign('pages', _MYREFERER_PAGES );
} else {
	$xoopsTpl->assign("numrows", 	'');
}

// Admin link
if ( $xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid()) ) {
	$admin = '<a href="admin/clean.php"><img src="images/icon/trash.gif" alt="'._DELETE.'"></a>&nbsp;
			  <a href="admin/stats_pages.php"><img src="images/icon/detail.gif" alt="' . _MYREFERER_STATS . '"></a>&nbsp;
			  <a href="admin/config.php"><img src="images/icon/config.gif" alt="' . _MYREFERER_CONFIG . '"></a>&nbsp;
	<a href="../system/admin.php?fct=preferences&amp;op=showmod&amp;mod='.$xoopsModule -> getVar( "mid" ).'">
	<img src="images/icon/edit.gif" alt="'._PREFERENCES.'"></a>';
} else {
	$admin = '';
}
$xoopsTpl->assign("admin", 		$admin);
// Admin link


include_once(XOOPS_ROOT_PATH."/footer.php");
?>
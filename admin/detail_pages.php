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

include_once( 'admin_header.php');

if (!isset($_POST["id"])) {
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
} else {
	$id = $_POST["id"];
}

if (!isset($_POST["op"])) {
	$op = isset($_GET["op"]) ? $_GET["op"] : "";
} else {
	$op = $_POST["op"];
}

if (!isset($_POST["confirm"])) {
	$confirm = isset($_GET["confirm"]) ? $_GET["confirm"] : 0;
} else {
	$confirm = $_POST["confirm"];
}

// Delete operation
if ( $op == 'del' AND $id ) {
	if ($confirm) {
		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_pages")." WHERE id = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_pages_stats")." WHERE pagesid = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_query_pages")." WHERE pagesid = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_query_pages_stats")." WHERE pagesid = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_referer_pages")." WHERE pagesid = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_referer_pages_stats")." WHERE pagesid = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_robots_pages")." WHERE pagesid = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_robots_pages_stats")." WHERE pagesid = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_users_pages")." WHERE pagesid = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_users_pages_stats")." WHERE pagesid = '$id' ";
		$xoopsDB->queryF($sql);

		echo "<script type='text/javascript'>\n";
    	echo "self.close();\n";
	    echo "</script>";
    } else {
		include_once( 'detail_header.php' );

		$sql = "SELECT page FROM " . $xoopsDB->prefix("myref_pages") . " WHERE id=$id";
        $result = $xoopsDB->query( $sql );
        list($name) = $xoopsDB->fetchRow($result);
		preg_match("/(" . str_replace("/", "\/", XOOPS_URL) . ")(.*)/i", 'http://'.$name, $mypage);
        $name = $mypage[2];

		xoops_confirm(array('op' => $op, 'id' => $id, 'confirm' => 1, 'ord' => $ord, 'search' => $search, 'week' => $week, 'start' => $start) , 'detail_pages.php', _MD_MYREFERER_DELETE_PAGE . " <br />" . "<br />" . $name . "<br />", _MD_MYREFERER_DELETE);

		include_once( 'detail_footer.php' );
		exit();
	}
}

// Hide/Show operation
if ( ($op == 'h' OR $op == 'd') AND $id ) {
	if ( $op == 'd' ) { $hide = 0; } else { $hide = 1; }
	$sql = "UPDATE ".$xoopsDB->prefix("myref_pages")." SET hide = '$hide' WHERE id = '$id'";
	$xoopsDB->queryF($sql);
}

// $this_date = date('W'); $this_name = _MD_MYREFERER_WEEK; // Week
$pages = "SELECT * FROM " . $xoopsDB->prefix("myref_pages") . " WHERE id = '$id' ORDER BY date DESC";

$counter = $xoopsDB->queryF($pages);
$count = mysql_NumRows( $counter );

include_once( 'detail_header.php' );

if( $count == 0) {
	echo '<div align="center">' . _MD_MYREFERER_NOVISIT . "</div>";
} else {
	$result = $xoopsDB->queryF($pages);
	$myrow = $xoopsDB->fetchArray($result);

	$members = "SELECT count(r.id) AS nb, sum(p.visit) AS visit, sum(p.visit_tmp) AS visit_tmp, r.startdate, p.date  FROM " .
				    $xoopsDB->prefix("myref_users_pages") . " p LEFT JOIN " .
                    $xoopsDB->prefix("myref_users") . " r on r.id = p.usersid
                    WHERE p.pagesid = '$id'
                    GROUP BY p.pagesid
                    ORDER BY r.date DESC";
	$result_members = $xoopsDB->queryF($members);
	$myrow_members = $xoopsDB->fetchArray($result_members);


	$referer = "SELECT count(r.id) AS nb, sum(p.visit) AS visit, sum(p.visit_tmp) AS visit_tmp, r.startdate, p.date  FROM " .
				    $xoopsDB->prefix("myref_referer_pages") . " p LEFT JOIN " .
                    $xoopsDB->prefix("myref_referer") . " r on r.id = p.refererid
                    WHERE r.engine=0 AND p.pagesid = '$id'
                    GROUP BY p.pagesid
                    ORDER BY r.date DESC";
	$result_referer = $xoopsDB->queryF($referer);
	$myrow_referer = $xoopsDB->fetchArray($result_referer);

	$search = "SELECT count(r.id) AS nb, sum(p.visit) AS visit, sum(p.visit_tmp) AS visit_tmp, r.startdate, p.date  FROM " .
				    $xoopsDB->prefix("myref_referer_pages") . " p LEFT JOIN " .
                    $xoopsDB->prefix("myref_referer") . " r on r.id = p.refererid
                    WHERE r.engine=1 AND p.pagesid = '$id'
                    GROUP BY p.pagesid
                    ORDER BY r.date DESC";
	$result_search = $xoopsDB->queryF($search);
	$myrow_search = $xoopsDB->fetchArray($result_search);

	$keyword = "SELECT count(r.id) AS nb, sum(p.visit) AS visit, sum(p.visit_tmp) AS visit_tmp, r.startdate, p.date  FROM " .
				    $xoopsDB->prefix("myref_query_pages") . " p LEFT JOIN " .
                    $xoopsDB->prefix("myref_query") . " r on r.id = p.queryid
                    WHERE r.keyword=1 AND p.pagesid = '$id'
                    GROUP BY p.pagesid
                    ORDER BY r.date DESC";
	$result_keyword = $xoopsDB->queryF($keyword);
	$myrow_keyword = $xoopsDB->fetchArray($result_keyword);

	$query = "SELECT count(r.id) AS nb, sum(p.visit) AS visit, sum(p.visit_tmp) AS visit_tmp, r.startdate, p.date  FROM " .
				    $xoopsDB->prefix("myref_query_pages") . " p LEFT JOIN " .
                    $xoopsDB->prefix("myref_query") . " r on r.id = p.queryid
                    WHERE r.keyword=0 AND p.pagesid = '$id'
                    GROUP BY p.pagesid
                    ORDER BY r.date DESC";
	$result_query = $xoopsDB->queryF($query);
	$myrow_query = $xoopsDB->fetchArray($result_query);

	$robots = "SELECT count(r.id) AS nb, sum(p.visit) AS visit, sum(p.visit_tmp) AS visit_tmp, r.startdate, p.date  FROM " .
				    $xoopsDB->prefix("myref_robots_pages") . " p LEFT JOIN " .
                    $xoopsDB->prefix("myref_robots") . " r on r.id = p.robotsid
                    WHERE p.pagesid = '$id'
                    GROUP BY p.pagesid
                    ORDER BY p.pagesid, r.date DESC";
	$result_robots = $xoopsDB->queryF($robots);
	$myrow_robots = $xoopsDB->fetchArray($result_robots);

// Admin
	$delete = "<a href='detail_pages.php?op=del&id=".$myrow["id"]."'>
			<img src='../images/icon/delete.gif' alt='"._DELETE."'></a>";

	if ( $myrow["hide"] ) {
       	$status = '&nbsp;<a href="detail_pages.php?op=d&id='.$myrow["id"].'">
				<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" /></a>';
	} else {
       	$status = '&nbsp;<a href="detail_pages.php?op=h&id='.$myrow["id"].'">
				<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_HIDDEN.'" /></a>';
	}
	echo '<div align="right" style="border:1px; padding:2px; "><b>' . _MD_MYREFERER_ADMIN . '</b>' . $status. '&nbsp;' . $delete . '</div>';
// Admin

	echo '<div align="center">
    	  <table width="100%" border="1" cellspacing="0" cellpadding="2">
          <tr class="bg3">
          <th style="align:center;" colspan="3"><b>'._MD_MYREFERER_STATS.'</b></th>
          </tr>';


	if ( $myrow["hide"] ) {
       	$status = '<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_HIDDEN.'" />';
	} else {
       	$status = '<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" />';
	}

	// Display weekly stats about visits and limit number to 2
	$visit = $myrow["visit"];
	$page = $myrow["page"];
	$date = $myrow['date'];
	$startdate = $myrow['startdate'];

	$total_day = ($date - $startdate) / (60 * 60 * 24);
	$day_stat = ( $visit / $total_day );
	$tmp = explode('.', $day_stat);
	if( $tmp[1] ){
		$tmp[1] = '.'.substr ( $tmp[1] , 0 , 2 );
	}
	$day_stat = abs($tmp[0].$tmp[1]);

	if ( $day_stat <= $visit AND $day_stat > 0) {
		$stats = '<nobr>'.$visit.' ['.$day_stat.'&nbsp;/&nbsp;'._DAY.']</nobr>';
	} else {
		$stats = '<b>'.$visit.'</b>';
	}

	preg_match("/(" . str_replace("/", "\/", XOOPS_URL) . ")(.*)/i", 'http://'.$myrow["page"], $mypage);
	$thepage = $mypage[2];
	if (preg_match("/(.*)(\?xoops_redirect)(.*)/i", $mypage[2],$tmppage) ) {
		$thepage = $tmppage[1];
	}
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_PAGE			. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $thepage			. '</td></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_ID		. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow["id"] 		. '</td></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $stats				. '</td></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow["visit_tmp"]	. '</td></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_FIRST	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow['startdate']) . '</td></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow["date"]) .'</td></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_STATUS	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $status				. '</td></tr>';

	// visitors
    $other_visit = $myrow["visit"];
    if ( mysql_NumRows( $result_members ) != 0) {
    	$other_visit = $other_visit - $myrow_members["visit"];
    }
    if ( mysql_NumRows( $result_referer ) != 0) {
    	$other_visit = $other_visit - $myrow_referer["visit"];
    }
    if ( mysql_NumRows( $result_search ) != 0) {
    	$other_visit = $other_visit - $myrow_search["visit"];
    }
    if ( mysql_NumRows( $result_keyword ) != 0) {
    	$other_visit = $other_visit - $myrow_keyword["visit"];
    }
    if ( mysql_NumRows( $result_query ) != 0) {
    	$other_visit = $other_visit - $myrow_query["visit"];
    }
    if ( mysql_NumRows( $result_robots ) != 0) {
    	$other_visit = $other_visit - $myrow_robots["visit"];
    }

    $other_visit_tmp = $myrow["visit_tmp"];
    if ( mysql_NumRows( $result_members ) != 0) {
    	$other_visit_tmp = $other_visit_tmp - $myrow_members["visit_tmp"];
    }
    if ( mysql_NumRows( $result_referer ) != 0) {
    	$other_visit_tmp = $other_visit_tmp - $myrow_referer["visit_tmp"];
    }
    if ( mysql_NumRows( $result_search ) != 0) {
    	$other_visit_tmp = $other_visit_tmp - $myrow_search["visit_tmp"];
    }
    if ( mysql_NumRows( $result_keyword ) != 0) {
    	$other_visit_tmp = $other_visit_tmp - $myrow_keyword["visit_tmp"];
    }
    if ( mysql_NumRows( $result_query ) != 0) {
    	$other_visit_tmp = $other_visit_tmp - $myrow_query["visit_tmp"];
    }
    if ( mysql_NumRows( $result_robots ) != 0) {
    	$other_visit_tmp = $other_visit_tmp - $myrow_robots["visit_tmp"];
    }

	// members
	echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_MEMBERS ;
    if ( mysql_NumRows( $result_referer ) != 0) {
    	echo  '&nbsp;[' . $myrow_referer["nb"] . ']</b></th></tr>';
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_members["visit"]		. '</td></tr>';
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_members["visit_tmp"]	. '</td></tr>';
//		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow_referer['date']) .'</td></tr>';
    } else {
	    echo '</b></th></tr>';
		echo '<tr><td colspan="3"><nobr><b>' . _MD_MYREFERER_NOVISIT	. '</b></nobr></td></tr>';
    }

	echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_VISITORS . '</b></th></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $other_visit	. '</td></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $other_visit_tmp	. '</td></tr>';

	// referers
	echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_REFERER ;
    if ( mysql_NumRows( $result_referer ) != 0) {
    	echo  '&nbsp;[' . $myrow_referer["nb"] . ']</b></th></tr>';
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_referer["visit"]		. '</td></tr>';
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_referer["visit_tmp"]	. '</td></tr>';
//		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow_referer['date']) .'</td></tr>';
    } else {
	    echo '</b></th></tr>';
		echo '<tr><td colspan="3"><nobr><b>' . _MD_MYREFERER_NOVISIT	. '</b></nobr></td></tr>';
    }

	// search engine
	echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_ENGINE ;
    if ( mysql_NumRows( $result_search ) != 0) {
    	echo '&nbsp;[' . $myrow_search["nb"] . ']</b></th></tr>';
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_search["visit"]		. '</td></tr>';
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_search["visit_tmp"]	. '</td></tr>';
//		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow_search['date']) .'</td></tr>';
    } else {
	    echo '</b></th></tr>';
		echo '<tr><td colspan="3"><nobr><b>' . _MD_MYREFERER_NOVISIT	. '</b></nobr></td></tr>';
    }

	// Keyword
	echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_KEYWORDS ;
    if ( mysql_NumRows( $result_keyword ) != 0) {
		echo '&nbsp;[' . $myrow_keyword["nb"] . ']</b></th></tr>';
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_keyword["visit"]		. '</td></tr>';
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_keyword["visit_tmp"]	. '</td></tr>';
//		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow_keyword['date']) .'</td></tr>';
    } else {
	    echo '</b></th></tr>';
		echo '<tr><td colspan="3"><nobr><b>' . _MD_MYREFERER_NOVISIT	. '</b></nobr></td></tr>';
    }

	// query
	echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_QUERY ;
    if ( mysql_NumRows( $result_query ) != 0) {
		echo '&nbsp;[' . $myrow_query["nb"] . ']</b></th></tr>';
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_query["visit"]		. '</td></tr>';
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_query["visit_tmp"]	. '</td></tr>';
//		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow_query['date']) .'</td></tr>';
    } else {
	    echo '</b></th></tr>';
		echo '<tr><td colspan="3"><nobr><b>' . _MD_MYREFERER_NOVISIT	. '</b></nobr></td></tr>';
    }

	// robots
	echo '<tr class="bg3"><th style="align:center;" colspan="3"><b>' . _MD_MYREFERER_ROBOTS ;
    if ( mysql_NumRows( $result_robots ) != 0) {
		echo '&nbsp;[' . $myrow_robots["nb"] . ']</b></th></tr>';
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_robots["visit"] 		. '</td></tr>';
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow_robots["visit_tmp"]	. '</td></tr>';
//		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow_robots['date']) .'</td></tr>';
    } else {
	    echo '</b></th></tr>';
		echo '<tr><td colspan="3"><nobr><b>' . _MD_MYREFERER_NOVISIT	. '</b></nobr></td></tr>';
    }

	echo '</table>';
} // if result

include_once("detail_footer.php");
?>
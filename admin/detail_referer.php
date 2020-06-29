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
		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_referer")." WHERE id = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_referer_stats")." WHERE refererid = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_referer_pages")." WHERE refererid = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_query_referer_stats")." WHERE refererid = '$id' ";
		$xoopsDB->queryF($sql);

		echo "<script type='text/javascript'>\n";
    	echo "self.close();\n";
	    echo "</script>";
    } else {
		include_once( 'detail_header.php' );

		$sql = "SELECT referer FROM " . $xoopsDB->prefix("myref_referer") . " WHERE id=$id";
        $result = $xoopsDB->query( $sql );
        list($name) = $xoopsDB->fetchRow($result);

		xoops_confirm(array('op' => $op, 'id' => $id, 'confirm' => 1, 'engine' => $engine, 'ord' => $ord, 'search' => $search, 'week' => $week, 'start' => $start), 'detail_referer.php', _MD_MYREFERER_DELETE_REFERER . " <br />" . "<br />" . $name . "<br />", _MD_MYREFERER_DELETE);

		include_once( 'detail_footer.php' );
		exit();
	}
}

// Hide/Show operation
if ( ($op == 'h' OR $op == 'd') AND $id ) {
	if ( $op == 'd' ) { $hide = 0; } else { $hide = 1; }
	$sql = "UPDATE ".$xoopsDB->prefix("myref_referer")." SET hide = '$hide' WHERE id = '$id'";
	$xoopsDB->queryF($sql);
}

// $this_date = date('W'); $this_name = _MD_MYREFERER_WEEK; // Week
$query = "SELECT * FROM " . $xoopsDB->prefix("myref_referer") . " WHERE id = '$id'";
$counter = $xoopsDB->queryF($query);
$count = mysql_NumRows( $counter );

include_once( 'detail_header.php' );

if( $count == 0) {
	echo '<div align="center">' . _MD_MYREFERER_NOVISIT . "</div>";
} else {
	$result = $xoopsDB->queryF($query);
	$myrow = $xoopsDB->fetchArray($result);

// Admin
	$delete = "<a href='detail_referer.php?op=del&id=".$myrow["id"]."'>
			<img src='../images/icon/delete.gif' alt='"._DELETE."'></a>";

	if ( $myrow["hide"] ) {
       	$status = '&nbsp;<a href="detail_referer.php?op=d&id='.$myrow["id"].'">
				<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" /></a>';
	} else {
       	$status = '&nbsp;<a href="detail_referer.php?op=h&id='.$myrow["id"].'">
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
	$robot_name = myReferer_GetRobotName($myrow["robots"]);
	$robot_url = myReferer_GetRobotUrl($myrow["robots"]);

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

	if ($myrow['engine'] == 1) {
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_REFERER	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow["referer"]						. '</td></tr>';
    } else {
		echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_ENGINE	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow["referer"]						. '</td></tr>';
    }
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_ID		. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow["id"] 							. '</td></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_TOTAL	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $stats				   					. '</td></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_WEEK 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $myrow["visit_tmp"]						. '</td></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_FIRST	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($myrow['startdate'])	. '</td></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_LAST 	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . formatTimestamp($date)					.'</td></tr>';
	echo '<tr><td style="text-align:left;"><nobr><b>' . _MD_MYREFERER_STATS_STATUS	. '</b></nobr></td><td colspan="2" style="text-align:left;">' . $status				   					. '</td></tr>';

	// pages viewed
	$page_query = "SELECT f.refererid, f.pagesid, p.page, f.visit, f.visit_tmp, f.date, p.hide FROM " .
    			  $xoopsDB->prefix("myref_referer_pages") . " f LEFT JOIN " .
                  $xoopsDB->prefix("myref_pages")  . " p on f.pagesid = p.id
                  WHERE f.refererid = " . $myrow["id"] . " ORDER BY p.hide, p.page";

	$page_result = $xoopsDB->queryF($page_query);

    echo '<tr><th colspan="3" style="align:center;"><b>' . _MD_MYREFERER_PAGE . '</b></th></tr>';
	echo '<tr><td colspan="3" style="text-align:left;">';
	while ( $page_myrow = $xoopsDB->fetchArray($page_result) )  {

		if ( $page_myrow["hide"] ) {
			$font_in = '<font color="red">';
		} else {
			$font_in = '<font color="green">';
		}
		preg_match("/(" . str_replace("/", "\/", XOOPS_URL) . ")(.*)/i", 'http://'.$page_myrow["page"], $pages);

		echo '<a target="thepage" href="http://' . $page_myrow["page"] . '">' .
        	  $font_in . $pages[2] . '</font></a> ['. $page_myrow["visit_tmp"] . '/<b>' . $page_myrow["visit"] . '</b>]&nbsp;(' . formatTimestamp($page_myrow['date']) . ')<br /> ';

	}

    echo '</tr>';
	echo '</table>';
} // if result

include_once("detail_footer.php");
?>
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
// $startart = isset( $HTTP_GET_VARS['startart'] ) ? intval( $HTTP_GET_VARS['startart'] ) : 0;
error_reporting(E_ALL ^ E_NOTICE);

if (!isset($_POST["startart"])) {
	$startart = isset($_GET["startart"]) ? $_GET["startart"] : 0;
} else {
	$startart = $_POST["startart"];
}
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

if (!isset($_POST["ord"])) {
	$ord = isset($_GET["ord"]) ? $_GET["ord"] : "";
} else {
	$ord = $_POST["ord"];
}

if (!isset($_POST["search"])) {
	$search = isset($_GET["search"]) ? $_GET["search"] : "";
} else {
	$search = $_POST["search"];
}

if (!isset($_POST["week"])) {
	$week = isset($_GET["week"]) ? $_GET["week"] : 0;
} else {
	$week = $_POST["week"];
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

		redirect_header('stats_pages.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=&startart='.$startart, 1, _MD_MYREFERER_CLEANED);
		exit();
    } else {
		myReferer_adminmenu(0, _MD_MYREFERER_STATS);

		$sql = "SELECT page FROM " . $xoopsDB->prefix("myref_pages") . " WHERE id=$id";
        $result = $xoopsDB->query( $sql );
        list($name) = $xoopsDB->fetchRow($result);
		preg_match("/(" . str_replace("/", "\/", XOOPS_URL) . ")(.*)/i", 'http://'.$name, $mypage);
        $name = $mypage[2];

		xoops_confirm(array('op' => $op, 'id' => $id, 'confirm' => 1, 'ord' => $ord, 'search' => $search, 'week' => $week, 'start' => $start) , 'stats_pages.php', _MD_MYREFERER_DELETE_PAGE . " <br />" . "<br />" . $name . "<br />", _MD_MYREFERER_DELETE);

		xoops_cp_footer();
		exit();
	}
}

// Hide/Show operation
if ( ($op == 'h' OR $op == 'd') AND $id ) {
	if ( $op == 'd' ) { $hide = 1; } else { $hide = 0; }
	$sql = "UPDATE ".$xoopsDB->prefix("myref_pages")." SET hide = '$hide' WHERE id = '$id'";
	$xoopsDB->queryF($sql);

	redirect_header('stats_pages.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=whitelist&startart='.$startart, 0, _MD_MYREFERER_UPDATED, true);
	exit();
}

// $this_date = date('m'); $this_name = _MD_MYREFERER_MONTH; // Month
$this_date = date('W'); $this_name = _MD_MYREFERER_WEEK; // Week
//   $this_date = date('z'); $this_name = _MD_MYREFERER_DAY; // Day of th year

$all = _MD_MYREFERER_ALL;

if ( $week ) { $where_week = "AND visit_tmp > 0"; $all = '';}
if ( $op == 'blacklist' ) {
	$where = "hide = 1";
}
elseif ( $op == 'whitelist' ) {
	$where = "hide = 0";
}
else {
	$where = "hide >= 0";
}

if ($ord == "") {
	$ordre = "visit_tmp";
	$sort_ordre = "DESC";
	$ord_text = _MD_MYREFERER_VISITS.' / '._MD_MYREFERER_WEEK;
}
if ($ord == "1") {
	$ordre = "id";
	$sort_ordre = "DESC";
	$ord_text = _MD_MYREFERER_LATEST;
}
if ($ord == "2") {
	$ordre = $xoopsModuleConfig['order'];
	$sort_ordre = "DESC";
	$ord_text = _MD_MYREFERER_VISITS;
}
if ($ord == "3") {
	$ordre = "page";
	$sort_ordre = "ASC";
	$ord_text = _MD_MYREFERER_PAGE;
}
if ($ord == "4") {
	$ordre = "date";
	$sort_ordre = "DESC";
	$ord_text = _MD_MYREFERER_DATE;
}

if ( $op == 'blacklist' ) {
	$all = '<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_HIDDEN.'" align="absmiddle" />&nbsp;';
    if ($week==1) {
    	$all .= "$this_name : $this_date";
    } else {
    	$all .= _MD_MYREFERER_ALL;
    }
	$black = '<a href="stats_pages.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=&startart='.$startart.'">
    		<img src="../images/icon/all.gif" alt="'._MD_MYREFERER_ALL.'" align="absmiddle" /></a>&nbsp;';

	$black .= '<a href="stats_pages.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=whitelist&startart='.$startart.'">
			<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" align="absmiddle" /></a>&nbsp;';

} elseif ( $op == 'whitelist' ) {
	$all = '<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" align="absmiddle" />&nbsp;';
    if ($week==1) {
    	$all .= "$this_name : $this_date";
    } else {
    	$all .= _MD_MYREFERER_ALL;
    }
	$black = '<a href="stats_pages.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=&startart='.$startart.'">
    		<img src="../images/icon/all.gif" alt="'._MD_MYREFERER_ALL.'" align="absmiddle" /></a>&nbsp;';

	$black .= '<a href="stats_pages.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=blacklist&startart='.$startart.'">
			<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_HIDDEN.'" align="absmiddle" /></a>';
} else {
	$all = '<img src="../images/icon/all.gif" alt="'._MD_MYREFERER_ALL.'" align="absmiddle" />&nbsp;';
    if ($week==1) {
    	$all .= "$this_name : $this_date";
    } else {
    	$all .= _MD_MYREFERER_ALL;
    }
	$black = '<a href="stats_pages.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=whitelist&startart='.$startart.'">
			<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" align="absmiddle" /></a>&nbsp;';

	$black .= '<a href="stats_pages.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=blacklist&startart='.$startart.'">
			<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_HIDDEN.'" align="absmiddle" /></a>';
}

myReferer_adminmenu(0, _MD_MYREFERER_STATS);
myReferer_statmenu(0, '');
OpenTable();

// Display informations
echo"<table width='100%'><tr><td>";
echo "<b>".$xoopsConfig['sitename']."</b><br /><a href='stats_pages.php?ord=$ord&search=$search&week=0&op=$op&startart=$startart'>"._MD_MYREFERER_ALL."</a> | <a href='stats_pages.php?ord=$ord&search=$search&week=1&op=$op&startart=$startart'>$this_name : $this_date </a> | $black";
echo "</td><td align='right'>";
myReferer_search($ord, $search, $engine, $week, $startart);
echo "</td></tr></table>";
// Display informations

$pages = "	SELECT * FROM " .
		$xoopsDB->prefix("myref_pages") . "
		WHERE $where $where_week AND page LIKE '%$search%'
		ORDER BY $ordre $sort_ordre";


$counter = $xoopsDB->queryF($pages);
$count = mysql_NumRows( $counter );

if( $count == 0) {
	echo _MD_MYREFERER_NOVISIT."<p />";
} else {
	$result = $xoopsDB->queryF($pages, $xoopsModuleConfig['perpage'], $startart);
	$pagenav = new XoopsPageNav( $count, $xoopsModuleConfig['perpage'], $startart, 'startart', 'ord='.$ord.'&search='.$search.'&week='.$week.'&op='.$op );

	echo "<br /><div style='text-align:center;'><b>$all</b> ". _MD_MYREFERER_RANKING . " <b>$ord_text</b> ($count)</div>";
	echo "<div style='text-align:right; width:95%;'>" . $pagenav -> renderNav() . "</div>";
	echo "<div align='center'>
		  <table border='0' cellpadding='4' cellspacing='1' class='bg2' width='90%'>
          <tr class='bg3'>
          <th style='align:center;'><a href='stats_pages.php?ord=1&search=$search&week=$week&op=$op&startart=$startart' title='"._MD_MYREFERER_RANKING._MD_MYREFERER_LATEST."'>		N°			</a></th>
          <th style='align:center;'>
          <a href='stats_pages.php?ord=&search=$search&week=$week&op=$op&startart=$startart' title='"._MD_MYREFERER_RANKING._MD_MYREFERER_VISITS." "._MD_MYREFERER_WEEK."'>	"._MD_MYREFERER_WEEK."</a>
          (<a href='stats_pages.php?ord=2&search=$search&week=$week&op=$op&startart=$startart' title='"._MD_MYREFERER_RANKING._MD_MYREFERER_VISITS." "._MD_MYREFERER_ALL."'>	"._MD_MYREFERER_VISITS."</a> )
          </th>
          <th style='align:center;'><a href='stats_pages.php?ord=3&search=$search&week=$week&op=$op&startart=$startart' title='"._MD_MYREFERER_RANKING._MD_MYREFERER_PAGE."'>	"._MD_MYREFERER_PAGE."</a></th>
          <th style='align:center;'><a href='stats_pages.php?ord=4&search=$search&week=$week&op=$op&startart=$startart' title='"._MD_MYREFERER_RANKING._MD_MYREFERER_DATE."'>	"._MD_MYREFERER_DATE."	</a></th>
          <th style='align:center;'><b>"._MD_MYREFERER_ADMIN."</b></th>
          </tr>";

    $i = $startart;
	while ( $myrow = $xoopsDB->fetchArray($result) ) {
		if ( $myrow["date"] ) {
//			$data_date = formatTimestamp($myrow["date"],'m');
			$data_date = formatTimestamp($myrow["date"],'W');
//			$data_date = formatTimestamp($myrow["date"],'z');
// 			$data_date = formatTimestamp($myrow["date"],'r');
		} else {
           	$date = _MD_MYREFERER_NOVISITYET;
		}

		if ( $myrow["startdate"] ){
           	$startdate = formatTimestamp($myrow["startdate"],'m');
		} else {
           	$startdate = _MD_MYREFERER_NOVISITYET;
		}

		preg_match("/(" . str_replace("/", "\/", XOOPS_URL) . ")(.*)/i", 'http://'.$myrow["page"], $mypage);
        $thepage = $mypage[2];
        if (preg_match("/(.*)(\?xoops_redirect)(.*)/i", $mypage[2],$tmppage) ) {
        	$thepage = $tmppage[1];
        }

        $detail = "<a onclick=\"window.open('', 'wclose', 'width=800, height=500, toolbar=no, scrollbars=yes, status=no, resizable=no, fullscreen=no, titlebar=no, left=10, top=10', 'false')\"  href='detail_pages.php?id=".$myrow["id"] ."' target='wclose'>
				<img src='../images/icon/detail.gif' alt='"._MD_MYREFERER_MORE."'></a>";
		$delete = "<a href='stats_pages.php?ord=$ord&search=$search&week=$week&op=del&id=".$myrow["id"]."'>
				<img src='../images/icon/delete.gif' alt='"._DELETE."'></a>";

		if ( $myrow["hide"] ) {
           	$status = '&nbsp;<a href="stats_pages.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=h&startart='.$startart.'&id='.$myrow["id"].'">
					<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_HIDDEN.'" /></a>';
		} else {
           	$status = '&nbsp;<a href="stats_pages.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=d&startart='.$startart.'&id='.$myrow["id"].'">
					<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" /></a>';
		}

		if ($ord == "1") { $time = $myrow["startdate"]; } else { $time = $myrow["date"]; }
		// setlocale('LC_TIME', 'french');

		if ( $this_date == $data_date ) {
           	$bg = "class='bg4'";
		} else {
           	$bg = "style='background-color:#EEE; color:#999;'";
		}

		$i++;
		if ( strlen($thepage) > 60 ) { $thepage = substr($thepage,0,60).'[...]'; }
		echo "<tr $bg>
           	  <td align='center'>	$i</a></td>
              <td align='center'><b>".$myrow["visit_tmp"]."</b> (".$myrow["visit"].")	</td>
              <td align='left'><a href='http://".$myrow["page"]."' title='" . $myrow["page"] ."' target='_blank'>" . $thepage . "</a></td>
              <td align='center'>	".formatTimestamp($time)."	</td>
              <td align='center'>	<nobr>$detail&nbsp;$delete&nbsp;$status</nobr>	</td>
              </tr>";

	}
	echo "</table></div>";
	echo '<div style="text-align:center;">' . $pagenav -> renderNav() . '</div>';
	echo "<br />\n";
}
CloseTable();
include_once( 'admin_footer.php' );
?>
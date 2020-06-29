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
		$sql = "DELETE FROM " . $xoopsDB->prefix("myref_robots") . " WHERE id = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_robots_stats")." WHERE robotsid = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_robots_pages")." WHERE robotsid = '$id' ";
		$xoopsDB->queryF($sql);

		$sql = "DELETE FROM ".$xoopsDB->prefix("myref_robots_pages_stats")." WHERE robotsid = '$id' ";
		$xoopsDB->queryF($sql);

		redirect_header('stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=&startart='.$startart, 1, _MD_MYREFERER_CLEANED);
		exit();
    } else {
		myReferer_adminmenu(0, _MD_MYREFERER_STATS);

		$sql = "SELECT robots FROM " . $xoopsDB->prefix("myref_robots") . " WHERE id=$id";
        $result = $xoopsDB->query( $sql );
        list($name) = $xoopsDB->fetchRow($result);
		$name = myReferer_GetRobotName($name);

        xoops_confirm(array('op' => $op, 'id' => $id, 'confirm' => 1, 'ord' => $ord, 'search' => $search, 'week' => $week, 'start' => $start) , 'stats_robots.php', _MD_MYREFERER_DELETE_ROBOT . " <br />" . "<br />" . $name . "<br />", _MD_MYREFERER_DELETE);

		xoops_cp_footer();
		exit();
	}
}

// Hide/Show operation
if ( ($op == 'h' OR $op == 'd') AND $id ) {
	if ( $op == 'd' ) { $hide = 1; } else { $hide = 0; }
    $sql = "UPDATE " . $xoopsDB->prefix("myref_robots") . " SET hide = '$hide' WHERE id = '$id'";

	$xoopsDB->queryF($sql);
	redirect_header('stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=whitelist&startart='.$startart, 1, _MD_MYREFERER_UPDATED, true);
	exit();
}

// Tracker on/off operation
if ( ($op == 'tracker_on' OR $op == 'tracker_off') AND $id ) {
	if ( $op == 'tracker_on' ) { $tracker = 1; } else { $tracker = 0; }
    $sql = "UPDATE " . $xoopsDB->prefix("myref_robots") . " SET tracker = '$tracker' WHERE id = '$id'";

	$xoopsDB->queryF($sql);
	redirect_header('stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=whitelist&startart='.$startart, 1, _MD_MYREFERER_UPDATED, true);
	exit();
}

// $this_date = date('m'); $this_name = _MD_MYREFERER_MONTH; // Month
$this_date = date('W'); $this_name = _MD_MYREFERER_WEEK; // Week
//   $this_date = date('z'); $this_name = _MD_MYREFERER_DAY; // Day of th year

$this_week = date('W');
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
	$ordre = "robots";
	$sort_ordre = "ASC";
	$ord_text = _MD_MYREFERER_ROBOTS;
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
	$black = '<a href="stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=&startart='.$startart.'">
    		<img src="../images/icon/all.gif" alt="'._MD_MYREFERER_ALL.'" align="absmiddle" /></a>&nbsp;';

	$black .= '<a href="stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=whitelist&startart='.$startart.'">
			<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" align="absmiddle" /></a>&nbsp;';
} elseif ( $op == 'whitelist' ) {
	$all = '<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" align="absmiddle" />&nbsp;';
    if ($week==1) {
    	$all .= "$this_name : $this_date";
    } else {
    	$all .= _MD_MYREFERER_ALL;
    }
	$black = '<a href="stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=&startart='.$startart.'">
    		<img src="../images/icon/all.gif" alt="'._MD_MYREFERER_ALL.'" align="absmiddle" /></a>&nbsp;';

	$black .= '<a href="stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=blacklist&startart='.$startart.'">
			<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_HIDDEN.'" align="absmiddle" /></a>';
} else {
	$all = '<img src="../images/icon/all.gif" alt="'._MD_MYREFERER_ALL.'" align="absmiddle" />&nbsp;';
    if ($week==1) {
    	$all .= "$this_name : $this_date";
    } else {
    	$all .= _MD_MYREFERER_ALL;
    }
	$black = '<a href="stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=whitelist&startart='.$startart.'">
			<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" align="absmiddle" /></a>&nbsp;';

	$black .= '<a href="stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=blacklist&startart='.$startart.'">
			<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_HIDDEN.'" align="absmiddle" /></a>';
}

myReferer_adminmenu(0, _MD_MYREFERER_STATS);
myReferer_statmenu(3, '');
OpenTable();

// Display informations
echo"<table width='100%'><tr><td>";
echo "<b>".$xoopsConfig['sitename']."</b><br /><a href='stats_robots.php?ord=$ord&search=$search&week=0&op=$op&startart=$startart'>"._MD_MYREFERER_ALL."</a> | <a href='stats_robots.php?ord=$ord&search=$search&week=1&op=$op&startart=$startart'>"._MD_MYREFERER_WEEK." : $this_week </a> | $black";
echo "</td><td align='right'>";
myReferer_search($ord, $search, $engine, $week, $startart);
echo "</td></tr></table>";
// Display informations

$query = "SELECT * FROM " . $xoopsDB->prefix("myref_robots") . "
	WHERE $where $where_week AND ( ref_url LIKE '%$search%' OR robots LIKE '%$search%' )
	ORDER BY $ordre $sort_ordre";

$counter = $xoopsDB->queryF($query);
$count = mysql_NumRows( $counter );

if( $count == 0) {
  echo _MD_MYREFERER_NOVISIT."<p />";
} else {

	$result = $xoopsDB->queryF($query, $xoopsModuleConfig['perpage'], $startart);
	$pagenav = new XoopsPageNav( $count, $xoopsModuleConfig['perpage'], $startart, 'startart', 'ord='.$ord.'&search='.$search.'&week='.$week.'&op='.$op );

	echo "<br /><div style='text-align:center;'><b>$all</b> ". _MD_MYREFERER_RANKING . " <b>$ord_text</b> ($count)</div>";
	echo "<a
             onclick=\"pop=window.open('', 'wclose', 'width=800, height=600, dependent=yes, toolbar=no, menubar=yes, status=no, scrollbars=yes, resizable=yes, titlebar=yes, left=160, top=160', 'false'); pop.focus(); \"
             target='wclose'
             href='report.php?sql=myref_robots&ord=$ord&search=$search&week=$week&op=$op&startart=$startart'
             title='"._MD_MYREFERER_REPORT."'>"._MD_MYREFERER_REPORT."</a>";
	echo "<div style='text-align:right; width:95%;'>" . $pagenav -> renderNav() . "</div>";
	echo "<div align='center'>
		  <table border='0' cellpadding='4' cellspacing='1' class='bg2' width='90%'>
          <tr class='bg3'>
          <th style='align:center;'><a href='stats_robots.php?ord=1&search=$search&week=$week&op=$op&startart=$startart' title='"._MD_MYREFERER_RANKING._MD_MYREFERER_LATEST."'>		N°			</a></th>
          <th style='align:center;'><nobr>
          <a href='stats_robots.php?ord=&search=$search&week=$week&op=$op&startart=$startart' title='"._MD_MYREFERER_RANKING._MD_MYREFERER_VISITS." "._MD_MYREFERER_WEEK."'>	"._MD_MYREFERER_WEEK."</a>
          (<a href='stats_robots.php?ord=2&search=$search&week=$week&op=$op&startart=$startart' title='"._MD_MYREFERER_RANKING._MD_MYREFERER_VISITS." "._MD_MYREFERER_ALL."'>	"._MD_MYREFERER_VISITS."</a> ) </nobr>
          </th>
          <th style='align:center;'><a href='stats_robots.php?ord=3&search=$search&week=$week&op=$op&startart=$startart' title='"._MD_MYREFERER_RANKING._MD_MYREFERER_ROBOTS."'>	"._MD_MYREFERER_ROBOTS."</a></th>
          <th style='align:center;'><a href='stats_robots.php?ord=4&search=$search&week=$week&op=$op&startart=$startart' title='"._MD_MYREFERER_RANKING._MD_MYREFERER_DATE."'>	"._MD_MYREFERER_DATE."	</a></th>
          <th style='align:center;'><b>"._MD_MYREFERER_ADMIN."</b></th>
          </tr>";

          // Get flag list
//define the path as relative
$path = "../images/logos/robots";

//using the opendir function
$dir_handle = @opendir($path) or die("Unable to open $path");

// echo "Directory Listing of $path<br/>";
     $pattern_robot=array();

//running the while loop
while ($file = readdir($dir_handle)) 
{

      if( $file!='.' && $file!='..' ) { 
          $file = str_replace('robot_', '', $file);
          $file = str_replace('.png', '', $file);
          $pattern_robots[] = $file; }
}

//closing the directory
closedir($dir_handle);

	$i = $startart;
	while ( $myrow = $xoopsDB->fetchArray($result) ) {
		if ( $myrow["date"] ) {
        	$date = formatTimestamp($myrow["date"],'m');
			$date_week = formatTimestamp($myrow["date"],'W');
			$date_month = formatTimestamp($myrow["date"],'F');
		} else {
        	$date = _MD_MYREFERER_NOVISITYET;
        }

        if ( $myrow["startdate"] ) {
        	$startdate = formatTimestamp($myrow["startdate"],'m');
			$startdate_week = formatTimestamp($myrow["startdate"],'W');
			$startdate_month = formatTimestamp($myrow["startdate"],'F');
		} else {
        	$startdate = _MD_MYREFERER_NOVISITYET;
        }

		$page =	str_replace( XOOPS_URL, '' , 'http://'.$myrow["page"] );

                $robot = addslashes($myrow["robots"]);
		$robot_name = myReferer_GetRobotName($robot);
		$robot_url = myReferer_GetRobotUrl($robot);

                include("robots_pics.php");

		if ( $robot_url != '') {
    		$robot_name = "<a href='$robot_url' title='".$myrow["robots"]."' title='" .$myrow["robots"]. "' target='_blank'>$robot_name</a>";
		} else {
    		$robot_name = $myrow["robots"];
	    }
                $robot_name = '<a href="stats_robots.php?search='.$robot_icon.'">
                            <img src="../images/logos/robots/robot_'.$robot_icon.'.png" alt="'.$robot_icon.'" /></a> ' . $robot_name;

        $detail = "<a onclick=\"window.open('', 'wclose', 'width=800, height=500, toolbar=no, scrollbars=yes, status=no, resizable=no, fullscreen=no, titlebar=no, left=10, top=10', 'false')\"  href='detail_robots.php?id=".$myrow["id"] ."' target='wclose'>
				<img src='../images/icon/detail.gif' alt='"._MD_MYREFERER_MORE."'></a>";

		$delete = "<a href='stats_robots.php?ord=$ord&search=$search&week=$week&op=del&id=".$myrow["id"]."'>
				<img src='../images/icon/delete.gif' alt='"._DELETE."' valign='absmiddle' /></a>";

		if ( $myrow["hide"] ) {
    		$status = '&nbsp;<a href="stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=h&startart='.$startart.'&id='.$myrow["id"].'">
					<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_HIDDEN.'" valign="absmiddle" /></a>';
		} else {
    		$status = '&nbsp;<a href="stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=d&startart='.$startart.'&id='.$myrow["id"].'">
					<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" valign="absmiddle" /></a>';
		}

		if ( $myrow["tracker"]==1 ) {
    		$tracker = '&nbsp;<a href="stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=tracker_off&startart='.$startart.'&id='.$myrow["id"].'">
					<img src="../images/icon/tracker_on.gif" alt="'._MD_MYREFERER_TRACKER_OFF.'" valign="absmiddle" /></a>';
		} else {
    		$tracker = '&nbsp;<a href="stats_robots.php?ord='.$ord.'&search='.$search.'&week='.$week.'&op=tracker_on&startart='.$startart.'&id='.$myrow["id"].'">
					<img src="../images/icon/tracker_off.gif" alt="'._MD_MYREFERER_TRACKER_ON.'" valign="absmiddle" /></a>';
		}

		if ($ord == "1") { $time = $startdate; } else { $time = $date; }


		if ( $this_week == $date_week ) { $bg = "class='bg4'"; } else { $bg = "style='background-color:#CCC; color:#666;'"; }
			$i++;
			echo "<tr $bg >
				  <td align='center'>	$i	</td>
                  <td align='center'><b>".$myrow["visit_tmp"]."</b> (".$myrow["visit"].")	</td>
                  <td align='left'>		$robot_name 	</td>
                  <td align='center'>	$time	</td>
                  <td align='center'>	<nobr>$detail&nbsp;$delete&nbsp;$status&nbsp;$tracker</nobr>	</td>
                  </tr>";

	}
	echo "</table></div>";
	echo '<div style="text-align:center;">' . $pagenav -> renderNav() . '</div>';
	echo "<br />\n";
}

CloseTable();
include_once( 'admin_footer.php' );
?>
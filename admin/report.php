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

// include("admin_header.php");
//include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
// $startart = isset( $HTTP_GET_VARS['startart'] ) ? intval( $HTTP_GET_VARS['startart'] ) : 0;
// error_reporting(E_ALL ^ E_NOTICE);


include_once( '../../../mainfile.php');
include_once( '../../../include/cp_header.php');

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

if (!isset($_POST["engine"])) {
	$engine = isset($_GET["engine"]) ? $_GET["engine"] : "0";
} else {
	$engine = $_POST["engine"];
}

if (!isset($_POST["sql"])) {
	$sql = isset($_GET["sql"]) ? $_GET["sql"] : 0;
} else {
	$sql = $_POST["sql"];
}
$and ='';

if($engine==1) { $and = " AND engine=1"; $data = 'referer'; $title = _MD_MYREFERER_ENGINE;} elseif ($engine==0) { $and .= " AND engine=0"; $data = 'referer'; $title = _MD_MYREFERER_REFERER;}
if($sql=='myref_query') { $and = " AND keyword=0"; $data = 'query'; $title = _MD_MYREFERER_QUERY; } elseif($sql=='myref_keywords') { $and = " AND keyword=1"; $sql='myref_query'; $data = 'query'; $title = _MD_MYREFERER_KEYWORDS; }
if($sql=='myref_robots') { $data = 'robots'; $and=''; $title = _MD_MYREFERER_ROBOTS;}
if($sql=='myref_users') { $data = 'user'; $and=''; $title = _MD_MYREFERER_USERS;}

$this_date = date('W'); $this_name = _MD_MYREFERER_WEEK; // Week
$all = _MD_MYREFERER_ALL;

if ( $week ) { $where_week = "AND visit_tmp > 0"; $all = '';} else { $where_week = ""; }
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
	$ordre = "query";
	$sort_ordre = "ASC";
	$ord_text = _MD_MYREFERER_KEYWORDS;
}
if ($ord == "4") {
	$ordre = "date";
	$sort_ordre = "DESC";
	$ord_text = _MD_MYREFERER_DATE;
}



$query = "	SELECT * FROM ".$xoopsDB->prefix($sql)."
		WHERE $where $where_week AND $data LIKE '%$search%' $and
		ORDER BY $ordre $sort_ordre";
$counter = $xoopsDB->queryF($query);
$count = mysql_NumRows( $counter );

if( $count == 0) {
	echo _MD_MYREFERER_NOVISIT."<p />";
} else {
	$result = $xoopsDB->queryF($query, $xoopsModuleConfig['perpage'], $startart);
//	$pagenav = new XoopsPageNav( $count, $xoopsModuleConfig['perpage'], $startart, 'startart', 'ord='.$ord.'&search='.$search.'&week='.$week.'&op='.$op );
        echo "<html>";
        echo "<head>";
        echo "<link rel='stylesheet' type='text/css' media='all' href='http://www.arma-sa.com/xoops.css' />";
        echo "<link rel='stylesheet' type='text/css' media='all' href='http://www.arma-sa.com/modules/system/style.css' />";
       	echo '<style type="text/css">';
	echo 'body {font-size: 12px; }';
	echo 'td {font-size: 10px; }';
	echo '</style>';
        echo "</head>";
        echo "<body>";
	echo "<div style='text-align:center;'>". _MD_MYREFERER_WEEK . " <b>$this_date</b> (".date(l)." ".formatTimestamp(time()).")</div>";
	echo "<div style='text-align:center;'><b>$all</b> ". _MD_MYREFERER_RANKING . " <b>$ord_text</b> ($count)</div>";

	echo "<p />";
	echo "<div align='center'>
		  <table border='1' cellpadding='2' cellspacing='0' class='bg2' width='600px'>
          <tr class='bg3'>
          <th style='align:center;'>N°</th>
          <th style='align:center;'>"._MD_MYREFERER_WEEK." ("._MD_MYREFERER_VISITS.")</th>
          <th style='align:center;'>".$title." </th>
          <th style='align:center;'>"._MD_MYREFERER_DATE."</th>
          </tr>";

    $i = $startart;
	while ( $myrow = $xoopsDB->fetchArray($result) ) {
		if ( $myrow["date"] ) {
			$data_date = formatTimestamp($myrow["date"],'W');
		} else {
           	$date = _MD_MYREFERER_NOVISITYET;
		}

		if ( $myrow["startdate"] ){
           	$startdate = formatTimestamp($myrow["startdate"],'m');
		} else {
           	$startdate = _MD_MYREFERER_NOVISITYET;
		}

		if ($ord == "1") { $time = $myrow["startdate"]; } else { $time = $myrow["date"]; }

		if ( $this_date == $data_date ) {
           	$bg = "class='bg4'";
		} else {
           	$bg = "style='background-color:#EEE; color:#999;'";
		}

		$i++;
		if($data=='user') { $myrow[$data] = XoopsUser::getUnameFromId($myrow[$data]);}
		echo "<tr $bg>
              <td align='center'>       $i</td>
              <td align='center'>       <b>".$myrow["visit_tmp"]."</b> (".$myrow["visit"].")	</td>
              <td align='center'>       ".$myrow[$data]."</td>
              <td align='center'>       ".formatTimestamp($time)."	</td>
              </tr>";

	}
	echo "</table></div>";
	echo "<br />\n";
        echo "</body>";
        echo "</html>";
}
?>
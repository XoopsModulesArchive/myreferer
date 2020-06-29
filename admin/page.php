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
$startart = isset( $HTTP_GET_VARS['startart'] ) ? intval( $HTTP_GET_VARS['startart'] ) : 0;

if (!isset($_POST["ord"])) {
	$ord = isset($_GET["ord"]) ? $_GET["ord"] : "";
} else {
	$ord = $_POST["ord"];
}

if ($ord == "3") {
	$ordre = "robots";
	$sort_ordre = "ASC";
	$ord_text = _MD_MYREFERER_ORIGINE;
}
if ($ord == "4") {
	$ordre = "date";
	$sort_ordre = "DESC";
	$ord_text = _MD_MYREFERER_DATE;
}
if ($ord == "2") {
	$ordre = "visit";
	$sort_ordre = "DESC";
	$ord_text = _MD_MYREFERER_VISITS;
}
if ($ord == "") {
	$ordre = "page";
	$sort_ordre = "ASC";
	$ord_text = _MD_MYREFERER_PAGE;
}
if ($ord == "del") {
	$id = isset($_GET["id"]) ? $_GET["id"] : "";

	$sql = "DELETE FROM ".$xoopsDB->prefix("myref_page")." WHERE id = $id";
	$xoopsDB->queryF($sql);

	redirect_header("page.php", 1, _MD_MYREFERER_DELETED);
	exit();
}
if ($ord == "clean") {
	$id = isset($_GET["id"]) ? $_GET["id"] : "";

	//	$clean_days = (time()-(86400) );
	$clean_days = time();
	$sql = "DELETE FROM " . $xoopsDB->prefix("myref_page") . " WHERE date < $clean_days";
	$xoopsDB->queryF($sql);

	redirect_header("page.php", 1, _MD_MYREFERER_CLEANED);
	exit();
}

include_once ("../include/nav.php");
OpenTable();
echo _MD_MYREFERER_HEADER." <b>".$xoopsConfig['sitename']."</b> <br />";

$result = $xoopsDB->query("SELECT id, page, robots, visit, date FROM " . $xoopsDB->prefix("myref_page") . "
	ORDER BY $ordre $sort_ordre");

    $robots = mysql_NumRows( $result );

	if( $robots == 0) {
		echo _MD_MYREFERER_NOVISIT."<p />";
	} else {
		echo _MD_MYREFERER_PAGE." <b>$robots</b><p />
        	 <center>"._MD_MYREFERER_RANKING." <b>$ord_text</b></center>
             <br />";

		echo "<div align='center'>
        	  <table border='0' cellpadding='4' cellspacing='1' class='bg2' width='100%'>
              <tr class='bg3'>
              <td><center><b>N°</b></center></td>
              <td><center><b><a href='page.php?ord=2'>	"._MD_MYREFERER_VISITS."	</a></b></center></td>
              <td><center><b><a href='page.php?ord=3'>	"._MD_MYREFERER_ROBOTS."	</a></b></center></td>
              <td><center><b><a href='page.php'>		"._MD_MYREFERER_PAGE."	</a></b></center></td>
              <td><center><b><a href='page.php?ord=4'>	"._MD_MYREFERER_DATE."	</a></b></center></td>
              <td><center><b>"._MD_MYREFERER_ADMIN."</b></center></td>
              </tr>";

        $i = 0;
		while ( $myrow = $xoopsDB->fetchArray($result) ) {
			if ( $myrow["date"] ){ $dates = formatTimestamp($myrow["date"],'m'); } else { $dates = _MD_MYREFERER_NOVISITYET; }
			$page = str_replace( XOOPS_URL, '' , 'http://'.$myrow["page"] );

			myReferer_GetRobotInfo($myrow["robots"], 'robot_name', 'robot_url');

			if ( $myrow["visit"] == '0' ) { $bg = 'bg1'; $i = ''; $myrow["visit"] = 'Page';
	            $delete = "<a href='page.php?ord=del&id=".$myrow["id"]."'>
						<img src='../images/icon/delete.gif' alt='"._DELETE."'></a>";
			} else { $bg = 'bg4'; $i++; $page = ''; $delete =''; }

			echo "<tr class='".$bg."'>
            	  <td align='center'>$i</td>
                  <td align='center'>".$myrow["visit"]."</td>
                  <td align='left'><a href='$robot_url' target='_blank' title='".$myrow['robots']."'>$robot_name</a></td>
                  <td align='left'><a href='http://".$myrow["page"]."' target='_blank'>$page</a></td>
                  <td>$dates</td>
                  <td align='center'>$delete</td>
                  </tr>";
		}
		echo    "</table></div>";

//		$pagenav = new XoopsPageNav( $i, 10, $startart, 'startart', 'page=' . $id );
//		echo '<div style="text-align:center;">' . $pagenav -> renderNav() . '</div>';
		echo "<br />\n";

		echo "<p align='right'>
        	  <a href='page.php?ord=clean'>"._MD_MYREFERER_CLEAN." 7&nbsp;"._MD_MYREFERER_DAYS." <img src='../images/icon/delete.gif' alt='"._DELETE."'></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>";
	}

CloseTable();
include_once( 'admin_footer.php' );
?>
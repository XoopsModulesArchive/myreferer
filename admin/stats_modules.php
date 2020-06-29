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
// include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

if (!isset($_POST["keyword"])) {
	$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : 1;
} else {
	$keyword = $_POST["keyword"];
}

if (!isset($_POST["op"])) {
	$op = isset($_GET["op"]) ? $_GET["op"] : "";
} else {
	$op = $_POST["op"];
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
if ( $week ) { $where_week = "AND visit_tmp > 0"; $all = '';}

// $this_date = date('m'); $this_name = _MD_MYREFERER_MONTH; // Month
$this_date = date('W'); $this_name = _MD_MYREFERER_WEEK; // Week
//   $this_date = date('z'); $this_name = _MD_MYREFERER_DAY; // Day of th year

if ( $op == 'blacklist' ) {
	$all = '<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_HIDDEN.'" align="absmiddle" />&nbsp;';
    if ($week==1) {
    	$all .= "$this_name : $this_date";
    } else {
    	$all .= _MD_MYREFERER_ALL;
    }

	$black = '<a href="stats_modules.php?keyword='.$keyword.'&ord='.$ord.'&search='.$search.'&week='.$week.'&op=&startart='.$startart.'">
			<img src="../images/icon/all.gif" alt="'._MD_MYREFERER_ALL.'" align="absmiddle" /></a>';

	$black .= '<a href="stats_modules.php?keyword='.$keyword.'&ord='.$ord.'&search='.$search.'&week='.$week.'&op=whitelist&startart='.$startart.'">
			<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" align="absmiddle" /></a>';

    $where = "hide = 1";
} elseif ( $op == 'whitelist' ) {
	$all = '<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" align="absmiddle" />&nbsp;';
    if ($week==1) {
    	$all .= "$this_name : $this_date";
    } else {
    	$all .= _MD_MYREFERER_ALL;
    }

	$black = '<a href="stats_modules.php?keyword='.$keyword.'&ord='.$ord.'&search='.$search.'&week='.$week.'&op=&startart='.$startart.'">
			<img src="../images/icon/all.gif" alt="'._MD_MYREFERER_ALL.'" align="absmiddle" /></a>';

	$black .= '<a href="stats_modules.php?keyword='.$keyword.'&ord='.$ord.'&search='.$search.'&week='.$week.'&op=blacklist&startart='.$startart.'">
			<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_HIDDEN.'" align="absmiddle" /></a>';

	$where = "hide = 0";
} else {
	$all = '<img src="../images/icon/all.gif" alt="'._MD_MYREFERER_ALL.'" align="absmiddle" />&nbsp;';
    if ($week==1) {
    	$all .= "$this_name : $this_date";
    } else {
    	$all .= _MD_MYREFERER_ALL;
    }

	$black = '<a href="stats_modules.php?keyword='.$keyword.'&ord='.$ord.'&search='.$search.'&week='.$week.'&op=whitelist&startart='.$startart.'">
			<img src="../images/icon/on.gif" alt="'._MD_MYREFERER_DISPLAYED.'" align="absmiddle" /></a>';

	$black .= '<a href="stats_modules.php?keyword='.$keyword.'&ord='.$ord.'&search='.$search.'&week='.$week.'&op=blacklist&startart='.$startart.'">
			<img src="../images/icon/off.gif" alt="'._MD_MYREFERER_HIDDEN.'" align="absmiddle" /></a>';

    $where = "hide >= 0";
}

myReferer_adminmenu(0, _MD_MYREFERER_STATS);
if ($keyword == 1) {
	myReferer_statmenu(6, '');
} else {
	myReferer_statmenu(7, '');
}
OpenTable();

// Display informations
echo"<table width='100%'><tr><td>";
echo "<b>".$xoopsConfig['sitename']."</b><br /><a href='stats_modules.php?keyword=$keyword&ord=$ord&search=$search&week=&op=$op&startart=$startart'>"._MD_MYREFERER_ALL."</a> | <a href='stats_modules.php?keyword=$keyword&ord=$ord&search=$search&week=1$&op=$op&startart=$startart'>$this_name : $this_date </a> | $black";
echo "</td><td align='right'>";
myReferer_search($ord, $search, $engine, $week, $startart);
echo "</td></tr></table>";
// Display informations

// Queries
// Query total
$sql = "SELECT page, query, hide FROM ".$xoopsDB->prefix("myref_query")." WHERE
		keyword=$keyword AND $where $where_week AND query LIKE '%$search%' ORDER BY page ASC";
$result = $xoopsDB->query($sql);

$counter = $xoopsDB->queryF($sql);
$count = mysql_NumRows( $counter );

if( $count == 0) {
	echo _MD_MYREFERER_NOVISIT."<p />";
} else {
	$head = 1;

	echo "<br /><div style='text-align:center;'><b>$all</b></div>";
	echo '<table cellpadding="1" cellspacing="1" border="0" class="bg2" width="98%"><tr><th colspan="2">
		  <a href="'.XOOPS_URL.'" target="_blank">Home</a>
	      </th></tr><tr><td>';

	while ( $myrow = $xoopsDB->fetchArray($result) ) {
		$count++;
		$li_in = ', ';

		if ( $myrow["hide"] ) { $font_in = '<font color="red">'; } else { $font_in = '<font color="green">';  }
				if ( $page != $myrow["page"] ) {
			$page = 	str_replace( XOOPS_URL, '' , 'http://'.$myrow["page"] );
			$page = 	str_replace( '/modules', '' , $page );
			$page = 	explode( '/', $page);
			$page_url = 	explode( 'PHPSESSID', $myrow["page"]);

			$page1_tmp = $page[1];
			if ( $page_tmp != $page[1] AND $page[1] != '') {
                                echo '</td><td>'.$count.'</td></tr>';
				echo'<tr class="bg3"><th colspan="3"><a href="'.XOOPS_URL.'/modules/'.$page[1].'/" target="_blank">'.strtoupper($page[1]).'</a></th></tr>';
				$page_tmp = $page[1];
				$count = 0;
				$head = 1;
			}

	        if ( !$head ) {
    	    	echo '</td><td>'.$count.'</td></tr>';
        	}

	        $head = 0;
			$li_in = '<tr class="bg4"><td align="left"><a href="http://'.$myrow["page"].'" target="_blank" title="'.$myrow["page"].'">/'.$page[1].'/'.$page[2].'</td><td>';
			$count = 0;
		}
		echo $li_in . $font_in . $myrow["query"].'</font>';

		$page = $myrow["page"];
	}
	if ( !$head ) {
		echo '</td><td>'.$count.'</td></tr>';
	}
}
echo '</td></tr></table>';
CloseTable();
include_once( 'admin_footer.php' );
?>
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

/*
 $query = "	SELECT * FROM ".$xoopsDB->prefix("myref_query_pages_stats")."
		WHERE year=2006 AND week=18
		ORDER BY visit DESC";
*/
$year = '2006';
$week_title = "";
$results = "";
for($week=1; $week<=52; $week++) {
$query = "   SELECT f.id, f.year, f.week, f.queryid, f.pagesid, f.visit, m.id, m.query, m.visit as visit_now, m.visit_tmp, m.hide FROM " .
                $xoopsDB->prefix("myref_query_pages_stats") . " f LEFT JOIN " .
                $xoopsDB->prefix("myref_query") . " m on f.id = m.id
                WHERE f.year=$year AND f.week=$week AND m.keyword=1 ORDER BY f.visit DESC";
                  
                $result = $xoopsDB->queryF($query);

    $week_title .= "<th style='align:center;'>"._MD_MYREFERER_WEEK." <b>".$week."</b></th>
                   ";
             
    $i=1;
    $results    .=  "<td style='vertical-align:top;'>
                          ";
    if( $xoopsDB->fetchArray($result) ) {
          $results    .=  "<table>";
          while ( $myrow = $xoopsDB->fetchArray($result) ) {  // if results
          $results    .=  "<tr><td><nobr>".$myrow["query"]." <b>".$myrow["visit"]."</b> (".$myrow["visit_now"].")</nobr></td></tr>
                          ";
              } // while each results
          $results    .=  "</table>";
    } else { // if no results
          $results    .=  _MD_MYREFERER_NODATAS;
    } 
          $result .= "</td>";
} //for 52 weeks

myReferer_adminmenu(5, _MD_MYREFERER_STATS);
OpenTable();
echo 'Stats';

	echo "
          <table border='0' cellpadding='4' cellspacing='1' class='bg2' width='90%'>
          <tr class='bg3'>
                ".$week_title."
          </tr>
          ";
        echo "<tr class='bg4'>";
        echo ".$results.";
        echo "</tr>";
        echo "</table>";


CloseTable();
include_once( 'admin_footer.php' );
?>
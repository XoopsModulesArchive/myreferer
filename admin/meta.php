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
// include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
if (!isset($_POST["ord"])) {
	$ord = isset($_GET["ord"]) ? $_GET["ord"] : $xoopsModuleConfig['order'];
} else {
	$ord = $_POST["ord"];
}

if (!isset($_POST["meta_keywords"])) {
	$keywords = isset($_GET["meta_keywords"]) ? $_GET["meta_keywords"] : '';
} else {
	$keywords = $_POST['meta_keywords'];
}

if (!isset($_POST["meta_limit"])) {
	$meta_limit = isset($_GET["meta_limit"]) ? $_GET["meta_limit"] : '100';
} else {
	$meta_limit= $_POST['meta_limit'];
}


if ( $ord == 'transfer' ) {
	$sql = "UPDATE " . $xoopsDB->prefix("config") . "SET conf_value = '$keywords' WHERE conf_id = 38";
	$xoopsDB->queryF($sql);

	redirect_header("meta.php", 1, _MD_MYREFERER_UPDATED);
	exit();
}

$pop = $xoopsModuleConfig['tag_pop'] / 10;
// $meta_limit = 100;

$metamenu = 0;
if ( $ord == 'date' OR $ord == 'referer' ){
	$name = _MD_MYREFERER_DATE; 	$ord = 'date DESC'; 	$where = 'AND visit > 1'; $metamenu = 0;
}
if ( $ord == 'new' ) 	{ $name = _MD_MYREFERER_NEW; 		$ord = 'date DESC'; 	$where = 'AND visit = 1'; $metamenu = 1; }
if ( $ord == 'visit') 	{ $name = _MD_MYREFERER_TOP.' '.$meta_limit; 		$ord = 'visit_tmp DESC'; 	$where = 'AND visit > 1'; $metamenu = 2;}
if ( $ord == 'pop' ) 	{ $name = _MD_MYREFERER_POP.' (> '.$pop.' hits)'; 	$ord = 'visit DESC'; 	$where = 'AND visit >= '.$pop; $metamenu = 3;}

if ( $ord == 'random' ) {
	$metamenu = 4;
	$name = _MD_MYREFERER_RANDOM;
	$ord = 'date DESC';
	$where = 'AND visit > 1';
	$result = $xoopsDB -> queryF( "SELECT COUNT(*) FROM " . $xoopsDB->prefix("myref_query")." WHERE hide = 0  AND keyword = 1 $where");

    list( $total )=$xoopsDB->fetchRow($result);
	$total = $total - $meta_limit;
	$rand = rand(0, $total);
} else {
	$rand = '';
}


// Start queries
$sql1 = "SELECT conf_value FROM ".$xoopsDB->prefix("config")." WHERE conf_id = 38";
$result1 = $xoopsDB->queryF($sql1);
while(list($query1) = $xoopsDB->fetchRow($result1)) {
	$meta_keywords = $query1;
}

$sql = "SELECT query FROM ".$xoopsDB->prefix("myref_query")." WHERE hide = 0 AND keyword = 1 $where ORDER BY $ord";
$result = $xoopsDB->queryF($sql, $meta_limit, $rand);
while(list($query) = $xoopsDB->fetchRow($result)) {
	$i++;
	if ($i > 1) { $coma = ', ';}
	$keywords = $keywords.$coma.$query;
}
$keywords_count = strlen($keywords);

myReferer_adminmenu(3, _MD_MYREFERER_KEYGEN);
myReferer_metamenu($metamenu, '');
//include_once ("../include/nav.php");
OpenTable();

echo '<div align="center"><h3>'._MD_MYREFERER_RANKING.' : '.$name.'</h3></div>';
echo '<div align="center"><h5>'._MD_MYREFERER_KEYWORDS.' : '.$i.' ('.$keywords_count.' '._MD_MYREFERER_LETTERS.') </h5></div>';
echo '<form action="meta.php?ord=transfer" method=post>';
echo '<div align="center"><textarea name="meta_keywords" rows="5" cols="300">';
echo $keywords;
echo '</textarea></div>';

echo '<p /><div align="center">
	  <INPUT type="submit" name="'._MD_MYREFERER_TRANSFER.'" value="'._MD_MYREFERER_TRANSFER.'">
      <p />
      <img src="../images/transfert.gif" alt="'._MD_MYREFERER_TRANSFER.'" /></input></div>';

echo '</form>';

echo '<div align="center">'._MD_MYREFERER_METAKEYWORDS.' ('.strlen($meta_keywords).' '._MD_MYREFERER_LETTERS.')</div><p />';
echo '<div align="center"><textarea name="" rows="5" cols="300">';
echo $meta_keywords;
echo '</textarea></div>';

CloseTable();
include_once( 'admin_footer.php' );
?>
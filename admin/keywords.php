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
$myts =& MyTextSanitizer::getInstance();

$sql = "SELECT query FROM " . $xoopsDB->prefix("myref_query") . "
	WHERE hide = 0 $where ORDER BY query ASC";
$result = $xoopsDB->queryF($sql);
$form_letter = '';

while(list($query) = $xoopsDB->fetchRow($result)) {
	$ii++;
	$letter = substr ( strtolower ($query), 0, 1);
	if ( $letter != $form_letter ) {
       	$first_letter = '<h3>'.$letter.'</h3>'; $i++;
	} else {
       	$first_letter = '';
	}
	$form_letter = $letter;

	if ($i > 3) {
    	$td = '</td><td>'; $i = '1';
	} else {
    	$td = ''; $retour = '<br />';
    }
	$keywords = $keywords.$td.$retour.$first_letter.$myts->makeTareaData4Show($query);
}

include_once ("../include/nav.php");
OpenTable();
echo '<div align="center"><h1>Meta Keywords</h1></div>';

echo '<div align="center">'._MD_MYREFERER_KEYWORDS.' : '.$ii.'</div>';
echo '<form action="meta.php?ord=transfer" method=post>';
echo '<div align="left"><table><tr><td>';
echo $keywords;
echo '</td></tr></table></div>';

CloseTable();
include_once( 'admin_footer.php' );
?>
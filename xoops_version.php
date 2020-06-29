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

$modversion['name'] = _MI_MYREF_NAME;
$modversion['version'] = 2.0;
$modversion['description'] = _MI_MYREF_DSC;
$modversion['credits'] = "<a href='http://www.wolfpackclan.com/wolfactory' target='_blank'>Wolfactory</a>, <a href='http://www.dugris.info' target='_blank'>dugris</a>";
$modversion['author'] = "Solo, DuGris";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/myreferer_slogo.png";
$modversion['dirname'] = "myReferer";

//sql tables
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0]  = "myref_config";
$modversion['tables'][1]  = "myref_pages";
$modversion['tables'][2]  = "myref_pages_stats";
$modversion['tables'][3]  = "myref_referer";
$modversion['tables'][4]  = "myref_referer_pages";
$modversion['tables'][5]  = "myref_referer_pages_stats";
$modversion['tables'][6]  = "myref_referer_stats";
$modversion['tables'][7]  = "myref_robots";
$modversion['tables'][8]  = "myref_robots_pages";
$modversion['tables'][9]  = "myref_robots_pages_stats";
$modversion['tables'][10] = "myref_robots_stats";
$modversion['tables'][11] = "myref_query";
$modversion['tables'][12] = "myref_query_pages";
$modversion['tables'][13] = "myref_query_pages_stats";
$modversion['tables'][14] = "myref_query_stats";
$modversion['tables'][15] = "myref_users";
$modversion['tables'][16] = "myref_users_stats";
$modversion['tables'][17] = "myref_users_pages";
$modversion['tables'][18] = "myref_users_pages_stats";

// Templates
$modversion['templates'][1]['file'] = 'myreferer_head.html';
$modversion['templates'][1]['description'] = "";
$modversion['templates'][2]['file'] = 'myreferer_foot.html';
$modversion['templates'][2]['description'] = "";
$modversion['templates'][3]['file'] = 'myreferer_index.html';
$modversion['templates'][3]['description'] = "";
$modversion['templates'][4]['file'] = 'myreferer_summary.html';
$modversion['templates'][4]['description'] = "";
$modversion['templates'][5]['file'] = 'myreferer_alpha.html';
$modversion['templates'][5]['description'] = "";

//Admin
// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//Main
$modversion['hasMain'] = 1;
global $xoopsUser, $xoopsModule, $xoopsModuleConfig;
if ($xoopsModule && $xoopsModule -> getVar( 'dirname' ) == 'myReferer') {
	$subcount = 1 ;
	if ( myReferer_checkRight(1) ){
		$modversion['sub'][$subcount]['name'] = _MI_MYREF_REFERER;
		$modversion['sub'][$subcount]['url'] = "referer.php?op=0" ;
		$subcount++ ;
	}
	if ( myReferer_checkRight(2) ){
		$modversion['sub'][$subcount]['name'] = _MI_MYREF_ENGINE;
		$modversion['sub'][$subcount]['url'] = "referer.php?op=1" ;
		$subcount++ ;
	}
	if ( myReferer_checkRight(3) ){
		$modversion['sub'][$subcount]['name'] = _MI_MYREF_KEYWORDS;
		$modversion['sub'][$subcount]['url'] = "query.php" ;
		$subcount++ ;
	}
	if ( myReferer_checkRight(4) ){
		$modversion['sub'][$subcount]['name'] = _MI_MYREF_QUERY;
		$modversion['sub'][$subcount]['url'] = "query.php" ;
		$subcount++ ;
	}
	if ( myReferer_checkRight(5) ){
		$modversion['sub'][$subcount]['name'] = _MI_MYREF_ROBOTS;
		$modversion['sub'][$subcount]['url'] = "spider.php" ;
		$subcount++ ;
	}

	$modversion['sub'][$subcount]['name'] = _MI_MYREF_ALPHA;
	$modversion['sub'][$subcount]['url'] = "query.php?ord=alpha" ;
	$subcount++ ;
}


// Blocks
$i=1;
$modversion['blocks'][$i]['file'] = "block.php";
$modversion['blocks'][$i]['name'] = _MI_MYREF_BLOC_ALLINFO;
$modversion['blocks'][$i]['description'] = "";
$modversion['blocks'][$i]['show_func'] = 'a_myrefererAll_show';
$modversion['blocks'][$i]['edit_func'] = 'a_myrefererAll_edit';
$modversion['blocks'][$i]['options'] = '1,2,3,4,5,6|new|3|10|0';
$modversion['blocks'][$i]['template'] = 'myreferer_block_01.html';

$i++;
$modversion['blocks'][$i]['file'] = "block.php";
$modversion['blocks'][$i]['name'] = _MI_MYREF_BLOC_REFERER;
$modversion['blocks'][$i]['description'] ="";
$modversion['blocks'][$i]['show_func'] = 'a_myreferer_show';
$modversion['blocks'][$i]['edit_func'] = 'a_myreferer_edit';
$modversion['blocks'][$i]['options'] = 'referer|new|3|10|20';
$modversion['blocks'][$i]['template'] = 'myreferer_block_02.html';

$i++;
$modversion['blocks'][$i]['file'] = "block.php";
$modversion['blocks'][$i]['name'] = _MI_MYREF_BLOC_ENGINE;
$modversion['blocks'][$i]['description'] ="";
$modversion['blocks'][$i]['show_func'] = 'a_myreferer_show';
$modversion['blocks'][$i]['edit_func'] = 'a_myreferer_edit';
$modversion['blocks'][$i]['options'] = 'engine|new|3|10|20';
$modversion['blocks'][$i]['template'] = 'myreferer_block_02.html';

$i++;
$modversion['blocks'][$i]['file'] = "block.php";
$modversion['blocks'][$i]['name'] = _MI_MYREF_BLOC_KEYWORD;
$modversion['blocks'][$i]['description'] ="";
$modversion['blocks'][$i]['show_func'] = 'a_myreferer_show';
$modversion['blocks'][$i]['edit_func'] = 'a_myreferer_edit';
$modversion['blocks'][$i]['options'] = 'keyword|new|3|10|20';
$modversion['blocks'][$i]['template'] = 'myreferer_block_02.html';

$i++;
$modversion['blocks'][$i]['file'] = "block.php";
$modversion['blocks'][$i]['name'] = _MI_MYREF_BLOC_QUERY;
$modversion['blocks'][$i]['description'] ="";
$modversion['blocks'][$i]['show_func'] = 'a_myreferer_show';
$modversion['blocks'][$i]['edit_func'] = 'a_myreferer_edit';
$modversion['blocks'][$i]['options'] = 'query|new|3|10|20';
$modversion['blocks'][$i]['template'] = 'myreferer_block_02.html';

$i++;
$modversion['blocks'][$i]['file'] = "block.php";
$modversion['blocks'][$i]['name'] = _MI_MYREF_BLOC_ROBOTS;
$modversion['blocks'][$i]['description'] ="";
$modversion['blocks'][$i]['show_func'] = 'a_myreferer_show';
$modversion['blocks'][$i]['edit_func'] = 'a_myreferer_edit';
$modversion['blocks'][$i]['options'] = 'robots|new|3|10|20';
$modversion['blocks'][$i]['template'] = 'myreferer_block_02.html';

$i++;
$modversion['blocks'][$i]['file'] = "block.php";
$modversion['blocks'][$i]['name'] = _MI_MYREF_BLOC_PAGES;
$modversion['blocks'][$i]['description'] ="";
$modversion['blocks'][$i]['show_func'] = 'a_myreferer_show';
$modversion['blocks'][$i]['edit_func'] = 'a_myreferer_edit';
$modversion['blocks'][$i]['options'] = 'pages|new|3|10|20';
$modversion['blocks'][$i]['template'] = 'myreferer_block_02.html';

$i++;
$modversion['blocks'][$i]['file'] = "block.php";
$modversion['blocks'][$i]['name'] = _MI_MYREF_BLOC_USERS;
$modversion['blocks'][$i]['description'] ="";
$modversion['blocks'][$i]['show_func'] = 'a_myreferer_show';
$modversion['blocks'][$i]['edit_func'] = 'a_myreferer_edit';
$modversion['blocks'][$i]['options'] = 'users|date DESC|3|10|20';
$modversion['blocks'][$i]['template'] = 'myreferer_block_02.html';

// Options
$i=1;
$modversion['config'][1]['name'] = 'banner';
$modversion['config'][1]['title'] = '_MI_MYREF_BANNER';
$modversion['config'][1]['description'] = '_MI_MYREF_BANNER_DSC';
$modversion['config'][1]['formtype'] = 'yesno';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = '1';

$i++;
$modversion['config'][$i]['name'] = 'text';
$modversion['config'][$i]['title'] = '_MI_MYREF_TEXT';
$modversion['config'][$i]['description'] = '_MI_MYREF_TEXT_DSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_MYREF_WELCOME;

$i++;
$modversion['config'][$i]['name'] = 'order';
$modversion['config'][$i]['title'] = '_MI_MYREF_ORDER';
$modversion['config'][$i]['description'] = '_MI_MYREF_ORDER_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'visit';
$modversion['config'][$i]['options'] = array( '_MI_MYREF_ORDER_VISIT' => 'visit', '_MI_MYREF_ORDER_REF' => 'referer', '_MI_MYREF_ORDER_DATE' => 'date' );

$i++;
$modversion['config'][$i]['name'] = 'perpage';
$modversion['config'][$i]['title'] = '_MI_MYREF_PERPAGE';
$modversion['config'][$i]['description'] = '_MI_MYREF_PERPAGE_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 30;
$modversion['config'][$i]['options'] = array( '10' => 10, '20' => 20, '30' => 30, '40' => 40, '50' => 50, '100' => 100  );

$i++;
$modversion['config'][$i]['name'] = 'tag_new';
$modversion['config'][$i]['title'] = '_MI_MYREF_TAG_NEW';
$modversion['config'][$i]['description'] = '_MI_MYREF_TAG_NEW_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '7|1';

$i++;
$modversion['config'][$i]['name'] = 'tag_pop';
$modversion['config'][$i]['title'] = '_MI_MYREF_TAG_POP';
$modversion['config'][$i]['description'] = '_MI_MYREF_TAG_POP_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '50';

$i++;
$modversion['config'][$i]['name'] = 'today';
$modversion['config'][$i]['title'] = '_MI_MYREF_TODAY';
$modversion['config'][$i]['description'] = '_MI_MYREF_TODAY';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '#AAAA00';

$i++;
$modversion['config'][$i]['name'] = 'toold';
$modversion['config'][$i]['title'] = '_MI_MYREF_TOOLD';
$modversion['config'][$i]['description'] = '_MI_MYREF_TOOLD';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '#AA0000';
?>
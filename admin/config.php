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

// Activate php debug mode
error_reporting(E_ALL ^ E_NOTICE);

$op = 'edit';
if (isset($_POST)) {
	foreach ( $_POST as $k => $v ) {
		${$k} = $v;
	}
}
if (isset($_GET['op'])) {
	$op = trim($_GET['op']);
}

if (isset($_GET['confcat_id'])) {
	$confcat_id = intval($_GET['confcat_id']);
}

$myReferer_Config_Handler = & xoops_getmodulehandler('myref_config', $xoopsModule->dirname() );

switch( $op ) {
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header(basename( __FILE__ ), 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
        }
		$count = count($conf_ids);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $config = new myReferer_configs($conf_ids[$i]);
                $new_value =& ${$config->getVar('conf_name')};
				$config->setConfValueForInput($new_value);
				if (!$myReferer_Config_Handler->insert($config)) {
		            redirect_header(basename( __FILE__ ), 3, implode('<br />', $config->getErrors() ));
                }
            }
        }
		redirect_header('index.php', 3, _MD_MYREFERER_DBUPDATE );
    	break;

	case 'edit':
    default:
        myReferer_adminmenu(2, _MD_MYREFERER_CONFIG);

		$criteria = new CriteriaCompo();
		$criteria->add(  new Criteria('conf_formtype', 'hidden', '!='));
		$criteria->setSort($sort);
		$criteria->setOrder($order);

		$config = $myReferer_Config_Handler->getAll($criteria);
		$confcount = count($config);
    	myReferer_EditConfig( $config );
	    break;

}
include_once( 'admin_footer.php' );

function myReferer_EditConfig( $config ) {
	$form = new XoopsThemeForm(_MD_MYREFERER_CONFIG, 'pref_form', basename( __FILE__ ), 'post', true);

	foreach ($config as $i => $configObj) {
		$title = (!defined($config[$i]->getVar('conf_desc')) || constant($config[$i]->getVar('conf_desc')) == '') ? constant($config[$i]->getVar('conf_title')) : constant($config[$i]->getVar('conf_title')).'<br /><br /><span style="font-weight:normal;">'.constant($config[$i]->getVar('conf_desc')).'</span>';

	    switch ($config[$i]->getVar('conf_formtype')) {
        case 'insertBreak':
        	$form->insertBreak( '', 'null' );
        	$form->insertBreak( '<span style="font-weight: bold;"><center>' . $title . '</center></span>', 'bg3' );
        	break;
		case 'textarea':
			$myts =& MyTextSanitizer::getInstance();
			if ($config[$i]->getVar('conf_valuetype') == 'array') {
				// this is exceptional.. only when value type is arrayneed a smarter way for this
				$ele = ($config[$i]->getVar('conf_value') != '') ? new XoopsFormTextArea($title, $config[$i]->getVar('conf_name'), $myts->htmlspecialchars(implode('|', $config[$i]->getConfValueForOutput())), 5, 50) : new XoopsFormTextArea($title, $config[$i]->getVar('conf_name'), '', 5, 50);
			} else {
				$ele = new XoopsFormTextArea($title, $config[$i]->getVar('conf_name'), $myts->htmlspecialchars($config[$i]->getConfValueForOutput()), 5, 50);
			}
	    	break;

	    case 'select':
            if ( $config[$i]->getVar('conf_name') == "save_group" ) {
				$ele = new XoopsFormSelectGroup($title, $config[$i]->getVar('conf_name'), false, $config[$i]->getConfValueForOutput(),5,true);
            } else {
				$ele = new XoopsFormSelect($title, $config[$i]->getVar('conf_name'), $config[$i]->getConfValueForOutput());
				$options = array( _MYREFERER_STATS_ALL => 0);
	            for ( $j=25; $j <= 200; $j=$j+25) {
	            	$options[ _MYREFERER_STATS_TOP . ' '. $j] = $j;
	            }

	            foreach ($options as $optkey => $optval) {
					$ele->addOption($optval, $optkey );
				}
            }
			break;

	    case 'select_multi':
			$ele = new XoopsFormSelect($title, $config[$i]->getVar('conf_name'), $config[$i]->getConfValueForOutput(), 5, true);
			$options =& $config_handler->getConfigOptions(new Criteria('conf_id', $config[$i]->getVar('conf_id')));
			$opcount = count($options);
			for ($j = 0; $j < $opcount; $j++) {
				$optval = defined($options[$j]->getVar('confop_value')) ? constant($options[$j]->getVar('confop_value')) : $options[$j]->getVar('confop_value');
				$optkey = defined($options[$j]->getVar('confop_name')) ? constant($options[$j]->getVar('confop_name')) : $options[$j]->getVar('confop_name');
				$ele->addOption($optval, $optkey);
			}
			break;

	    case 'yesno':
			$ele = new XoopsFormRadioYN($title, $config[$i]->getVar('conf_name'), $config[$i]->getConfValueForOutput(), _YES, _NO);
			break;

		case 'textbox':
		default:
			$myts =& MyTextSanitizer::getInstance();
			$ele = new XoopsFormText($title, $config[$i]->getVar('conf_name'), 50, 255, $myts->htmlspecialchars($config[$i]->getConfValueForOutput()));
			break;
	    }
		$hidden = new XoopsFormHidden('conf_ids[]', $config[$i]->getVar('conf_id'));
		$form->addElement($ele);
		$form->addElement($hidden);
		unset($ele);
		unset($hidden);
	}

	$form->addElement(new XoopsFormHidden('op', 'save'));
	$form->addElement(new XoopsFormButton('', 'button', _GO, 'submit'));
	$form->display();
}
?>
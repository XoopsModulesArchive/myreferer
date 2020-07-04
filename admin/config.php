<?php declare(strict_types=1);

/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2004 <https://xoops.org>
 *
 * Module: myreferer 2.0
 * Licence : GPL
 * Authors :
 *           - solo (www.wolfpackclan.com/wolfactory)
 *            - DuGris (www.dugris.info)
 */

use XoopsModules\Myreferer\Config;
use XoopsModules\Myreferer\Helper;

require_once __DIR__ . '/admin_header.php';

xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));

// Activate php debug mode
error_reporting(E_ALL ^ E_NOTICE);

$op = 'edit';
if (isset($_POST)) {
    foreach ($_POST as $k => $v) {
        ${$k} = $v;
    }
}
if (isset($_GET['op'])) {
    $op = trim($_GET['op']);
}

if (isset($_GET['confcat_id'])) {
    $confcat_id = (int)$_GET['confcat_id'];
}

$helper        = Helper::getInstance();
$configHandler = $helper->getHandler('Config');

switch ($op) {
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header(basename(__FILE__), 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $count = count($conf_ids);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $config = new Config($conf_ids[$i]);

                $new_value = ${$config->getVar('conf_name')};

                $config->setConfValueForInput($new_value);

                if (!$configHandler->insert($config)) {
                    redirect_header(basename(__FILE__), 3, implode('<br>', $config->getErrors()));
                }
            }
        }
        redirect_header('index.php', 3, _MD_MYREFERER_DBUPDATE);
        break;
    case 'edit':
    default:
        // Utility::getAdminMenu(2, _MD_MYREFERER_CONFIG);

        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('conf_formtype', 'hidden', '!='));
        $criteria->setSort($sort);
        $criteria->setOrder($order);

        $config    = $configHandler->getAll($criteria);
        $confcount = count($config);
        myreferer_EditConfig($config);
        break;
}
require_once __DIR__ . '/admin_footer.php';

/**
 * @param $config
 */
function myreferer_EditConfig($config)
{
    xoops_load('XoopsThemeForm');

    $form = new XoopsThemeForm(_MD_MYREFERER_CONFIG, 'pref_form', basename(__FILE__), 'post', true);

    $helper = Helper::getInstance();

    $configHandler = $helper->getHandler('Config');

    foreach ($config as $i => $configObj) {
        $title = !defined($config[$i]->getVar('conf_desc')) || '' == constant($config[$i]->getVar('conf_desc')) ? constant($config[$i]->getVar('conf_title')) : constant($config[$i]->getVar('conf_title')) . '<br><br><span style="font-weight:normal;">'
                                                                                                                                                                . constant($config[$i]->getVar('conf_desc')) . '</span>';

        switch ($config[$i]->getVar('conf_formtype')) {
            case 'insertBreak':
                $form->insertBreak('', 'null');
                $form->insertBreak('<span style="font-weight: bold; text-align: center;">' . $title . '</span>', 'bg3');
                break;
            case 'textarea':
                $myts = \MyTextSanitizer::getInstance();
                if ('array' === $config[$i]->getVar('conf_valuetype')) {
                    // this is exceptional.. only when value type is arrayneed a smarter way for this

                    $ele = '' != $config[$i]->getVar('conf_value') ? new XoopsFormTextArea($title, $config[$i]->getVar('conf_name'), $myts->htmlSpecialChars(implode('|', $config[$i]->getConfValueForOutput())), 5, 50) : new XoopsFormTextArea($title,
                                                                                                                                                                                                                                                 $config[$i]->getVar('conf_name'),
                                                                                                                                                                                                                                                 '', 5,
                                                                                                                                                                                                                                                 50);
                } else {
                    $ele = new XoopsFormTextArea($title, $config[$i]->getVar('conf_name'), $myts->htmlSpecialChars($config[$i]->getConfValueForOutput()), 5, 50);
                }
                break;
            case 'select':
                if ('save_group' === $config[$i]->getVar('conf_name')) {
                    $ele = new XoopsFormSelectGroup($title, $config[$i]->getVar('conf_name'), false, $config[$i]->getConfValueForOutput(), 5, true);
                } else {
                    $ele = new XoopsFormSelect($title, $config[$i]->getVar('conf_name'), $config[$i]->getConfValueForOutput());

                    $options = [_MYREFERER_STATS_ALL => 0];

                    for ($j = 25; $j <= 200; $j += 25) {
                        $options[_MYREFERER_STATS_TOP . ' ' . $j] = $j;
                    }

                    foreach ($options as $optkey => $optval) {
                        $ele->addOption($optval, $optkey);
                    }
                }
                break;
            case 'select_multi':
                $ele     = new XoopsFormSelect($title, $config[$i]->getVar('conf_name'), $config[$i]->getConfValueForOutput(), 5, true);
                $options = $configHandler->getConfigOptions(new Criteria('conf_id', $config[$i]->getVar('conf_id')));
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
                $myts = \MyTextSanitizer::getInstance();
                $ele  = new XoopsFormText($title, $config[$i]->getVar('conf_name'), 50, 255, $myts->htmlSpecialChars($config[$i]->getConfValueForOutput()));
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

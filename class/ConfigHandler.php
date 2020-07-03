<?php

namespace XoopsModules\Myreferer;

/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2004 <https://xoops.org>
 *
 * Module: myReferer 2.0
 * Licence : GPL
 * Authors :
 *           - solo (www.wolfpackclan.com/wolfactory)
 *            - DuGris (www.dugris.info)
 */

use Criteria;
use CriteriaCompo;
use CriteriaElement;
use XoopsObject;
use XoopsObjectHandler;

if (!\defined('XOOPS_ROOT_PATH')) {
    exit('XOOPS root path not defined');
}

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Class ConfigsHandler
 */
class ConfigHandler extends XoopsObjectHandler
{
    /**
     * @param int  $id
     * @param bool $asobject
     * @return bool|\Configs|XoopsObject
     */
    public function get($id, $asobject = true)
    {
        if ((int)$id > 0) {
            $sql = 'SELECT * FROM ' . $this->db->prefix('myref_config') . ' WHERE conf_id=' . $id;
            if (!$result = $this->db->query($sql)) {
                return false;
            }
            $numrows = $this->db->getRowsNum($result);
            if (1 == $numrows) {
                $myrow = $this->db->fetchArray($result);
                if (!$asobject) {
                    $ret[$myrow['conf_id']] = $myrow;
                } else {
                    $ret = new Config($myrow['conf_id']);
                    $ret->assignVars($myrow);
                }

                return $ret;
            }
        }

        return false;
    }

    /**
     * @param XoopsObject $config
     * @return bool|void
     */
    public function insert(XoopsObject $config)
    {
        if ('configs' !== mb_strtolower(\get_class($config))) {
            return false;
        }
        if (!$config->isDirty()) {
            return true;
        }
        if (!$config->cleanVars()) {
            return false;
        }
        foreach ($config->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($config->isNew()) {
            $conf_id = $this->db->genId('config_conf_id_seq');
            $sql     = \sprintf(
                'INSERT INTO %s (conf_id, conf_name, conf_title, conf_value, conf_desc, conf_formtype, conf_valuetype, conf_order) VALUES (%u, %u, %u, %s, %s, %s, %s, %s, %s, %u)',
                $this->db->prefix('myref_config'),
                $conf_id,
                $this->db->quoteString($conf_name),
                $this->db->quoteString($conf_title),
                $this->db->quoteString($conf_value),
                $this->db->quoteString($conf_desc),
                $this->db->quoteString($conf_formtype),
                $this->db->quoteString($conf_valuetype),
                $conf_order
            );
        } else {
            $sql = \sprintf(
                'UPDATE %s SET conf_name = %s, conf_title = %s, conf_value = %s, conf_desc = %s, conf_formtype = %s, conf_valuetype = %s, conf_order = %u WHERE conf_id = %u',
                $this->db->prefix('myref_config'),
                $this->db->quoteString($conf_name),
                $this->db->quoteString($conf_title),
                $this->db->quoteString($conf_value),
                $this->db->quoteString($conf_desc),
                $this->db->quoteString($conf_formtype),
                $this->db->quoteString($conf_valuetype),
                $conf_order,
                $conf_id
            );
        }

        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        if (empty($conf_id)) {
            $conf_id = $this->db->getInsertId();
        }
        $config->assignVar('conf_id', $conf_id);

        return $this->WriteConfigFile();
    }

    /**
     * @param null   $criteria
     * @param string $sort
     * @param string $order
     * @param bool   $asobject
     * @return array
     */
    public function getAll($criteria = null, $sort = 'conf_order', $order = 'ASC', $asobject = true)
    {
        $ret = [];

        if (null === $criteria) {
            $criteria = new CriteriaCompo();
            $criteria->setSort($sort);
            $criteria->setOrder($order);
        }

        $sql = 'SELECT * FROM ' . $this->db->prefix('myref_config');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
            if ('' != $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
        }

        $result = $this->db->query($sql);
        if (!$result) {
            return $ret;
        }

        while (false !== ($myrow = $this->db->fetchArray($result))) {
            if (!$asobject) {
                $ret[$myrow['conf_id']] = $myrow;
            } else {
                $ret[$myrow['conf_id']] = new Config($myrow);
            }
        }

        return $ret;
    }

    /**
     * @param string $file
     * @return bool
     */
    public function WriteConfigFile($file = 'myReferer.conf.php')
    {
        global $xoopsModule, $xoopsConfig, $configHandler;
        $hModule     = \xoops_getHandler('module');
        $myRefModule = $hModule->getByDirname('myReferer');

        if (\file_exists(XOOPS_ROOT_PATH . '/modules/' . $myRefModule->dirname() . '/language/' . $xoopsConfig['language'] . '/common.php')) {
            require_once XOOPS_ROOT_PATH . '/modules/' . $myRefModule->dirname() . '/language/' . $xoopsConfig['language'] . '/common.php';
        } else {
            require_once XOOPS_ROOT_PATH . '/modules/' . $myRefModule->dirname() . '/language/french/common.php';
        }

        $file_content = "<?php
/**
* XOOPS - PHP Content Management System
* Copyright (c) 2004 <https://xoops.org>
*
* Module: myReferer 2.0
* Licence : GPL
* Authors :
*           - solo (www.wolfpackclan.com/wolfactory)
*			- DuGris (www.dugris.info)
*/
\n\n";

        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('conf_valuetype', 'hidden', '!='));
        $criteria->setSort($sort);
        $criteria->setOrder($order);

        $tmp_configs = $configHandler->getAll($criteria);
        foreach ($tmp_configs as $i => $tmp_config) {
            $file_content .= '// ' . \constant(\strip_tags($tmp_configs[$i]->getVar('conf_title'))) . "\n";
            $file_content .= '$' . $tmp_configs[$i]->getVar('conf_name');
            $file_content .= ' = ' . $tmp_configs[$i]->setConfValueForWrite() . ';';
            $file_content .= "\n\n";
        }
        $file_content .= '?>';

        // Debug : view file before write
        //        echo str_replace("\n", "<br>", $file_content);

        // Write the config file
        Utility::createDir();
        $target = XOOPS_ROOT_PATH . '/modules/' . $myRefModule->dirname() . '/config/';
        $handle = \fopen($target . $file, 'wb+');
        if ($handle) {
            if (\fwrite($handle, $file_content)) {
                return true;
            }
        }

        return false;
    }
}

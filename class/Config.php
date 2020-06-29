<?php

namespace XoopsModules\Myreferer;

use XoopsDatabaseFactory;
use XoopsObject;

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
if (!\defined('XOOPS_ROOT_PATH')) {
    exit('XOOPS root path not defined');
}

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Class Configs
 */
class Config extends XoopsObject
{
    public $db;
    public $_groups_read = null;
    // constructor

    /**
     * Configs constructor.
     * @param null $conf_id
     */
    public function __construct($conf_id = null)
    {
        $this->db = \XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('conf_id', \XOBJ_DTYPE_INT, 0, true, 5);
        $this->initVar('conf_name', \XOBJ_DTYPE_TXTBOX, '', true, 25);
        $this->initVar('conf_title', \XOBJ_DTYPE_TXTBOX, '', true, 30);
        $this->initVar('conf_value', \XOBJ_DTYPE_TXTAREA, '', false, 0);
        $this->initVar('conf_desc', \XOBJ_DTYPE_TXTBOX, '', true, 50);
        $this->initVar('conf_formtype', \XOBJ_DTYPE_TXTBOX, '', true, 15);
        $this->initVar('conf_valuetype', \XOBJ_DTYPE_TXTBOX, '', true, 10);
        $this->initVar('conf_order', \XOBJ_DTYPE_INT, 0, true, 5);

        if (!empty($conf_id)) {
            if (\is_array($conf_id)) {
                $this->assignVars($conf_id);
            } else {
                $this->load($conf_id);
            }
        } else {
            $this->setNew();
        }
    }

    /**
     * @param $conf_id
     */
    public function load($conf_id)
    {
        $sql   = 'SELECT * FROM ' . $this->db->prefix('myref_config') . ' WHERE conf_id=' . $conf_id;
        $myrow = $this->db->fetchArray($this->db->query($sql));
        $this->assignVars($myrow);
        if (!$myrow) {
            $this->setNew();
        }
    }

    /**
     * @return float|int|mixed
     */
    public function getConfValueForOutput()
    {
        switch ($this->getVar('conf_valuetype')) {
            case 'int':
                return (int)$this->getVar('conf_value', 'N');
                break;
            case 'array':
                return \unserialize($this->getVar('conf_value', 'N'));
            case 'float':
                $value = $this->getVar('conf_value', 'N');

                return (float)$value;
                break;
            case 'textarea':
                return $this->getVar('conf_value');
            default:
                return $this->getVar('conf_value', 'N');
                break;
        }
    }

    /**
     * @param      $value
     * @param bool $force_slash
     */
    public function setConfValueForInput(&$value, $force_slash = false)
    {
        switch ($this->getVar('conf_valuetype')) {
            case 'array':
                if (!\is_array($value)) {
                    $value = \explode('|', \trim($value));
                }
                $this->setVar('conf_value', \serialize($value), $force_slash);
                break;
            case 'text':
                $this->setVar('conf_value', \trim($value), $force_slash);
                break;
            default:
                $this->setVar('conf_value', $value, $force_slash);
                break;
        }
    }

    /**
     * @return string
     */
    public function setConfValueForWrite()
    {
        switch ($this->getVar('conf_valuetype')) {
            case 'array':
                $value = '"' . \implode('|', \unserialize($this->getVar('conf_value', 'N'))) . '"';

                return $value;
            case 'text':
                $value = '"' . \trim($this->getVar('conf_value', 'N')) . '"';

                return $value;
            default:
                return \trim($this->getVar('conf_value', 'N'));
        }

        return '';
    }
}

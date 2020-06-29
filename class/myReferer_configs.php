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

if (!defined("XOOPS_ROOT_PATH")) { die("XOOPS root path not defined"); }

include_once( XOOPS_ROOT_PATH . '/class/xoopsobject.php');
include_once ( XOOPS_ROOT_PATH . '/modules/myReferer/include/functions_myreferer.php' );

class myReferer_configs extends XoopsObject
{
	var $db;
    var $_groups_read = null;

	// constructor
	function myReferer_configs ( $conf_id=null )
	{
		$this->db =& Database::getInstance();
		$this->initVar('conf_id'		,XOBJ_DTYPE_INT		,0	,true	,5);
		$this->initVar('conf_name'		,XOBJ_DTYPE_TXTBOX	,''	,true	,25);
		$this->initVar('conf_title'		,XOBJ_DTYPE_TXTBOX	,''	,true	,30);
		$this->initVar('conf_value'		,XOBJ_DTYPE_TXTAREA	,''	,false	,0);
		$this->initVar('conf_desc'		,XOBJ_DTYPE_TXTBOX	,''	,true	,50);
		$this->initVar('conf_formtype'	,XOBJ_DTYPE_TXTBOX	,''	,true	,15);
		$this->initVar('conf_valuetype'	,XOBJ_DTYPE_TXTBOX	,''	,true	,10);
		$this->initVar('conf_order'		,XOBJ_DTYPE_INT		,0	,true	,5);

		if ( !empty($conf_id) ) {
			if ( is_array($conf_id) ) {
				$this->assignVars($conf_id);
			} else {
				$this->load($conf_id);
			}
		} else {
			$this->setNew();
		}
    }

	function load($conf_id)
	{
		$sql = 'SELECT * FROM ' . $this->db->prefix('myref_config') . ' WHERE conf_id=' . $conf_id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

    function &getConfValueForOutput()
    {
        switch ($this->getVar('conf_valuetype')) {
        case 'int':
            return intval($this->getVar('conf_value', 'N'));
            break;
        case 'array':
            return unserialize($this->getVar('conf_value', 'N'));
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

    function setConfValueForInput(&$value, $force_slash = false)
    {
        switch($this->getVar('conf_valuetype')) {
        case 'array':
            if (!is_array($value)) {
                $value = explode('|', trim($value));
            }
            $this->setVar('conf_value', serialize($value), $force_slash);
            break;
        case 'text':
            $this->setVar('conf_value', trim($value), $force_slash);
            break;
        default:
            $this->setVar('conf_value', $value, $force_slash);
            break;
        }
    }

    function setConfValueForWrite()
    {
        switch ($this->getVar('conf_valuetype')) {
        case 'array':
			$value = '"' . implode('|', unserialize($this->getVar('conf_value', 'N')) ) . '"';
            return $value;
        case 'text':
        	$value = '"' . trim($this->getVar('conf_value', 'N')) . '"';
            return $value;
        default:
        	return trim($this->getVar('conf_value', 'N'));
        }
        return "";
    }
}

class myReferermyref_configHandler extends XoopsObjectHandler
{
	function &get($id, $asobject=true)
    {
		if (intval($id) > 0) {
			$sql = 'SELECT * FROM ' . $this->db->prefix( 'myref_config' ) . ' WHERE conf_id='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$myrow = $this->db->fetchArray($result);
				if ( !$asobject ) {
					$ret[$myrow['conf_id']] = $myrow;
				} else {
					$ret = new myReferer_configs( $myrow['conf_id'] );
					$ret->assignVars($myrow);
                }
				return $ret;
			}
		}
		return false;
	}

    function insert(&$config) {
        if (strtolower(get_class($config)) != 'myreferer_configs') {
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
            $sql = sprintf('INSERT INTO %s (conf_id, conf_name, conf_title, conf_value, conf_desc, conf_formtype, conf_valuetype, conf_order) VALUES (%u, %u, %u, %s, %s, %s, %s, %s, %s, %u)', $this->db->prefix('myref_config'), $conf_id, $this->db->quoteString($conf_name), $this->db->quoteString($conf_title), $this->db->quoteString($conf_value), $this->db->quoteString($conf_desc), $this->db->quoteString($conf_formtype), $this->db->quoteString($conf_valuetype), $conf_order);
        } else {
            $sql = sprintf('UPDATE %s SET conf_name = %s, conf_title = %s, conf_value = %s, conf_desc = %s, conf_formtype = %s, conf_valuetype = %s, conf_order = %u WHERE conf_id = %u', $this->db->prefix('myref_config'), $this->db->quoteString($conf_name), $this->db->quoteString($conf_title), $this->db->quoteString($conf_value), $this->db->quoteString($conf_desc), $this->db->quoteString($conf_formtype), $this->db->quoteString($conf_valuetype), $conf_order, $conf_id);
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

	function getAll($criteria=null, $sort='conf_order', $order='ASC', $asobject=true)
	{
        $ret = array();

		if ($criteria == null) {
			$criteria = new CriteriaCompo();
			$criteria->setSort($sort);
			$criteria->setOrder($order);
        }

        $sql = 'SELECT * FROM ' . $this->db->prefix( 'myref_config' );
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
			if ($criteria->getSort() != '') {
				$sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
			}
		}

		$result = $this->db->query($sql);
		if (!$result) {
			return $ret;
		}

		while ( $myrow = $this->db->fetchArray($result) ) {
			if ( !$asobject ) {
				$ret[$myrow['conf_id']] = $myrow;
			} else {
				$ret[$myrow['conf_id']] = new myReferer_configs( $myrow );
			}
		}
		return $ret;
	}

	function WriteConfigFile( $file='myReferer.conf.php') {
    	global $xoopsModule, $xoopsConfig, $myReferer_Config_Handler;
        $hModule = &xoops_gethandler('module');
        $myRefModule = $hModule->getByDirname('myReferer');

		if ( file_exists( XOOPS_ROOT_PATH . '/modules/' . $myRefModule->dirname() . '/language/' . $xoopsConfig['language'] . '/common.php') ) {
			include_once(XOOPS_ROOT_PATH . '/modules/' . $myRefModule->dirname() . '/language/' . $xoopsConfig['language'] . '/common.php');
		} else {
			include_once(XOOPS_ROOT_PATH . '/modules/' . $myRefModule->dirname() . '/language/french/common.php');
		}

        $file_content = "<?php
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
\n\n";

		$criteria = new CriteriaCompo();
		$criteria->add(  new Criteria('conf_valuetype', 'hidden', '!='));
		$criteria->setSort($sort);
		$criteria->setOrder($order);

        $tmp_configs = $myReferer_Config_Handler->getAll( $criteria );
		foreach ($tmp_configs as $i => $tmp_config) {
            $file_content .= '// ' . constant( strip_tags( $tmp_configs[$i]->getVar('conf_title') ) )  . "\n";
			$file_content .= '$' . $tmp_configs[$i]->getVar('conf_name');
            $file_content .= ' = ' . $tmp_configs[$i]->setConfValueForWrite() . ';';
            $file_content .= "\n\n";
        }
        $file_content .= "?>";

        // Debug : view file before write
//        echo str_replace("\n", "<br />", $file_content);

        // Write the config file
        myReferer_create_dir();
        $target = XOOPS_ROOT_PATH . '/modules/' . $myRefModule->dirname() . '/config/';
       	$handle = fopen($target . $file, 'w+');
		if ($handle) {
			if ( fwrite($handle, $file_content) ) {
               	return true;
			}
        }
        return false;
    }
}
?>
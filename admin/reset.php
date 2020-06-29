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
include "../../../mainfile.php";
if (!defined("XOOPS_ROOT_PATH")) { die("XOOPS root path not defined"); }

        $confirm = ( isset($confirm)) ? 1 : 0;
        if ($confirm) {
           if ( myreferer_reset() ) {
            redirect_header( "index.php", 1, sprintf( _MD_MYREFERER_UPDATED, '') );
              } else {
            redirect_header( "index.php", 1, sprintf( _MD_MYREFERER_NOTUPDATED, '') );  
              }

           exit();
		} else {
           include_once( "admin_header.php" );
             xoops_confirm( array( '', '', 'confirm' => 1, '' ), 'reset.php', _MD_MYREFERER_RESET_DATA, _MD_MYREFERER_RESET );
           include_once( 'admin_footer.php' );
        }


/**
 * Restoring visit_tmp by 0
 */
function myreferer_reset()
{
    	global $xoopsDB;

    	// get table list (xoops_version.php)
        include_once( XOOPS_ROOT_PATH . '/modules/myReferer/language/english/modinfo.php' );
        include_once( XOOPS_ROOT_PATH . '/modules/myReferer/xoops_version.php' );

        foreach ( $modversion['tables'] as $table ) {
                $sql = "UPDATE " . $xoopsDB->prefix($table) . " SET visit_tmp = 0 WHERE visit_tmp !=0";
                $xoopsDB->queryF($sql);
        }
        return TRUE;
}

include_once( 'admin_footer.php' );
?>
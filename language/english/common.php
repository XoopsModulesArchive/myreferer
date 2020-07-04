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

// myreferer_config table
define('_MYREFERER_KEYWORD_MIN', 'Keyword minimum size');
define('_MYREFERER_KEYWORD_MIN_DSC', '');

define('_MYREFERER_KEYWORD_MAX', 'Keyword maximum size');
define('_MYREFERER_KEYWORD_MAX_DSC', '');

define('_MYREFERER_MBCONVERT', 'Convert special caracters');
define('_MYREFERER_MBCONVERT_DSC', '');

define('_MYREFERER_PUNCTATION', 'Keep punctuation');
define('_MYREFERER_PUNCTATION_DSC', '');

define('_MYREFERER_NUMBERS', 'Keep numbers');
define('_MYREFERER_NUMBERS_DSC', '');

define('_MYREFERER_SMALLCAPS', 'Convert to lowercase');
define('_MYREFERER_SMALLCAPS_DSC', '');

define('_MYREFERER_KEYWORD_BLACKLIST', 'Keywords Blacklist');
define('_MYREFERER_KEYWORD_BLACKLIST_DSC', 'Specify which keywords are blacklisted.<br>Keywords must be separated by  <b><span style="color: #CC0000; ">|</span></b>.<br>For instance: myreferer<b><span style="color: #CC0000; ">|</span></b>multiMenu');

define('_MYREFERER_MODULE_BLACKLIST', 'Modules Blacklist');
define('_MYREFERER_MODULE_BLACKLIST_DSC',
       'Specify which modules are blacklisted.<br>Directories must be separated by  <b><span style="color: #CC0000; ">|</span></b>.<br>For instance: myreferer<b><span style="color: #CC0000; ">|</span></b>multiMenu');

define('_MYREFERER_SEARCH_BLACKLIST', 'Search Engines Blacklist');
define('_MYREFERER_SEARCH_BLACKLIST_DSC',
       'Specify which search engines are blacklisted.<br>Search engine must be separated by  <b><span style="color: #CC0000; ">|</span></b>.<br>For instance: google.it<b><span style="color: #CC0000; ">|</span></b>sucheaol.aol.de');

define('_MYREFERER_REFERER_BLACKLIST', 'Referers Blacklist');
define('_MYREFERER_REFERER_BLACKLIST_DSC',
       'Specify which referer are blacklisted.<br>Referers must be separated by  <b><span style="color: #CC0000; ">|</span></b>.<br>For instance: 127.0.0.1<b><span style="color: #CC0000; ">|</span></b>mail.google.com');

define('_MYREFERER_NEW_BOT_SMAIL', 'Activate warning by mail when a new robot is visiting the site');
define('_MYREFERER_NEW_BOT_SMAIL_DSC', '');

define('_MYREFERER_NEW_BOT_MAIL', 'Warning mail adresss');
define('_MYREFERER_NEW_BOT_MAIL_DSC', 'If empty mails are sent to site admin');

define('_MYREFERER_ROBOTS_BLACKLIST', 'Robots Blacklist');
define('_MYREFERER_ROBOTS_BLACKLIST_DSC', 'Specify which robots are blacklisted.<br>Robots must be separated by  <b><span style="color: #CC0000; ">|</span></b>.<br>For instance:  googlebot<b><span style="color: #CC0000; ">|</span></b>msnbot');

define('_MYREFERER_PAGE_PROHIBIT', 'Redirection page for blacklisted bots');
define('_MYREFERER_PAGE_PROHIBIT_DSC', '');

define('_MYREFERER_ROBOTS_PROHIBIT', 'Forbiden robots');
define('_MYREFERER_ROBOTS_PROHIBIT_DSC',
       'This option allow to forbidden specified robots.<br>Robots must be separated by  <b><span style="color: #CC0000; ">|</span></b>.<br>For instance: fileDL.exe<b><span style="color: #CC0000; ">|</span></b>Lynx');

define('_MYREFERER_STATS_ALL', 'All');
define('_MYREFERER_STATS_TOP', 'Top');

define('_MYREFERER_STATS_PAGES', 'Top Pages');
define('_MYREFERER_STATS_PAGES_DSC', '');

define('_MYREFERER_STATS_QUERY', 'Top Keywords');
define('_MYREFERER_STATS_QUERY_DSC', '');

define('_MYREFERER_STATS_QUERY_PAGES', 'Keywords/Pages ');
define('_MYREFERER_STATS_QUERY_PAGES_DSC', '');

define('_MYREFERER_STATS_REFERER', 'Top Referers');
define('_MYREFERER_STATS_REFERER_DSC', '');

define('_MYREFERER_STATS_REFERER_PAGES', 'Referer/Pages');
define('_MYREFERER_STATS_REFERER_PAGES_DSC', '');

define('_MYREFERER_STATS_ROBOTS', 'Top Robots');
define('_MYREFERER_STATS_ROBOTS_DSC', '');

define('_MYREFERER_STATS_ROBOTS_PAGES', 'Robots/Pages');
define('_MYREFERER_STATS_ROBOTS_PAGES_DSC', '');

define('_MYREFERER_STATS_USERS', 'Visitors');
define('_MYREFERER_STATS_USERS_DSC', '');

define('_MYREFERER_STATS_USERS_PAGES', 'Visitors/Pages');
define('_MYREFERER_STATS_USERS_PAGES_DSC', '');

define('_MYREFERER_COUNT_ADMIN', 'Count the visits of Webmaster(s) ');
define('_MYREFERER_COUNT_ADMIN_DSC', '');

define('_MYREFERER_USER_VISIT', 'Record the pages seen');
define('_MYREFERER_USER_VISIT_DSC', '');

define('_MYREFERER_SAVE_GROUP', 'Choose the groups');
define('_MYREFERER_SAVE_GROUP_DSC', '');

define('_MYREFERER_ADMIN_VISIT', 'Record the pages seen by the Webmaster(s) ');
define('_MYREFERER_ADMIN_VISIT_DSC', '');

//define('_MYREFERER_KEYWORD', 'Keywords configuration');
//define('_MYREFERER_REFERER', 'Referers configuration');
define('_MYREFERER_ROBOTS', 'Robots configuration');
//define('_MYREFERER_STATS', 'Statistics configuration');
define('_MYREFERER_USERVISIT', 'USER VISIT Configuration');

$moduleDirName      = basename(dirname(__DIR__, 2));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

define('CO_' . $moduleDirNameUpper . '_GDLIBSTATUS', 'GD library support: ');
define('CO_' . $moduleDirNameUpper . '_GDLIBVERSION', 'GD Library version: ');
define('CO_' . $moduleDirNameUpper . '_GDOFF', "<span style='font-weight: bold;'>Disabled</span> (No thumbnails available)");
define('CO_' . $moduleDirNameUpper . '_GDON', "<span style='font-weight: bold;'>Enabled</span> (Thumbsnails available)");
define('CO_' . $moduleDirNameUpper . '_IMAGEINFO', 'Server status');
define('CO_' . $moduleDirNameUpper . '_MAXPOSTSIZE', 'Max post size permitted (post_max_size directive in php.ini): ');
define('CO_' . $moduleDirNameUpper . '_MAXUPLOADSIZE', 'Max upload size permitted (upload_max_filesize directive in php.ini): ');
define('CO_' . $moduleDirNameUpper . '_MEMORYLIMIT', 'Memory limit (memory_limit directive in php.ini): ');
define('CO_' . $moduleDirNameUpper . '_METAVERSION', "<span style='font-weight: bold;'>Downloads meta version:</span> ");
define('CO_' . $moduleDirNameUpper . '_OFF', "<span style='font-weight: bold;'>OFF</span>");
define('CO_' . $moduleDirNameUpper . '_ON', "<span style='font-weight: bold;'>ON</span>");
define('CO_' . $moduleDirNameUpper . '_SERVERPATH', 'Server path to XOOPS root: ');
define('CO_' . $moduleDirNameUpper . '_SERVERUPLOADSTATUS', 'Server uploads status: ');
define('CO_' . $moduleDirNameUpper . '_SPHPINI', "<span style='font-weight: bold;'>Information taken from PHP ini file:</span>");
define('CO_' . $moduleDirNameUpper . '_UPLOADPATHDSC', 'Note. Upload path *MUST* contain the full server path of your upload folder.');

define('CO_' . $moduleDirNameUpper . '_PRINT', "<span style='font-weight: bold;'>Print</span>");
define('CO_' . $moduleDirNameUpper . '_PDF', "<span style='font-weight: bold;'>Create PDF</span>");

define('CO_' . $moduleDirNameUpper . '_UPGRADEFAILED0', "Update failed - couldn't rename field '%s'");
define('CO_' . $moduleDirNameUpper . '_UPGRADEFAILED1', "Update failed - couldn't add new fields");
define('CO_' . $moduleDirNameUpper . '_UPGRADEFAILED2', "Update failed - couldn't rename table '%s'");
define('CO_' . $moduleDirNameUpper . '_ERROR_COLUMN', 'Could not create column in database : %s');
define('CO_' . $moduleDirNameUpper . '_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
define('CO_' . $moduleDirNameUpper . '_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');
define('CO_' . $moduleDirNameUpper . '_ERROR_TAG_REMOVAL', 'Could not remove tags from Tag Module');

define('CO_' . $moduleDirNameUpper . '_FOLDERS_DELETED_OK', 'Upload Folders have been deleted');

// Error Msgs
define('CO_' . $moduleDirNameUpper . '_ERROR_BAD_DEL_PATH', 'Could not delete %s directory');
define('CO_' . $moduleDirNameUpper . '_ERROR_BAD_REMOVE', 'Could not delete %s');
define('CO_' . $moduleDirNameUpper . '_ERROR_NO_PLUGIN', 'Could not load plugin');

//Help
define('CO_' . $moduleDirNameUpper . '_DIRNAME', basename(dirname(__DIR__, 2)));
define('CO_' . $moduleDirNameUpper . '_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('CO_' . $moduleDirNameUpper . '_BACK_2_ADMIN', 'Back to Administration of ');
define('CO_' . $moduleDirNameUpper . '_OVERVIEW', 'Overview');

//define('CO_' . $moduleDirNameUpper . '_HELP_DIR', __DIR__);

//help multi-page
define('CO_' . $moduleDirNameUpper . '_DISCLAIMER', 'Disclaimer');
define('CO_' . $moduleDirNameUpper . '_LICENSE', 'License');
define('CO_' . $moduleDirNameUpper . '_SUPPORT', 'Support');

//Sample Data
define('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA', 'Import Sample Data (will delete ALL current data)');
define('CO_' . $moduleDirNameUpper . '_' . 'SAMPLEDATA_SUCCESS', 'Sample Date uploaded successfully');
define('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA', 'Export Tables to YAML');
define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON', 'Show Sample Button?');
define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC', 'If yes, the "Add Sample Data" button will be visible to the Admin. It is Yes as a default for first installation.');
define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA', 'Export DB Schema to YAML');
define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_SUCCESS', 'Export DB Schema to YAML was a success');
define('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_ERROR', 'ERROR: Export of DB Schema to YAML failed');
define('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA_OK', 'Are you sure to Import Sample Data? (It will delete ALL current data)');
define('CO_' . $moduleDirNameUpper . '_' . 'HIDE_SAMPLEDATA_BUTTONS', 'Hide the Import buttons)');
define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLEDATA_BUTTONS', 'Show the Import buttons)');
define('CO_' . $moduleDirNameUpper . '_' . 'CONFIRM', 'Confirm');

//letter choice
define('CO_' . $moduleDirNameUpper . '_' . 'BROWSETOTOPIC', "<span style='font-weight: bold;'>Browse items alphabetically</span>");
define('CO_' . $moduleDirNameUpper . '_' . 'OTHER', 'Other');
define('CO_' . $moduleDirNameUpper . '_' . 'ALL', 'All');

// block defines
define('CO_' . $moduleDirNameUpper . '_' . 'ACCESSRIGHTS', 'Access Rights');
define('CO_' . $moduleDirNameUpper . '_' . 'ACTION', 'Action');
define('CO_' . $moduleDirNameUpper . '_' . 'ACTIVERIGHTS', 'Active Rights');
define('CO_' . $moduleDirNameUpper . '_' . 'BADMIN', 'Block Administration');
define('CO_' . $moduleDirNameUpper . '_' . 'BLKDESC', 'Description');
define('CO_' . $moduleDirNameUpper . '_' . 'CBCENTER', 'Center Middle');
define('CO_' . $moduleDirNameUpper . '_' . 'CBLEFT', 'Center Left');
define('CO_' . $moduleDirNameUpper . '_' . 'CBRIGHT', 'Center Right');
define('CO_' . $moduleDirNameUpper . '_' . 'SBLEFT', 'Left');
define('CO_' . $moduleDirNameUpper . '_' . 'SBRIGHT', 'Right');
define('CO_' . $moduleDirNameUpper . '_' . 'SIDE', 'Alignment');
define('CO_' . $moduleDirNameUpper . '_' . 'TITLE', 'Title');
define('CO_' . $moduleDirNameUpper . '_' . 'VISIBLE', 'Visible');
define('CO_' . $moduleDirNameUpper . '_' . 'VISIBLEIN', 'Visible In');
define('CO_' . $moduleDirNameUpper . '_' . 'WEIGHT', 'Weight');

define('CO_' . $moduleDirNameUpper . '_' . 'PERMISSIONS', 'Permissions');
define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS', 'Blocks Admin');
define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS_DESC', 'Blocks/Group Admin');

define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS_MANAGMENT', 'Manage');
define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS_ADDBLOCK', 'Add a new block');
define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS_EDITBLOCK', 'Edit a block');
define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS_CLONEBLOCK', 'Clone a block');

//myblocksadmin
define('CO_' . $moduleDirNameUpper . '_' . 'AGDS', 'Admin Groups');
define('CO_' . $moduleDirNameUpper . '_' . 'BCACHETIME', 'Cache Time');
define('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS_ADMIN', 'Blocks Admin');

//Template Admin
define('CO_' . $moduleDirNameUpper . '_' . 'TPLSETS', 'Template Management');
define('CO_' . $moduleDirNameUpper . '_' . 'GENERATE', 'Generate');
define('CO_' . $moduleDirNameUpper . '_' . 'FILENAME', 'File Name');

//Menu
define('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE', 'Migrate');
define('CO_' . $moduleDirNameUpper . '_' . 'FOLDER_YES', 'Folder "%s" exist');
define('CO_' . $moduleDirNameUpper . '_' . 'FOLDER_NO', 'Folder "%s" does not exist. Create the specified folder with CHMOD 777.');
define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS', 'Show Development Tools Button?');
define('CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC', 'If yes, the "Migrate" Tab and other Development tools will be visible to the Admin.');
define('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_FEEDBACK', 'Feedback');
define('CO_' . $moduleDirNameUpper . '_' . 'MIGRATE_OK', 'Database migrated to current schema.');
define('CO_' . $moduleDirNameUpper . '_' . 'MIGRATE_WARNING', 'Warning! This is intended for developers only. Confirm write schema file from current database.');
define('CO_' . $moduleDirNameUpper . '_' . 'MIGRATE_SCHEMA_OK', 'Current schema file written');

//Latest Version Check
define('CO_' . $moduleDirNameUpper . '_' . 'NEW_VERSION', 'New Version: ');

//DirectoryChecker
define('CO_' . $moduleDirNameUpper . '_' . 'AVAILABLE', "<span style='color: green;'>Available</span>");
define('CO_' . $moduleDirNameUpper . '_' . 'NOTAVAILABLE', "<span style='color: red;'>Not available</span>");
define('CO_' . $moduleDirNameUpper . '_' . 'NOTWRITABLE', "<span style='color: red;'>Should have permission ( %d ), but it has ( %d )</span>");
define('CO_' . $moduleDirNameUpper . '_' . 'CREATETHEDIR', 'Create it');
define('CO_' . $moduleDirNameUpper . '_' . 'SETMPERM', 'Set the permission');
define('CO_' . $moduleDirNameUpper . '_' . 'DIRCREATED', 'The directory has been created');
define('CO_' . $moduleDirNameUpper . '_' . 'DIRNOTCREATED', 'The directory cannot be created');
define('CO_' . $moduleDirNameUpper . '_' . 'PERMSET', 'The permission has been set');
define('CO_' . $moduleDirNameUpper . '_' . 'PERMNOTSET', 'The permission cannot be set');

//FileChecker
//define('CO_' . $moduleDirNameUpper . '_' . 'AVAILABLE', "<span style='color: green;'>Available</span>");
//define('CO_' . $moduleDirNameUpper . '_' . 'NOTAVAILABLE', "<span style='color: red;'>Not available</span>");
//define('CO_' . $moduleDirNameUpper . '_' . 'NOTWRITABLE', "<span style='color: red;'>Should have permission ( %d ), but it has ( %d )</span>");
//define('CO_' . $moduleDirNameUpper . '_' . 'COPYTHEFILE', 'Copy it');
//define('CO_' . $moduleDirNameUpper . '_' . 'CREATETHEFILE', 'Create it');
//define('CO_' . $moduleDirNameUpper . '_' . 'SETMPERM', 'Set the permission');

define('CO_' . $moduleDirNameUpper . '_' . 'FILECOPIED', 'The file has been copied');
define('CO_' . $moduleDirNameUpper . '_' . 'FILENOTCOPIED', 'The file cannot be copied');

//define('CO_' . $moduleDirNameUpper . '_' . 'PERMSET', 'The permission has been set');
//define('CO_' . $moduleDirNameUpper . '_' . 'PERMNOTSET', 'The permission cannot be set');

//image config
define('CO_' . $moduleDirNameUpper . '_' . 'IMAGE_WIDTH', 'Image Display Width');
define('CO_' . $moduleDirNameUpper . '_' . 'IMAGE_WIDTH_DSC', 'Display width for image');
define('CO_' . $moduleDirNameUpper . '_' . 'IMAGE_HEIGHT', 'Image Display Height');
define('CO_' . $moduleDirNameUpper . '_' . 'IMAGE_HEIGHT_DSC', 'Display height for image');
define('CO_' . $moduleDirNameUpper . '_' . 'IMAGE_CONFIG', '<span style="color: #FF0000; font-size: Small;  font-weight: bold;">--- EXTERNAL Image configuration ---</span> ');
define('CO_' . $moduleDirNameUpper . '_' . 'IMAGE_CONFIG_DSC', '');
define('CO_' . $moduleDirNameUpper . '_' . 'IMAGE_UPLOAD_PATH', 'Image Upload path');
define('CO_' . $moduleDirNameUpper . '_' . 'IMAGE_UPLOAD_PATH_DSC', 'Path for uploading images');

define('CO_' . $moduleDirNameUpper . '_' . 'IMAGE_FILE_SIZE', 'Image File Size (in Bytes)');
define('CO_' . $moduleDirNameUpper . '_' . 'IMAGE_FILE_SIZE_DSC', 'The maximum file size of the image file (in Bytes)');

//Preferences
define('CO_' . $moduleDirNameUpper . '_' . 'TRUNCATE_LENGTH', 'Number of Characters to truncate to the long text field');
define('CO_' . $moduleDirNameUpper . '_' . 'TRUNCATE_LENGTH_DESC', 'Set the maximum number of characters to truncate the long text fields');

//Module Stats
define('CO_' . $moduleDirNameUpper . '_' . 'STATS_SUMMARY', 'Module Statistics');
define('CO_' . $moduleDirNameUpper . '_' . 'TOTAL_CATEGORIES', 'Categories:');
define('CO_' . $moduleDirNameUpper . '_' . 'TOTAL_ITEMS', 'Items');
define('CO_' . $moduleDirNameUpper . '_' . 'TOTAL_OFFLINE', 'Offline');
define('CO_' . $moduleDirNameUpper . '_' . 'TOTAL_PUBLISHED', 'Published');
define('CO_' . $moduleDirNameUpper . '_' . 'TOTAL_REJECTED', 'Rejected');
define('CO_' . $moduleDirNameUpper . '_' . 'TOTAL_SUBMITTED', 'Submitted');

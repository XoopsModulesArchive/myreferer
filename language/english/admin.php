<?php

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
define('_MD_MYREFERER_NAME', 'myReferer');
define('_MD_MYREFERER_REFERER', 'Referer');
define('_MD_MYREFERER_HEADER', 'Referers of ');
define('_MD_MYREFERER_NOVISIT', 'There are no data recorded in the database yet.');
define('_MD_MYREFERER_NOVISITYET', '...');
define('_MD_MYREFERER_ROBOTS', 'Meta Crawlers');
define('_MD_MYREFERER_PAGE', 'Pages');
define('_MD_MYREFERER_ENGINE', 'Search engine');
define('_MD_MYREFERER_ENGINES', 'Engines');
define('_MD_MYREFERER_KEYWORDS', 'Keywords');
define('_MD_MYREFERER_QUERY', 'Queries');
define('_MD_MYREFERER_USERS', 'Users');
define('_MD_MYREFERER_METAKEYWORDS', 'Current Meta Keywords');
define('_MD_MYREFERER_KEYGEN', 'Meta Keywords generator');
define('_MD_MYREFERER_CLEANER', 'DataBase cleaner');
define('_MD_MYREFERER_PREFERENCES', 'Preferences');

define('_MD_MYREFERER_INDEX', 'Go to module');
define('_MD_MYREFERER_SEARCH', 'Search');
define('_MD_MYREFERER_HELP', 'Help');
define('_MD_MYREFERER_TRANSFER', 'Replace current Meta Keywords');

define('_MD_MYREFERER_CREDIT', ' is a creation of %s<br>with the participation of %s');
define('_MD_MYREFERER_DATE', 'Last visit');
define('_MD_MYREFERER_NEW', 'Recent queries');
define('_MD_MYREFERER_TOP', 'Top');
define('_MD_MYREFERER_LETTERS', 'letters');
define('_MD_MYREFERER_POP', 'Popular queries');
define('_MD_MYREFERER_RANDOM', 'Random');
define('_MD_MYREFERER_AGENT', 'Agent');
define('_MD_MYREFERER_VISITS', 'Visits');
define('_MD_MYREFERER_RANKING', 'Ordered by');

define('_MD_MYREFERER_ADMIN', 'Admin');
define('_MD_MYREFERER_DATATYPE', 'Select a data type');
define('_MD_MYREFERER_DELETED', 'Data successfully deleted');
define('_MD_MYREFERER_UPDATED', 'Data successfully updated');
define('_MD_MYREFERER_CLEANED', 'Database cleaned');
define('_MD_MYREFERER_REMOVE', 'Data selection');
define('_MD_MYREFERER_NOTUPDATED', 'older than ');
define('_MD_MYREFERER_DAYS', 'days');
define('_MD_MYREFERER_AND', 'and / or');
define('_MD_MYREFERER_ATLEAST', 'having maximum ');
define('_MD_MYREFERER_SUBMIT', 'Submit');
define('_MD_MYREFERER_WEEKS', 'weeks');
define('_MD_MYREFERER_ENTRIES', ' data(s)');
define('_MD_MYREFERER_ERROR', 'You must select data type first!');
define('_MD_MYREFERER_STATS', 'Stats');
define('_MD_MYREFERER_WEEK', 'W');
define('_MD_MYREFERER_ALL', 'All');
define('_MD_MYREFERER_LATEST', 'last entry');
//define('_MD_MYREFERER_NOVISIT', 'No result to display');

define('_MD_MYREFERER_TOTAL', 'Total');
define('_MD_MYREFERER_VISIBLE', 'Visible');
define('_MD_MYREFERER_INVISIBLE', 'Invisible');
define('_MD_MYREFERER_UPDATE', 'Refresh');
define('_MD_MYREFERER_DISPLAYED', 'Displayed');
define('_MD_MYREFERER_HIDDEN', 'Hidden');

// Version 1.1
define('_MD_MYREFERER_UPDATE_MODULE', 'Update module');
// upgrade
define('_MD_MYREFERER_UPGRADE_DB', 'Database  update');
define('_MD_MYREFERER_UPGRADE_TO', 'myReferer upgrade: %s');
define('_MD_MYREFERER_UPGRADE_OK', '<br><p><b>myReferer %u : <span style="color: #CC0000; ">Upgrade successful</span></b>');
define('_MD_MYREFERER_UPGRADE_ERR', '<br><p><b>myReferer %u : <span style="color: #CC0000; ">An error occured while upgrading</span></b>');

// Config file
define('_MD_MYREFERER_CONFIG', 'Configuration');
define('_MD_MYREFERER_DBUPDATE', 'Database upgraded successfully!');

// Tracker
define('_MD_MYREFERER_TRACKER_ON', 'Activate mail when this robot is visting a page');
define('_MD_MYREFERER_TRACKER_OFF', 'Deactivate mail when this robot is visting a page');

define('_MD_MYREFERER_USERVISIT_ON', 'Activate the recording of the pages for this member');
define('_MD_MYREFERER_USERVISIT_OFF', 'Déactivate the recording of the pages for this member');

// Permissions / blocks & groups
define('_MD_MYREFERER_PERMISSIONS', 'Permissions');
define('_MD_MYREFERER_PERMISSIONS_DSC', 'Permissions to view');
define('_MD_MYREFERER_BLOCKS', 'Blocks & Groups');
define('_MD_MYREFERER_BLOCKS_DSC', 'Blocks management');
define('_MD_MYREFERER_GROUPS_DSC', 'Groups management');

// Stats keyword / query
define('_MD_MYREFERER_CLOSE', 'Close');
define('_MD_MYREFERER_MORE', 'More statistics');
define('_MD_MYREFERER_VISITORS', 'Visitors');
define('_MD_MYREFERER_MEMBERS', 'Members');
define('_MD_MYREFERER_STATS_ID', 'ID');
define('_MD_MYREFERER_STATS_TOTAL', 'Total visits');
define('_MD_MYREFERER_STATS_WEEK', 'Visits this week');
define('_MD_MYREFERER_STATS_FIRST', 'First visit');
define('_MD_MYREFERER_STATS_LAST', 'Last visit');
define('_MD_MYREFERER_STATS_STATUS', 'Status');
define('_MD_MYREFERER_STATS_SIMILAR', 'Similars');
define('_MD_MYREFERER_STATS_ENTRYPAGE', 'Entry page');
define('_MD_MYREFERER_STATS_SAMEPAGE', 'Same page');
define('_MD_MYREFERER_NODATAS', '/');

// delete text
define('_MD_MYREFERER_DELETE', 'delete');
define('_MD_MYREFERER_DELETE_KEYWORD', 'Confirm the suppression of this Key Word ');
define('_MD_MYREFERER_DELETE_PAGE', 'Confirm the suppression of this Page');
define('_MD_MYREFERER_DELETE_QUERY', 'Confirm the suppression of this Query');
define('_MD_MYREFERER_DELETE_REFERER', 'Confirm the suppression of this Referer');
define('_MD_MYREFERER_DELETE_ROBOT', 'Confirm the suppression of this Meta Crawler');
define('_MD_MYREFERER_DELETE_USER', 'Confirm the deletion of data concerning this User');
define('_MD_MYREFERER_RESET_DATAS', 'Reset weekly visits');
define('_MD_MYREFERER_RESET_DATA', 'Confirm the reset of the visits of the week');
define('_MD_MYREFERER_RESET', 'Reset');


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
define('_MI_MYREFERER_NAME', 'myReferer');
define('_MI_MYREFERER_DSC', 'Saves the statistics of the redirected pages from the deleted modules.');

// Menus
define('_MI_MYREFERER_ADMIN', 'Dashboard');
define('_MI_MYREFERER_CONFIG', 'Configuration');
define('_MI_MYREFERER_META', 'Meta Generator');
define('_MI_MYREFERER_CLEAN', 'Database cleanup');
define('_MI_MYREFERER_STATS', 'Statistiques');
define('_MI_MYREFERER_PERMS', 'Permissions');
define('_MI_MYREFERER_BLOCKS', 'Blocks & Groups');

define('_MI_MYREFERER_HELP', 'Help');

//  Blocks
define('_MI_MYREFERER_BLOC_ALLINFO', 'Last Informations');
define('_MI_MYREFERER_BLOC_REFERER', 'Last Referers');
define('_MI_MYREFERER_BLOC_ENGINE', 'Last Search engine');
define('_MI_MYREFERER_BLOC_KEYWORD', 'Last Keywords');
define('_MI_MYREFERER_BLOC_QUERY', 'Last Queries');
define('_MI_MYREFERER_BLOC_USERS', 'Last Users');
define('_MI_MYREFERER_BLOC_ROBOTS', 'Last Meta Crawlers');
define('_MI_MYREFERER_BLOC_PAGES', 'Last Pages');
define('_MI_MYREFERER_PAGECHCK', '');

// Preferecnces
define('_MI_MYREFERER_BANNER', 'Display banner');
define('_MI_MYREFERER_BANNER_DSC', '');
define('_MI_MYREFERER_TEXT', 'Text');
define('_MI_MYREFERER_TEXT_DSC', 'Display a welcome text');
define('_MI_MYREFERER_WELCOME', "Here are all the information regarding this website's traffic.");
define('_MI_MYREFERER_STARTDATE', 'Starting date');
define('_MI_MYREFERER_STARTDATE_DSC', 'Visits counter, starting date. Update only if your reset all your datas.');
define('_MI_MYREFERER_ORDER', 'Display order');
define('_MI_MYREFERER_ORDER_REF', 'Referer');
define('_MI_MYREFERER_ORDER_DATE', 'Last visit');
define('_MI_MYREFERER_ORDER_VISIT', 'Visits');
define('_MI_MYREFERER_PERPAGE', 'Results count');
define('_MI_MYREFERER_PERPAGE_DSC', 'Number of results to display per page.');
define('_MI_MYREFERER_TAG_NEW', 'New');
define(
    '_MI_MYREFERER_TAG_NEW_DSC',
    '1) How many time to be considered as new.<br>
2) How many hits to be displayed in user side and usable by the Meta generator.'
);

define('_MI_MYREFERER_TAG_POP', 'Popular');
define('_MI_MYREFERER_TAG_POP_DSC', 'How many hits to be considered as popular.');
define('_MI_MYREFERER_TODAY', "Today's entries");
define('_MI_MYREFERER_TODAY_DSC', "Date colors for todays' updated entries.");
define('_MI_MYREFERER_TOOLD', 'Too old entries');
define('_MI_MYREFERER_TOOLD_DSC', 'Date colors for outdated entries.');
define('_MI_MYREFERER_ALPHA', 'Alpha list');
define('_MI_MYREFERER_DESCRIPTION', 'Display stats for users.');

define('_MI_MYREFERER_PAGES', 'Pages');
define('_MI_MYREFERER_KEYWORDS', 'Keywords');
define('_MI_MYREFERER_QUERY', 'Queries');
define('_MI_MYREFERER_ROBOTS', 'Meta Crawlers');
define('_MI_MYREFERER_REFERER', 'Referer');
define('_MI_MYREFERER_ENGINE', 'Search engine');
define('_MI_MYREFERER_USERVISIT', 'Users visits');
define('_MI_MYREFERER_USERS', 'Users');
define('_MI_MYREFERER_BYMODULE_KEYWORD', 'Keywords by modules/pages');
define('_MI_MYREFERER_BYMODULE_QUERY', 'Queries by modules/pages');
define('_MI_MYREFERER_BYREFERER', 'Referes by modules/pages');

define('_MI_MYREFERER_DATE', 'Last visit');
define('_MI_MYREFERER_NEW', 'Recent queries');
define('_MI_MYREFERER_TOP', 'Top');
define('_MI_MYREFERER_POP', 'Popular queries');
define('_MI_MYREFERER_RANDOM', 'Random');

//Menu
define('_MI_MYREFERER_MENU_HOME', 'Home');
define('_MI_MYREFERER_MENU_01', 'Admin');
define('_MI_MYREFERER_MENU_ABOUT', 'About');

//Config
define('MI_MYREFERER_EDITOR_ADMIN', 'Editor: Admin');
define('MI_MYREFERER_EDITOR_ADMIN_DESC', 'Select the Editor to use by the Admin');
define('MI_MYREFERER_EDITOR_USER', 'Editor: User');
define('MI_MYREFERER_EDITOR_USER_DESC', 'Select the Editor to use by the User');

//Help
define('_MI_MYREFERER_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_MYREFERER_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_MYREFERER_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_MYREFERER_OVERVIEW', 'Overview');

//define('_MI_MYREFERER_HELP_DIR', __DIR__);

//help multi-page
define('_MI_MYREFERER_DISCLAIMER', 'Disclaimer');
define('_MI_MYREFERER_LICENSE', 'License');
define('_MI_MYREFERER_SUPPORT', 'Support');

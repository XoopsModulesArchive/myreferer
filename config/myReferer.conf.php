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

// Count visits from Webmaster (s)
$count_admin = 0;

// List of modules to exclude
$module_blacklist = 'xoopsorgnews|xoops_redirect|user|search|notifications|viewpmsg|readpmsg';

// Minimum size of keywords searched
$keyword_min = 3;

// Maximum size of keywords searched
$keyword_max = 24;

// Keep the punctuation in the searched keywords
$punctation = 1;

// Keep the numbers in the searched keywords
$numbers = 0;

// Convert the search words to lowercase
$smallcaps = 1;

// List of negative keywords
$keyword_blacklist = 'pour|avec|dans|site';

// List of negative search engines
$search_blacklist = '';

// List of referrers to exclude
$referer_blacklist = '127.0.0.1|mail|xoopsorgnews|casino|online|rate|sex|insur|finance|viagra|drug|cialis|health|loan|credit|poker|pharma|institute|weight';

// Activate the sending of an email for referencing by a new robot
$new_bot_smail = 0;

// Address for sending emails
$new_bot_mail = '';

// List of robots to exclude
$robots_blacklist = 'W3C_Validator|Lynx|libwww-perl';

// Prohibited robots redirect page
$page_prohibit = 'modules/myreferer/norobot.html';

// List of prohibited robots
$robots_prohibit = '';

// Save page views
$user_visit = 1;

// Choose groups
$save_group = '2';

// Pages - Afficher le top
$myreferer_pages_stats = 100;

// Keywords - Show top
$myreferer_query_stats = 100;

// Keywords / Pages - Display the top
$myreferer_query_pages_stats = 100;

// Referer - View the top
$myreferer_referer_stats = 100;

// Referer / Pages - View the top
$myreferer_referer_pages_stats = 100;

// Robots - View the top
$myreferer_robots_stats = 100;

// Robots / Pages - View the top
$myreferer_robots_pages_stats = 100;

// Visitors - View the top
$myreferer_users_stats = 100;

// Visitors / Pages - Display the top
$myreferer_users_pages_stats = 100;

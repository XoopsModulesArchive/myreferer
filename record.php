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

use Xmf\Request;
use XoopsModules\Myreferer\Helper;
use XoopsModules\Myreferer\Utility;

$helper = Helper::getInstance();

// Activate php debug mode
error_reporting(E_ALL ^ E_NOTICE);

// Global $xoopsDB, $xoopsUser, $xoopsModule;

// General settings : load the config file
$config_file = XOOPS_ROOT_PATH . '/modules/myreferer/config/myReferer.conf.php';
if (!file_exists($config_file)) {
    $configHandler = $helper->getHandler('Config');
    $configHandler->WriteConfigFile();
    unset($configHandler);
}
require_once $config_file;

// General settings
// Global $xoopsDB, $xoopsUser, $xoopsModule;
$myRefererIsAdmin = 0;
$record           = 1;
if (is_object($xoopsUser)) {
    $myRefererIsAdmin = $xoopsUser->isAdmin();
    if ($count_admin) {
        $record = 0;
    }
}

//  ------------------------------------------------------------------------------------------------------------- //
// 0) Restoring visit_tmp by 0
if (1 == date('w')) {
    Utility::restoring();
}

//  ------------------------------------------------------------------------------------------------------------- //
// 1) Gather informations about this referer
$_SERVER['REQUEST_URI'] = ($_SERVER['REQUEST_URI'] ?? ($_SERVER['SCRIPT_NAME'] . isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));

$page    = getenv('HTTP_HOST') . $_SERVER['REQUEST_URI'];
$page    = preg_replace('/[?&](PHPSESSID|(var_[^=&]*))=[^&]*/i', '', $page);
$date    = time();
$ref_url = getenv('HTTP_REFERER');

// The activated page is a blacklisted Module
$hide = '0';
if ($module_blacklist && preg_match('/(' . $module_blacklist . ')/i', $page)) {
    $hide = '1';
}
//  ------------------------------------------------------------------------------------------------------------- //
// Check page

$sql_page    = 'SELECT id FROM ' . $xoopsDB->prefix('myref_pages') . " WHERE page='$page'";
$result_page = $xoopsDB->query($sql_page);

$myrow   = $xoopsDB->fetchArray($result_page);
$pagesid = $myrow['id'];

if (!$pagesid) {
    // The page is not yet in the db, so let's add a new record
    if ($myRefererIsAdmin && !$count_admin) {
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('myref_pages') . "
				VALUES ('', '$page', '0', '0', '$date', '$date', '$hide')";
    } else {
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('myref_pages') . "
				VALUES ('', '$page', '1', '1', '$date', '$date', '$hide')";
    }

    $xoopsDB->queryF($sql);
    $pagesid = $xoopsDB->getInsertId();
} else {
    // The page is already in the db
    //	if (!$myRefererIsAdmin) {
    if ($count_admin) {
        $sql = 'UPDATE ' . $xoopsDB->prefix('myref_pages') . "
			SET visit = visit+1, visit_tmp = visit_tmp+1, date = '$date'
			WHERE page = '$page'";
        $xoopsDB->queryF($sql);
    }
}

//  ------------------------------------------------------------------------------------------------------------- //
// Save user visit page
$robots     = getenv('HTTP_USER_AGENT');
$save_gpage = 0;
$save_upage = 0;
$uid        = 0;
// if ( is_object($xoopsUser) AND $myRefererIsAdmin ) {
if (is_object($xoopsUser)) {
    $uid_groups = explode('|', $save_group);
    $uid        = $xoopsUser->uid();

    $memberHandler = xoops_getHandler('member');
    $groups        = $memberHandler->getGroupsByUser($uid);

    foreach ($groups as $key => $group) {
        if (in_array($group, $uid_groups)) {
            $save_gpage = 1;
            break;
        }
    }
}

if ((preg_match('Mozilla', $robots) || preg_match('Opera', $robots)) && !preg_match('googlebot', $robots) && is_object($xoopsUser)) {
    $sql    = 'SELECT id, tracker, date 
                FROM ' . $xoopsDB->prefix('myref_users') . "
                WHERE user=$uid";
    $result = $xoopsDB->queryF($sql);

    if (0 == $xoopsDB->getRowsNum($result)) {
        // The page is not yet in the db, so let's add a new record
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('myref_users') . "
		        VALUES (0, '$uid', '1', '1', '$date', '$date', '0', '1')";

        $xoopsDB->queryF($sql);
        $userid     = $xoopsDB->getInsertId();
        $save_upage = 1;
    } elseif ($record) {
        // The user is already in the db
        $myrow = $xoopsDB->fetchArray($result);
        // Check user's last visit and update if necessary (every hour)
        $userid     = $myrow['id'];
        $save_upage = $myrow['tracker'];
        $diff       = time() - $myrow['date'];

        if ($diff >= 3600) {
            $sql = 'UPDATE ' . $xoopsDB->prefix('myref_users') . "
				SET visit = visit+1, visit_tmp = visit_tmp+1, date = '$date'
				WHERE user = $uid";
        } else {
            $sql = 'UPDATE ' . $xoopsDB->prefix('myref_users') . "
				SET date = '$date'
				WHERE user = $uid";
        }

        $xoopsDB->queryF($sql);
    }
}

if ($user_visit and is_object($xoopsUser)) {
    if ($save_gpage && $save_upage) {
        // check user visit per pages
        $sql    = 'SELECT id FROM ' . $xoopsDB->prefix('myref_users_pages') . " WHERE usersid='$userid' AND pagesid='$pagesid'";
        $result = $xoopsDB->query($sql);
        if (0 == $xoopsDB->getRowsNum($result)) {
            $sql = 'INSERT INTO ' . $xoopsDB->prefix('myref_users_pages') . "
					VALUES ('', '$userid', '$pagesid', '1', '1', '$date', '$date', '$hide', '0')";

            $xoopsDB->queryF($sql);
        } else {
            $sql = 'UPDATE ' . $xoopsDB->prefix('myref_users_pages') . "
				SET visit = visit+1, visit_tmp = visit_tmp+1, date = $date, tracker='0'
				WHERE usersid='$userid' AND pagesid='$pagesid'";

            $xoopsDB->queryF($sql);
        }
    }
}

//  ------------------------------------------------------------------------------------------------------------- //
// 2) Referers
// Check wether the visitor is coming from current site, or from direct url
if (!preg_match(XOOPS_URL, $ref_url) and $ref_url) {
    // Who's that referer ?
    preg_match('|^http://(.*?)/|', $ref_url, $referers);
    $referer = $referers[1];

    // 2.a Check wether referer is a search engine or not and gather keywords
    $url_array = parse_url(Request::getString('HTTP_REFERER', '', 'SERVER'));
    //	if (array_key_exists('query', $url_array)) {
    parse_str($url_array['query'], $variables);
    //	}

    $variables['p']           = $variables['p'] ?? '';
    $variables['q']           = $variables['q'] ?? '';
    $variables['qs']          = $variables['qs'] ?? '';
    $variables['as_q']        = $variables['as_q'] ?? '';
    $variables['q1']          = $variables['q1'] ?? '';
    $variables['word']        = $variables['word'] ?? '';
    $variables['query']       = $variables['query'] ?? '';
    $variables['keywords']    = $variables['keywords'] ?? '';
    $variables['KeyWords']    = $variables['KeyWords'] ?? '';
    $variables['Keywords']    = $variables['Keywords'] ?? '';
    $variables['strKeywords'] = $variables['strKeywords'] ?? '';
    $variables['search']      = $variables['search'] ?? '';
    $variables['Search']      = $variables['Search'] ?? '';
    $variables['searchfor']   = $variables['searchfor'] ?? '';

    if (($variables['p']
         || $variables['qs']
         || $variables['q']
         || $variables['as_q']
         || $variables['q1']
         || $variables['query']
         || $variables['word']
         || $variables['keywords']
         || $variables['KeyWords']
         || $variables['strKeywords']
         || $variables['search']
         || $variables['Search']
         || $variables['searchfor'])
        && !preg_match('=cache', $url_array['query'])) {
        // If there is a query, it's a search engine
        $engine = 1;
        $key    = '';

        // Update the query table
        // Keywords can be found and retrived into the following queries
        $query = urldecode($variables['p']);
        $query = urldecode($variables['q']) . $query;
        $query = urldecode($variables['qs']) . $query;
        $query = urldecode($variables['as_q']) . $query;
        $query = urldecode($variables['q1']) . $query;
        $query = urldecode($variables['query']) . $query;
        $query = urldecode($variables['word']) . $query;
        $query = urldecode($variables['keywords']) . $query;
        $query = urldecode($variables['KeyWords']) . $query;
        $query = urldecode($variables['Keywords']) . $query;
        $query = urldecode($variables['strKeywords']) . $query;
        $query = urldecode($variables['search']) . $query;
        $query = urldecode($variables['Search']) . $query;
        $query = urldecode($variables['searchfor']) . $query;

        // We clean up the query
        $keywords = Utility::cleanQueries($query, $keyword_min, $keyword_max, $punctation, $numbers, $smallcaps, 1);

        // Keywords are extracted from the query and data base is updated
        if (is_array($keywords)) {
            foreach ($keywords as $keyword) {
                if ('' != $keyword) {
                    // And about query keywords?
                    $sql = 'SELECT id
					FROM ' . $xoopsDB->prefix('myref_query') . "
					WHERE query = '$keyword'";

                    $result = $xoopsDB->query($sql);

                    // The keyword is not yet in the db, so let's add a new record
                    if (0 == $xoopsDB->getRowsNum($result)) {
                        $sql = 'INSERT INTO ' . $xoopsDB->prefix('myref_query') . "
						VALUES ('', '$keyword', '1', '$page', '1', '1', '$date', '$date', '$hide')";

                        $xoopsDB->queryF($sql);
                        $queryid = $xoopsDB->getInsertId();
                    } else {
                        $myrow   = $xoopsDB->fetchArray($result);
                        $queryid = $myrow['id'];
                        // The keyword is already in the db, thus we update infos
                        $sql = 'UPDATE ' . $xoopsDB->prefix('myref_query') . "
						SET visit = visit+1, keyword = '1', page = '$page', date = '$date', visit_tmp = visit_tmp+1
						WHERE query = '$keyword'";

                        $xoopsDB->queryF($sql);
                    } // if in db or not

                    // check query per pages
                    $sql    = 'SELECT id FROM ' . $xoopsDB->prefix('myref_query_pages') . " WHERE queryid='$queryid' AND pagesid='$pagesid'";
                    $result = $xoopsDB->query($sql);
                    if (0 == $xoopsDB->getRowsNum($result)) {
                        $sql = 'INSERT INTO ' . $xoopsDB->prefix('myref_query_pages') . "
							VALUES ('', '$queryid', '$pagesid', '1', '1', '$date', '$date', '$hide', '0')";

                        $xoopsDB->queryF($sql);
                    } else {
                        $sql = 'UPDATE ' . $xoopsDB->prefix('myref_query_pages') . "
						SET visit = visit+1, visit_tmp = visit_tmp+1, date = '$date', tracker='0'
						WHERE queryid='$queryid' AND pagesid='$pagesid'";

                        $xoopsDB->queryF($sql);
                    }
                } // if keyword
            } // foreach
        }

        // save the phrases
        if (is_array($keywords) && count($keywords) > 1) {
            $query = Utility::cleanQueries($query, $keyword_min, $keyword_max, $punctation, $numbers, $smallcaps, 0);

            // And about query keywords?
            $sql    = 'SELECT id
				FROM ' . $xoopsDB->prefix('myref_query') . "
				WHERE query = '$query'";
            $result = $xoopsDB->query($sql);

            // The keyword is not yet in the db, so let's add a new record
            if (0 == $xoopsDB->getRowsNum($result)) {
                $sql = 'INSERT INTO ' . $xoopsDB->prefix('myref_query') . "
						VALUES ('', '$query', '0', '$page', '1', '1', '$date', '$date', '$hide')";

                $xoopsDB->queryF($sql);
                $queryid = $xoopsDB->getInsertId();
            } else {
                $myrow   = $xoopsDB->fetchArray($result);
                $queryid = $myrow['id'];
                // The keywords is already in the db, thus we update infos
                $sql = 'UPDATE ' . $xoopsDB->prefix('myref_query') . "
					SET visit = visit+1,  page = '$page', date = '$date', visit_tmp = visit_tmp+1, hide = '$hide'
					WHERE query = '$query'";

                $xoopsDB->queryF($sql);
            } // if in db or not

            // check query per pages
            $sql    = 'SELECT id FROM ' . $xoopsDB->prefix('myref_query_pages') . " WHERE queryid='$queryid' AND pagesid='$pagesid'";
            $result = $xoopsDB->query($sql);
            if (0 == $xoopsDB->getRowsNum($result)) {
                $sql = 'INSERT INTO ' . $xoopsDB->prefix('myref_query_pages') . "
						VALUES ('', '$queryid', '$pagesid', '1', '1', '$date', '$date', '$hide', '0')";

                $xoopsDB->queryF($sql);
            } else {
                $sql = 'UPDATE ' . $xoopsDB->prefix('myref_query_pages') . "
					SET visit = visit+1, visit_tmp = visit_tmp+1, date = '$date', tracker='0'
					WHERE queryid='$queryid' AND pagesid='$pagesid'";

                $xoopsDB->queryF($sql);
            }
        }
    } else {
        // 2.b That's not a search engine
        if (preg_match('=cache', $url_array['query'])) {
            $engine = 1;
        } else {
            $engine = 0;
        }
    }

    //  ------------------------------------------------------------------------------------------------------------- //
    // 3) So what about this referer?

    // The activated page is a blacklisted Referer
    $hide = '0';
    if ('' != $referer_blacklist && preg_match('/(' . $referer_blacklist . ')/i', $referer, $temp)) {
        $hide = '1';
    }
    if ('' != $referer_blacklist && preg_match('/(' . $referer_blacklist . ')/i', $ref_url, $temp)) {
        $hide = '1';
    }

    $sql    = 'SELECT id FROM ' . $xoopsDB->prefix('myref_referer') . "	WHERE referer = '$referer' ";
    $result = $xoopsDB->query($sql);

    // The referer is not yet in the db, so let's add a new record
    if (0 == $xoopsDB->getRowsNum($result)) {
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('myref_referer') . "
			VALUES ('', '$engine', '$referer', '$ref_url', '$page',  '1', '1', '$date', '$date', '$hide')";

        $xoopsDB->queryF($sql);
        $refererid = $xoopsDB->getInsertId();
    } else {
        $myrow     = $xoopsDB->fetchArray($result);
        $refererid = $myrow['id'];
        // The referer is already in the db, thus we update infos
        $sql = 'UPDATE ' . $xoopsDB->prefix('myref_referer') . "
			SET engine = '$engine', ref_url = '$ref_url', page = '$page', visit = visit+1, date = '$date', visit_tmp = visit_tmp+1
			WHERE referer = '$referer'";

        $xoopsDB->queryF($sql);
    } // What about referer

    // check referer per pages
    $sql    = 'SELECT id FROM ' . $xoopsDB->prefix('myref_referer_pages') . " WHERE refererid='$refererid' AND pagesid='$pagesid'";
    $result = $xoopsDB->query($sql);
    if (0 == $xoopsDB->getRowsNum($result)) {
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('myref_referer_pages') . "
				VALUES ('', '$refererid', '$pagesid', '1', '1', '$date', '$date', '$hide', '0')";

        $xoopsDB->queryF($sql);
    } else {
        $sql = 'UPDATE ' . $xoopsDB->prefix('myref_referer_pages') . "
			SET visit = visit+1, visit_tmp = visit_tmp+1, date = '$date', tracker='0'
			WHERE refererid='$refererid' AND pagesid='$pagesid'";

        $xoopsDB->queryF($sql);
    }
}

//  ------------------------------------------------------------------------------------------------------------- //
// 4) Robots
// Check wether this referer is a spider or not
$robots = getenv('HTTP_USER_AGENT');

if (!preg_match('Mozilla', $robots) && !preg_match('Opera', $robots) || preg_match('googlebot', $robots)) {
    if ('' != $robots_prohibit && preg_match('/(' . $robots_prohibit . ')/i', $robots, $temp)) {
        if ('' == $page_prohibit) {
            $page_prohibit = 'modules/myReferer/norobot.html';
        }
        header('Location: ' . XOOPS_URL . '/' . $page_prohibit);
    }

    $hide = '0';
    // The activated page is a blacklisted Module
    if ('' != $robots_blacklist && preg_match('/(' . $robots_blacklist . ')/i', $robots, $temp)) {
        $hide = '1';
    }

    $robot_name = Utility::getRobotName($robots);
    $ref_url    = Utility::getRobotUrl($robots);

    $sql    = 'SELECT id, tracker FROM ' . $xoopsDB->prefix('myref_robots') . " WHERE robots = '$robots' ";
    $result = $xoopsDB->query($sql);

    // The robot is not yet in the db, so let's add a new record
    if (0 == $xoopsDB->getRowsNum($result)) {
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('myref_robots') . "
				VALUES ('', '$robots', '$ref_url', '$page',  '1', '1', '$date', '$date', '$hide', '0')";

        $xoopsDB->queryF($sql);
        $robotsid = $xoopsDB->getInsertId();

        // send for new bot
        if ($new_bot_smail) {
            Utility::sendMail(1, $new_bot_mail, $robot_name, $ref_url, $page);
        }
    } else {
        $myrow    = $xoopsDB->fetchArray($result);
        $robotsid = $myrow['id'];
        $tracker  = $myrow['tracker'];
        // The robot is already in the db
        $sql = 'UPDATE ' . $xoopsDB->prefix('myref_robots') . "
			SET ref_url = '$ref_url', page = '$page', visit = visit+1, date = '$date', visit_tmp = visit_tmp+1
			WHERE robots = '$robots'";

        $xoopsDB->queryF($sql);

        // send mail for bot tracker
        //		if ( $tracker ) {
        //        	Utility::sendMail ( 0 , $new_bot_mail, $robot_name, $ref_url, $page ) ;
        //		}
    }

    // check robots per pages
    $sql    = 'SELECT id, tracker FROM ' . $xoopsDB->prefix('myref_robots_pages') . " WHERE robotsid='$robotsid' AND pagesid='$pagesid'";
    $result = $xoopsDB->query($sql);
    if (0 == $xoopsDB->getRowsNum($result)) {
        $sql = 'INSERT INTO ' . $xoopsDB->prefix('myref_robots_pages') . "
				VALUES ('', '$robotsid', '$pagesid', '1', '1', '$date', '$date', '$hide', '0')";

        $xoopsDB->queryF($sql);

        // send mail for bot tracker
        if ($tracker) {
            Utility::sendMail(0, $new_bot_mail, $robot_name, $ref_url, $page);
        }
    } else {
        $myrow   = $xoopsDB->fetchArray($result);
        $tracker = $myrow['tracker'];
        // The robot is already in the db
        $sql = 'UPDATE ' . $xoopsDB->prefix('myref_robots_pages') . "
			SET visit = visit+1, visit_tmp = visit_tmp+1, date = '$date', tracker='0'
			WHERE robotsid='$robotsid' AND pagesid='$pagesid'";

        $xoopsDB->queryF($sql);

        // send mail for page tracker
        if ($tracker) {
            Utility::sendMail(0, $new_bot_mail, $robot_name, $ref_url, $page);
        }
    }
}

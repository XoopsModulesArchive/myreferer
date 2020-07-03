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

use XoopsModules\Myreferer\Utility;

if (!defined('XOOPS_ROOT_PATH')) {
    exit('XOOPS root path not defined');
}

/**
 * @param $options
 * @return mixed
 */
function a_myrefererAll_show($options)
{
    global $xoopsDB, $xoopsUser, $xoopsModule;

    $myts = \MyTextSanitizer::getInstance();

    $new = explode('|', Utility::getOption('tag_new'));

    if (count($new) < 2) {
        $new[0] = 7;

        $new[1] = 1;
    }

    $more = 'AND hide = 0 AND visit >= ' . $new[1];

    if (empty($options[0]) || (0 == $options[0])) {
        $selected = range(1, 5);
    } else {
        $selected = explode(',', $options[0]);
    }

    if ('new' === $options[1]) {
        $title = ' (' . _MB_MYREFERER_ORDER_NEW . ')';
    } elseif ('date DESC' === $options[1]) {
        $title = ' (' . _MB_MYREFERER_ORDER_DATE_DESC . ')';
    } elseif ('visit DESC' === $options[1]) {
        $title = ' (' . _MB_MYREFERER_ORDER_VISIT_DESC . ')';
    }

    $startingdate = time() - (86400 * $new[0]);

    if ('new' === $options[1]) {
        $options[1] = 'date DESC';

        $where = 'AND ' . $startingdate . ' <= date';
    } else {
        $where = '';
    }

    // Referer

    $data = [];

    if (in_array(1, $selected, true) && Utility::checkRight(1)) {
        $sql = 'SELECT referer, visit, date, ref_url
				FROM ' . $xoopsDB->prefix('myreferer_referer') . "
				WHERE engine=0 $more $where
				ORDER BY $options[1]";

        $result = $xoopsDB->queryF($sql, $options[3], 0);

        while (list($referer, $visit, $date, $ref_url) = $xoopsDB->fetchRow($result)) {
            $referer = trim($referer);

            if (mb_strlen($referer) > $options[4] && 0 != $options[4]) {
                $referer = mb_substr($referer, 0, $options[4]);
            }

            if ($ref_url) {
                $value = '<a target="_blank" href="' . $ref_url . '" title="' . $ref_url . '" >' . $referer . '</a>';
            } else {
                $value = $referer;
            }

            if (1 == $options[2]) {
                $value .= '&nbsp;[' . $visit . ']';
            } elseif (2 == $options[2]) {
                $value .= '&nbsp;[' . formatTimestamp($date, 'm') . ']';
            } elseif (3 == $options[2]) {
                $value .= '&nbsp;[' . $visit . ']&nbsp;[' . formatTimestamp($date, 'm') . ']';
            }

            $data['result'][] = $value;

            $data['title'] = _MB_MYREFERER_REFERER . $title;

            $data['more'] = '<a href="' . XOOPS_URL . '/modules/myreferer/referer.php?op=0" title="' . _MB_MYREFERER_REFERER . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_REFERER . '...</a>';
        }

        $block['data'][1] = $data;
    }

    // Engine

    $data = [];

    if (in_array(2, $selected, true) && Utility::checkRight(2)) {
        $sql = 'SELECT referer, visit, date, ref_url
			FROM ' . $xoopsDB->prefix('myreferer_referer') . "
			WHERE engine=1 $more $where
			ORDER BY $options[1]";

        $result = $xoopsDB->queryF($sql, $options[3], 0);

        while (list($referer, $visit, $date, $ref_url) = $xoopsDB->fetchRow($result)) {
            $referer = trim($referer);

            if (mb_strlen($referer) > $options[4] && 0 != $options[4]) {
                $referer = mb_substr($referer, 0, $options[4]);
            }

            if ($ref_url) {
                $value = '<a target="_blank" href="' . $ref_url . '" title="' . $ref_url . '" >' . $referer . '</a>';
            } else {
                $value = $referer;
            }

            if (1 == $options[2]) {
                $value .= '&nbsp;[' . $visit . ']';
            } elseif (2 == $options[2]) {
                $value .= '&nbsp;[' . formatTimestamp($date, 'm') . ']';
            } elseif (3 == $options[2]) {
                $value .= '&nbsp;[' . $visit . ']&nbsp;[' . formatTimestamp($date, 'm') . ']';
            }

            $data['result'][] = $value;

            $data['title'] = _MB_MYREFERER_ENGINE . $title;

            $data['more'] = '<a href="' . XOOPS_URL . '/modules/myreferer/referer.php?op=1" title="' . _MB_MYREFERER_REFERER . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_ENGINE . '...</a>';
        }

        $block['data'][2] = $data;
    }

    // Keyword

    $data = [];

    if (in_array(3, $selected, true) && Utility::checkRight(3)) {
        $sql = 'SELECT query, visit, date, page
				FROM ' . $xoopsDB->prefix('myreferer_query') . "
				WHERE keyword=1 $more $where
				ORDER BY $options[1]";

        $result = $xoopsDB->queryF($sql, $options[3], 0);

        while (list($referer, $visit, $date, $ref_url) = $xoopsDB->fetchRow($result)) {
            $referer = trim($referer);

            if (mb_strlen($referer) > $options[4] && 0 != $options[4]) {
                $referer = mb_substr($referer, 0, $options[4]);
            }

            if ($ref_url) {
                $ref_url = 'http://' . $ref_url;

                $value = '<a href="' . $ref_url . '" title="' . $ref_url . '" >' . $referer . '</a>';
            } else {
                $value = $referer;
            }

            if (1 == $options[2]) {
                $value .= '&nbsp;[' . $visit . ']';
            } elseif (2 == $options[2]) {
                $value .= '&nbsp;[' . formatTimestamp($date, 'm') . ']';
            } elseif (3 == $options[2]) {
                $value .= '&nbsp;[' . $visit . ']&nbsp;[' . formatTimestamp($date, 'm') . ']';
            }

            $data['result'][] = $value;

            $data['title'] = _MB_MYREFERER_KEYWORD . $title;

            $data['more'] = '<a href="' . XOOPS_URL . '/modules/myreferer/query.php?op=1" title="' . _MB_MYREFERER_QUERY . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_KEYWORD . '...</a>';
        }

        $block['data'][3] = $data;
    }

    // Query

    $data = [];

    if (in_array(4, $selected, true) && Utility::checkRight(4)) {
        $sql = 'SELECT query, visit, date, page
				FROM ' . $xoopsDB->prefix('myreferer_query') . "
				WHERE keyword=0 $more $where
				ORDER BY $options[1]";

        $result = $xoopsDB->queryF($sql, $options[3], 0);

        while (list($referer, $visit, $date, $ref_url) = $xoopsDB->fetchRow($result)) {
            $referer = trim($referer);

            if (mb_strlen($referer) > $options[4] && 0 != $options[4]) {
                $referer = mb_substr($referer, 0, $options[4]);
            }

            if ($ref_url) {
                $ref_url = 'http://' . $ref_url;

                $value = '<a href="' . $ref_url . '" title="' . $ref_url . '" >' . $referer . '</a>';
            } else {
                $value = $referer;
            }

            if (1 == $options[2]) {
                $value .= '&nbsp;[' . $visit . ']';
            } elseif (2 == $options[2]) {
                $value .= '&nbsp;[' . formatTimestamp($date, 'm') . ']';
            } elseif (3 == $options[2]) {
                $value .= '&nbsp;[' . $visit . ']&nbsp;[' . formatTimestamp($date, 'm') . ']';
            }

            $data['result'][] = $value;

            $data['title'] = _MB_MYREFERER_QUERY . $title;

            $data['more'] = '<a href="' . XOOPS_URL . '/modules/myreferer/query.php?op=0" title="' . _MB_MYREFERER_QUERY . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_QUERY . '...</a>';
        }

        $block['data'][4] = $data;
    }

    // Robots

    $data = [];

    if (in_array(5, $selected, true) && Utility::checkRight(5)) {
        $sql = 'SELECT robots, visit, date, id
				FROM ' . $xoopsDB->prefix('myreferer_robots') . "
				WHERE hide=0 $more $where
				ORDER BY $options[1]";

        $result = $xoopsDB->queryF($sql, $options[3], 0);

        while (list($referer, $visit, $date, $id) = $xoopsDB->fetchRow($result)) {
            $ref_url = Utility::getRobotUrl($referer);

            $referer = Utility::getRobotName($referer);

            $referer = trim($referer);

            if (mb_strlen($referer) > $options[4] && 0 != $options[4]) {
                $referer = mb_substr($referer, 0, $options[4]);
            }

            if ($ref_url) {
                $value = '<a target="_blank" href="' . $ref_url . '" title="' . $ref_url . '" >' . $referer . '</a>';
            } else {
                $value = $referer;
            }

            if (1 == $options[2]) {
                $value .= '&nbsp;[' . $visit . ']';
            } elseif (2 == $options[2]) {
                $value .= '&nbsp;[' . formatTimestamp($date, 'm') . ']';
            } elseif (3 == $options[2]) {
                $value .= '&nbsp;[' . $visit . ']&nbsp;[' . formatTimestamp($date, 'm') . ']';
            }

            $data['result'][] = $value;

            $data['title'] = _MB_MYREFERER_ROBOT . $title;

            $data['more'] = '<a href="' . XOOPS_URL . '/modules/myreferer/spider.php" title="' . _MB_MYREFERER_ROBOT . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_ROBOT . '...</a>';
        }

        $block['data'][5] = $data;
    }

    // User

    $data = [];

    if (in_array(6, $selected, true) && Utility::checkRight(2)) {
        $sql = 'SELECT user, visit, visit_tmp, date, ref_url
			FROM ' . $xoopsDB->prefix('myreferer_users') . "
			WHERE $more $where
			ORDER BY $options[1]";

        $result = $xoopsDB->queryF($sql, $options[3], 0);

        while (list($referer, $visit, $visit_tmp, $date, $ref_url) = $xoopsDB->fetchRow($result)) {
            $referer = trim($referer);

            if (mb_strlen($referer) > $options[4] && 0 != $options[4]) {
                $referer = mb_substr($referer, 0, $options[4]);
            }

            if ($ref_url) {
                $value = '<a target="_blank" href="' . $ref_url . '" title="[' . formatTimestamp($date, 'm') . '] [' . $visit_tmp . '/' . $visit . ']" >' . $referer . '</a>';
            } else {
                $value = $referer;
            }

            if (1 == $options[2]) {
                $value = '&nbsp;[' . $visit_tmp . '/' . $visit . ']';
            } elseif (2 == $options[2]) {
                $value = '&nbsp;[' . formatTimestamp($date, 'm') . ']';
            } elseif (3 == $options[2]) {
                $value = '&nbsp;[' . $visit_tmp . '/' . $visit . ']&nbsp;[' . formatTimestamp($date, 'm') . ']';
            }

            $data['result'][] = $value;

            $data['title'] = _MB_MYREFERER_USERS . $title;

            $data['more'] = '<a href="' . XOOPS_URL . '/modules/myreferer/users.php" title="' . _MB_MYREFERER_USERS . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_USERS . '...</a>';
        }

        $block['data'][2] = $data;
    }

    return $block;
}

/**
 * @param $options
 * @return string
 */
function a_myrefererAll_edit($options)
{
    $form = "<table border='0' width='100%'>";

    // Type

    if (empty($options[0]) || (0 == $options[0])) {
        $selected = array_fill(0, 6, '');
    } else {
        $selected_tmp = explode(',', $options[0]);

        foreach ($selected_tmp as $key => $tmp) {
            $selected[$tmp] = " selected='selected'";
        }
    }

    $form .= "<tr><td width='40%' valign='top'>" . _MB_MYREFERER_SELECT . '</td><td>';

    $form .= "<select name='options[0][]' size='6' multiple='multiple'>";

    $form .= "<option value='1' " . $selected[1] . '>' . _MB_MYREFERER_REFERER . '</option>';

    $form .= "<option value='2' " . $selected[2] . '>' . _MB_MYREFERER_ENGINE . '</option>';

    $form .= "<option value='3' " . $selected[3] . '>' . _MB_MYREFERER_KEYWORD . '</option>';

    $form .= "<option value='4' " . $selected[4] . '>' . _MB_MYREFERER_QUERY . '</option>';

    $form .= "<option value='5' " . $selected[5] . '>' . _MB_MYREFERER_ROBOT . '</option>';

    $form .= "<option value='6' " . $selected[6] . '>' . _MB_MYREFERER_PAGES . '</option>';

    $form .= "<option value='7' " . $selected[6] . '>' . _MB_MYREFERER_USERS . '</option>';

    $form .= '</select></td></tr>';

    // Ranking

    $form .= "<tr><td width='40%' valign='top'>" . _MB_MYREFERER_ORDER . '</td><td>';

    $form .= "<select name='options[1]'>";

    $form .= '<option value="date DESC"';

    if ('date DESC' === $options[1]) {
        $form .= ' selected="selected"';
    }

    $form .= '>' . _MB_MYREFERER_ORDER_DATE_DESC . '</option>';

    $form .= '<option value="visit DESC"';

    if ('visit DESC' === $options[1]) {
        $form .= ' selected="selected"';
    }

    $form .= '>' . _MB_MYREFERER_ORDER_VISIT_DESC . '</option>';

    $form .= '<option value="new"';

    if ('new' === $options[1]) {
        $form .= ' selected="selected"';
    }

    $form .= '>' . _MB_MYREFERER_ORDER_NEW . '</option>';

    $form .= '</select></td></tr>';

    // infos to display

    $selected = array_fill(0, 3, '');

    $selected[$options[2]] = " selected='selected'";

    $form .= "<tr><td width='40%' valign='top'>" . _MB_MYREFERER_INFO . '</td><td>';

    $form .= "<select name='options[2]'>";

    $form .= "<option value='0' " . $selected[0] . '>' . _MB_MYREFERER_INFO_NONE . '</option>';

    $form .= "<option value='1' " . $selected[1] . '>' . _MB_MYREFERER_INFO_VISIT . '</option>';

    $form .= "<option value='2' " . $selected[2] . '>' . _MB_MYREFERER_INFO_LAST . '</option>';

    $form .= "<option value='3' " . $selected[3] . '>' . _MB_MYREFERER_INFO_BOTH . '</option>';

    $form .= '</select></td></tr>';

    // Number to display

    $form .= "<tr><td width='40%' valign='top'>" . _MB_MYREFERER_HOWMANY . '</td><td>';

    $form .= "<input type='text' size='3' name='options[3]' value='" . $options[3] . "'>";

    // Number caractère to display

    $form .= "<tr><td width='40%' valign='top'>" . _MB_MYREFERER_CHARS . '</td><td>';

    $form .= "<input type='text' size='3' name='options[4]' value='" . $options[4] . "'>";

    $form .= '</td></tr>';

    $form .= '</table>';

    return $form;
}

/**
 * @param $options
 * @return array
 */
function a_myreferer_show($options)
{
    global $xoopsDB, $xoopsUser, $xoopsModule;

    $myts = \MyTextSanitizer::getInstance();

    $new = explode('|', Utility::getOption('tag_new'));

    if (count($new) < 2) {
        $new[0] = 7;

        $new[1] = 1;
    }

    $more = 'AND hide = 0 AND visit >= ' . $new[1];

    $block = [];

    $startingdate = time() - (86400 * $new[0]);

    if ('new' === $options[1]) {
        $options[1] = 'date DESC';

        $where = 'AND ' . $startingdate . ' <= date';
    } else {
        $where = '';
    }

    if ('referer' === $options[0] && Utility::checkRight(1)) {
        $sql = 'SELECT referer, visit, visit_tmp, date, ref_url
				FROM ' . $xoopsDB->prefix('myreferer_referer') . "
				WHERE engine = 0 $more $where
				ORDER BY $options[1]";

        $more = '<a href="' . XOOPS_URL . '/modules/myreferer/referer.php?op=0" title="' . _MB_MYREFERER_REFERER . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_REFERER . '...</a>';
    }

    if ('engine' === $options[0] && Utility::checkRight(2)) {
        $sql = 'SELECT referer, visit, visit_tmp, date, ref_url
				FROM ' . $xoopsDB->prefix('myreferer_referer') . "
				WHERE engine = 1 $more $where
				ORDER BY $options[1]";

        $more = '<a href="' . XOOPS_URL . '/modules/myreferer/referer.php?op=1" title="' . _MB_MYREFERER_ENGINE . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_ENGINE . '...</a>';
    }

    if ('keyword' === $options[0] && Utility::checkRight(3)) {
        $sql = 'SELECT query, visit, visit_tmp, date, page
				FROM ' . $xoopsDB->prefix('myreferer_query') . "
				WHERE keyword=1 $more $where
				ORDER BY $options[1]";

        $more = '<a href="' . XOOPS_URL . '/modules/myreferer/query.php" title="' . _MB_MYREFERER_KEYWORDS . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_KEYWORDS . '...</a>';
    }

    if ('query' === $options[0] && Utility::checkRight(4)) {
        $sql = 'SELECT query, visit, visit_tmp, date, page
				FROM ' . $xoopsDB->prefix('myreferer_query') . "
				WHERE keyword=0 $more $where
				ORDER BY $options[1]";

        $more = '<a href="' . XOOPS_URL . '/modules/myreferer/query.php" title="' . _MB_MYREFERER_QUERY . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_QUERY . '...</a>';
    }

    if ('robots' === $options[0] && Utility::checkRight(5)) {
        $sql = 'SELECT robots, visit, visit_tmp, date, id
				FROM ' . $xoopsDB->prefix('myreferer_robots') . "
				WHERE robots!='' $more $where
				ORDER BY $options[1]";

        $more = '<a href="' . XOOPS_URL . '/modules/myreferer/spider.php" title="' . _MB_MYREFERER_ROBOT . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_ROBOT . '...</a>';
    }

    if ('pages' === $options[0] && Utility::checkRight(6)) {
        $sql = 'SELECT page, visit, visit_tmp, date, id
				FROM ' . $xoopsDB->prefix('myreferer_pages') . "
				WHERE page!='' $more $where
				ORDER BY $options[1]";

        $more = '<a href="' . XOOPS_URL . '/modules/myreferer/page.php" title="' . _MB_MYREFERER_PAGES . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_PAGES . '...</a>';
    }

    if ('users' === $options[0] && Utility::checkRight(7)) {
        $sql = 'SELECT user, visit, visit_tmp, date, id
				FROM ' . $xoopsDB->prefix('myreferer_users') . "
				WHERE user!='' $more $where
				ORDER BY $options[1]";

        $more = '<a href="' . XOOPS_URL . '/modules/myreferer/users.php" title="' . _MB_MYREFERER_USERS . '" target="_self">' . _MB_MYREFERER_MORE . _MB_MYREFERER_USERS . '...</a>';
    }

    if (isset($more)) {
        $blocks['more'] = $more;
    }

    if (isset($sql)) {
        $result = $xoopsDB->queryF($sql, $options[3], 0);

        while (list($referer, $visit, $visit_tmp, $date, $ref_url) = $xoopsDB->fetchRow($result)) {
            // Compile results of query

            if ('robots' === $options[0]) {
                $ref_url = Utility::getRobotUrl($referer);

                $referer = Utility::getRobotName($referer);
            }

            if ('pages' === $options[0]) {
                $ref_url = 'http://' . $referer;

                preg_match('/(' . str_replace('/', "\/", XOOPS_URL) . ')(.*)/i', 'http://' . $referer, $mypage);

                $referer = $mypage[2];
            }

            if ('keyword' === $options[0] or 'query' === $options[0]) {
                $ref_url = 'http://' . $ref_url;
            }

            if ('users' === $options[0]) {
                $ref_url = XOOPS_URL . '/userinfo.php?uid=' . $referer;

                $referer = XoopsUser::getUnameFromId($referer);
            }

            $referer = trim($referer);

            if (mb_strlen($referer) > $options[4] && 0 != $options[4]) {
                $referer = mb_substr($referer, 0, $options[4]);
            }

            if ($ref_url) {
                $value = '<a target="_blank" href="' . $ref_url . '" title="[' . formatTimestamp($date, 'm') . '] [' . $visit_tmp . '/' . $visit . ']" >' . $referer . '</a>';
            } else {
                $value = $referer;
            }

            if (1 == $options[2]) {
                $value .= '&nbsp;[' . $visit_tmp . '/' . $visit . ']';
            } elseif (2 == $options[2]) {
                $value .= '[' . formatTimestamp($date, 'm') . ']';
            } elseif (3 == $options[2]) {
                $value .= '&nbsp;[' . $visit_tmp . '/' . $visit . ']&nbsp;[' . formatTimestamp($date, 'm') . ']';
            }

            $blocks['result'] = $value;

            $block['content'][] = $blocks;
        }

        return $block;
    }
}

/**
 * @param $options
 * @return string
 */
function a_myreferer_edit($options)
{
    // Type

    $form = "<input type='hidden' name='options[0]' value='" . $options[0] . "'>";

    $form .= "<table border='0' width='100%'>";

    // Ranking

    $form .= "<tr><td width='40%' valign='top'>" . _MB_MYREFERER_ORDER . '</td><td>';

    $form .= "<select name='options[1]'>";

    $form .= '<option value="date DESC"';

    if ('date DESC' === $options[1]) {
        $form .= ' selected="selected"';
    }

    $form .= '>' . _MB_MYREFERER_ORDER_DATE_DESC . '</option>';

    $form .= '<option value="visit DESC"';

    if ('visit DESC' === $options[1]) {
        $form .= ' selected="selected"';
    }

    $form .= '>' . _MB_MYREFERER_ORDER_VISIT_DESC . '</option>';

    $form .= '<option value="new"';

    if ('new' === $options[1]) {
        $form .= ' selected="selected"';
    }

    $form .= '>' . _MB_MYREFERER_ORDER_NEW . '</option>';

    $form .= '</select></td></tr>';

    // infos to display

    $selected = array_fill(0, 3, '');

    $selected[$options[2]] = " selected='selected'";

    $form .= "<tr><td width='40%' valign='top'>" . _MB_MYREFERER_INFO . '</td><td>';

    $form .= "<select name='options[2]'>";

    $form .= "<option value='0' " . $selected[0] . '>' . _MB_MYREFERER_INFO_NONE . '</option>';

    $form .= "<option value='1' " . $selected[1] . '>' . _MB_MYREFERER_INFO_VISIT . '</option>';

    $form .= "<option value='2' " . $selected[2] . '>' . _MB_MYREFERER_INFO_LAST . '</option>';

    $form .= "<option value='3' " . $selected[3] . '>' . _MB_MYREFERER_INFO_BOTH . '</option>';

    $form .= '</select></td></tr>';

    // Number to display

    $form .= "<tr><td width='40%' valign='top'>" . _MB_MYREFERER_HOWMANY . '</td><td>';

    $form .= "<input type='text' size='3' name='options[3]' value='" . $options[3] . "'>";

    // Number caractère to display

    $form .= "<tr><td width='40%' valign='top'>" . _MB_MYREFERER_CHARS . '</td><td>';

    $form .= "<input type='text' size='3' name='options[4]' value='" . $options[4] . "'>";

    $form .= '</td></tr>';

    $form .= '</table>';

    return $form;
}

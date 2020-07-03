<?php

namespace XoopsModules\Myreferer;

use MyTextSanitizer;
use XoopsDatabaseFactory;
use XoopsModules\Myreferer\Common;

/**
 * Class Utility
 */
class Utility extends Common\SysUtility
{
    //--------------- Custom module methods -----------------------------
    /**
     * @param string $query
     * @param int    $min
     * @param int    $max
     * @param int    $punct
     * @param int    $numbers
     * @param int    $smallcaps
     * @param int    $keyword
     * @return string
     */
    public static function cleanQueries($query = '', $min = 3, $max = 24, $punct = 1, $numbers = 1, $smallcaps = 1, $keyword = 1)
    {
        // Clean up query from all code
        $query = \strip_tags($query);

        //$query = str_replace("&quot;"," ", $query);
        $query = \str_replace('"', '', $query);
        $query = \str_replace('(', '', $query);
        $query = \str_replace(')', '', $query);
        $query = \str_replace('/', ' ', $query);

        // Uncomment the following line if you have problems with special characters.
        // Attention: this option may cause your site to crash if not accepted by your server!
        if (\function_exists('mb_convert_encoding')) {
            $query = mb_convert_encoding($query, '', 'auto');
        }
        $query = \html_entity_decode(\urldecode($query));
        // if you want to remove puncutation except the '-'

        if (0 == $punct) {
            $query = \str_replace("d'", '', $query);
            $query = \str_replace("l'", '', $query);
            $query = \str_replace("n'", '', $query);
            $query = \str_replace("t'", '', $query);
            $query = \str_replace("m'", '', $query);
            $query = \str_replace("c'", '', $query);
            $query = \str_replace("j'", '', $query);
            $query = \str_replace("s'", '', $query);
            $query = \str_replace('-', 'xZy', $query);
            $query = \preg_replace('/[[:punct:]]/i', ' ', $query);
            $query = \preg_replace('/[[:graph:]]/i', ' ', $query);
            $query = \str_replace('xZy', '-', $query);
        } // Punct
        //	echo "<a title='".$query."'>".$query."</a><br>";

        // if you want numbers
        if (0 == $numbers) {
            $query = \preg_replace('/[[:digit:]]/i', ' ', $query);
        }

        // All minuscules
        if (1 == $smallcaps) {
            $query = mb_strtolower($query);
        }

        // Remove all keywords regarding their size
        $query   = \trim($query);
        $queries = \explode(' ', $query);

        //	$key = [];
        foreach ($queries as $tmpkeyword) {
            // Check keyword lenght
            $keyword_lenght = mb_strlen(\trim($tmpkeyword));
            if (0 != $keyword_lenght && $keyword_lenght > $min && $keyword_lenght < $max) {
                $key[] = $tmpkeyword;
            }
        }

        if (1 == $keyword) {
            return $key;
        }
        //		if ( count( $key ) < 4 ) { sort( $key ); }
        \sort($key);

        return \implode(' ', $key);
    }

    /**
     * send mail for new bot or tracker bot
     *
     * @param mixed $newbot
     * @param mixed $new_bot_mail
     * @param mixed $robotName
     * @param mixed $robotUrl
     * @param mixed $page
     */
    public static function sendMail($newbot, $new_bot_mail, $robotName, $robotUrl, $page)
    {
        global $xoopsConfig;
        require_once XOOPS_ROOT_PATH . '/modules/myreferer/language/' . $xoopsConfig['language'] . '/main.php';

        $today        = \date(_MYREFERER_MAIL_DATEFORMAT);
        $template_dir = XOOPS_ROOT_PATH . '/modules/myreferer/language/' . $xoopsConfig['language'] . '/mail_template';

        $xoopsMailer = \getMailer();
        $xoopsMailer->useMail();
        $xoopsMailer->setTemplateDir($template_dir);
        if ($newbot) {
            $xoopsMailer->setTemplate('newbot.tpl');
            $xoopsMailer->setSubject(\sprintf(_MYREFERER_MAIL_SUBJECT_NEW, $xoopsConfig['sitename']));
        } else {
            $xoopsMailer->setTemplate('trackerbot.tpl');
            $xoopsMailer->setSubject(\sprintf(_MYREFERER_MAIL_SUBJECT_TRACKER, $xoopsConfig['sitename'], $robotName));
        }
        $xoopsMailer->assign('SITENAME', $xoopsConfig['sitename'] . ' - ' . $xoopsConfig['slogan']);
        $xoopsMailer->assign('ADMINMAIL', $xoopsConfig['adminmail']);
        $xoopsMailer->assign('SITEURL', XOOPS_URL . '/');
        $xoopsMailer->assign('SPIDER', $robotName);
        if ($ref_url) {
            $xoopsMailer->assign('SPIDER_URL', '(' . $robotUrl . ')');
        } else {
            $xoopsMailer->assign('SPIDER_URL', ' ');
        }
        $xoopsMailer->assign('SPIDER_PAGE', 'http://' . $page);
        $xoopsMailer->assign('SPIDER_TODAY', $today);

        if ($new_bot_mail) {
            $xoopsMailer->setToEmails([$new_bot_mail]);
        } else {
            $xoopsMailer->setToEmails([$xoopsConfig['adminmail']]);
        }
        $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
        $xoopsMailer->setFromName($xoopsConfig['sitename']);
        $xoopsMailer->send();
    }

    /**
     * Get Robot name
     *
     * @param mixed $robots
     * @return string    : Bot Name
     */
    public static function getRobotName($robots = '')
    {
        $tmp_bot = ('' == $robots) ? \getenv('HTTP_USER_AGENT') : $robots;
        \preg_match("/^(http:\/\/)?([^\/]+)/si", $tmp_bot, $matches);

        if (isset($matches[1])) {
            if (\preg_match('Googlebot', $robots) && 'Mozilla' === $matches[0]) {
                $bot_name = 'Googlebot';
            } else {
                $bot_name = $matches[0];
            }
        } else {
            $bot_name = $robots;
        }

        return $bot_name;
    }

    /**
     * Get Robot url
     *
     * @param mixed $robots
     * @return string    : Bot url
     */
    public static function getRobotUrl($robots = '')
    {
        $bot_url = '';
        $str0    = $robots;
        $str1    = \explode('http://', $str0);
        if (\count($str1) > 1) {
            $str2 = \explode(')', $str1[1]);
            $str2 = \explode(' ', $str2[0]);
            $str2 = \explode(';', $str2[0]);
            if ($str2[0]) {
                $bot_url = 'http://' . $str2[0];
            }
        }

        return $bot_url;
    }

    /**
     * Restoring visit_tmp by 0
     */
    public static function restoring()
    {
        $week      = \date('W');
        $day       = ($week * 7) - 5;
        $this_week = \mktime(0, 0, 0, 1, $day, \date('Y'));
        if ($week > self::getMeta('lastraz')) {
            //  if (  $week > 0 ) {

            global $xoopsDB;
            // get table list (xoops_version.php)
            require_once XOOPS_ROOT_PATH . '/modules/myreferer/language/english/modinfo.php';
            require_once XOOPS_ROOT_PATH . '/modules/myreferer/xoops_version.php';
            $ret = true;
            foreach ($modversion['tables'] as $table) {
                if (self::existFieldname($table, 'visit_tmp')) {
                    global ${$table . '_stats'};
                    //				if ( self::existTable( $table . '_stats') )  {
                    $sql_select = 'SELECT * FROM ' . $xoopsDB->prefix($table) . " WHERE visit_tmp!=0 AND date < $this_week ORDER BY visit_tmp DESC LIMIT 0 , " . ${$table . '_stats'};
                    $res_select = $xoopsDB->query($sql_select);

                    while (false !== ($myrow = $xoopsDB->fetchArray($res_select))) {
                        $sql_insert = 'INSERT INTO ' . $xoopsDB->prefix($table) . '_stats VALUES ';
                        switch ($table) {
                            case 'myref_pages':
                                $sql_insert .= '(0,' . \date('Y') . ',' . (\date('W') - 1) . ',' . $myrow['id'] . ',' . $myrow['visit_tmp'] . ');';
                                break;
                            case 'myref_query':

                                $sql_insert .= '(0,' . \date('Y') . ',' . (\date('W') - 1) . ',' . $myrow['id'] . ',' . $myrow['visit_tmp'] . ');';
                                break;
                            case 'myref_query_pages':
                                $sql_insert .= '(0,' . \date('Y') . ',' . (\date('W') - 1) . ',' . $myrow['queryid'] . ',' . $myrow['pagesid'] . ',' . $myrow['visit_tmp'] . ');';
                                break;
                            case 'myref_referer':
                                $sql_insert .= '(0,' . \date('Y') . ',' . (\date('W') - 1) . ',' . $myrow['id'] . ',' . $myrow['visit_tmp'] . ');';
                                break;
                            case 'myref_referer_pages':
                                $sql_insert .= '(0,' . \date('Y') . ',' . (\date('W') - 1) . ',' . $myrow['refererid'] . ',' . $myrow['pagesid'] . ',' . $myrow['visit_tmp'] . ');';
                                break;
                            case 'myref_robots':
                                $sql_insert .= '(0,' . \date('Y') . ',' . (\date('W') - 1) . ',' . $myrow['id'] . ',' . $myrow['visit_tmp'] . ');';
                                break;
                            case 'myref_robots_pages':
                                $sql_insert .= '(0,' . \date('Y') . ',' . (\date('W') - 1) . ',' . $myrow['robotsid'] . ',' . $myrow['pagesid'] . ',' . $myrow['visit_tmp'] . ');';
                                break;
                            case 'myref_users':
                                $sql_insert .= '(0,' . \date('Y') . ',' . (\date('W') - 1) . ',' . $myrow['id'] . ',' . $myrow['visit_tmp'] . ');';
                                break;
                            case 'myref_users_pages':
                                $sql_insert .= '(0,' . \date('Y') . ',' . (\date('W') - 1) . ',' . $myrow['usersid'] . ',' . $myrow['pagesid'] . ',' . $myrow['visit_tmp'] . ');';
                                break;
                        }
                        $xoopsDB->queryF($sql_insert);
                        //	                }
                    }

                    $sql = 'UPDATE ' . $xoopsDB->prefix($table) . " SET visit_tmp = 0 WHERE visit_tmp !=0 AND date < $this_week";
                    $xoopsDB->queryF($sql);
                }
            }
            self::setMeta('lastraz', $week);
        }
    }

    /**
     * @param string $letter
     * @param int    $op
     * @return string
     */
    public static function letters($letter = _ALL, $op = 1)
    {
        global $xoopsModule;

        $letterchoice = '<hr>[  ';
        $alphabet     = [_MYREFERER_OTHERS, '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', _ALL];
        $num          = \count($alphabet) - 1;
        $counter      = 0;
        while (list(, $ltr) = \each($alphabet)) {
            if ($ltr == $letter) {
                $letterchoice .= '<b>' . $ltr . '</b>';
            } else {
                $letterchoice .= "<a href='" . XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . "/query.php?ord=alpha&op=$op&letter=$ltr'>$ltr</a>";
            }
            if ($counter == \round($num / 2)) {
                $letterchoice .= ' ]<br>[ ';
            } elseif ($counter != $num) {
                $letterchoice .= '&nbsp;|&nbsp;';
            }
            $counter++;
        }
        $letterchoice .= ' ]<hr>';

        return $letterchoice;
    }

    /**
     * @param int    $currentoption
     * @param string $breadcrumb
     */
    public static function getAdminMenu($currentoption = 0, $breadcrumb = '')
    {
        echo "
    	<style type='text/css'>
    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/myreferer/images/bg.gif') repeat-x left bottom; font-size: 10px; line-height:normal; border-left: 1px solid #000000; border-right: 1px solid #000000; margin-bottom: 12px; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:0px 5px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/myreferer/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; white-space: nowrap}
		#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/myreferer/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; white-space: nowrap}
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar #current a { background-position:0 -150px; border-width:0; }
		#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }
		</style>
    ";
        // global $xoopsDB, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
        global $xoopsModule, $xoopsConfig;
        $myts = \MyTextSanitizer::getInstance();

        $tblColors                 = array_fill(0, 8, '');
        $tblColors[$currentoption] = 'current';

        //echo XOOPS_ROOT_PATH . '/modules/myreferer/language/' . $xoopsConfig['language'] . '/modinfo.php';

        if (\file_exists(XOOPS_ROOT_PATH . '/modules/myreferer/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
            require_once XOOPS_ROOT_PATH . '/modules/myreferer/language/' . $xoopsConfig['language'] . '/modinfo.php';
        } else {
            require_once XOOPS_ROOT_PATH . '/modules/myreferer/language/french/modinfo.php';
        }

        require \dirname(__DIR__) . '/admin/menu.php';

        echo '<div id="buttontop">';
        echo '<table style="width: 100%; padding: 0;" cellspacing="0"><tr>';
        echo '<td style="font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;">';
        for ($i = 0, $iMax = \count($headermenu); $i < $iMax; $i++) {
            echo '<a class="nobutton" href="' . $headermenu[$i]['link'] . '">' . $headermenu[$i]['title'] . '</a> ';
            if ($i < \count($headermenu) - 1) {
                echo '| ';
            }
        }
        echo '</td>';
        echo '<td style="font-size: 12px; text-align: right; color: #CC0000; padding: 0 6px; line-height: 18px; font-weight: bold;">' . $breadcrumb . '</td>';
        echo '</tr></table>';
        echo '</div>';

        echo '<div id="buttonbar">';
        echo '<ul>';

        for ($i = 0, $iMax = \count($adminmenu); $i < $iMax; $i++) {
            echo '<li id="' . $tblColors[$i] . '">
                      <a href="' . XOOPS_URL . '/modules/myreferer/' . $adminmenu[$i]['link'] . '">
                      <span>' . $adminmenu[$i]['title'] . '</span></a>
                      </li>';
        }
        echo '</ul></div>';
        echo '<div style="float: left; width: 100%; text-align: center; margin: 0px; padding: 0px">';
    }

    /**
     * @param int    $currentoption
     * @param string $breadcrumb
     */
    public static function getStatMenu($currentoption = 0, $breadcrumb = '')
    {
        echo "
    	<style type='text/css'>
    	#statbar { float:right; font-size: 10px; line-height:normal; margin-bottom: 0px; }
    	#statbar ul { margin:0; margin-top: 0px; padding:0px 0px 0; list-style:none;}
		#statbar li { display:inline; margin:0; padding:0;}
		#statbar a 		{ float:left; background-color: #DDE; margin:0; padding: 5px; text-align: center; text-decoration:none; border: 1px solid #000000; border-bottom: 0px; white-space: nowrap}
		#statbar a span { display:block; white-space: nowrap;}
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#statbar a span {float:none;}
		/* End IE5-Mac hack */
		#statbar a:hover span { color:#333; }
		#statbar #current a { background-color: #00FFFF; border: 1px solid #000000; border-bottom: 0px;}
		#statbar #current a span { background-color: #00FFFF; color:#333; }
		#statbar a:hover { background-position:0% -150px; background-color: #00FFFF; }
		#statbar a:hover span { background-position:100% -150px; background-color: #00FFFF; }
		</style>
    ";
        // global $xoopsDB, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
        global $xoopsModule, $xoopsConfig;
        $myts = \MyTextSanitizer::getInstance();
        $statmenu = [];

        $tblColors                 = array_fill(0, 8, '');
        $tblColors[$currentoption] = 'current';

        //echo XOOPS_ROOT_PATH . '/modules/myreferer/language/' . $xoopsConfig['language'] . '/modinfo.php';

        if (\file_exists(XOOPS_ROOT_PATH . '/modules/myreferer/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
            require_once XOOPS_ROOT_PATH . '/modules/myreferer/language/' . $xoopsConfig['language'] . '/modinfo.php';
        } else {
            require_once XOOPS_ROOT_PATH . '/modules/myreferer/language/french/modinfo.php';
        }

        require \dirname(__DIR__) . '/admin/menu.php';

        echo '<div id="adminmenu" style="visibility:hidden;position:absolute;z-index:100;top:-100"></div>';
        echo '<script language="JavaScript1.2" src="../assets/js/popmenu.js" type="text/javascript"></script>';
        echo '
     <script language="JavaScript1.2"  type="text/javascript">
     ';

        for ($i = 0, $iMax = \count($statmenu); $i < $iMax; $i++) {
            echo '
      Text[' . $i . ']=["' . $statmenu[$i]['title'] . '","' . $statmenu[$i]['help'] . '"]
';
        }

        /* The Style array parameters come in the following order
    Style[...]=[titleColor,TitleBgColor,TitleBgImag,TitleTextAlign,TitleFontFace,TitleFontSize,
                   TextColor,TextBgColor,TextBgImag,TextTextAlign,TextFontFace,TextFontSize,
                   Width,Height,BorderSize,BorderColor,
                   Textpadding,transition number,Transition duration,
                   Transparency level,shadow type,shadow color,Appearance behavior,TipPositionType,Xpos,Ypos]
    */
        echo '
      Style[0]=["white","#2F5376","","","","","black","white","","center","",,300,,1,"#2F5376",2,,,96,2,"black",,,,]
';
        echo '
     var TipId="adminmenu"
     var FiltersEnabled = 1
     mig_clay()
     </script>
     ';

        echo '<br><div id="statbar">';
        echo '<ul>';

        for ($i = 0, $iMax = \count($statmenu); $i < $iMax; $i++) {
            echo '<li id="' . $tblColors[$i] . '">
                      <a onMouseOver="stm(Text[' . $i . '],Style[0])" onMouseOut="htm()"
                         href="' . XOOPS_URL . '/modules/myreferer/' . $statmenu[$i]['link'] . '">
                      <span>' . $statmenu[$i]['title'] . '</span></a></li>';
        }
        echo '</ul></div>';
        echo '<div style="float: left; width: 100%; text-align: center; margin: 0px; padding: 0px">';
    }

    /**
     * @param int    $currentoption
     * @param string $breadcrumb
     */
    public static function getMetaMenu($currentoption = 0, $breadcrumb = '')
    {
        echo "
    	<style type='text/css'>
    	#statbar { float:right; font-size: 10px; line-height:normal; margin-bottom: 0px; }
    	#statbar ul { margin:0; margin-top: 0px; padding:0px 0px 0; list-style:none;}
		#statbar li { display:inline; margin:0; padding:0;}
		#statbar a 		{ float:left; background-color: #DDE; margin:0; padding: 5px; text-align: center; text-decoration:none; border: 1px solid #000000; border-bottom: 0px; white-space: nowrap}
		#statbar a span { display:block; white-space: nowrap;}
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#statbar a span {float:none;}
		/* End IE5-Mac hack */
		#statbar a:hover span { color:#333; }
		#statbar #current a { background-color: #00FFFF; border: 1px solid #000000; border-bottom: 0px;}
		#statbar #current a span { background-color: #00FFFF; color:#333; }
		#statbar a:hover { background-position:0% -150px; background-color: #00FFFF; }
		#statbar a:hover span { background-position:100% -150px; background-color: #00FFFF; }
		</style>
    ";
        // global $xoopsDB, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
        global $xoopsModule, $xoopsConfig;
        $myts = \MyTextSanitizer::getInstance();

        $tblColors                 = array_fill(0, 8, '');
        $tblColors[$currentoption] = 'current';

        //echo XOOPS_ROOT_PATH . '/modules/myreferer/language/' . $xoopsConfig['language'] . '/modinfo.php';

//        if (\file_exists(XOOPS_ROOT_PATH . '/modules/myreferer/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
//            require_once XOOPS_ROOT_PATH . '/modules/myreferer/language/' . $xoopsConfig['language'] . '/modinfo.php';
//        } else {
//            require_once XOOPS_ROOT_PATH . '/modules/myreferer/language/french/modinfo.php';
//        }

        xoops_loadLanguage('modinfo', 'myreferer');

        require \dirname(__DIR__) . '/admin/menu.php';
        echo '<br><div id="statbar">';
        echo '<ul>';

        for ($i = 0, $iMax = \count($metamenu); $i < $iMax; $i++) {
            echo '<li id="' . $tblColors[$i] . '"><a href="' . XOOPS_URL . '/modules/myreferer/' . $metamenu[$i]['link'] . '"><span>' . $metamenu[$i]['title'] . '</span></a></li>';
        }
        echo '</ul></div>';
        echo '<div style="float: left; width: 100%; text-align: center; margin: 0px; padding: 0px">';
    }

    /**
     * @param string $ord
     * @param string $search
     * @param string $engine
     * @param string $week
     * @param string $startart
     */
    public static function search($ord = '', $search = '', $engine = '', $week = '', $startart = '')
    {
        echo '
	<div style="text-align:right; padding-right:10px;">
	<form style="margin:0px; vertical-align: center; " action="' . $_SERVER['SCRIPT_NAME'] . '?ord=' . $ord . '&search=' . $search . '&engine=' . $engine . '&week=' . $week . '&op=&startart=' . $startart . '" method="post">
	<input style="margin:0px; vertical-align: center; " type="text" name="search" size="30" maxlength="30" value="' . $search . '">&nbsp;<button style="font-size:11px; " type="submit">' . _MD_MYREFERER_SEARCH . '</button>
	</form>
	</div>';
    }

    public static function getAdminFooter()
    {
        echo '<p>';
        OpenTable();
        echo '<div style="text-align: right; vertical-align: center"><img src="../assets/images/myReferer.gif" border="0" align="center" valign="absmiddle">';
        echo \sprintf(_MD_MYREFERER_CREDIT, '<a href="http://wolfactory.wolfpackclan.com" target="_blank">WolFactory</a>', '<a href="http://www.dugris.info" target="_blank">DuGris</a>');
        echo '</div>';
        CloseTable();
        echo '<p>';
    }

    /**
     * Get module preference
     *
     * @param string $option
     * @param mixed  $repmodule
     * @return string
     */
    public static function getOption($option, $repmodule = 'myReferer')
    {
        global $xoopsModuleConfig, $xoopsModule;
        static $tbloptions = [];
        if (\is_array($tbloptions) && \array_key_exists($option, $tbloptions)) {
            return $tbloptions[$option];
        }

        $retval = false;
        if (isset($xoopsModuleConfig) && (\is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
            if (isset($xoopsModuleConfig[$option])) {
                $retval = $xoopsModuleConfig[$option];
            }
        } else {
            $moduleHandler = \xoops_getHandler('module');
            $module        = $moduleHandler->getByDirname($repmodule);
            $configHandler = \xoops_getHandler('config');
            if ($module) {
                $moduleConfig = &$configHandler->getConfigsByCat(0, $module->getVar('mid'));
                if (isset($moduleConfig[$option])) {
                    $retval = $moduleConfig[$option];
                }
            }
        }
        $tbloptions[$option] = $retval;

        return $retval;
    }

    /**
     * check permissions
     *
     * @param int $refererid
     *            1 -> Referers
     *            2 -> Engines
     *            3 -> Keywords
     *            4 -> Queries
     *            5 -> Robots
     * @return bool
     */
    public static function checkRight($refererid)
    {
        global $xoopsUser;
        $groups           = \is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $grouppermHandler = \xoops_getHandler('groupperm');

        $moduleHandler   = \xoops_getHandler('module');
        $myRefererModule = $moduleHandler->getByDirname('myReferer');
        if ($grouppermHandler->checkRight('myReferer_wiew', $refererid, $groups, $myRefererModule->getVar('mid'))) {
            return true;
        }

        return false;
    }

    /**
     * Gets a value for a key in the myReferer_config table
     *
     * @param string $key
     * @return string $value
     */
    public static function getMeta($key)
    {
        $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();
        $sql     = \sprintf('SELECT conf_value FROM %s WHERE conf_name=%s', $xoopsDB->prefix('myref_config'), $xoopsDB->quoteString($key));
        $ret     = $xoopsDB->query($sql);
        if (!$ret) {
            $value = false;
        } else {
            [$value] = $xoopsDB->fetchRow($ret);
        }

        return $value;
    }

    /**
     * @param string $directory
     * @return int|string
     */
    public static function createDir($directory = 'config')
    {
        $thePath = XOOPS_ROOT_PATH . '/modules/myreferer/' . $directory . '/';

        if (@\is_writable($thePath)) {
            self::adminChmod($thePath, $mode = 0777);

            return $thePath;
        }

        if (!@\is_dir($thePath)) {
            self::adminMkdir($thePath);

            return $thePath;
        }

        return 0;
    }

    /**
     * @param $target
     * @return bool
     */
    public static function adminMkdir($target)
    {
        // http://www.php.net/manual/en/public static function .mkdir.php
        // saint at corenova.com
        // bart at cdasites dot com
        if (\is_dir($target) || empty($target)) {
            return true; // best case check first
        }

        if (\file_exists($target) && !\is_dir($target)) {
            return false;
        }

        if (self::adminMkdir(mb_substr($target, 0, mb_strrpos($target, '/')))) {
            if (!\file_exists($target)) {
                $res = \mkdir($target, 0777); // crawl back up & create dir tree
                self::adminChmod($target);

                return $res;
            }
        }
        $res = \is_dir($target);

        return $res;
    }

    /**
     * @param     $target
     * @param int $mode
     * @return bool
     */
    public static function adminChmod($target, $mode = 0777)
    {
        return @\chmod($target, $mode);
    }

    /**
     * Sets a value for a key in the myReferer_config table
     *
     * @param string $key
     * @param string $value
     * @return bool TRUE if success, FALSE if failure
     */
    public static function setMeta($key, $value)
    {
        $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();
        if (self::getMeta($key)) {
            $sql = \sprintf('UPDATE %s SET conf_value = %s WHERE conf_name = %s', $xoopsDB->prefix('myref_config'), $xoopsDB->quoteString($value), $xoopsDB->quoteString($key));
        } else {
            $sql = \sprintf(
                "INSERT INTO %s (conf_id , conf_name, conf_title, conf_value, conf_desc, conf_formtype, conf_valuetype, conf_order) 
        VALUES (0, %s, '', %s, '', 'hidden', 'hidden', 0)",
                $xoopsDB->prefix('myref_config'),
                $xoopsDB->quoteString($key),
                $xoopsDB->quoteString($value)
            );
        }
        $ret = $xoopsDB->queryF($sql);
        if (!$ret) {
            return false;
        }

        return true;
    }

    /**
     * Detemines if a field exists in the current db
     *
     * @param string $table the table name (without XOOPS prefix)
     * @param string $field the field name
     * @return bool True if table exists, false if not
     */
    public static function existFieldname($table, $field)
    {
        $bRetVal = false;
        $xoopsDB = XoopsDatabaseFactory::getDatabaseConnection();
        $sql     = 'SHOW COLUMNS FROM ' . $xoopsDB->prefix($table);
        $ret     = $xoopsDB->queryF($sql);
        while (list($m_fieldname) = $xoopsDB->fetchRow($ret)) {
            if ($m_fieldname == $field) {
                $bRetVal = true;
                break;
            }
        }
        $xoopsDB->freeRecordSet($ret);

        return $bRetVal;
    }

    /**
     * Detemines if a table exists in the current db
     *
     * @param string $table the table name (without XOOPS prefix)
     * @return bool True if table exists, false if not
     */
    public static function existTable($table)
    {
        $bRetVal = false;
        //Verifies that a MySQL table exists
        $xoopsDB  = XoopsDatabaseFactory::getDatabaseConnection();
        $realname = $xoopsDB->prefix($table);
        $sql      = 'SHOW TABLES FROM ' . XOOPS_DB_NAME;
        $ret      = $xoopsDB->queryF($sql);
        while (list($m_table) = $xoopsDB->fetchRow($ret)) {
            if ($m_table == $realname) {
                $bRetVal = true;
                break;
            }
        }
        $xoopsDB->freeRecordSet($ret);

        return $bRetVal;
    }

    /**
     * Detemines if a table exists in the current db
     *
     * @param mixed $url
     * @param mixed $length
     * @return array True if table exists, false if not
     */
    public static function displayUrl($url, $length = '20')
    {
        \preg_match('/(' . \str_replace('/', "\/", XOOPS_URL) . ')(.*)/i', 'http://' . $url, $urls);

        if (mb_strlen($urls[2]) && mb_strlen($urls[2]) > $length) {
            $urls         = \explode('?', $urls[2]);
            $urls['name'] = $urls[0];

            if ($urls[1]) {
                $urls['alt'] = $urls[1];
                $url_id      = \explode('id=', $urls[1]);

                if ($url_id[1]) {
                    $urls['name'] .= '&nbsp;[id=' . $url_id[1] . ']';
                } else {
                    $urls['name'] .= '&nbsp;[...]';
                }
            }
        } else {
            $urls['name'] = $urls[2];
            $urls['alt']  = '';
        }

        return $urls;
    }
}

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
foreach ($pattern_robots as $pattern_robot) {
    if (preg_match($pattern_robot, $robot)) {
        $robot_icon = $pattern_robot;
        break;
    }
    $robot_icon = 'robot';
}

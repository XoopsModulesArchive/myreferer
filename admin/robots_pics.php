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



foreach( $pattern_robots as $pattern_robot ) {

if ( eregi($pattern_robot, $robot ) ) {
  
  $robot_icon = $pattern_robot;
  break;
} else {

  $robot_icon = 'robot';
}
}

?>
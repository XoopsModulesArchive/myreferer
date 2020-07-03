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
echo '<!DOCTYPE html>';
echo '<html xml:lang="' . _LANGCODE . '" lang="' . _LANGCODE . '">
	<head>
	<meta http-equiv="content-type" content="text/html; charset=' . _CHARSET . '">
	<meta http-equiv="content-language" content="' . _LANGCODE . '">
	<title>' . htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES) . ' Administration</title>
	<script type="text/javascript" src="' . XOOPS_URL . '/include/xoops.js"></script>
	';
echo '<link rel="stylesheet" type="text/css" media="all" href="' . XOOPS_URL . '/xoops.css">';
echo '<link rel="stylesheet" type="text/css" media="all" href="' . XOOPS_URL . '/modules/system/style.css">';
echo "<script type='text/javascript'>\n";
echo "self.focus();\n";
echo '</script>';
echo '</head>';
OpenTable();

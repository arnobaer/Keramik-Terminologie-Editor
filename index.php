<?php define('KeramikGuardian', true);

/**
 * Keramik Terminologie Editor
 * Copyright (C) 2012-2013  Bernhard R. Arnold
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

include_once('include/config.inc.php');

$form = new Form();

?>
<!doctype html>
<html lang="us">
<head>
	<meta charset="utf-8">
	<title>Keramik Terminologie Editor</title>
	<link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<link href="css/keramik/default.css" rel="stylesheet">
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui-1.10.3.custom.js"></script>
	<script src="js/keramik.js"></script>
	<script src="js/keramik-condition.js"></script>
<?php
		// This restores the last open accordion panel.
		$accordion_active = $form->getPost('accordion_active');
		echo "\t<script type=\"text/javascript\">".'$(function() {$( "#accordion" ).accordion( "option", "active", '.($accordion_active !== false ? $accordion_active : 'false').' );});</script>'.PHP_EOL;
?>
</head>
<body style="margin-top: 0; padding-top:10px;">

<div style="width:960px; margin:0 auto; padding:0;">

<p style="margin:0;padding:0;"><span style="float: left; margin-right:5px;" class="ui-icon ui-icon-circle-arrow-e"></span> <a href="/">Toolserver</a> &raquo; <a href=".">Keramik Terminologie Editor</a></p>

<div class="ui-widget">
	<h1>Keramik Terminologie <sub><em>Editor</em></sub></h1>
	<img class="cover" src="images/cover.png">
	<p>Ein Hilfsmittel zur Dokumentation von Keramikfunden nach dem <em>Handbuch zur Terminologie der mittelalterlichen und neuzeitlichen Keramik in Österreich (<span class="caps">FÖM</span>at A/Sonderheft 12)</em>. Zu beziehen beim Bundesdenkmalamt Wien (<a href="http://www.bda.at/organisation/889/">Mag. Hofer</a>) oder beim <a href="http://www.verlag-berger.at/">Verlag Berger</a>, Kosten etwa € 15,-. </p>
	<p>Der generierte Text kann bearbeitet und in die Funddokumentation eingegliedert werden.</p>
</div>

<div class="clear space"></div>

<?php

$form->run();

?>

<div class="clear space"></div>

<div class="ui-widget footer">
	<p><em>Keramik Terminologie Editor</em> ist freie, unter der <a href="http://www.gnu.org/licenses/gpl-3.0.txt">GNU/GPL-Lizenz 3.0</a> veröffentlichte Software.<br>
	Copyleft 2012&ndash;<?php echo date('Y'); ?> Bernhard R. Arnold</p>
</div>

</div>

</body>
</html>

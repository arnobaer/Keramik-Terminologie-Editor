<?php defined('KeramikTerminologieEditor') or die();

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
?>
<!doctype html>
<html lang="de-AT">
<head>
	<meta charset="utf-8">
	<title>Keramik Terminologie Editor</title>
	<link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<link href="css/keramik/default.css" rel="stylesheet">
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui-1.10.3.custom.js"></script>
	<script src="js/keramik.js"></script>
	<script src="js/keramik-condition.js"></script>
	<!-- This restores the last open accordion panel. -->
	<script type="text/javascript">$(function() {$("#accordion").accordion("option", "active", <?php echo post('accordion_active', 'false'); ?>);});</script>
</head>
<body style="margin-top: 0; padding-top:10px;">

<div style="width:960px; margin:0 auto; padding:0;">

<p style="margin:0;padding:0;"><span style="float: left; margin-right:5px;" class="ui-icon ui-icon-circle-arrow-e"></span> <a href="/">Toolserver</a> &raquo; <a href=".">Keramik Terminologie Editor</a></p>

<div class="ui-widget">
	<h1>Keramik Terminologie <sub><em>Editor</em></sub></h1>
	<img class="cover" src="images/cover.png">
	<p>Ein Hilfsmittel zur Dokumentation von Keramikfunden nach dem <em>Handbuch zur Terminologie der mittelalterlichen und neuzeitlichen Keramik in Österreich (<span class="caps">FÖM</span>at A/Sonderheft 12)</em>. Zu beziehen beim Bundesdenkmalamt Wien (<a href="http://www.bda.at/organisation/889/">Mag. Hofer</a>) oder beim <a href="http://www.verlag-berger.at/">Verlag Berger</a>, Kosten etwa € 15,-. </p>
	<p>Die generierte Beschreibung orientiert sich möglichst strikt an den Empfehlungen des Bundesdenkmalamts und eignet sich besonders für eine einheitliche Beschreibung großer Fundbestände.</p>
</div>

<div class="clear space"></div>

<?php $form->run(); ?>

<div class="clear space"></div>

<div class="ui-widget footer">
	<p><em>Keramik Terminologie Editor</em> ist freie, unter der <a href="http://www.gnu.org/licenses/gpl-3.0.txt">GNU/GPL-Lizenz 3.0</a> veröffentlichte Software.<br>
	Copyright &copy; 2012&ndash;2013 Bernhard R. Arnold</p>
</div>

</div>

</body>
</html>

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
</head>
<body>

	<div style="width:960px; margin:0 auto; padding: 0;">

<?php include VIEW_PATH.'/document_header.php'; ?>

		<div class="clear space"></div>

		<?php $form->run(); ?>

		<div class="clear space"></div>

<?php include VIEW_PATH.'/document_footer.php'; ?>

	</div>

	<!-- Including the jQuery UI framework. -->
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui-1.10.3.custom.js"></script>

	<!-- Including the custom section scripts. -->
	<script src="js/keramik.js"></script>
	<script src="js/keramik-condition.js"></script>

	<!-- This restores the last open accordion panel. -->
	<script type="text/javascript">$(function() {$("#accordion").accordion("option", "active", <?php echo post('accordion_active', 'false'); ?>);});</script>

</body>
</html>

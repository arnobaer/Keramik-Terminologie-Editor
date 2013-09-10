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

	<!-- Including the jQuery UI framework. -->
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui-1.10.3.custom.js"></script>

	<!-- Including the custom section scripts. -->
	<script src="js/keramik.js"></script>
	<script src="js/keramik-erhaltungszustand.js"></script>

	<!-- This restores the last open accordion panel. -->
	<script type="text/javascript">$(function() {$("#accordion").accordion("option", "active", <?php js_accordion_active(); ?>);});</script>

	<!-- This restores the last active tab panel. -->
	<script type="text/javascript">$(function() {$("#grundform_tabs").tabs("option", "active", <?php js_tabs_active(); ?>);});</script>

</head>
<body>

	<a id="github_ribbon" href="<?php echo AppGithubUrl; ?>"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png" alt="Fork me on GitHub"></a>

	<div style="width:960px; margin:0 auto; padding: 0;">

<?php include VIEW_PATH.'/document_header.php'; ?>

		<!-- ID report is the anchor for displaying the following report in a
			visually appealing way. -->
		<div id="beschreibung" class="clear space"></div>

		<?php $form->run(); ?>

		<div class="clear space"></div>

<?php include VIEW_PATH.'/document_footer.php'; ?>

	</div>

	<div>
	<p>Debug:</p>
	<pre><?php print_r($_POST);?></pre>
	</div>

</body>
</html>

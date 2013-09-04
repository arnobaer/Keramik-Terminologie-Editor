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

		<!-- Calculated description, long and short version. -->
		<?php echo $description; ?>

		<form action="<?php echo $url; ?>#<?php echo $anchor; ?>" method="post">
			<input type="hidden" name="session" value="<?php echo $session; ?>">
			<input id="accordion_active" type="hidden" name="accordion_active" value="">
			<input id="tab_active" type="hidden" name="tab_active" value="">

			<?php echo $accordion; ?>

			<div>
			<hr>
			<button id="submit_button" type="submit" name="<?php echo $submit_name; ?>" value="submit">Text erzeugen</button>
			<button id="reset_button" type="submit" name="<?php echo $reset_name; ?>" value="reset">Zurücksetzen</button>
			</div>
		</form>

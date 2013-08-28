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

/** Object condition section.

POST variables:

	bodenbereich_boden    - type of vessel bottom.
*/
class Bodenbereich extends AccordionSection
{
	public function __construct()
	{
		parent::__construct('bodenbereich', "Bodenbereich", 34);
	}

	public function show_content()
	{
?>
		<table style="width:auto;">
			<tr>
				<td><?php $this->show_boden(); ?></td>
			</tr>
		</table>
<?php
	}

	/** Specify the vessel neck type. */
	public function show_boden()
	{
		$input = new Choice('bodenbereich_boden', false);
		$input->addChoice(0, "keine Angabe");
		$input->addChoice("Flachboden");
		$input->addChoice("minimal nach oben gewölbter Flachboden", "Flachboden, min. n. oben gewölbt");
		$input->addChoice("Konvexboden");
		$input->addChoice("Konkavboden");
		$input->addChoice("aus der Masse gedrehter Standring");

		$box = new Box('boden', "Bodenformen", $input->getHtml());
		echo $box->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		$list = array();

		$list[] = self::getPost('bodenbereich_boden');

		$list = array_filter($list);

		return implode(", ", $list);
	}
}

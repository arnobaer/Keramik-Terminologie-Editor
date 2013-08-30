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
*/
class SectionBottom extends AccordionSection
{
	// Used POST variable names.

	const KEY_BOTTOM    = 'KEY_BOTTOM';

	// Used variable values to be compared somewhere.

	const VAL_NOT_SPECIFIED = 0;

	public function __construct()
	{
		parent::__construct(
			'bottomzone',   // Element id
			"Bodenbereich", // Section title
			34              // Page number
		);
	}

	public function show_content()
	{
?>
		<table style="width:auto;">
			<tr>
				<td><?php $this->show_bottom(); ?></td>
			</tr>
		</table>
<?php
	}

	/** Specify the vessel bottom type. */
	public function show_bottom()
	{
		$input = new Choice(self::KEY_BOTTOM, false);
		$input->addChoice(0, "keine Angabe");
		$input->addChoice("Flachboden");
		$input->addChoice("minimal nach oben gewölbter Flachboden", "Flachboden, min. n. oben gewölbt");
		$input->addChoice("Konvexboden");
		$input->addChoice("Konkavboden");
		$input->addChoice("aus der Masse gedrehter Standring");

		$box = new Box('bottom', "Bodenformen", $input->getHtml());
		echo $box->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		$list = array();

		$list[] = post(self::KEY_BOTTOM);

		$list = array_filter($list);

		return implode(", ", $list);
	}

	/** Returns short formal description. */
	static public function get_short_description()
	{
		return '';
	}
}

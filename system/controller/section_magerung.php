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

/**
 *
 */
class SectionMagerung extends AccordionSection
{
	// Used POST variable names.


	public function __construct()
	{
		parent::__construct(
			'magerung', // Element id
			"Magerung", // Section title
			12          // Page number
		);
	}

	public function show_content()
	{
?>
		<table>
			<tr>
				<td></td>
			</tr>
		</table>
<?php
	}

	/**
	 *
	 */
	public function show_()
	{
		$fieldset = new FieldsetWidget('functionals_foot', "Standvorrichtungen", '');
		echo $fieldset->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		return '';
	}

	/** Returns short formal description. */
	static public function get_short_description()
	{
		return '';
	}
}

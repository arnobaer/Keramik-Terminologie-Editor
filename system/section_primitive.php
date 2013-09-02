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

/** Object primitive form section.
*/
class SectionPrimitive extends AccordionSection
{
	// Used POST variable names.

	const ID_         = 'primitive_';

	// Used variable values to be compared somewhere.

	const VALUE_NOT_SPECIFIED = 0;

	public function __construct()
	{
		parent::__construct(
			'primitive_form', // Element id
			"Grundform",      // Section title
			58                // Page number
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
	 * @returns
	 */
	public function fieldset_()
	{

		$fieldset = new FieldsetWidget('production_forming', "Formgebung", $forming->getHtml());
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

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

class SectionDimensions extends AccordionSection
{
	// Used POST variable names.

	const KEY_RIM            = 'KEY_DIMENSIONS_RIM';
	const KEY_MAXIMUM        = 'KEY_DIMENSIONS_MAXIMUM';
	const KEY_BOTTOM         = 'KEY_DIMENSIONS_BOTTOM';
	const KEY_WALL_THICKNESS = 'KEY_DIMENSIONS_WALL_THICKNESS';
	const KEY_HEIGHT         = 'KEY_DIMENSIONS_HEIGHT';
	const KEY_RIM_PRESERVED  = 'KEY_DIMENSIONS_KEY_RIM_PRESERVED';

	// Used variable values to be compared somewhere.

	const VAL_NOT_SPECIFIED = 0;

	public function __construct()
	{
		parent::__construct(
			'dimensions',     // Element id
			"Massangaben", // Section title
			34            // Page number
		);
	}

	public function show_content()
	{
		$html = '<p class="infobox" style="margin-top:7px;"><strong>Don\'t care!</strong> Eingaben jeglicher Art, mit und ohne Komma und Einheit oder ungültige Zeichen werden automatisch gefiltert und formatiert.</p>'.PHP_EOL;
?>
		<table style="width:100%;">
			<tr>
				<td><?php $this->show_rim(); ?></td>
				<td><?php $this->show_wall_thickness(); ?></td>
				<td style="width:33%;"><?php echo $html; ?></td>
			</tr>
		</table>
<?php
	}

	public function show_rim()
	{

		$input = new TextInput(self::KEY_RIM, 'Randdurchmesser (cm)');

		$input2 = new TextInput(self::KEY_MAXIMUM, 'Maximaldurchmesser (cm)');

		$input3 = new TextInput(self::KEY_BOTTOM, 'Bodendurchmesser (cm)');

		$box = new Box('dimensions', "Durchmesser", $input->getHtml().$input2->getHtml().$input3->getHtml());
		echo $box->show();
	}

	public function show_wall_thickness()
	{
		$input = new TextInput(self::KEY_WALL_THICKNESS, 'Wandstärke von&ndash;bis (cm)');

		$input2 = new TextInput(self::KEY_HEIGHT, '(erh.) Höhe (cm)');

		$input3 = new TextInput(self::KEY_RIM_PRESERVED, 'Randerhalt (%)');

		$box = new Box('dimensions_2', "Abmessungen", $input->getHtml().$input2->getHtml().$input3->getHtml());
		echo $box->show();
	}
}

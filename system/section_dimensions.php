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

/** References to class SectionCondition.
 */
class SectionDimensions extends AccordionSection
{
	// Used POST variable names.

	const KEY_RIM            = 'dimensions_rim';
	const KEY_MAXIMUM        = 'dimensions_maximum';
	const KEY_BOTTOM         = 'dimensions_bottom';
	const KEY_WALL_THICKNESS = 'dimensions_wallthickness';
	const KEY_HEIGHT         = 'dimensions_height';
	const KEY_RIM_PRESERVED  = 'dimensions_rimpreserved';

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
		$information = "<strong>Hinweis:</strong> ".
			"Eingaben jeglicher Art, mit und ohne Komma und Einheit oder " .
			"ungültige Zeichen werden automatisch gefiltert, gerundet und " .
			"formatiert.";

		$dimensions = '<p class="infobox" style="margin-top:7px;">'.$information.'</p>'.PHP_EOL;
?>
		<table style="width:100%;">
			<tr>
				<td><?php $this->show_rim(); ?></td>
				<td><?php $this->show_wall_thickness(); ?></td>
				<td style="width:33%;"><?php echo $dimensions; ?></td>
			</tr>
		</table>
<?php
	}

	public function show_rim()
	{

		$input = new TextInputWidget(self::KEY_RIM, 'Randdurchmesser (cm)');

		$input2 = new TextInputWidget(self::KEY_MAXIMUM, 'Maximaldurchmesser (cm)');

		$input3 = new TextInputWidget(self::KEY_BOTTOM, 'Bodendurchmesser (cm)');

		$fieldset = new FieldsetWidget('dimensions', "Durchmesser", $input->getHtml().$input2->getHtml().$input3->getHtml());
		echo $fieldset->show();
	}

	public function show_wall_thickness()
	{
		$input = new TextInputWidget(self::KEY_WALL_THICKNESS, 'Wandstärke von&ndash;bis (cm)');

		$input2 = new TextInputWidget(self::KEY_HEIGHT, '(erh.) Höhe (cm)');

		$input3 = new TextInputWidget(self::KEY_RIM_PRESERVED, 'Randerhalt (%)');

		$fieldset = new FieldsetWidget('dimensions_2', "Abmessungen", $input->getHtml().$input2->getHtml().$input3->getHtml());
		echo $fieldset->show();
	}

	public function rim_diameter()
	{
		$cm = str_centimeters(post(self::KEY_RIM));
		return $cm ? ("Randdm. {$cm}") : '';
	}

	static public function maximum_diameter()
	{
		$cm = str_centimeters(post(self::KEY_MAXIMUM));
		return $cm ? ("max. Dm. {$cm}") : '';
	}

	static public function bottom_diameter()
	{
		$cm = str_centimeters(post(self::KEY_BOTTOM));
		return $cm ? ("Bodendm. {$cm}") : '';
	}

	static public function wall_thickness()
	{
		$cm = str_centimeters_range(post(self::KEY_WALL_THICKNESS));
		return $cm ? ("Wandst. {$cm}") : '';
	}

	static public function height()
	{
		$cm = str_centimeters(post(self::KEY_HEIGHT));
		$preserved = SectionCondition::is_complete_extent() ? '' : "erh. ";
		return $cm ? ("{$preserved}H. {$cm}") : '';
	}

	static public function rim_preserved()
	{
		$percent = str_percent(post(self::KEY_RIM_PRESERVED));
		return $percent ? ("{$percent} Randerhalt") : '';
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		$dimensions = array();

		$dimensions[] = self::height();

		// Show preserved rim percent only if diameter is specified.
		$rim_diameter = self::rim_diameter();
		$rim_preserved = self::rim_preserved();
		if ($rim_diameter and $rim_preserved)
			$rim_diameter .= " ({$rim_preserved})";

		$dimensions[] = $rim_diameter;
		$dimensions[] = self::maximum_diameter();
		$dimensions[] = self::bottom_diameter();
		$dimensions[] = self::wall_thickness();

		return implode(', ', array_filter($dimensions));
	}

	/** Returns short formal description. */
	static public function get_short_description()
	{
		$dimensions = array();
		$dimensions[] = self::height();
		$dimensions[] = self::rim_diameter();
		$dimensions[] = self::maximum_diameter();
		$dimensions[] = self::bottom_diameter();
		$dimensions[] = self::wall_thickness();
		return implode(', ', array_filter($dimensions));
	}
}

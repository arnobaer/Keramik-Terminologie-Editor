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

/** Object production section.
*/
class SectionProduction extends AccordionSection
{
	// Used POST variable names.

	const ID_FORMING         = 'production_forming';
	const ID_PRIMARY_BURNING = 'production_primary_burning';

	const ID_COLOR_OUTSIDE_A    = 'production_color_outside_a';
	const ID_COLOR_OUTSIDE_B    = 'production_color_outside_b';
	const ID_COLOR_OUTSIDE_DIST = 'production_color_outside_dist';

	const ID_COLOR_FRACTURE_A    = 'production_color_fracture_a';
	const ID_COLOR_FRACTURE_B    = 'production_color_fracture_b';
	const ID_COLOR_FRACTURE_DIST = 'production_color_fracture_dist';

	const ID_COLOR_INSIDE_A    = 'production_color_inside_a';
	const ID_COLOR_INSIDE_B    = 'production_color_inside_b';
	const ID_COLOR_INSIDE_DIST = 'production_color_inside_dist';

	const ID_MARKS_SOFT      = 'production_marks_soft';
	const ID_MARKS_SEMIHARD  = 'production_marks_semihard';
	const ID_MARKS_BURNING   = 'production_marks_burning';
	const ID_SECONDARY_CHANGES = 'production_secondary_changes';

	// Used variable values to be compared somewhere.

	const VALUE_NOT_SPECIFIED = 0;

	public function __construct()
	{
		parent::__construct(
			'production',  // Element id
			"Herstellung", // Section title
			16             // Page number
		);
	}

	static public function forming()
	{
		return post(self::ID_FORMING);
	}

	static public function primary_burning()
	{
		return post(self::ID_PRIMARY_BURNING);
	}

	static public function color_outside_a()
	{
		return post(self::ID_COLOR_OUTSIDE_A);
	}

	static public function color_outside_b()
	{
		return post(self::ID_COLOR_OUTSIDE_B);
	}

	static public function color_outside_dist()
	{
		return post(self::ID_COLOR_OUTSIDE_DIST);
	}

	static public function color_fracture_a()
	{
		return post(self::ID_COLOR_FRACTURE_A);
	}

	static public function color_fracture_b()
	{
		return post(self::ID_COLOR_FRACTURE_B);
	}

	static public function color_fracture_dist()
	{
		return post(self::ID_COLOR_FRACTURE_DIST);
	}

	static public function color_inside_a()
	{
		return post(self::ID_COLOR_INSIDE_A);
	}

	static public function color_inside_b()
	{
		return post(self::ID_COLOR_INSIDE_B);
	}

	static public function color_inside_dist()
	{
		return post(self::ID_COLOR_INSIDE_DIST);
	}

	static public function marks_soft()
	{
		return post(self::ID_MARKS_SOFT);
	}

	static public function marks_semihard()
	{
		return post(self::ID_MARKS_SEMIHARD);
	}

	static public function marks_burning()
	{
		return post(self::ID_MARKS_BURNING);
	}

	static public function secondary_changes()
	{
		return post(self::ID_SECONDARY_CHANGES);
	}

	public function show_content()
	{
?>
		<table>
			<tr>
				<td colspan="2"><?php $this->fieldset_forming(); ?></td>
				<td><?php $this->fieldset_primary_burning(); ?></td>
				<td></td>
			</tr>
			<tr>
				<td style="width:33%"><?php $this->fieldset_color_outside(); ?></td>
				<td style="width:33%"><?php $this->fieldset_color_fracture(); ?></td>
				<td style="width:33%"><?php $this->fieldset_color_inside(); ?></td>
			</tr>
			<tr>
				<td colspan="3"><p style="margin-top:0;padding:top:0;" class="infobox"><strong>Hinweis:</strong> Farbangaben nach Oyama und Takehara 1996 (Munsell), RAL oder Farbnamen.</p></td>
			</tr>
			<tr>
				<td rowspan="2"><?php $this->fieldset_marks_soft(); ?></td>
				<td><?php $this->fieldset_marks_semihard(); ?></td>
				<td><?php $this->fieldset_marks_burning(); ?></td>
			</tr>
			<tr>
				<td colspan="2"><?php $this->fieldset_secondary_changes(); ?></td>
			</tr>
		</table>
<?php
	}

	/**
	 * @returns field set for production forming.
	 */
	public function fieldset_forming()
	{
		$forming = new ChoiceWidget(self::ID_FORMING);
		$forming->addChoice('frei geformt', 'frei/ohne Verwendung einer Drehilfe geformt');
		$forming->addChoice('drehend geformt', 'langsam gedreht/drehend geformt');
		$forming->addChoice('drehend hochgezogen', 'schnell gedreht/drehend hochgezogen');
		$forming->addChoice('mit Formhilfe geformt');

		$fieldset = new FieldsetWidget('production_forming', "Formgebung", $forming->getHtml());
		echo $fieldset->show();
	}

	/**
	 * @returns field set for production primary burning.
	 */
	public function fieldset_primary_burning()
	{
		$primary = new ChoiceWidget(self::ID_PRIMARY_BURNING, false);
		$primary->addChoice(self::VALUE_NOT_SPECIFIED, "keine Angabe");
		$primary->addChoice('oxidierend gebrannt', 'Oxidationsbrand (rot/braun/gelblich)');
		$primary->addChoice('reduzierend gebrannt', 'Reduktionsbrand (grau/schwarz)');
		$primary->addChoice('oxidierend mit Reduktionskern gebrannt', 'Oxidationsbrand mit Reduktionskern');
		$primary->addChoice('reduzierend mit Oxidationskern gebrannt', 'Reduktionsbrand mit Oxidationskern');
		$primary->addChoice('mischbrandig', 'Mischbrand');

		$fieldset = new FieldsetWidget('production_primary_burning', "Primärbrand", $primary->getHtml());
		echo $fieldset->show();
	}

	/**
	 * @returns field set for production color outside.
	 */
	public function fieldset_color_outside()
	{
		$color_a = str_clean_color(self::ID_COLOR_OUTSIDE_A, $color_a_valid, $color_a_is_munsell);
		$color_b = str_clean_color(self::ID_COLOR_OUTSIDE_B, $color_b_valid, $color_b_is_munsell);

		$colors  = 'Farbe <input style="'.($color_a_valid?'':'color:red;').'" type="text" name="'.self::ID_COLOR_OUTSIDE_A.'" value="'.$color_a.'">';
		$colors .= ' bis ';
		$colors .= '<input style="'.($color_b_valid?'':'color:red;').'" type="text" name="'.self::ID_COLOR_OUTSIDE_B.'" value="'.$color_b.'">';

		$dist = new ChoiceWidget(self::ID_COLOR_OUTSIDE_DIST);
		$dist->addChoice('gleichmäßig');
		$dist->addChoice('ungleichmäßig');
		$dist->addChoice('scharf begrenzte Farbzonen');
		$dist->addChoice('ineinander übergehende Farbzohnen');

		$fieldset = new FieldsetWidget('production_color_outside', "Oberfläche außen", $colors.$dist->getHtml());
		echo $fieldset->show();
	}

	/**
	 * @returns field set for production color fracture.
	 */
	public function fieldset_color_fracture()
	{
		$color_a = str_clean_color(self::ID_COLOR_FRACTURE_A, $color_a_valid, $color_a_is_munsell);
		$color_b = str_clean_color(self::ID_COLOR_FRACTURE_B, $color_b_valid, $color_b_is_munsell);

		$colors  = 'Farbe <input style="'.($color_a_valid?'':'color:red;').'" type="text" name="'.self::ID_COLOR_FRACTURE_A.'" value="'.$color_a.'">';
		$colors .= ' bis ';
		$colors .= '<input style="'.($color_b_valid?'':'color:red;').'" type="text" name="'.self::ID_COLOR_FRACTURE_B.'" value="'.$color_b.'">';

		$dist = new ChoiceWidget(self::ID_COLOR_FRACTURE_DIST);
		$dist->addChoice('gleichmäßig');
		$dist->addChoice('ungleichmäßig');
		$dist->addChoice('scharf begrenzte Farbzonen');
		$dist->addChoice('ineinander übergehende Farbzohnen');

		$fieldset = new FieldsetWidget('production_color_fracture', "Bruch", $colors.$dist->getHtml());
		echo $fieldset->show();
	}

	/**
	 * @returns field set for production color inside.
	 */
	public function fieldset_color_inside()
	{
		$color_a = str_clean_color(self::ID_COLOR_INSIDE_A, $color_a_valid, $color_a_is_munsell);
		$color_b = str_clean_color(self::ID_COLOR_INSIDE_B, $color_b_valid, $color_b_is_munsell);

		$colors  = 'Farbe <input style="'.($color_a_valid?'':'color:red;').'" type="text" name="'.self::ID_COLOR_INSIDE_A.'" value="'.$color_a.'">';
		$colors .= ' bis ';
		$colors .= '<input style="'.($color_b_valid?'':'color:red;').'" type="text" name="'.self::ID_COLOR_INSIDE_B.'" value="'.$color_b.'">';

		$dist = new ChoiceWidget(self::ID_COLOR_INSIDE_DIST);
		$dist->addChoice('gleichmäßig');
		$dist->addChoice('ungleichmäßig');
		$dist->addChoice('scharf begrenzte Farbzonen');
		$dist->addChoice('ineinander übergehende Farbzohnen');

		$fieldset = new FieldsetWidget('production_color_inside', "Oberfläche innen", $colors.$dist->getHtml());
		echo $fieldset->show();
	}

	/**
	 * @returns field set for production marks on soft clay.
	 */
	public function fieldset_marks_soft()
	{
		$marks = new MultiChoiceWidget(self::ID_MARKS_SOFT);
		$marks->addChoice('Abhebespur');
		$marks->addChoice('parallele Abschneidespuren', 'Abschneidespuren, paralell');
		$marks->addChoice('radiale Abschneidespuren', 'Abschneidespuren, radial');
		$marks->addChoice('Achsabdruck');
		$marks->addChoice('Bodenringfalte');
		$marks->addChoice('Drehrille');
		$marks->addChoice('Fingerabdruck');
		$marks->addChoice('Fingernagelabdruck');
		$marks->addChoice('Delle');
		$marks->addChoice('Formhilfenabdruck');
		$marks->addChoice('Formnaht');
		$marks->addChoice('Fügestelle', 'Naht-/Fügestelle');
		$marks->addChoice('Partikelkonzentration am Boden');
		$marks->addChoice('Quellrandboden');
		$marks->addChoice('Self-slip');
		$marks->addChoice('Verstreichspur');

		$fieldset = new FieldsetWidget('production_marks_soft', "Spuren am nicht ausgehärteten Ton", $marks->getHtml());
		echo $fieldset->show();
	}

	/**
	 * @returns field set for production marks on semi-hard clay.
	 */
	public function fieldset_marks_semihard()
	{
		$marks = new MultiChoiceWidget(self::ID_MARKS_SEMIHARD);
		$marks->addChoice('Abdrehspuren');
		$marks->addChoice('Angarnierungsdruckspur');
		$marks->addChoice('Nachdrehspuren');
		$marks->addChoice('Trochnungseinschnitt', 'Trochnungseinschnitt/-stich');

		$fieldset = new FieldsetWidget('production_marks_semihard', "Spuren am \"lederharten\" Ton", $marks->getHtml());
		echo $fieldset->show();
	}

	/**
	 * @returns field set for production marks at burning process.
	 */
	public function fieldset_marks_burning()
	{
		$marks = new MultiChoiceWidget(self::ID_MARKS_BURNING);
		$marks->addChoice('Brennhaut');
		$marks->addChoice('Brennhilfeabriss');
		$marks->addChoice('Brennriss');
		$marks->addChoice('Brennschatten');
		$marks->addChoice('Fehlbrand');
		$marks->addChoice('Glasurabriss');
		$marks->addChoice('metallischer Anflug', 'Metallischer Anflug');
		$marks->addChoice('Windflecken');

		$fieldset = new FieldsetWidget('production_marks_burning', "Brandbedingte Herstellungsspuren", $marks->getHtml());
		echo $fieldset->show();
	}

	/**
	 * @returns field set for production marks at burning process.
	 */
	public function fieldset_secondary_changes()
	{
		$secondary = new TextAreaWidget(self::ID_SECONDARY_CHANGES, "<br/>Veränderungen wie Lochungen die nich im Zusammenahng mit der Herstellung stehen.");

		$fieldset = new FieldsetWidget('production_secondary_changes', "Sekundäre Veränderungen (optional)", $secondary->getHtml());
		echo $fieldset->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		// Note: forming attribute is extracted separately.

		$marks = array();

		$soft = self::marks_soft();
		$semihard = self::marks_semihard();
		$burning = self::marks_burning();

		$marks[] = implode(', ', $soft ? $soft : array());
		$marks[] = implode(', ', $semihard ? $semihard : array());
		$marks[] = implode(', ', $burning ? $burning : array());

		return ucfirst(implode(', ', array_filter($marks)));
	}

	/** Returns short formal description. */
	static public function get_short_description()
	{
		return self::get_long_description();
	}

	static public function get_long_colors()
	{
		$color = array();

		$outside = str_colors(self::ID_COLOR_OUTSIDE_A, self::ID_COLOR_OUTSIDE_B);
		$dist1 = post(self::ID_COLOR_OUTSIDE_DIST);
		if ($outside and $dist1) $outside .= ", {$dist1}";
		if ($outside) $color[] = "Oberfläche außen: {$outside}";

		$fracture = str_colors(self::ID_COLOR_FRACTURE_A, self::ID_COLOR_FRACTURE_B);
		$dist2 = post(self::ID_COLOR_FRACTURE_DIST);
		if ($fracture and $dist2) $fracture .= ", {$dist2}";
		if ($fracture) $color[] = "Bruch: {$fracture}";

		$inside = str_colors(self::ID_COLOR_INSIDE_A, self::ID_COLOR_INSIDE_B);
		$dist3 = post(self::ID_COLOR_INSIDE_DIST);
		if ($inside and $dist3) $inside .= ", {$dist3}";
		if ($inside) $color[] = "Oberfläche innen: {$inside}";
		$color = implode('; ', $color);
		$paragraph = SectionCondition::is_complete_extent() ? 'Farbe' : 'Scherbenfarbe';
		return $color ? "<strong>{$paragraph}:</strong> {$color}.<br>".PHP_EOL : '';
	}

	static public function get_short_colors()
	{
		$color = array();
		$outside = str_clean_color(self::ID_COLOR_OUTSIDE_A, $foo, $bar);
		$outside2 = str_clean_color(self::ID_COLOR_OUTSIDE_B, $foo, $bar);
		if ($outside and $outside2) $outside .= " bis {$outside2}";
		if ($outside) $color[] = "außen: {$outside}";
		$fracture = str_clean_color(self::ID_COLOR_FRACTURE_A, $foo, $bar);
		$fracture2 = str_clean_color(self::ID_COLOR_FRACTURE_B, $foo, $bar);
		if ($fracture and $fracture2) $fracture .= " bis {$fracture2}";
		if ($fracture) $color[] = "Bruch: {$fracture}";
		$inside = str_clean_color(self::ID_COLOR_INSIDE_A, $foo, $bar);
		$inside2 = str_clean_color(self::ID_COLOR_INSIDE_B, $foo, $bar);
		if ($inside and $inside2) $inside .= " bis {$inside2}";
		if ($inside) $color[] = "innen: {$inside}";
		$color = implode(', ', $color);
		return $color ? "({$color})" : '';
	}
}

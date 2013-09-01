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

/*
		$farbe_aussen_value = $this->getCleanColor('farbe_aussen', $farbe_aussen_valid, $farbe_aussen_munsell);
		$farbe_aussen_value_2 = $this->getCleanColor('farbe_aussen_2', $farbe_aussen_valid_2, $farbe_aussen_munsell_2);
		$farbe_bruch_value = $this->getCleanColor('farbe_bruch', $farbe_bruch_valid, $farbe_bruch_munsell);
		$farbe_bruch_value_2 = $this->getCleanColor('farbe_bruch_2', $farbe_bruch_valid_2, $farbe_bruch_munsell_2);
		$farbe_innen_value = $this->getCleanColor('farbe_innen', $farbe_innen_valid, $farbe_innen_munsell);
		$farbe_innen_value_2 = $this->getCleanColor('farbe_innen_2', $farbe_innen_valid_2, $farbe_innen_munsell_2);

		$html .= '<div class="sixteen columns">'.PHP_EOL;
		$html .= '<h4>Brand: Farbe</h4>'.PHP_EOL;
		$html .= '<p>Farbangaben nach Oyama und Takehara 1996 (Munsell), RAL oder Farbnamen. <strong>Don\'t care!</strong> Experimentelle automatische Formatierung.</p>'.PHP_EOL;


		$html .= '<div class="five columns alpha"><h5>Oberfläche außen</h5><p>'.PHP_EOL;
		$html .= '<input style="'.($farbe_aussen_valid?'':'color:red;').'" type="text" name="farbe_aussen" value="'.$farbe_aussen_value.'">';
		$html .= 'bis';
		$html .= '<input style="'.($farbe_aussen_valid_2?'':'color:red;').'" type="text" name="farbe_aussen_2" value="'.$farbe_aussen_value_2.'">';
		$html .= '</p><h5>Farbverteilung</h5><p>';
		$input = new Choice('farbverteilung_aussen');
		$input->addChoice('gleichmäßig');
		$input->addChoice('ungleichmäßig');
		$input->addChoice('scharf begrenzte Farbzonen');
		$input->addChoice('ineinander übergehende Farbzohnen');
		$html .= $input->getHtml();
		$html .= '</p></div>'.PHP_EOL;


		$html .= '<div class="five columns alpha"><h5>Bruch</h5><p>'.PHP_EOL;
		$html .= '<input style="'.($farbe_bruch_valid?'':'color:red;').'" type="text" name="farbe_bruch" value="'.$farbe_bruch_value.'">';
		$html .= 'bis';
		$html .= '<input style="'.($farbe_bruch_valid_2?'':'color:red;').'" type="text" name="farbe_bruch_2" value="'.$farbe_bruch_value_2.'">';
		$html .= '</p><h5>Farbverteilung</h5><p>';
		$input = new Choice('farbverteilung_bruch');
		$input->addChoice('gleichmäßig');
		$input->addChoice('ungleichmäßig');
		$input->addChoice('scharf begrenzte Farbzonen');
		$input->addChoice('ineinander übergehende Farbzohnen');
		$html .= $input->getHtml();
		$html .= '</p></div>'.PHP_EOL;


		$html .= '<div class="six columns omega"><h5>Oberfläche innen</h5><p>'.PHP_EOL;
		$html .= '<input style="'.($farbe_innen_valid?'':'color:red;').'" type="text" name="farbe_innen" value="'.$farbe_innen_value.'">';
		$html .= 'bis';
		$html .= '<input style="'.($farbe_innen_valid_2?'':'color:red;').'" type="text" name="farbe_innen_2" value="'.$farbe_innen_value_2.'">';
		$html .= '</p><h5>Farbverteilung</h5><p>';
		$input = new Choice('farbverteilung_innen');
		$input->addChoice('gleichmäßig');
		$input->addChoice('ungleichmäßig');
		$input->addChoice('scharf begrenzte Farbzonen');
		$input->addChoice('ineinander übergehende Farbzohnen');
		$html .= $input->getHtml();
		$html .= '</p></div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL

		$html .= '</div>'.PHP_EOL;
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
				<td><?php $this->fieldset_forming(); ?></td>
				<td><?php $this->fieldset_primary_burning(); ?></td>
			</tr>
			<tr>
				<td><?php $this->fieldset_color_outside(); ?></td>
				<td><?php $this->fieldset_color_fracture(); ?></td>
				<td><?php $this->fieldset_color_inside(); ?></td>
			</tr>
			<tr>
				<td><?php $this->fieldset_marks_soft(); ?></td>
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
		$forming = new Choice(self::ID_FORMING, false);
		$forming->addChoice(self::VALUE_NOT_SPECIFIED, "keine Angabe");
		$forming->addChoice('frei geformt', 'frei/ohne Verwendung einer Drehilfe geformt');
		$forming->addChoice('drehend geformt', 'langsam gedreht/drehend geformt');
		$forming->addChoice('drehend hochgezogen', 'schnell gedreht/drehend hochgezogen');
		$forming->addChoice('mit Formhilfe geformt');

		$box = new Box('production_forming', "Formgebung", $forming->getHtml());
		echo $box->show();
	}

	/**
	 * @returns field set for production primary burning.
	 */
	public function fieldset_primary_burning()
	{
		$primary = new Choice(self::ID_PRIMARY_BURNING, false);
		$primary->addChoice(self::VALUE_NOT_SPECIFIED, "keine Angabe");
		$primary->addChoice('oxidierend gebrannt', 'Oxidationsbrand (rot/braun/gelblich)');
		$primary->addChoice('reduzierend gebrannt', 'Reduktionsbrand (grau/schwarz)');
		$primary->addChoice('oxidierend mit Reduktionskern gebrannt', 'Oxidationsbrand mit Reduktionskern');
		$primary->addChoice('reduzierend mit Oxidationskern gebrannt', 'Reduktionsbrand mit Oxidationskern');
		$primary->addChoice('mischbrandig', 'Mischbrand');

		$box = new Box('production_primary_burning', "Primärbrand", $primary->getHtml());
		echo $box->show();
	}

	/**
	 * @returns field set for production color outside.
	 */
	public function fieldset_color_outside()
	{
		$primary = new Choice(self::ID_PRIMARY_BURNING, false);

		$box = new Box('production_color_outside', "Oberfläche außen", $primary->getHtml());
		echo $box->show();
	}

	/**
	 * @returns field set for production color fracture.
	 */
	public function fieldset_color_fracture()
	{
		$primary = new Choice(self::ID_PRIMARY_BURNING, false);

		$box = new Box('production_color_fracture', "Bruch", $primary->getHtml());
		echo $box->show();
	}

	/**
	 * @returns field set for production color inside.
	 */
	public function fieldset_color_inside()
	{
		$primary = new Choice(self::ID_PRIMARY_BURNING, false);

		$box = new Box('production_color_inside', "Oberfläche innen", $primary->getHtml());
		echo $box->show();
	}

	/**
	 * @returns field set for production marks on soft clay.
	 */
	public function fieldset_marks_soft()
	{
		$marks = new MultiChoice(self::ID_MARKS_SOFT);
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

		$box = new Box('production_marks_soft', "Herstellungsspuren am nicht ausgehärteten Ton", $marks->getHtml());
		echo $box->show();
	}

	/**
	 * @returns field set for production marks on semi-hard clay.
	 */
	public function fieldset_marks_semihard()
	{
		$marks = new MultiChoice(self::ID_MARKS_SEMIHARD);
		$marks->addChoice('Abdrehspuren');
		$marks->addChoice('Angarnierungsdruckspur');
		$marks->addChoice('Nachdrehspuren');
		$marks->addChoice('Trochnungseinschnitt', 'Trochnungseinschnitt/-stich');

		$box = new Box('production_marks_semihard', "Herstellungsspuren am \"lederharten\" Ton", $marks->getHtml());
		echo $box->show();
	}

	/**
	 * @returns field set for production marks at burning process.
	 */
	public function fieldset_marks_burning()
	{
		$marks = new MultiChoice(self::ID_MARKS_BURNING);
		$marks->addChoice('Brennhaut');
		$marks->addChoice('Brennhilfeabriss');
		$marks->addChoice('Brennriss');
		$marks->addChoice('Brennschatten');
		$marks->addChoice('Fehlbrand');
		$marks->addChoice('Glasurabriss');
		$marks->addChoice('metallischer Anflug', 'Metallischer Anflug');
		$marks->addChoice('Windflecken');

		$box = new Box('production_marks_burning', "Brandbedingte Herstellungsspuren", $marks->getHtml());
		echo $box->show();
	}

	/**
	 * @returns field set for production marks at burning process.
	 */
	public function fieldset_secondary_changes()
	{
		$secondary = new TextArea(self::ID_SECONDARY_CHANGES, "<br/>Veränderungen wie Lochungen die nich im Zusammenahng mit der Herstellung stehen.");

		$box = new Box('production_secondary_changes', "Sekundäre Veränderungen (optional)", $secondary->getHtml());
		echo $box->show();
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
}

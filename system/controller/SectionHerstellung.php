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
class SectionHerstellung extends AccordionSectionWidget
{
	const IdFormgebung   = 'herstellung_formgebung';
	const IdPrimaerbrand = 'herstellung_primaerbrand';

	const IdFarbeAussen1 = 'herstellung_farbe_aussen_1';
	const IdFarbeAussen2 = 'herstellung_farbe_aussen_2';
	const IdFarbverteilungAussen = 'herstellung_farbverteilung_aussen';

	const IdFarbeBruch1 = 'herstellung_farbe_bruch_1';
	const IdFarbeBruch2 = 'herstellung_farbe_bruch_2';
	const IdFarbverteilungBruch = 'herstellung_farbverteilung_bruch';

	const IdFarbeInnen1 = 'herstellung_farbe_innen_1';
	const IdFarbeInnen2 = 'herstellung_farbe_innen_2';
	const IdFarbverteilungInnen = 'herstellung_farbverteilung_innen';

	const IdSpurenWeich        = 'herstellung_spuren_weich';
	const IdSpurenLederhart    = 'herstellung_spuren_lederhart';
	const IdSpurenBrandbedingt = 'herstellung_spuren_brandbedingt';

	const IdSekundaereVeraenderungen = 'herstellung_sekundaere_veraenderungen';

	// Used variable values to be compared somewhere.

	const VALUE_NOT_SPECIFIED = 0;

	public function __construct()
	{
		parent::__construct('herstellung', "Herstellung", 16);
	}

	static public function formgebung()
	{
		return post(self::IdFormgebung);
	}

	static public function primaerbrand()
	{
		return post(self::IdPrimaerbrand);
	}

	static public function farbeAussen1()
	{
		return post(self::IdFarbeAussen1);
	}

	static public function farbeAussen2()
	{
		return post(self::IdFarbeAussen2);
	}

	static public function farbverteilungAussen()
	{
		return post(self::IdFarbverteilungAussen);
	}

	static public function farbeBruch1()
	{
		return post(self::IdFarbeBruch1);
	}

	static public function farbeBruch2()
	{
		return post(self::IdFarbeBruch2);
	}

	static public function farbverteilungBruch()
	{
		return post(self::IdFarbverteilungBruch);
	}

	static public function farbeInnen1()
	{
		return post(self::IdFarbeInnen1);
	}

	static public function farbeInnen2()
	{
		return post(self::IdFarbeInnen2);
	}

	static public function farbverteilungInnen()
	{
		return post(self::IdFarbverteilungInnen);
	}

	static public function spurenWeich()
	{
		return post(self::IdSpurenWeich);
	}

	static public function spurenLederhart()
	{
		return post(self::IdSpurenLederhart);
	}

	static public function spurenBrandbedingt()
	{
		return post(self::IdSpurenBrandbedingt);
	}

	static public function sekundaereVeraenderungen()
	{
		return post(self::IdSekundaereVeraenderungen);
	}

	public function content()
	{
		$data = array(
			'formgebung' => $this->fieldsetFormgebung(),
			'primaerbrand' => $this->fieldsetPrimaerbrand(),
			'farbe_aussen' => $this->fieldsetFarbeAussen(),
			'farbe_innen' => $this->fieldsetFarbeInnen(),
			'farbe_bruch' => $this->fieldsetFarbeBruch(),
			'spuren_weich' => $this->fieldsetSpurenWeich(),
			'spuren_lederhart' => $this->fieldsetSpurenLederhart(),
			'spuren_brandbedingt' => $this->fieldsetSpurenBrandbedingt(),
			'sekundaere_veraenderungen' => $this->fieldsetSekundaereVeraenderungen(),
		);
		return $this->loadView('herstellung', $data, false);
	}

	/**
	 * @returns field set for production forming.
	 */
	public function fieldsetFormgebung()
	{
		$forming = new ChoiceWidget(self::IdFormgebung);
		$forming->addChoice('frei geformt', 'frei/ohne Verwendung einer Drehilfe geformt');
		$forming->addChoice('drehend geformt', 'langsam gedreht/drehend geformt');
		$forming->addChoice('drehend hochgezogen', 'schnell gedreht/drehend hochgezogen');
		$forming->addChoice('mit Formhilfe geformt');

		$fieldset = new FieldsetWidget('herstellung_formgebung', "Formgebung", $forming->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 * @returns field set for production primary burning.
	 */
	public function fieldsetPrimaerbrand()
	{
		$primary = new ChoiceWidget(self::IdPrimaerbrand, false);
		$primary->addChoice(self::VALUE_NOT_SPECIFIED, "keine Angabe");
		$primary->addChoice('oxidierend gebrannt', 'Oxidationsbrand (rot/braun/gelblich)');
		$primary->addChoice('reduzierend gebrannt', 'Reduktionsbrand (grau/schwarz)');
		$primary->addChoice('oxidierend mit Reduktionskern gebrannt', 'Oxidationsbrand mit Reduktionskern');
		$primary->addChoice('reduzierend mit Oxidationskern gebrannt', 'Reduktionsbrand mit Oxidationskern');
		$primary->addChoice('mischbrandig', 'Mischbrand');

		$fieldset = new FieldsetWidget('herstellung_primaerbrand', "Primärbrand", $primary->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 * @returns field set for production color outside.
	 */
	public function fieldsetFarbeAussen()
	{
		$color_a = str_clean_color(self::IdFarbeAussen1, $color_a_valid, $color_a_is_munsell);
		$color_b = str_clean_color(self::IdFarbeAussen2, $color_b_valid, $color_b_is_munsell);

		$colors  = 'Farbe <input style="'.($color_a_valid?'':'color:red;').'" type="text" name="'.self::IdFarbeAussen1.'" value="'.$color_a.'">';
		$colors .= ' bis ';
		$colors .= '<input style="'.($color_b_valid?'':'color:red;').'" type="text" name="'.self::IdFarbeAussen2.'" value="'.$color_b.'">';

		$dist = new ChoiceWidget(self::IdFarbverteilungAussen);
		$dist->addChoice('gleichmäßig');
		$dist->addChoice('ungleichmäßig');
		$dist->addChoice('scharf begrenzte Farbzonen');
		$dist->addChoice('ineinander übergeh. Farbzohnen');

		$fieldset = new FieldsetWidget('herstellung_farbe_aussen', "Oberfläche außen", $colors.$dist->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 * @returns field set for production color fracture.
	 */
	public function fieldsetFarbeBruch()
	{
		$color_a = str_clean_color(self::IdFarbeBruch1, $color_a_valid, $color_a_is_munsell);
		$color_b = str_clean_color(self::IdFarbeBruch2, $color_b_valid, $color_b_is_munsell);

		$colors  = 'Farbe <input style="'.($color_a_valid?'':'color:red;').'" type="text" name="'.self::IdFarbeBruch1.'" value="'.$color_a.'">';
		$colors .= ' bis ';
		$colors .= '<input style="'.($color_b_valid?'':'color:red;').'" type="text" name="'.self::IdFarbeBruch2.'" value="'.$color_b.'">';

		$dist = new ChoiceWidget(self::IdFarbverteilungBruch);
		$dist->addChoice('gleichmäßig');
		$dist->addChoice('ungleichmäßig');
		$dist->addChoice('scharf begrenzte Farbzonen');
		$dist->addChoice('ineinander übergeh. Farbzohnen');

		$fieldset = new FieldsetWidget('herstellung_farbe_bruch', "Bruch", $colors.$dist->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 * @returns field set for production color inside.
	 */
	public function fieldsetFarbeInnen()
	{
		$color_a = str_clean_color(self::IdFarbeInnen1, $color_a_valid, $color_a_is_munsell);
		$color_b = str_clean_color(self::IdFarbeInnen2, $color_b_valid, $color_b_is_munsell);

		$colors  = 'Farbe <input style="'.($color_a_valid?'':'color:red;').'" type="text" name="'.self::IdFarbeInnen1.'" value="'.$color_a.'">';
		$colors .= ' bis ';
		$colors .= '<input style="'.($color_b_valid?'':'color:red;').'" type="text" name="'.self::IdFarbeInnen2.'" value="'.$color_b.'">';

		$dist = new ChoiceWidget(self::IdFarbverteilungInnen);
		$dist->addChoice('gleichmäßig');
		$dist->addChoice('ungleichmäßig');
		$dist->addChoice('scharf begrenzte Farbzonen');
		$dist->addChoice('ineinander übergeh. Farbzohnen');

		$fieldset = new FieldsetWidget('herstellung_farbe_innen', "Oberfläche innen", $colors.$dist->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 * @returns field set for production marks on soft clay.
	 */
	public function fieldsetSpurenWeich()
	{
		$marks = new MultiChoiceWidget(self::IdSpurenWeich);
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

		$fieldset = new FieldsetWidget('herstellung_spuren_weich', "Spuren am nicht ausgehärteten Ton", $marks->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 * @returns field set for production marks on semi-hard clay.
	 */
	public function fieldsetSpurenLederhart()
	{
		$marks = new MultiChoiceWidget(self::IdSpurenLederhart);
		$marks->addChoice('Abdrehspuren');
		$marks->addChoice('Angarnierungsdruckspur');
		$marks->addChoice('Nachdrehspuren');
		$marks->addChoice('Trochnungseinschnitt', 'Trochnungseinschnitt/-stich');

		$fieldset = new FieldsetWidget('herstellung_spuren_lederhart', "Spuren am \"lederharten\" Ton", $marks->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 * @returns field set for production marks at burning process.
	 */
	public function fieldsetSpurenBrandbedingt()
	{
		$marks = new MultiChoiceWidget(self::IdSpurenBrandbedingt);
		$marks->addChoice('Brennhaut');
		$marks->addChoice('Brennhilfeabriss');
		$marks->addChoice('Brennriss');
		$marks->addChoice('Brennschatten');
		$marks->addChoice('Fehlbrand');
		$marks->addChoice('Glasurabriss');
		$marks->addChoice('metallischer Anflug', 'Metallischer Anflug');
		$marks->addChoice('Windflecken');

		$fieldset = new FieldsetWidget('herstellung_spuren_brandbedingt', "Brandbedingte Herstellungsspuren", $marks->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 * @returns field set for production marks at burning process.
	 */
	public function fieldsetSekundaereVeraenderungen()
	{
		$secondary = new TextAreaWidget(self::IdSekundaereVeraenderungen, "<br/>Veränderungen wie Lochungen die nich im Zusammenahng mit der Herstellung stehen.");

		$fieldset = new FieldsetWidget('herstellung_sekundaere_veraenderungen', "Sekundäre Veränderungen (optional)", $secondary->getHtml());
		return $fieldset->getHtml();
	}

	/** Returns long detailed description. */
	static public function longDescription()
	{
		// Note: forming attribute is extracted separately.

		$marks = array();

		$soft = self::spurenWeich();
		$semihard = self::spurenLederhart();
		$burning = self::spurenBrandbedingt();

		$marks[] = implode(', ', $soft ? $soft : array());
		$marks[] = implode(', ', $semihard ? $semihard : array());
		$marks[] = implode(', ', $burning ? $burning : array());

		return ucfirst(implode(', ', array_filter($marks)));
	}

	/** Returns short formal description. */
	static public function shortDescription()
	{
		return self::longDescription();
	}

	static public function longColorDescription()
	{
		$color = array();

		$outside = str_colors(self::IdFarbeAussen1, self::IdFarbeAussen2);
		$dist1 = post(self::IdFarbverteilungAussen);
		if ($outside and $dist1) $outside .= ", {$dist1}";
		if ($outside) $color[] = "Oberfläche außen: {$outside}";

		$fracture = str_colors(self::IdFarbeBruch1, self::IdFarbeBruch2);
		$dist2 = post(self::IdFarbverteilungBruch);
		if ($fracture and $dist2) $fracture .= ", {$dist2}";
		if ($fracture) $color[] = "Bruch: {$fracture}";

		$inside = str_colors(self::IdFarbeInnen1, self::IdFarbeInnen2);
		$dist3 = post(self::IdFarbverteilungInnen);
		if ($inside and $dist3) $inside .= ", {$dist3}";
		if ($inside) $color[] = "Oberfläche innen: {$inside}";
		$color = implode('; ', $color);
		$paragraph = SectionErhaltungszustand::isVollstaendigErhalten() ? 'Farbe' : 'Scherbenfarbe';
		return $color ? "<strong>{$paragraph}:</strong> {$color}.<br>".PHP_EOL : '';
	}

	static public function shortColorDescription()
	{
		$color = array();
		$outside = str_clean_color(self::IdFarbeAussen1, $foo, $bar);
		$outside2 = str_clean_color(self::IdFarbeAussen2, $foo, $bar);
		if ($outside and $outside2) $outside .= " bis {$outside2}";
		if ($outside) $color[] = "außen: {$outside}";
		$fracture = str_clean_color(self::IdFarbeBruch1, $foo, $bar);
		$fracture2 = str_clean_color(self::IdFarbeBruch2, $foo, $bar);
		if ($fracture and $fracture2) $fracture .= " bis {$fracture2}";
		if ($fracture) $color[] = "Bruch: {$fracture}";
		$inside = str_clean_color(self::IdFarbeInnen1, $foo, $bar);
		$inside2 = str_clean_color(self::IdFarbeInnen2, $foo, $bar);
		if ($inside and $inside2) $inside .= " bis {$inside2}";
		if ($inside) $color[] = "innen: {$inside}";
		$color = implode(', ', $color);
		return $color ? "({$color})" : '';
	}
}

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
 * Beschreibt den Bruch.
 */
class SectionFracture extends AccordionSection
{
	// Used POST variable names.

	const KEY_FRACTURE_HAPTIC = 'KEY_FRACTURE_HAPTIC';
	const KEY_FRACTURE_OPTIC  = 'KEY_FRACTURE_OPTIC';
	const KEY_FRACTURE_PORES  = 'KEY_FRACTURE_PORES';

	// Used variable values to be compared somewhere.

	const VAL_NOT_SPECIFIED = 0;

	const VAL_PLAIN = "glatt";
	const VAL_GRAINY = "körnig";

	const VAL_FISSURED   = "geklüftet";
	const VAL_LAYERED    = "geschichtet";
	const VAL_CONCHOIDAL = "muschelig";

	const VAL_LONGISH  = "länglich";
	const VAL_ROUNDISH = "rundlich";


	/** Constructor. */
	public function __construct()
	{
		parent::__construct(
			'fracture',         // Element id
			"Bruch", // Section title
			15                 // Page number
		);
	}

	/** Print all subsections. */
	public function show_content()
	{
		$this->show_fracture_haptic();
		$this->show_fracture_optic();
		$this->show_fracture_pores();
	}

	/** */
	protected function show_fracture_haptic()
	{
		$input = new Choice(self::KEY_FRACTURE_HAPTIC, false);
		$input->addChoice(self::VAL_NOT_SPECIFIED, "keine Angabe");
		$input->addChoice(self::VAL_PLAIN, 'glatt (haptisch)');
		$input->addChoice(self::VAL_GRAINY, 'körnig (haptisch)');

		$box = new Box('fracture_haptic', "Bruchstruktur (haptisch)", $input->getHtml());
		$box->floatLeft();
		echo $box->show();
	}

	/** */
	protected function show_fracture_optic()
	{
		$input = new Choice(self::KEY_FRACTURE_OPTIC, false);
		$input->addChoice(self::VAL_NOT_SPECIFIED, "keine Angabe");
		$input->addChoice(self::VAL_FISSURED, 'geklüftet (optisch)');
		$input->addChoice(self::VAL_LAYERED, 'geschichtet/splittrig (optisch)');
		$input->addChoice(self::VAL_CONCHOIDAL, 'muschelig (optisch)');

		$box = new Box('fracture_haptic', "Bruchstruktur (optisch)", $input->getHtml());
		$box->floatLeft();
		echo $box->show();
	}

	/** */
	protected function show_fracture_pores()
	{
		$input = new Choice(self::KEY_FRACTURE_PORES, false);
		$input->addChoice(self::VAL_NOT_SPECIFIED, "keine Angabe");
		$input->addChoice(self::VAL_LONGISH);
		$input->addChoice(self::VAL_ROUNDISH);

		$box = new Box('fracture_haptic_optic', "Porenform", $input->getHtml() .
			"<p class=\"infobox\" style=\"width:400px;\"><strong>Hinweis:</strong> Form der Poren in der Matrix, nicht der ausgefallenen Partikel. Nur am Dünnschliff erkennbar.</p>");
		$box->floatLeft();
		echo $box->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		$result = array();

		$haptic = post(self::KEY_FRACTURE_HAPTIC);
		$optic = post(self::KEY_FRACTURE_OPTIC);
		$pores = post(self::KEY_FRACTURE_PORES);

		if ($haptic) $result[] = $haptic;
		if ($optic) $result[] = $optic;
		if ($pores) $result[] = $pores . "e Porenform";

		return ucfirst(implode(', ', $result));
	}

	/** Returns short formal description. */
	static public function get_short_description() {
		return '';
	}
}

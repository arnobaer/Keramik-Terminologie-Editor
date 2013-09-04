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

class SectionBruch extends AccordionSectionWidget
{
	// Used POST variable names.

	const IdHaptisch = 'bruch_haptisch';
	const IdOptisch  = 'bruch_optisch';
	const IdPoren    = 'bruch_poren';

	const ValueGlatt   = "glatt";
	const ValueKoernig = "körnig";

	const ValueGeklueftet  = "geklüftet";
	const ValueGeschichtet = "geschichtet";
	const ValueMuschelig   = "muschelig";

	const ValueLaenglich = "länglich";
	const ValueRundlich  = "rundlich";


	/** Constructor. */
	public function __construct()
	{
		parent::__construct('bruch', "Bruch", 15);
	}

	static public function haptisch()
	{
		return post(self::IdHaptisch);
	}

	static public function optisch()
	{
		return post(self::IdOptisch);
	}

	static public function poren()
	{
		return post(self::IdPoren);
	}

	/** Print all subsections. */
	public function content()
	{
		$data = array(
			'haptisch' => $this->fieldsetHaptisch(),
			'optisch' => $this->fieldsetOptisch(),
			'poren' => $this->fieldsetPoren(),
		);
		return $this->loadView('bruch', $data, false);
	}

	/** */
	protected function fieldsetHaptisch()
	{
		$input = new ChoiceWidget(self::IdHaptisch);
		$input->addChoice(self::ValueGlatt, 'glatt (haptisch)');
		$input->addChoice(self::ValueKoernig, 'körnig (haptisch)');

		$fieldset = new FieldsetWidget('fracture_haptic', "Bruchstruktur (haptisch)", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** */
	protected function fieldsetOptisch()
	{
		$input = new ChoiceWidget(self::IdOptisch);
		$input->addChoice(self::ValueGeklueftet, 'geklüftet (optisch)');
		$input->addChoice(self::ValueGeschichtet, 'geschichtet/splittrig (optisch)');
		$input->addChoice(self::ValueMuschelig, 'muschelig (optisch)');

		$fieldset = new FieldsetWidget('fracture_haptic', "Bruchstruktur (optisch)", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** */
	protected function fieldsetPoren()
	{
		$input = new ChoiceWidget(self::IdPoren);
		$input->addChoice(self::ValueLaenglich);
		$input->addChoice(self::ValueRundlich);

		$fieldset = new FieldsetWidget('fracture_haptic_optic', "Porenform", $input->getHtml() .
			"<p class=\"infobox\" style=\"\"><strong>Hinweis:</strong> Form der Poren in der Matrix, nicht der ausgefallenen Partikel. Nur am Dünnschliff erkennbar.</p>");
		return $fieldset->getHtml();
	}

	/** Returns long detailed description. */
	static public function longDescription()
	{
		$result = array();

		$haptic = self::haptisch();
		$optic = self::optisch();
		$pores = self::poren();

		$result[] = $haptic;
		$result[] = $optic;
		if ($pores) $result[] = $pores . "e Porenform";

		return ucfirst(implode(', ', array_filter($result)));
	}

	/** Returns short formal description. */
	static public function shortDescription() {
		return '';
	}
}

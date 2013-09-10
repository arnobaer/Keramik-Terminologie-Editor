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

class SectionRandbereich extends AccordionSectionWidget
{
	const IdMuendung           = 'randbereich_muendung';
	const IdFormalbeschreibung = 'randbereich_formalbeschreibung';
	const IdHerstellung        = 'randbereich_herstellung';
	const IdRandform           = 'randbereich_randform';
	const IdRandkontur         = 'randbereich_randkontur';

	/** Constructor. */
	public function __construct()
	{
		parent::__construct('randbereich', "Randbereich", 27);
	}

	public function muendung()
	{
		return post(self::IdMuendung);
	}

	public function formalbeschreibung()
	{
		return post(self::IdFormalbeschreibung);
	}

	public function herstellung()
	{
		return post(self::IdHerstellung);
	}

	public function randform()
	{
		return post(self::IdRandform);
	}

	public function randkontur()
	{
		return post(self::IdRandkontur);
	}

	/** Print all subsections. */
	public function content()
	{
		$data = array(
			'muendung' => $this->fieldsetMuendung(),
			'formalbeschreibung' => $this->fieldsetFormalbeschreibung(),
			'herstellung' => $this->fieldsetHerstellung(),
			'randform' => $this->fieldsetRandform(),
			'randkontur' => $this->fieldsetRandrandkontur(),
		);
		return $this->loadView('randbereich', $data, false);
	}

	/** */
	protected function fieldsetMuendung()
	{
		$input = new LineEditWidget(self::IdMuendung, " z. B. runde, kleeblattförmige, vierpassförmige, viereckige, dreieckige.", false);

		$fieldset = new FieldsetWidget('randbereich_muendung', "Mündung", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** */
	protected function fieldsetFormalbeschreibung()
	{
		$input = new ChoiceWidget(self::IdFormalbeschreibung);
		$input->addChoice('gerundet');
		$input->addChoice('gekehlt');
		$input->addChoice('flach');
		$input->addChoice('spitz');
		$input->addChoice('gerillt');
		$input->addChoice('gekantet');

		$fieldset = new FieldsetWidget('randbereich_form', 'Formalbeschreibung', $input->getHtml());
		return $fieldset->getHtml();
	}

	/** */
	protected function fieldsetHerstellung()
	{
		$input = new ChoiceWidget(self::IdHerstellung);
		$input->addChoice('abgeschnitten');
		$input->addChoice('zugeschnitten');
		$input->addChoice('beschnitten', 'beschnitten (Draht, Schnur, Messer)');
		$input->addChoice('abgestrichen', 'abgestrichen (Finger, Schwamm, Holzstück)');
		$input->addChoice('gerillt');
		$input->addChoice('gekantet');

		$fieldset = new FieldsetWidget('randbereich_herstellung', "Herstellungstechnische Beschreibung", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** */
	protected function fieldsetRandform()
	{
		$input = new ChoiceWidget(self::IdRandform);
		$input->addChoice('nicht verstärkter Rand');
		$input->addChoice('aufgestellter Rand');
		$input->addChoice('verstärkter Rand');
		$input->addChoice('Keulenrand');
		$input->addChoice('Wulstrand');
		$input->addChoice('Leistenrand');
		$input->addChoice('Kragenrand');
		$input->addChoice('Kremprand');
		$input->addChoice('Rollrand');
		$input->addChoice('Sichelrand');

		$fieldset = new FieldsetWidget('randbereich_randform', "Randform", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** */
	protected function fieldsetRandrandkontur()
	{
		$input = new ChoiceWidget(self::IdRandkontur);
		$input->addChoice('vertikaler Rand');
		$input->addChoice('ausladender Rand');
		$input->addChoice('steil ausladender Rand');
		$input->addChoice('flach ausladender Rand');
		$input->addChoice('einziehender Rand');
		$input->addChoice('steil einziehender Rand');
		$input->addChoice('flach einziehender Rand');
		$input->addChoice('umgebogener Rand');
		$input->addChoice('umgeklappter Rand');
		$input->addChoice('untergriffiger Rand');
		$input->addChoice('unterschnittener Rand');
		$input->addChoice('eingerollter Rand');
		$input->addChoice('profilierter Rand');
		$input->addChoice('Fahne');

		$fieldset = new FieldsetWidget('randbereich_randkontur', "Randkontur", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** Returns long detailed description. */
	static public function longDescription()
	{
		$randbereich = array();

		$muendung = self::muendung();
		$muendung = str_replace('Mündung', '', $muendung);
		$muendung = str_replace('mündung', '', $muendung);
		$muendung = trim($muendung);
		// Every fitting attribute in German will end with an e, so add if is missing.
		if ($muendung and substr($muendung, -1) != 'e') $muendung .= 'e';

		$randform = self::randform();
		$kontur = self::randkontur();
		$herstellung = self::herstellung();
		$randformal = self::formalbeschreibung();

		if ($kontur == 'Fahne') { $randform = 'Fahne'; $kontur = ''; } // Superior.
		if ($randformal) $randbereich[] = "{$randformal}er";
		if ($herstellung) $randbereich[] = "{$herstellung}er";
		if ($randform and $kontur) $kontur = str_replace(' Rand', '', $kontur);
		if ($kontur) $randbereich[] = $kontur;
		if ($randform) $randbereich[] = $randform;

		if ((!$randform and !$kontur) and ($herstellung or $randformal))
			$randbereich[sizeof($randbereich)-1] .= " Rand";

		if ($muendung) $randbereich[] = $muendung . ' Mündung';

		return implode(', ', $randbereich);
	}

	/** Returns short formal description. */
	static public function shortDescription() {
		return '';
	}
}

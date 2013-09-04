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

/** Object funktionselemente section.
*/
class SectionFunktionselemente extends AccordionSectionWidget
{
	// Used POST variable names.

	const IdStandvorrichtung = 'funktionselemente_standvorrichtung';
	const IdHandhaben        = 'funktionselemente_handhaben';
	const IdHandhabenHenkel  = 'funktionselemente_handhaben_henkel';

	// Used variable values to be compared somewhere.

	const VAL_NOT_SPECIFIED = 0;

	public function __construct()
	{
		parent::__construct('funktionselemente', "Funktionselemente", 35);
	}

	static public function standvorrichtung()
	{
		return post(self::IdStandvorrichtung);
	}

	static public function handhaben()
	{
		return post(self::IdHandhaben);
	}

	static public function handhabenHenkel()
	{
		return post(self::IdHandhabenHenkel);
	}

	public function content()
	{
		$data = array(
			'standvorrichtung' => $this->fieldsetStandvorrichtung(),
			'handhaben' => $this->fieldsetHandhaben(),
			'henkel' => $this->fieldsetHandhabenHenkel(),
		);
		return $this->loadView('funktionselemente', $data, false);
	}

	/** Specify foot type. */
	public function fieldsetStandvorrichtung()
	{
		$input = new ChoiceWidget(self::IdStandvorrichtung);
		$input->addChoice("Hohlfuß");
		$input->addChoice("Massivfuß");
		$input->addChoice("zapfenförmiger Massivfuß");
		$input->addChoice("tierfußförmiger Massivfuß");
		$input->addChoice("zylindrischer Massivfuß", "zylindrischer/amorpher Massivfuß");
		$input->addChoice("Standring");

		$fieldset = new FieldsetWidget('funktionselemente_standvorrichtung', "Standvorrichtung", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** Specify handling zone type. */
	public function fieldsetHandhaben()
	{
		$input = new MultiChoiceWidget(self::IdHandhaben);
		$input->addChoice("Grifflappen");
		$input->addChoice("Knauf");
		$input->addChoice("Knubbe");
		$input->addChoice("Rohrgriff");
		$input->addChoice("Stielgriff");

		$fieldset = new FieldsetWidget('funktionselemente_handhaben', "Handhaben", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** Specify handle type. */
	public function fieldsetHandhabenHenkel()
	{
		$input = new MultiChoiceWidget(self::IdHandhabenHenkel);
		$input->addChoice('Bandhenkel');
		$input->addChoice('Wulsthenkel');

		$fieldset = new FieldsetWidget('funktionselemente_handhaben_henkel', "Handhaben/Henkel", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** Returns long detailed description. */
	static public function longDescription()
	{
		$list = array();

		$list[] = self::standvorrichtung();
		$handhaben = self::handhaben();

		if (is_array($handhaben) and sizeof($handhaben)) $list[] = implode(', ', $handhaben);
		$handhaben_henkel = self::handhabenHenkel();

		if (is_array($handhaben_henkel) and sizeof($handhaben_henkel)) $list[] = implode(', ', $handhaben_henkel);
		$list = array_filter($list);

		return ucfirst(implode('; ', $list));
	}

	/** Returns short formal description. */
	static public function shortDescription()
	{
		return '';
	}
}

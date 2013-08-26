<?php defined('KeramikGuardian') or die();

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

/** Object condition section.

POST variables:

	wandbereich_hals     - type of vessel neck.
	wandbereich_schulter - type of vessel shoulder.
	wandbereich_bauch    - type of vessel bulge.
	wandbereich_fuss     - type of vessel foot.
*/
class Funktionselemente extends AccordionSection
{
	public function __construct()
	{
		parent::__construct('funktionselemente', "Funktionselemente", 35);
	}

	public function show_content()
	{
		$this->show_standvorrichtungen();
		$this->show_handhaben();
		$this->show_handhaben_henkel();
	}

	/** Specify foot type. */
	public function show_standvorrichtungen()
	{
		$input = new Choice('standvorrichtungen', false);
		$input->addChoice(0, "keine Angabe");
		$input->addChoice("Hohlfuß");
		$input->addChoice("Massivfuß");
		$input->addChoice("zapfenförmiger Massivfuß");
		$input->addChoice("tierfußförmiger Massivfuß");
		$input->addChoice("zylindrischer Massivfuß", "zylindrischer/amorpher Massivfuß");
		$input->addChoice("Standring");

		$box = new Box('standvorrichtungen', "Standvorrichtungen", $input->getHtml());
		$box->floatLeft();
		echo $box->show();
	}

	/** Specify handling zone type. */
	public function show_handhaben()
	{
		$input = new MultiChoice('handhaben');
		$input->addChoice("Grifflappen");
		$input->addChoice("Knauf");
		$input->addChoice("Knubbe");
		$input->addChoice("Rohrgriff");
		$input->addChoice("Stielgriff");

		$box = new Box('handhaben', "Handhaben", $input->getHtml());
		$box->floatLeft();
		echo $box->show();
	}

	/** Specify handle type. */
	public function show_handhaben_henkel()
	{
		$input = new MultiChoice('handhaben_henkel');
		$input->addChoice('Bandhenkel');
		$input->addChoice('Wulsthenkel');

		$box = new Box('handhaben_henkel', "Handhaben/Henkel", $input->getHtml());
		$box->floatLeft();
		echo $box->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		$list = array();

		$list[] = self::getPost('wandbereich_fuss');
		$list[] = self::getPost('wandbereich_bauch');
		$list[] = self::getPost('wandbereich_schulter');
		$list[] = self::getPost('wandbereich_hals');

		$list = array_filter($list);

		return implode("; ", $list);
	}
}

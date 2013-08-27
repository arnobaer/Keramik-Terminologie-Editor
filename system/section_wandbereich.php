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

/** Object condition section.

POST variables:

	wandbereich_hals     - type of vessel neck.
	wandbereich_schulter - type of vessel shoulder.
	wandbereich_bauch    - type of vessel bulge.
	wandbereich_fuss     - type of vessel foot.
*/
class Wandbereich extends AccordionSection
{
	public function __construct()
	{
		parent::__construct('wandbereich', "Wandbereich", 31);
	}

	public function show_content()
	{
		$this->show_hals();
		$this->show_schulter();
		$this->show_bauch();
		$this->show_fuss();
	}

	/** Specify the vessel neck type. */
	public function show_hals()
	{
		$input = new Choice('wandbereich_hals', false);
		$input->addChoice(0, "keine Angabe");
		$input->addChoice("stark einziehender Hals");
		$input->addChoice("schwach einziehender Hals");
		$input->addChoice("zylindrischer Hals");
		$input->addChoice("konischer Hals");

		$box = new Box('hals', "Hals/Halszone", $input->getHtml());
		$box->floatLeft();
		echo $box->show();
	}

	/** Specify the vessel shoulder type. */
	public function show_schulter()
	{
		$input = new Choice('wandbereich_schulter', false);
		$input->addChoice(0, "keine Angabe");
		$input->addChoice("flach ansteigende Schulter");
		$input->addChoice("steil ansteigende Schulter");

		$box = new Box('schulter', "Schulter/Schulterzone", $input->getHtml());
		$box->floatLeft();
		echo $box->show();
	}

	/** Specify the vessel bulge type. */
	public function show_bauch()
	{
		$input = new Choice('wandbereich_bauch', false);
		$input->addChoice(0, "keine Angabe");
		$input->addChoice("zylindrischer Bauch");
		$input->addChoice("ellipsoider Bauch");
		$input->addChoice("kugeliger Bauch");
		$input->addChoice("konischer Bauch");
		$input->addChoice("quaderförmiger Bauch");

		$box = new Box('bauch', "Bauch/Bauchzone", $input->getHtml());
		$box->floatLeft();
		echo $box->show();
	}

	/** Specify the vessel foot type. */
	public function show_fuss()
	{
		$input = new Choice('wandbereich_fuss');
		$input->addChoice("einziehender Fuß");
		$input->addChoice("ausladende Fußzone");
		$input->addChoice("zylindrische Fußzone");

		$box = new Box('fuss', "Fuß/Fußzone", $input->getHtml());
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

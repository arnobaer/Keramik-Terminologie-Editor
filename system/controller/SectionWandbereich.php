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

class SectionWandbereich extends AccordionSectionWidget
{
	const IdHalszone     = 'wandbereich_halszone';
	const IdSchulterzone = 'wandbereich_schulterzone';
	const IdBauchzone    = 'wandbereich_bauchzone';
	const IdFusszone     = 'wandbereich_fusszone';

	public function __construct()
	{
		parent::__construct('wandbereich', "Wandbereich", 31);
	}

	static public function halszone()
	{
		return post(self::IdHalszone);
	}

	static public function schulterzone()
	{
		return post(self::IdSchulterzone);
	}

	static public function bauchzone()
	{
		return post(self::IdBauchzone);
	}

	static public function fusszone()
	{
		return post(self::IdFusszone);
	}

	public function content()
	{
		$data = array(
			'halszone' => $this->fieldsetHalszone(),
			'schulterzone' => $this->fieldsetSchulterzone(),
			'bauchzone' => $this->fieldsetBauchzone(),
			'fusszone' => $this->fieldsetFusszone(),
		);
		return $this->loadView('wandbereich', $data, false);
	}

	/** Specify the vessel neck type. */
	public function fieldsetHalszone()
	{
		$input = new ChoiceWidget(self::IdHalszone);
		$input->addChoice("stark einziehender Hals");
		$input->addChoice("schwach einziehender Hals");
		$input->addChoice("zylindrischer Hals");
		$input->addChoice("konischer Hals");

		$fieldset = new FieldsetWidget('hals', "Hals/Halszone", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** Specify the vessel shoulder type. */
	public function fieldsetSchulterzone()
	{
		$input = new ChoiceWidget(self::IdSchulterzone);
		$input->addChoice("flach ansteigende Schulter");
		$input->addChoice("steil ansteigende Schulter");

		$fieldset = new FieldsetWidget('schulter', "Schulter/Schulterzone", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** Specify the vessel bulge type. */
	public function fieldsetBauchzone()
	{
		$input = new ChoiceWidget(self::IdBauchzone);
		$input->addChoice("zylindrischer Bauch");
		$input->addChoice("ellipsoider Bauch");
		$input->addChoice("kugeliger Bauch");
		$input->addChoice("konischer Bauch");
		$input->addChoice("quaderförmiger Bauch");

		$fieldset = new FieldsetWidget('bauch', "Bauch/Bauchzone", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** Specify the vessel foot type. */
	public function fieldsetFusszone()
	{
		$input = new ChoiceWidget(self::IdFusszone);
		$input->addChoice("einziehender Fuß");
		$input->addChoice("ausladende Fußzone");
		$input->addChoice("zylindrische Fußzone");

		$fieldset = new FieldsetWidget('fuss', "Fuß/Fußzone", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** Returns long detailed description. */
	static public function longDescription()
	{
		$list = array();

		$list[] = self::fusszone();
		$list[] = self::bauchzone();
		$list[] = self::schulterzone();
		$list[] = self::halszone();

		return implode("; ", array_filter($list));
	}

	/** Returns short formal description. */
	static public function shortDescription()
	{
		return '';
	}
}

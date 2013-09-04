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

class SectionGrundlagen extends AccordionSectionWidget
{
	const IdKeramikgattung = 'grundlagen_keramikgattung';

	const ValueIrdenware = 'Irdenware';
	const ValueFayence   = 'Fayence';
	const ValueSteingut  = 'Steingut';
	const ValueSteinzeug = 'Steinzeug';
	const ValuePorzellan = 'Porzellan';

	public function __construct()
	{
		parent::__construct('grundlagen', "Grundlagen", 10);
	}

	/** @returns returns a string containing the ceramic category.
	 */
	static public function keramikgattung()
	{
		return post(self::IdKeramikgattung);
	}

	/** @returns returns true if the ceramic category is earthenware.
	 */
	static public function isIrdenware()
	{
		return self::keramikgattung() == self::ValueIrdenware;
	}

	public function content()
	{
		$data = array(
			'keramikgattung' => $this->fieldsetKeramikgattung(),
		);
		return $this->loadView('grundlagen', $data, false);
	}

	public function fieldsetKeramikgattung()
	{
		$choice = new ChoiceWidget(self::IdKeramikgattung, false);
		$choice->addChoice(self::ValueIrdenware, false, true);
		$choice->addChoice(self::ValueFayence);
		$choice->addChoice(self::ValueSteingut);
		$choice->addChoice(self::ValueSteinzeug);
		$choice->addChoice(self::ValuePorzellan);

		$fieldset = new FieldsetWidget('grundlagen_keramikgattung', "Keramikgattung", $choice->getHtml());
		return $fieldset->getHtml();
	}

	/** Returns long detailed description. */
	static public function longDescription()
	{
		return '';
	}

	/** Returns short formal description. */
	static public function shortDescription()
	{
		return '';
	}
}

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

class SectionGrundlagen extends AccordionSection
{
	const Title = "Grundlagen";
	const PageNumber = 12;

	const IdKeramikgattung = 'grundlagen_keramikgattung';

	const ValueIrdenware = 'Irdenware';
	const ValueFayence   = 'Fayence';
	const ValueSteingut  = 'Steingut';
	const ValueSteinzeug = 'Steinzeug';
	const ValuePorzellan = 'Porzellan';

	public function __construct()
	{
		parent::__construct('grundlagen', self::Title, self::PageNumber);
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

	public function show_content()
	{
?>
		<table style="width:auto;">
			<tr>
				<td><?php $this->show_keramikgattung(); ?></td>
			</tr>
		</table>
<?php
	}

	public function show_keramikgattung()
	{
		$input = new ChoiceWidget(self::IdKeramikgattung, false);
		$input->addChoice(self::ValueIrdenware, false, true);
		$input->addChoice(self::ValueFayence);
		$input->addChoice(self::ValueSteingut);
		$input->addChoice(self::ValueSteinzeug);
		$input->addChoice(self::ValuePorzellan);

		$fieldset = new FieldsetWidget('grundlagen_keramikgattung', "Keramikgattung", $input->getHtml());
		echo $fieldset->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		return '';
	}

	/** Returns short formal description. */
	static public function get_short_description()
	{
		return '';
	}
}

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

/** Object functionals section.
*/
class SectionFunctionals extends AccordionSection
{
	// Used POST variable names.

	const KEY_FOOT    = 'key_functionals_foot';
	const KEY_HANDLES = 'key_functionals_handles';
	const KEY_BAIL    = 'key_functionals_bail';

	// Used variable values to be compared somewhere.

	const VAL_NOT_SPECIFIED = 0;

	public function __construct()
	{
		parent::__construct(
			'functionals',       // Element id
			"Funktionselemente", // Section title
			35                   // Page number
		);
	}

	public function show_content()
	{
?>
		<table>
			<tr>
				<td><?php $this->show_standvorrichtungen(); ?></td>
				<td><?php $this->show_handhaben(); ?></td>
				<td><?php $this->show_handhaben_henkel(); ?></td>
			</tr>
		</table>
<?php
	}

	/** Specify foot type. */
	public function show_standvorrichtungen()
	{
		$input = new ChoiceWidget(self::KEY_FOOT);
		$input->addChoice("Hohlfuß");
		$input->addChoice("Massivfuß");
		$input->addChoice("zapfenförmiger Massivfuß");
		$input->addChoice("tierfußförmiger Massivfuß");
		$input->addChoice("zylindrischer Massivfuß", "zylindrischer/amorpher Massivfuß");
		$input->addChoice("Standring");

		$fieldset = new FieldsetWidget('functionals_foot', "Standvorrichtungen", $input->getHtml());
		echo $fieldset->show();
	}

	/** Specify handling zone type. */
	public function show_handhaben()
	{
		$input = new MultiChoiceWidget(self::KEY_HANDLES);
		$input->addChoice("Grifflappen");
		$input->addChoice("Knauf");
		$input->addChoice("Knubbe");
		$input->addChoice("Rohrgriff");
		$input->addChoice("Stielgriff");

		$fieldset = new FieldsetWidget('functionals_handles', "Handhaben", $input->getHtml());
		echo $fieldset->show();
	}

	/** Specify handle type. */
	public function show_handhaben_henkel()
	{
		$input = new MultiChoiceWidget(self::KEY_BAIL);
		$input->addChoice('Bandhenkel');
		$input->addChoice('Wulsthenkel');

		$fieldset = new FieldsetWidget('functionals_bail', "Handhaben/Henkel", $input->getHtml());
		echo $fieldset->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		$list = array();

		$list[] = post(self::KEY_FOOT);
		$handhaben = post(self::KEY_HANDLES);

		if (is_array($handhaben) and sizeof($handhaben)) $list[] = implode(', ', $handhaben);
		$handhaben_henkel = post(self::KEY_BAIL);

		if (is_array($handhaben_henkel) and sizeof($handhaben_henkel)) $list[] = implode(', ', $handhaben_henkel);
		$list = array_filter($list);

		return ucfirst(implode('; ', $list));
	}

	/** Returns short formal description. */
	static public function get_short_description()
	{
		return '';
	}
}

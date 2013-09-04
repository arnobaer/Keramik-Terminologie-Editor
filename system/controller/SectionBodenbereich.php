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
*/
class SectionBodenbereich extends AccordionSectionWidget
{
	const IdBoden    = 'bodenbereich_boden';

	public function __construct()
	{
		parent::__construct('bodenbereich', "Bodenbereich", 34);
	}

	public function content()
	{
		$data = array(
			'boden' => $this->fieldsetBoden(),
		);
		return $this->loadView('bodenbereich', $data, false);
	}

	/** Specify the vessel bottom type. */
	public function fieldsetBoden()
	{
		$input = new ChoiceWidget(self::IdBoden);
		$input->addChoice("Flachboden");
		$input->addChoice("minimal nach oben gewölbter Flachboden", "Flachboden, min. n. oben gewölbt");
		$input->addChoice("Konvexboden");
		$input->addChoice("Konkavboden");
		$input->addChoice("aus der Masse gedrehter Standring");

		$fieldset = new FieldsetWidget('bottom', "Bodenformen", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** Returns long detailed description. */
	static public function longDescription()
	{
		$list = array();

		$list[] = post(self::IdBoden);

		$list = array_filter($list);

		return implode(", ", $list);
	}

	/** Returns short formal description. */
	static public function shortDescription()
	{
		return '';
	}
}

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

/**
 * Beschreibt Gebrauchsspuren.
 */
class SectionGebrauchsspuren extends AccordionSectionWidget
{
	const IdGebrauchsspuren = 'gebrauchsspuren_gebrauchsspuren';

	/** Constructor. */
	public function __construct()
	{
		parent::__construct('gebrauchsspuren', "Gebrauchsspuren", 52);
	}

	static public function gebrauchsspuren()
	{
		return post(self::IdGebrauchsspuren);
	}

	/** Print all subsections. */
	public function content()
	{
		$data = array(
			'gebrauchsspuren' => $this->fieldsetGebrauchsspuren(),
		);
		return $this->loadView('gebrauchsspuren', $data, false);
	}

	/** Specify the degree of use-wear. */
	protected function fieldsetGebrauchsspuren()
	{
		$input = new TextAreaWidget(self::IdGebrauchsspuren, "<br/>Beschreibung der Gebrauchsspuren (Abreibespuren, Schmauchspuren, Reparaturen, etc.)");

		$fieldset = new FieldsetWidget('gebrauchsspuren_gebrauchsspuren', "Gebrauchsspuren (optional)", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** Returns long detailed description. */
	static public function longDescription() {
		$result = ucfirst(self::gebrauchsspuren());

		// Could be done better. remove separation characters.
		$result = trim($result);
		foreach (array(',', '.', ';') as $key) {
			$result = trim($result, $key);
		}

		return ucfirst(rtrim($result, '.'));
	}

	/** Returns short formal description. */
	static public function shortDescription() {
		return '';
	}
}

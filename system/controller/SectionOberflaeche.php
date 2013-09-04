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

class SectionOberflaeche extends AccordionSectionWidget
{
	const IdStruktur          = 'oberflaeche_struktur';
	const IdStrukturAnmerkung = 'oberflaeche_anmerkung';
	const IdScherbenhaerte    = 'oberflaeche_scherbenhaerte';

	public function __construct()
	{
		parent::__construct('oberflaeche', "Oberfläche", 15);
	}

	static public function struktur()
	{
		return post(self::IdStruktur);
	}

	static public function strukturAnmerkung()
	{
		return post(self::IdStrukturAnmerkung);
	}

	static public function scherbenhaerte()
	{
		return post(self::IdScherbenhaerte);
	}

	public function content()
	{
		$data = array(
			'struktur' => $this->fieldsetStruktur(),
			'scherbenhaerte' => $this->fieldsetScherbenhaerte(),
			'anmerkung' => $this->fieldsetStrukturAnmerkung(),
		);
		return $this->loadView('oberflaeche', $data, false);
	}

	/**
	 * @returns field set for surface texture.
	 */
	public function fieldsetStruktur()
	{
		$texture = new MultiChoiceWidget(self::IdStruktur);
		$texture->addChoice('glatt', 'glatt (haptisch)');
		$texture->addChoice('körnig', 'körnig (haptisch)');
		$texture->addChoice('kreidig', 'kreidig (haptisch)');
		$texture->addChoice('rau', 'rau (haptisch)');
		$texture->addChoice('seifig', 'seifig (haptisch)');
		$texture->addChoice('blasig', 'blasig (haptisch, optisch)');
		$texture->addChoice('löchrig', 'löchrig (optisch)');
		$texture->addChoice('rissig', 'rissig/schrundig (optisch)');

		$annotation = new LineEditWidget(self::IdStrukturAnmerkung, "Anmerkung (optional)");

		$fieldset = new FieldsetWidget('surface_texture', "Oberflächenstruktur", $texture->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 * @returns field set for surface texture annotation.
	 */
	public function fieldsetStrukturAnmerkung()
	{
		$annotation = new LineEditWidget(self::IdStrukturAnmerkung, "Anmerkung  zur Oberflächenstruktur (optional)");

		$fieldset = new FieldsetWidget('surface_texture_annotation', "Anmerkung (optional)", $annotation->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 * @returns field set for surface shard hardness.
	 */
	public function fieldsetScherbenhaerte()
	{
		$hardness = new ChoiceWidget(self::IdScherbenhaerte);
		$hardness->addChoice('weich');
		$hardness->addChoice('hart');
		$hardness->addChoice('sehr hart');
		$hardness->addChoice('klingend hart');

		$fieldset = new FieldsetWidget('surface_hardness', "Scherbenhärte", $hardness->getHtml());
		return $fieldset->getHtml();
	}

	/** Returns long detailed description. */
	static public function longDescription()
	{
		$surface = array();

		$texture = self::struktur();

		$surface[] = implode(', ', $texture ? $texture : array());
		$surface[] = self::strukturAnmerkung();

		$surface = implode(', ', array_filter($surface));

		// Note: hardness is extracted separately on different position.

		return ucfirst($surface);
	}

	/** Returns short formal description. */
	static public function shortDescription()
	{
		$hardness = self::scherbenhaerte();
		return lcfirst(($hardness ? "{$hardness} " : '') . "gebrannt");
	}
}

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

/** Object surface section.
*/
class SectionSurface extends AccordionSection
{
	const Title = "Oberfläche";
	const PageNumber = 15;

	// Used POST variable names.

	const IdStruktur          = 'oberflaeche_struktur';
	const IdStrukturAnmerkung = 'oberflaeche_anmerkung';
	const IdScherbenhaerte    = 'oberflaeche_scherbenhaerte';

	// Used variable values to be compared somewhere.

	const VALUE_NOT_SPECIFIED = 0;

	public function __construct()
	{
		parent::__construct('oberflaeche', self::Title, self::PageNumber);
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

	public function show_content()
	{
?>
		<table>
			<tr>
				<td><?php $this->fieldset_texture(); ?></td>
				<td><?php $this->fieldset_scherbenhaerte(); ?></td>
			</tr>
			<tr>
				<td><?php $this->fieldset_texture_annotation(); ?></td>
			</tr>
		</table>
<?php
	}

	/**
	 * @returns field set for surface texture.
	 */
	public function fieldset_texture()
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

		$annotation = new TextInputWidget(self::IdStrukturAnmerkung, "Anmerkung (optional)");

		$fieldset = new FieldsetWidget('surface_texture', "Oberflächenstruktur", $texture->getHtml());
		echo $fieldset->show();
	}

	/**
	 * @returns field set for surface texture annotation.
	 */
	public function fieldset_texture_annotation()
	{
		$annotation = new TextInputWidget(self::IdStrukturAnmerkung, "Anmerkung  zur Oberflächenstruktur (optional)");

		$fieldset = new FieldsetWidget('surface_texture_annotation', "Anmerkung (optional)", $annotation->getHtml());
		echo $fieldset->show();
	}

	/**
	 * @returns field set for surface shard hardness.
	 */
	public function fieldset_scherbenhaerte()
	{
		$hardness = new ChoiceWidget(self::IdScherbenhaerte);
		$hardness->addChoice('weich');
		$hardness->addChoice('hart');
		$hardness->addChoice('sehr hart');
		$hardness->addChoice('klingend hart');

		$fieldset = new FieldsetWidget('surface_hardness', "Scherbenhärte", $hardness->getHtml());
		echo $fieldset->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
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
	static public function get_short_description()
	{
		$hardness = self::scherbenhaerte();
		return lcfirst(($hardness ? "{$hardness} " : '') . "gebrannt");
	}
}

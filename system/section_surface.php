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
	// Used POST variable names.

	const ID_TEXTURE            = 'surface_texture';
	const ID_TEXTURE_ANNOTATION = 'surface_annotation';
	const ID_HARDNESS           = 'surface_hardness';

	// Used variable values to be compared somewhere.

	const VALUE_NOT_SPECIFIED = 0;

	public function __construct()
	{
		parent::__construct(
			'surface',    // Element id
			"Oberfläche", // Section title
			15            // Page number
		);
	}

	static public function texture()
	{
		return post(self::ID_TEXTURE);
	}

	static public function texture_annotation()
	{
		return post(self::ID_TEXTURE_ANNOTATION);
	}

	static public function hardness()
	{
		return post(self::ID_HARDNESS);
	}

	public function show_content()
	{
?>
		<table>
			<tr>
				<td><?php $this->fieldset_texture(); ?></td>
				<td><?php $this->fieldset_hardness(); ?></td>
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
		$texture = new MultiChoice(self::ID_TEXTURE, false);
		$texture->addChoice(self::VALUE_NOT_SPECIFIED, 'glatt (haptisch)');
		$texture->addChoice('glatt', 'glatt (haptisch)');
		$texture->addChoice('körnig', 'körnig (haptisch)');
		$texture->addChoice('kreidig', 'kreidig (haptisch)');
		$texture->addChoice('rau', 'rau (haptisch)');
		$texture->addChoice('seifig', 'seifig (haptisch)');
		$texture->addChoice('blasig', 'blasig (haptisch, optisch)');
		$texture->addChoice('löchrig', 'löchrig (optisch)');
		$texture->addChoice('rissig', 'rissig/schrundig (optisch)');

		$annotation = new TextInput(self::ID_TEXTURE_ANNOTATION, "Anmerkung (optional)");

		$box = new Box('surface_texture', "Oberflächenstruktur", $texture->getHtml());
		echo $box->show();
	}

	/**
	 * @returns field set for surface texture annotation.
	 */
	public function fieldset_texture_annotation()
	{
		$annotation = new TextInput(self::ID_TEXTURE_ANNOTATION, "Anmerkung  zur Oberflächenstruktur (optional)");

		$box = new Box('surface_texture_annotation', "Anmerkung (optional)", $annotation->getHtml());
		echo $box->show();
	}

	/**
	 * @returns field set for surface shard hardness.
	 */
	public function fieldset_hardness()
	{
		$hardness = new Choice(self::ID_HARDNESS);
		$hardness->addChoice('weich');
		$hardness->addChoice('hart');
		$hardness->addChoice('sehr hart');
		$hardness->addChoice('klingend hart');

		$box = new Box('surface_hardness', "Scherbenhärte", $hardness->getHtml());
		echo $box->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		$surface = array();

		$texture = self::texture();

		$surface[] = implode(', ', $texture ? $texture : array());
		$surface[] = self::texture_annotation();

		$surface = implode(', ', array_filter($surface));

		// Note: hardness is extracted separately on different position.

		return ucfirst($surface);
	}

	/** Returns short formal description. */
	static public function get_short_description()
	{
		return lcfirst(self::hardness()." gebrannt");
	}
}

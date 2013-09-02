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
class SectionUsewear extends AccordionSection
{
	// Used POST variable names.

	const USEWEAR   = 'usewear_usewear';

	/** Constructor. */
	public function __construct()
	{
		parent::__construct(
			'usewear',         // Element id
			"Gebrauchsspuren", // Section title
			52                 // Page number
		);
	}

	/** Print all subsections. */
	public function show_content()
	{
?>
		<table>
			<tr>
				<td><?php $this->show_usewear(); ?></td>
			</tr>
		</table>
<?php
	}

	/** Specify the degree of use-wear. */
	protected function show_usewear()
	{
		$input = new TextAreaWidget(self::USEWEAR, '<br/>Beschreibung der Gebrauchsspuren (Abreibespuren, Schmauchspuren, Reparaturen, etc.)');

		$fieldset = new FieldsetWidget('useware2', "Gebrauchsspuren (optional)", $input->getHtml());
		echo $fieldset->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description() {
		$result = ucfirst(post(SectionUsewear::USEWEAR));

		// Could be done better.
		$result = trim($result);
		foreach (array(',', '.', ';') as $key) {
			$result = trim($result, $key);
		}

		return ucfirst(rtrim($result, '.'));
	}

	/** Returns short formal description. */
	static public function get_short_description() {
		return '';
	}
}

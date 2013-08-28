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
 * Beschreibt den Randbereich.
 */
class SectionBorder extends AccordionSection
{
	// Used POST variable names.

	const KEY_BORDER_SPOUT = 'KEY_BORDER_SPOUT';
	const KEY_BORDER_FORMAL = 'KEY_BORDER_FORMAL';
	const KEY_BORDER_ASSEMBLY = 'KEY_BORDER_ASSEMBLY';
	const KEY_BORDER_SHAPE = 'KEY_BORDER_SHAPE';
	const KEY_BORDER_CONTOUR = 'KEY_BORDER_CONTOUR';

	// Used variable values to be compared somewhere.

	const VAL_NOT_SPECIFIED = 0;


	/** Constructor. */
	public function __construct()
	{
		parent::__construct(
			'borderarea',  // Element id
			"Randbereich", // Section title
			27             // Page number
		);
	}

	/** Print all subsections. */
	public function show_content()
	{
?>
		<table>
			<tr>
				<td colspan="2"><?php $this->show_border_spout(); ?></td>
			</tr>
			<tr>
				<td><?php $this->show_border_formal(); ?></td>
				<td><?php $this->show_border_assembly(); ?></td>
			</tr>
			<tr>
				<td><?php $this->show_border_shape(); ?></td>
				<td><?php $this->show_border_contour(); ?></td>
			</tr>
		</table>
<?php
	}

	/** */
	protected function show_border_spout()
	{
		$input = new TextInput(self::KEY_BORDER_SPOUT, " z. B. runde, kleeblattförmige, vierpassförmige, viereckige, dreieckige.", false);

		$box = new Box('border_spout', "Mündung", $input->getHtml());
		echo $box->show();
	}

	/** */
	protected function show_border_formal()
	{
		$input = new Choice(self::KEY_BORDER_FORMAL);
		$input->addChoice('gerundet');
		$input->addChoice('gekehlt');
		$input->addChoice('flach');
		$input->addChoice('spitz');
		$input->addChoice('gerillt');
		$input->addChoice('gekantet');

		$box = new Box('border_form', 'Formalbeschreibung', $input->getHtml());
		echo $box->show();
	}

	/** */
	protected function show_border_assembly()
	{
		$input = new Choice(self::KEY_BORDER_ASSEMBLY);
		$input->addChoice('abgeschnitten');
		$input->addChoice('zugeschnitten');
		$input->addChoice('beschnitten', 'beschnitten (Draht, Schnur, Messer)');
		$input->addChoice('abgestrichen', 'abgestrichen (Finger, Schwamm, Holzstück)');
		$input->addChoice('gerillt');
		$input->addChoice('gekantet');

		$box = new Box('border_assembly', "Herstellungstechnische Beschreibung", $input->getHtml());
		echo $box->show();
	}

	/** */
	protected function show_border_shape()
	{
		$input = new Choice(self::KEY_BORDER_SHAPE);
		$input->addChoice('nicht verstärkter Rand');
		$input->addChoice('aufgestellter Rand');
		$input->addChoice('verstärkter Rand');
		$input->addChoice('Keulenrand');
		$input->addChoice('Wulstrand');
		$input->addChoice('Leistenrand');
		$input->addChoice('Kragenrand');
		$input->addChoice('Kremprand');
		$input->addChoice('Rollrand');
		$input->addChoice('Sichelrand');

		$box = new Box('border_shape', "Randform", $input->getHtml());
		echo $box->show();
	}

	/** */
	protected function show_border_contour()
	{
		$input = new Choice(self::KEY_BORDER_CONTOUR);
		$input->addChoice('vertikaler Rand');
		$input->addChoice('ausladender Rand');
		$input->addChoice('steil ausladender Rand');
		$input->addChoice('flach ausladender Rand');
		$input->addChoice('einziehender Rand');
		$input->addChoice('steil einziehender Rand');
		$input->addChoice('flach einziehender Rand');
		$input->addChoice('umgebogener Rand');
		$input->addChoice('umgeklappter Rand');
		$input->addChoice('untergriffiger Rand');
		$input->addChoice('unterschnittener Rand');
		$input->addChoice('eingerollter Rand');
		$input->addChoice('profilierter Rand');
		$input->addChoice('Fahne');

		$box = new Box('border_contour', "Randkontur", $input->getHtml());
		echo $box->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		$border = array();

		$spout = post(self::KEY_BORDER_SPOUT);
		$spout = str_replace('Mündung', '', $spout);
		$spout = str_replace('mündung', '', $spout);
		$spout = trim($spout);

		$shape = post(self::KEY_BORDER_SHAPE);
		$contour = post(self::KEY_BORDER_CONTOUR);
		$assembly = post(self::KEY_BORDER_ASSEMBLY);
		$shapeal = post(self::KEY_BORDER_FORMAL);

		if ($contour == 'Fahne') { $shape = 'Fahne'; $contour = ''; } // Superior.
		if ($shapeal) $border[] = "{$shapeal}er";
		if ($assembly) $border[] = "{$assembly}er";
		if ($shape and $contour) $contour = str_replace(' Rand', '', $contour);
		if ($contour) $border[] = $contour;
		if ($shape) $border[] = $shape;
		if ($spout) $border[] = $spout . ' Mündung';

		return implode(', ', $border);
	}

	/** Returns short formal description. */
	static public function get_short_description() {
		return '';
	}
}

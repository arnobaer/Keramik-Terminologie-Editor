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

	const ID_SPOUT    = 'border_spout';
	const ID_FORMAL   = 'border_formal';
	const ID_ASSEMBLY = 'border_assembly';
	const ID_SHAPE    = 'border_shape';
	const ID_CONTOUR  = 'border_contour';

	// Used variable values to be compared somewhere.

	const VALUE_NOT_SPECIFIED = 0;


	/** Constructor. */
	public function __construct()
	{
		parent::__construct(
			'borderarea',  // Element id
			"Randbereich", // Section title
			27             // Page number
		);
	}

	public function spout()
	{
		return post(self::ID_SPOUT);
	}

	public function formal()
	{
		return post(self::ID_FORMAL);
	}

	public function assembly()
	{
		return post(self::ID_ASSEMBLY);
	}

	public function shape()
	{
		return post(self::ID_SHAPE);
	}

	public function contour()
	{
		return post(self::ID_CONTOUR);
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
		$input = new TextInputWidget(self::ID_SPOUT, " z. B. runde, kleeblattförmige, vierpassförmige, viereckige, dreieckige.", false);

		$fieldset = new FieldsetWidget('border_spout', "Mündung", $input->getHtml());
		echo $fieldset->show();
	}

	/** */
	protected function show_border_formal()
	{
		$input = new ChoiceWidget(self::ID_FORMAL);
		$input->addChoice('gerundet');
		$input->addChoice('gekehlt');
		$input->addChoice('flach');
		$input->addChoice('spitz');
		$input->addChoice('gerillt');
		$input->addChoice('gekantet');

		$fieldset = new FieldsetWidget('border_form', 'Formalbeschreibung', $input->getHtml());
		echo $fieldset->show();
	}

	/** */
	protected function show_border_assembly()
	{
		$input = new ChoiceWidget(self::ID_ASSEMBLY);
		$input->addChoice('abgeschnitten');
		$input->addChoice('zugeschnitten');
		$input->addChoice('beschnitten', 'beschnitten (Draht, Schnur, Messer)');
		$input->addChoice('abgestrichen', 'abgestrichen (Finger, Schwamm, Holzstück)');
		$input->addChoice('gerillt');
		$input->addChoice('gekantet');

		$fieldset = new FieldsetWidget('border_assembly', "Herstellungstechnische Beschreibung", $input->getHtml());
		echo $fieldset->show();
	}

	/** */
	protected function show_border_shape()
	{
		$input = new ChoiceWidget(self::ID_SHAPE);
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

		$fieldset = new FieldsetWidget('border_shape', "Randform", $input->getHtml());
		echo $fieldset->show();
	}

	/** */
	protected function show_border_contour()
	{
		$input = new ChoiceWidget(self::ID_CONTOUR);
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

		$fieldset = new FieldsetWidget('border_contour', "Randkontur", $input->getHtml());
		echo $fieldset->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		$border = array();

		$spout = self::spout();
		$spout = str_replace('Mündung', '', $spout);
		$spout = str_replace('mündung', '', $spout);
		$spout = trim($spout);

		$shape = self::shape();
		$contour = self::contour();
		$assembly = self::assembly();
		$shapeal = self::formal();

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

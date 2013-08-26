<?php defined('KeramikGuardian') or die();

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

POST variables:

	erhaltung_fragmentierung   - type of fragmentation.
	erhaltung_anzahl_fragmente - count of fragments.
	erhaltung_restauration     - type of restorations (array).
		geklebt                  - true if glued.
		rekonstruiert          - true if reconstructed.
*/
class Erhaltung extends AccordionSection
{
	public function __construct()
	{
		parent::__construct('erhaltung', "Erhaltungszustand");
	}

	public function show_content()
	{
		$this->show_fragmentierung();
		$this->show_anzahl_fragmente();
		$this->show_restauration();
	}

	/** Specify the degree of possible fragmentation. */
	public function show_fragmentierung()
	{
		$input = new Choice('erhaltung_fragmentierung', false);
		$input->addChoice(0, "keine Angabe", false, false, "condition_image('not_specified')");
		$input->addChoice("vollständig erh.", "vollständig erhalten", false, false, "condition_image('complete_extent')");
		$input->addChoice("Fragment", "allg. Fragment(e)", false, false, "condition_image('general_fragments')");
		$input->addChoice("Randfragment", false, false, false, "condition_image('rim')");
		$input->addChoice("Rand-/Wandfragment", false, false, false, "condition_image('rim_wall')");
		$input->addChoice("Wandfragment", false, false, false, "condition_image('wall')");
		$input->addChoice("Wand-/Bodenfragment", false, false, false, "condition_image('wall_bottom')");
		$input->addChoice("Bodenfragment", false, false, false, "condition_image('bottom')");

		// Temp. translation.
		$image = array(
			0 => 'not_specified',
			'vollständig erh.' => 'complete_extent',
			'Fragment' => 'general_fragments',
			'Randfragment' => 'rim',
			'Rand-/Wandfragment' => 'rim_wall',
			'Wandfragment' => 'wall',
			'Wand-/Bodenfragment' => 'wall_bottom',
			'Bodenfragment' => 'bottom',
		);

		$content = '<div style="float:left; margin-right: 50px;">'.$input->getHtml().'</div>';
		$content .= '<div><img id="condition_figure" src="images/condition_'.$image[self::getPost('erhaltung_fragmentierung')].'.png"></div>';
		$content .= '<div style="clear:left;"></div>';

		$box = new Box('fragmentierung', "Fragmentierung", $content);
		echo $box->show();
	}

	/** Count of fragments. This parameter is optional. */
	public function show_anzahl_fragmente()
	{

		$input = new TextInput('erhaltung_anzahl_fragmente', "Stück", false, 3);

		$box = new Box('anzahl_fragmente', "Anzahl der Fragmente (optional)", $input->getHtml());
		echo $box->show();
	}

	/** Was the object restored? For example where the parts glued together? */
	public function show_restauration()
	{
		$input = new MultiChoice('erhaltung_restauration');
		$input->addChoice('geklebt', "geklebt (z. B. <em>Archäocoll 2000</em> oder <em>Paraloid&trade; B 72</em>)");
		$input->addChoice('rekonstruiert', "rekonstruiert (z. B. <em>Alabastergips</em>)");

		$box = new Box('restauration', "Restauration", $input->getHtml());
		echo $box->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description() {
		$fragmentierung = self::getPost('erhaltung_fragmentierung');
		$anzahl_fragmente = intval(self::getPost('erhaltung_anzahl_fragmente'));

		// Get restoration conditions of object.
		$restauration = self::getPost('erhaltung_restauration');

		// True if object was glued.
		$geklebt = array_key_exists('geklebt', $restauration ? $restauration : array());

		// True if object was reconstructed.
		$rekonstruiert = array_key_exists('rekonstruiert', $restauration ? $restauration : array());

		// Construct the object condition statement.
		$html = (($fragmentierung == "vollständig erh.") ? '' : $fragmentierung);

		// First create a list of additional attributes in braces.
		$args = array();
		// Hahaha grammar havoc!! xD
		if ($anzahl_fragmente > 1) $args[] = "$anzahl_fragmente Fragmente";
		if ($geklebt) $args[] = "geklebt";
		if ($rekonstruiert) $args[] = "rekonstruiert";

		// Next prepend the major attributes.
		$args = implode(', ', $args);
		if ($args) $args = "({$args})";
		if ($html and $args) $html .= ' '.$args;
		if ($fragmentierung == "Fragment" and $anzahl_fragmente > 1) $html = trim($args, '()');
		if ($html) $html = ucfirst($html);
		if ($geklebt and $html == '') $html = "geklebt";
		if ($html) $html = '; '.$html;
		return $html;
	}

	/** Returns short formal description. */
	static public function get_short_description() {
		$fragmentierung = self::getPost('erhaltung_fragmentierung');
		$anzahl_fragmente = intval(self::getPost('erhaltung_anzahl_fragmente'));
		$html = $fragmentierung;
		if ($fragmentierung == "Fragment" and $anzahl_fragmente > 1) $html = "mehrere Fragmente";
		if ($html) $html = ', '.$html;
		return $html;
	}
}

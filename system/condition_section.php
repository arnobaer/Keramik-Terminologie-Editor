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

	condition_fragmentation   - type of fragmentation.
	condition_fragments_count - count of fragments.
	condition_restoration     - type of restorations (array).
		glued                 - true if glued.
		reconstructed         - true if reconstructed.
*/
class ConditionSection extends AccordionSection
{
	public function __construct()
	{
		parent::__construct('condition', "Erhaltungszustand");
	}

	public function show_content()
	{
		$this->show_fragmentation();
		$this->show_fragments_count();
		$this->show_restoration();
	}

	/** Specify the degree of possible fragmentation. */
	public function show_fragmentation()
	{
		$input = new Choice('condition_fragmentation', false);
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
		$content .= '<div><img id="condition_figure" src="images/condition_'.$image[self::getPost('condition_fragmentation')].'.png"></div>';
		$content .= '<div style="clear:left;"></div>';

		$box = new Box('fragmentation', "Fragmentierung", $content);
		echo $box->show();
	}

	/** Count of fragments. This parameter is optional. */
	public function show_fragments_count()
	{

		$input = new TextInput('condition_fragments_count', "Stück", false, 3);

		$box = new Box('fragments_count', "Anzahl der Fragmente (optional)", $input->getHtml());
		echo $box->show();
	}

	/** Was the object restored? For example where the parts glued together? */
	public function show_restoration()
	{
		$input = new MultiChoice('condition_restoration');
		$input->addChoice('glued', "geklebt (z. B. <em>Archäocoll 2000</em> oder <em>Paraloid&trade; B 72</em>)");
		$input->addChoice('reconstructed', "rekonstruiert (z. B. <em>Alabastergips</em>)");

		$box = new Box('restoration', "Restauration", $input->getHtml());
		echo $box->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description() {
		$fragmentation = self::getPost('condition_fragmentation');
		$fragments_count = intval(self::getPost('condition_fragments_count'));

		// Get restoration conditions of object.
		$restoration = self::getPost('condition_restoration');

		// True if object was glued.
		$glued = array_key_exists('glued', $restoration ? $restoration : array());

		// True if object was reconstructed.
		$reconstructed = array_key_exists('reconstructed', $restoration ? $restoration : array());

		// Construct the object condition statement.
		$html = (($fragmentation == "vollständig erh.") ? '' : $fragmentation);

		// First create a list of additional attributes in braces.
		$args = array();
		// Hahaha grammar havoc!! xD
		if ($fragments_count > 1) $args[] = "$fragments_count Fragmente";
		if ($glued) $args[] = "geklebt";
		if ($reconstructed) $args[] = "rekonstruiert";

		// Next prepend the major attributes.
		$args = implode(', ', $args);
		if ($args) $args = "({$args})";
		if ($html and $args) $html .= ' '.$args;
		if ($fragmentation == "Fragment" and $fragments_count > 1) $html = trim($args, '()');
		if ($html) $html = ucfirst($html);
		if ($glued and $html == '') $html = "geklebt";
		if ($html) $html = '; '.$html;
		return $html;
	}

	/** Returns short formal description. */
	static public function get_short_description() {
		$fragmentation = self::getPost('condition_fragmentation');
		$fragments_count = intval(self::getPost('condition_fragments_count'));
		$html = $fragmentation;
		if ($fragmentation == "Fragment" and $fragments_count > 1) $html = "mehrere Fragmente";
		if ($html) $html = ', '.$html;
		return $html;
	}
}

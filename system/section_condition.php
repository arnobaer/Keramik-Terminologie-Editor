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
 * Beschreibt den Erhaltungszustand des Keramikfundes.
 */
class SectionCondition extends AccordionSection
{
	// Used POST variable names.

	const KEY_FRAGMENTATION   = 'KEY_CONDITION_FRAGMENTATION';
	const KEY_FRAGMENTS_COUNT = 'KEY_CONDITION_FRAGMENTS_COUNT';
	const KEY_RESTORATION     = 'KEY_CONDITION_RESTORATION';

	// Used variable values to be compared somewhere.

	const VAL_NOT_SPECIFIED = 0;

	const VAL_COMPLETE_EXTENT     = "vollständig erh.";
	const VAL_GENERAL_FRAGMENTS   = "Fragment";
	const VAL_RIM_FRAGMENT        = "Randfragment";
	const VAL_RIM_WALL_FRAGMENT   = "Rand-/Wandfragment";
	const VAL_WALL_FRAGMENT       = "Wandfragment";
	const VAL_ALL_BOTTOM_FRAGMENT = "Wand-/Bodenfragment";
	const VAL_BOTTOM_FRAGMENT     = "Bodenfragment";

	const VAL_FRAGMENTS_COUNT = "anzahl_fragmente";

	const VAL_RESTORATION_GLUED         = "geklebt";
	const VAL_RESTORATION_RECONSTRUCTED = "rekonstruiert";

	/** Constructor. */
	public function __construct()
	{
		parent::__construct(
			'condition',         // Element id
			"Erhaltungszustand", // Section title
			false                // Page number
		);
	}

	/** Print all subsections. */
	public function show_content()
	{
?>
		<table>
			<tr>
				<td style="width:380px;" rowspan="2"><?php $this->show_fragmentation(); ?></td>
				<td><?php $this->show_fragments_count(); ?></td>
			</tr>
			<tr>
				<td><?php $this->show_restoration(); ?></td>
			</tr>
		</table>
<?php
	}

	/** Specify the degree of possible fragmentation. */
	protected function show_fragmentation()
	{
		$input = new ChoiceWidget(self::KEY_FRAGMENTATION, false);
		$input->addChoice(self::VAL_NOT_SPECIFIED, "keine Angabe", false, false, "condition_image('not_specified')");
		$input->addChoice(self::VAL_COMPLETE_EXTENT, "vollständig erhalten", false, false, "condition_image('complete_extent')");
		$input->addChoice(self::VAL_GENERAL_FRAGMENTS, "allg. Fragment(e)", false, false, "condition_image('general_fragments')");
		$input->addChoice(self::VAL_RIM_FRAGMENT, false, false, false, "condition_image('rim')");
		$input->addChoice(self::VAL_RIM_WALL_FRAGMENT, false, false, false, "condition_image('rim_wall')");
		$input->addChoice(self::VAL_WALL_FRAGMENT, false, false, false, "condition_image('wall')");
		$input->addChoice(self::VAL_ALL_BOTTOM_FRAGMENT, false, false, false, "condition_image('wall_bottom')");
		$input->addChoice(self::VAL_BOTTOM_FRAGMENT, false, false, false, "condition_image('bottom')");

		// Image path translation.
		$image = array(
			self::VAL_NOT_SPECIFIED       => 'not_specified',
			self::VAL_COMPLETE_EXTENT     => 'complete_extent',
			self::VAL_GENERAL_FRAGMENTS   => 'general_fragments',
			self::VAL_RIM_FRAGMENT        => 'rim',
			self::VAL_RIM_WALL_FRAGMENT   => 'rim_wall',
			self::VAL_WALL_FRAGMENT       => 'wall',
			self::VAL_ALL_BOTTOM_FRAGMENT => 'wall_bottom',
			self::VAL_BOTTOM_FRAGMENT     => 'bottom',
		);

		$content = '<div style="float:left; margin-right: 50px;">'.$input->getHtml().'</div>';
		$content .= '<div><img id="condition_figure" src="images/condition_'.$image[post(self::KEY_FRAGMENTATION)].'.png"></div>';
		$content .= '<div style="clear:left;"></div>';

		$fieldset = new FieldsetWidget('fragmentierung', "Fragmentierung", $content);
		echo $fieldset->show();
	}

	/** Count of fragments. This parameter is optional. */
	protected function show_fragments_count()
	{

		$input = new TextInputWidget(self::KEY_FRAGMENTS_COUNT, "Stück", false, 3);

		$fieldset = new FieldsetWidget(self::VAL_FRAGMENTS_COUNT, "Anzahl der Fragmente (optional)", $input->getHtml());
		echo $fieldset->show();
	}

	/** Was the object restored? For example where the parts glued together? */
	protected function show_restoration()
	{
		$input = new MultiChoiceWidget(self::KEY_RESTORATION);
		$input->addChoice(self::VAL_RESTORATION_GLUED, "geklebt (z. B. <em>Archäocoll 2000</em> oder <em>Paraloid&trade; B 72</em>)");
		$input->addChoice(self::VAL_RESTORATION_RECONSTRUCTED, "rekonstruiert (z. B. <em>Alabastergips</em>)");

		$fieldset = new FieldsetWidget('restauration', "Restauration", $input->getHtml());
		echo $fieldset->show();
	}

	/** @returns type of fragmentation. */
	static public function fragmentation()
	{
		return post(self::KEY_FRAGMENTATION);
	}

	/** @returns true if object is not fragmented. */
	static public function is_complete_extent()
	{
		return self::fragmentation() == self::VAL_COMPLETE_EXTENT;
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		$fragmentation = self::fragmentation();
		$fragments_count = intval(post(self::KEY_FRAGMENTS_COUNT));

		// Get restoration conditions of object.
		$restoration = post(self::KEY_RESTORATION);

		// True if object was glued.
		$isGlued = array_key_exists(self::VAL_RESTORATION_GLUED, $restoration ? $restoration : array());

		// True if object was reconstructed.
		$isReconstructed = array_key_exists(self::VAL_RESTORATION_RECONSTRUCTED, $restoration ? $restoration : array());

		// Construct the object condition statement.
		$result = (($fragmentation == self::VAL_COMPLETE_EXTENT) ? '' : $fragmentation);

		// First create a list of additional attributes in braces.
		$args = array();
		// Hahaha grammar havoc!! xD
		if ($fragments_count > 1) $args[] = "$fragments_count Fragmente";
		if ($isGlued) $args[] = "geklebt";
		if ($isReconstructed) $args[] = "rekonstruiert";

		// Next prepend the major attributes.
		$args = implode(', ', $args);
		if ($args) $args = "({$args})";
		if ($result and $args) $result .= ' '.$args;
		if ($fragmentation == self::VAL_GENERAL_FRAGMENTS and $fragments_count > 1) $result = trim($args, '()');
		if ($result) $result = ucfirst($result);
		if ($isGlued and $result == '') $result = "geklebt";
		if ($result) $result = '; '.$result;

		return $result;
	}

	/** Returns short formal description. */
	static public function get_short_description()
	{
		$fragmentation = post(self::KEY_FRAGMENTATION);
		$fragments_count = intval(post(self::KEY_FRAGMENTS_COUNT));
		$result = $fragmentation;

		if ($fragmentation == self::VAL_GENERAL_FRAGMENTS and $fragments_count > 1) $result = "mehrere Fragmente";
		if ($result) $result = ', '.$result;

		return $result;
	}
}

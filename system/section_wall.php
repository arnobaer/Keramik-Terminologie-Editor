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

/** Object wall zone section.*/
class SectionWall extends AccordionSection
{
	// Used POST variable names.

	const KEY_WALL_NECK     = 'wall_neck';
	const KEY_WALL_SHOULDER = 'wall_shoulder';
	const KEY_WALL_BULGE    = 'wall_bulge';
	const KEY_WALL_FOOT     = 'wall_foot';

	// Used variable values to be compared somewhere.

	const VAL_NOT_SPECIFIED = 0;
	public function __construct()
	{
		parent::__construct(
			'wallzone',    // Element id
			"Wandbereich", // Section title
			31);           // Page number
	}

	public function show_content()
	{
?>
		<table>
			<tr>
				<td><?php $this->show_neck(); ?></td>
				<td><?php $this->show_shoulder(); ?></td>
				<td><?php $this->show_bulge(); ?></td>
				<td><?php $this->show_foot(); ?></td>
			</tr>
		</table>
<?php
	}

	/** Specify the vessel neck type. */
	public function show_neck()
	{
		$input = new Choice(self::KEY_WALL_NECK, false);
		$input->addChoice(self::VAL_NOT_SPECIFIED, "keine Angabe");
		$input->addChoice("stark einziehender Hals");
		$input->addChoice("schwach einziehender Hals");
		$input->addChoice("zylindrischer Hals");
		$input->addChoice("konischer Hals");

		$box = new Box('hals', "Hals/Halszone", $input->getHtml());
		echo $box->show();
	}

	/** Specify the vessel shoulder type. */
	public function show_shoulder()
	{
		$input = new Choice(self::KEY_WALL_SHOULDER, false);
		$input->addChoice(0, "keine Angabe");
		$input->addChoice("flach ansteigende Schulter");
		$input->addChoice("steil ansteigende Schulter");

		$box = new Box('schulter', "Schulter/Schulterzone", $input->getHtml());
		echo $box->show();
	}

	/** Specify the vessel bulge type. */
	public function show_bulge()
	{
		$input = new Choice(self::KEY_WALL_BULGE, false);
		$input->addChoice(0, "keine Angabe");
		$input->addChoice("zylindrischer Bauch");
		$input->addChoice("ellipsoider Bauch");
		$input->addChoice("kugeliger Bauch");
		$input->addChoice("konischer Bauch");
		$input->addChoice("quaderförmiger Bauch");

		$box = new Box('bauch', "Bauch/Bauchzone", $input->getHtml());
		echo $box->show();
	}

	/** Specify the vessel foot type. */
	public function show_foot()
	{
		$input = new Choice(self::KEY_WALL_FOOT);
		$input->addChoice("einziehender Fuß");
		$input->addChoice("ausladende Fußzone");
		$input->addChoice("zylindrische Fußzone");

		$box = new Box('fuss', "Fuß/Fußzone", $input->getHtml());
		echo $box->show();
	}

	/** Returns long detailed description. */
	static public function get_long_description()
	{
		$list = array();

		$list[] = post(self::KEY_WALL_FOOT);
		$list[] = post(self::KEY_WALL_BULGE);
		$list[] = post(self::KEY_WALL_SHOULDER);
		$list[] = post(self::KEY_WALL_NECK);

		$list = array_filter($list);

		return implode("; ", $list);
	}

	/** Returns short formal description. */
	static public function get_short_description()
	{
		return '';
	}
}

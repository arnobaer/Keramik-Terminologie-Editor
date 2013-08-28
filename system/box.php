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

/** Implements a simple content box with title.

How to use:

$box = new Box('my_box', "A simple box", "Lorem ipsum et dolor.");
$box->show();

*/
class Box
{
	/** Constructor. */
	public function __construct($id, $title, $content)
	{
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
		$this->float = false; // if true float boxes to the left.
	}

	public function floatLeft()
	{
		$this->float = true;
	}

	/** Print section to stdout. */
	public function show()
	{
		$style = '';
		if ($this->float) $style = 'float:left; padding-right:25px;';
		echo "\t<fieldset id=\"{$this->id}_box\" style=\"$style\">".PHP_EOL;
		echo "\t\t<legend id=\"{$this->id}_box_title\">{$this->title}</legend>".PHP_EOL;
// 		echo "\t\t<div style=\"float:left;\" id=\"{$this->id}_box_content\">".PHP_EOL;
		echo "\t\t\t{$this->content}".PHP_EOL;
// 		echo "\t\t</div>".PHP_EOL;
		echo "\t</fieldset>".PHP_EOL;
	}
}

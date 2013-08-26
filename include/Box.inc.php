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
	}

	/** Print section to stdout. */
	public function show()
	{
		echo "\t<div id=\"{$this->id}_box\">".PHP_EOL;
		echo "\t\t<h4 id=\"{$this->id}_box_title\">{$this->title}</h4>".PHP_EOL;
		echo "\t\t<p id=\"{$this->id}_box_content\">".PHP_EOL;
		echo "\t\t\t{$this->content}".PHP_EOL;
		echo "\t\t</p>".PHP_EOL;
		echo "\t</div>".PHP_EOL;
	}
}

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

/** Implements an accordion section.

How to use:

class FooSection extends AccordionSection
{
	public function __construct()
	{
		parent::__construct('foo', "Foo Section");
	}

	public function show_content()
	{
		echo "Lorem ipsum et dolor.";
	}
}

*/
abstract class AccordionSection
{
	/** Constructor. */
	public function __construct($id, $title, $page = false)
	{
		$this->id = $id;
		$this->title = $title;
		$this->page = $page;
	}

	/** Overload this to print section content to stdout. */
	abstract public function show_content();

	/** Print section to stdout. */
	public function show()
	{
		$page = $this->page ? " <em>Seite {$this->page}</em>" : '';
		echo "\t<h3 id=\"{$this->id}_title\">{$this->title}{$page}</h3>".PHP_EOL;
		echo "\t<div id=\"{$this->id}_container\">".PHP_EOL;
		$this->show_content();
		echo "\t</div>".PHP_EOL;
	}

	/** Get POST value or false if does not exist. */
	static public function getPost($key) {
		return isset($_POST[$key]) ? $_POST[$key] : false;
	}
}

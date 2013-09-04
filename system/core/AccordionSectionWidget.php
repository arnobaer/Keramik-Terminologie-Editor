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

/** Implements an accordion section.

How to use:

class FooSection extends AccordionSectionWidget
{
	public function __construct()
	{
		parent::__construct('foo', "Foo Section");
	}

	public function content()
	{
		echo "Lorem ipsum et dolor.";
	}
}

*/
abstract class AccordionSectionWidget extends Controller
{
	protected $id;
	protected $title;
	protected $page;

	/** Constructor. */
	public function __construct($id, $title, $page = false)
	{
		$this->id = $id;
		$this->title = $title;
		$this->page = $page;
	}

	/** Overload this to print section content to stdout. */
	abstract public function content();

	/** Print section to stdout. */
	public function getHtml()
	{
		$data = array(
			'id' => $this->id,
			'title' => $this->title,
			'page' => $this->page ? " <em>Seite {$this->page}</em>" : '',
			'content' => $this->content(),
		);
		return $this->loadView('accordion_section_widget', $data, false);
	}

	/** Returns long detailed description. Implement in derived class. */
	abstract static public function longDescription();

	/** Returns short formal description. Implement in derived class. */
	abstract static public function shortDescription();
}

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

/** Implements a jQuery UI accordion widget.

How to use:

$accordion = new Accordion('accordion');
$accordion.add_section(new FooSection());
$accordion.add_section(new BarSection());
$accordion->show();

*/
class AccordionWidget
{
	protected $id;
	protected $section;

	/** Constructor.
	 * @param id a unique ID name.
	 */
	public function __construct($id)
	{
		$this->id = $id;
		$this->sections = array();
	}

	/** Add a section to the accordion. */
	public function addSection(AccordionSectionWidget &$section)
	{
		$this->sections[] = $section;
	}

	/** Print section to stdout. */
	public function getHtml()
	{
		$buffer = '';
		$buffer .= "<div id=\"{$this->id}\">".PHP_EOL;
		foreach ($this->sections as &$section) {
			$buffer .= $section->getHtml();
		}
		$buffer .=  '</div>'.PHP_EOL;
		return $buffer;
	}
}

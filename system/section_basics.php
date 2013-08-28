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

class SectionBasics extends AccordionSection
{
	public function __construct()
	{
		parent::__construct(
			'basics',     // Element id
			"Grundlagen", // Section title
			10            // Page number
		);
	}

	public function show_content()
	{
?>
		<table style="width:auto;">
			<tr>
				<td><?php $this->show_basic(); ?></td>
			</tr>
		</table>
<?php
	}

	public function show_basic()
	{
		$input = new Choice('basics_ceramic_category', false);
		$input->addChoice('Irdenware', false, true);
		$input->addChoice('Fayence');
		$input->addChoice('Steingut');
		$input->addChoice('Steinzeug');
		$input->addChoice('Porzellan');

		$box = new Box('ceramic_category', "Keramikgattung", $input->getHtml());
		echo $box->show();
	}
}

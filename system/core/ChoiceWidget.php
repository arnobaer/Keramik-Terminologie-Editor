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

class _ChoiceItem
{
	public $value;
	public $label;
	public $default;
	public $margin;
	public $onclick;

	public function __construct($value, $label = false, $margin = false, $onclick = false)
	{
		$this->value   = $value;   // The actual value.
		$this->label   = $label;   // If no label is set, value is used as label.
		$this->margin  = $margin;  // Set a margin level.
		$this->onclick = $onclick; // Set an onclick javascript event.
	}
}

class ChoiceWidget extends Controller
{
	const ValueNotSpecified = 0;
	const LabelNotSpecified = "keine Angabe";

	private $_key;
	private $_default;

	/** @param onclick define javascript function to be called on click. */
	public function __construct($key, $notSpecified = true)
	{
		$this->_key = $key;
		$this->_items = array();
		$this->_default = -1; // Array index of last default element.
		// Add not specified label as first item if requested.
		if ($notSpecified) {
			$this->addChoice(self::ValueNotSpecified, self::LabelNotSpecified, true);
		}
	}

	// Only the last default button is the default selected button.
	// Margin: temp. hack for nested list style margins.
	/** @param onclick define javascript function to be called on click. */
	public function addChoice($value, $label = false, $default = false, $margin = false, $onclick = false)
	{
		$item = new _ChoiceItem($value, $label ? $label : $value, $margin, $onclick);
		$this->_items[] = $item;
		if ($default) {
			$this->_default = sizeof($this->_items) - 1;
		}
	}

	private function getCurrentChecked()
	{
		return post($this->_key);
	}

	public function getHtml()
	{
		$content = array();

		foreach ($this->_items as $key => &$item) {

			$currentValue = $this->getCurrentChecked();

			// Calculate if item is checked.
			$checked = $currentValue == $item->value;
			if (!$checked and ($key == $this->_default) and !$currentValue) $checked = true;

			$id = strtolower("{$this->_key}_{$key}_{$item->value}");
			foreach (array('ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss') as $key => $value) {
				$id = str_replace($key, $value, $id);
			}
			$chars = str_split(' .,|-()[]/\\*&^%$#@!');
			foreach ($chars as $char) {
				$id = str_replace($char, '_', $id);
			}

			$marginPt = $item->margin * 18;

			$input = Summoning::inputRadio($this->_key, $item->value);
			$input->setAttribute('id', $id);
			if ($checked) $input->setAttribute('checked', 'checked');
			if ($item->margin) $input->setAttribute('style', "margin-left:{$marginPt}pt");
			if ($item->onclick) $input->setAttribute('onclick', $item->onclick);

			$label = Summoning::label($input->get()." {$item->label}");
			$label->setAttribute('for', $id);

			$content[] = $label->get();
		}
		return Summoning::div(implode(PHP_EOL, array_filter($content)))->get();
	}
}

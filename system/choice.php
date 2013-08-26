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

class Choice {

	private $_key;
	private $_default;

	/** @param onclick define javascript function to be called on click. */
	public function __construct($key, $notSpecified = true) {
		$this->_key = $key;
		$this->_buttons = array();
		$this->_default = -1; // Array index of last default element.
		if ($notSpecified) {
			$this->addChoice(false, 'keine Angabe', true);
		}
	}

	// Only the last default button is the default selected button.
	// Margin: temp. hack for nested list style margins.
	public function addChoice($value, $label = false, $default = false, $margin = false, $onclick = false) {
		$button = array($value, $label ? $label : $value, $margin, $onclick);
		$this->_buttons[] = $button;
		if ($default) {
			$this->_default = sizeof($this->_buttons) - 1;
		}
	}

	private function getCurrentChecked() {
		$key = &$this->_key;
		if (isset($_POST[$key]) and !is_array($_POST[$key])) {
			return strip_tags($_POST[$key]);
		}
		return false;
	}

	// list true generates an <ul> list.
	public function getHtml() {
		$html = '';
		foreach ($this->_buttons as $key => &$button) {
			$value = &$button[0];
			$label = &$button[1];
			$currentValue = $this->getCurrentChecked();
			$checked = $currentValue == $value ? ' checked' : '';
			if (!$checked and ($key == $this->_default) and !$currentValue) $checked = ' checked';
			$id = strtolower("{$this->_key}_{$key}_{$value}");
			$margin = $button[2] * 10;
			$onclick = ($button[3] ? " onclick=\"{$button[3]}\"" : '');
			$html .= "<label for=\"{$id}\"><input{$onclick} style=\"margin-left:{$margin}pt\" id=\"{$id}\" type=\"radio\" name=\"{$this->_key}\" value=\"{$value}\"{$checked}> {$label}</label>".PHP_EOL;
		}
		return $html;
	}
}

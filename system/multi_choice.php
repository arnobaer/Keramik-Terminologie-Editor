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

class MultiChoice {

	private $_key;

	public function __construct($key) {
		$this->_key = $key;
		$this->_boxes = array();
	}

	public function addChoice($value, $label = false) {
		$box = array($value, $label ? $label : $value);
		$this->_boxes[] = $box;
	}

	private function isChecked(&$value) {
		if (isset($_POST[$this->_key]) and is_array($_POST[$this->_key])) {
			if (array_key_exists($value, $_POST[$this->_key])) {
				$temp = &$_POST[$this->_key];
				if ($temp[$value]) {
					return true;
				}
			}
		}
		return false;
	}

	public function getHtml() {
		$html = '';
		foreach ($this->_boxes as $key => &$button) {
			$value = &$button[0];
			$label = &$button[1];
			$checked = $this->isChecked($value) ? ' checked' : '';
			$id = strtolower("{$this->_key}_{$key}_{$value}");
			$html .= "<label for=\"{$id}\"><input id=\"{$id}\" type=\"checkbox\" name=\"{$this->_key}[{$value}]\" value=\"{$value}\"{$checked}> {$label}</label>".PHP_EOL;
		}
		return $html;
	}
}

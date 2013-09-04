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

class TextAreaWidget extends Controller
{
	protected $_key;
	protected $_label;
	protected $_format;
	protected $_size;
	protected $_style;

	/** Constructor.

	@param key is the POST variable key.
	@param label is the displayed text label.
	@param format is an optional formatting description for the user.
	@param size max characters.
	@param style affects the HTMl style attribute.
	*/
	public function __construct($key, $label = false, $format = false, $size = false, $rows = 3, $cols = 80, $style = '')
	{
		$this->_key = $key;
		$this->_label = $label;
		$this->_format = $format;
		$this->_size = $size;
		$this->_rows = $rows;
		$this->_cols = $cols;
		$this->_style = $style;
	}

	/** Returns string. */
	public function getHtml()
	{
		$label = $this->_label ? $this->_label : '';
		$value = post($this->_key);
		$value = $value ? $value : '';
		$id = strtolower(str_replace(' ', '_', "text_{$this->_key}"));
		$style = $this->_style ? ' style="float:left; '.$this->_style.'"':'';
		$size = ($this->_rows ? " rows=\"{$this->_rows}\"" : '');
		$size = ($this->_cols ? " cols=\"{$this->_cols}\"" : '');
		$maxlength = ($this->_size ? " maxlength=\"{$this->_size}\"" : '');
		$html = ($label ? "<label for=\"{$id}\">" : '');
		$html .= "<textarea{$style}{$size}{$maxlength} id=\"{$id}\" type=\"text\" name=\"{$this->_key}\">{$value}</textarea>";
		$html .= ($label ? " $label</label>" : '');
		$html .= ($this->_format ? '<em style="font-size:.75em;"><div>Format: '.$this->_format.'</div></em>' : '');
		return $html;
	}
}

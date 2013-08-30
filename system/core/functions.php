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

/** Get POST value or false if does not exist.
 * @param key the variable name.
 * @param default the default value if variable is not set.
 * @returns string value on success or false if variable not set.
 */
function post($key, $default = false)
{
	if (isset($_POST[$key])) {
		if (is_array($_POST[$key])) {
			$values = array();
			foreach ($_POST[$key] as $key_ => $value) {
				$values[$key_] = htmlspecialchars($value);
			}
			return $values;
		}
		return filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
	}
	return $default;
}

/** Filters a floating point value from any input string and returns a formatted
 * string with unit suffix.
 * @param input any string containing a numeric information.
 * @param suffix the unit suffix.
 * @param comma the displayed comma character.
 * @returns formatted string with comma and unit suffix, eg. '2,34 cm'.
 */
function str_centimeters($input, $suffix = 'cm', $comma = ',')
{
	$input = str_replace(',', '.', $input); // Normalize commas.
	preg_match_all('!\d+(?:\.\d+)?|(?:\.\d+)!', $input, $matches);
	return (sizeof($matches[0]) ? (str_replace('.', $comma, round($matches[0][0], 1)).($suffix ? " {$suffix}" : '')) : false);
}

/** Filters up to two floating point values from any input string and returns a
 * formatted string with unit suffix.
 * @param input any string containing a numeric information.
 * @param suffix the unit suffix.
 * @param comma the displayed comma character.
 * @returns formatted string with comma and unit suffix, eg. '2,34 - 4,56 cm'.
 */
function str_centimeters_range($input, $suffix = 'cm', $comma = ',')
{
	$input = str_replace(',', '.', $input); // Normalize commas.
	preg_match_all('!\d+(?:\.\d+)?|(?:\.\d+)!', $input, $matches);
	return (sizeof($matches[0]) ? str_replace('.', $comma, (sizeof($matches[0]) > 1) ? round($matches[0][0], 1).'&ndash;'.$matches[0][1] : round($matches[0][0], 1)).($suffix ? " {$suffix}" : '') : false);
}

/** Filters a floating point value from any input string and returns a formatted
 * string with unit suffix.
 * @param input any string containing a numeric information.
 * @param suffix the unit suffix.
 * @param comma the displayed comma character.
 * @returns formatted string with comma and unit suffix, eg. '2,34 %'.
 */
function str_percent($input, $suffix = '%', $comma = ',')
{
	$input = str_replace(',', '.', $input); // Normalize commas.
	preg_match_all('!\d+(?:\.\d+)?|(?:\.\d+)!', $input, $matches);
	return (sizeof($matches[0]) ? (str_replace('.', $comma, round($matches[0][0], 1)).($suffix ? "{$suffix}" : '')) : false);
}

/** Filters a Munsell color code from any input string and returns a formatted
 * string with unit suffix.
 * @param input any string containing a numeric information.
 * @returns formatted string of color code.
 */
function str_munsell_color($input)
{
	$input = str_replace(' ', '', trim(strtoupper($input))); // strip any spaces.
	$input = str_replace(',', '.', $input); // commas to dots.
	preg_match_all('!(\d{1,2}(?:GB|GY|YR|B|G|R|Y))(\d(?:\.5)?\/\d)!', $input, $matches);
	return sizeof($matches[0]) ? $matches[1][0].' '.$matches[2][0] : false;
}

/** Filters a RAL color code from any input string and returns a formatted
 * string with unit suffix.
 * @param input any string containing a numeric information.
 * @returns formatted string of color code.
 */
function str_ral_color($input)
{
	$input = str_replace(' ', '', trim(strtoupper($input))); // strip any spaces.
	preg_match_all('!(RAL)(\d{4})!', $input, $matches);
	return sizeof($matches[0]) ? $matches[1][0].' '.$matches[2][0] : false;
}

/** Filters a color name from any input string and returns a formatted
 * string with unit suffix.
 * @param input any string containing a numeric information.
 * @returns formatted string of color name.
 */
function str_named_color($input)
{
	$input = str_replace('  ', ' ', trim($input)); // strip double spaces.
	foreach ($this->munsell->dict as $en => $de) {
		if ($input == $en or $input == $de)
			return $input;
	}
	return false;
}

/** Auto detect color code or name and return filtered string.
 * @param input any string containing a numeric information.
 * @returns formatted string of color code or name.
 */
function str_clean_color($name, &$valid, &$munsell)
{
	$valid = true;
	$munsell = true;
	$input = isset($_POST[$name]) ? $_POST[$name] : false;
	if (!$input) return '';
	$color = $this->getMunsellColor($input);
	if ($color)
		return $color;
	$munsell = false;
	$color = $this->getRalColor($input);
	if ($color)
		return $color;
	$color = $this->getNamedColor($input);
	if ($color)
		return $color;
	$valid = false;
	return $input;
}

/** What the hack does this function?! I forgot completely...
 */
function str_colors($name1, $name2)
{
	$color1 = $this->getCleanColor($name1, $valid1, $munsell1);
	$color2 = $this->getCleanColor($name2, $valid2, $munsell2);
	if ($color1 == $color2) $color2 = false;
	$html = '';
	if ($color1 and $color2) {
		$name1 = '';
		$name2 = '';
		if ($munsell1) {
			$en = $this->munsell->getName($color1);
			$de = $this->munsell->getTranslation($en);
			$name1 = ($de?"$de":'');
			$name2 = "$color1".($en?" $en":'');
		}
		else {
			$name1 = ($de?"$de ":'');
			$name1 = $color1;
		}
		if ($munsell2) {
			$en = $this->munsell->getName($color2);
			$de = $this->munsell->getTranslation($en);
			$name1 .= " bis ".($de?"$de":'');
			$name2 .= " bis $color2".($en?" $en":'');
		}
		else {
			$name1 .= " bis $color2";
		}
		$name3 = explode(' ', $name1); // Prevent double naming.
		if (sizeof($name3) > 2)
			if ($name3[0] == $name3[2])
				$name1 = $name3[0];
		return "$name1".($name2?" ($name2)":'');
	}
	if ($color1) {
		if ($munsell1) {
			$en = $this->munsell->getName($color1);
			$de = $this->munsell->getTranslation($en);
			$html = ($de?"$de ":'')."($color1".($en?" $en":'').')';
		}
		else
			$html = $color1;
	}
	return $html;
}

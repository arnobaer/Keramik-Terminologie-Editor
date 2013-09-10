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

/** Returns server URI.
 */
function get_url()
{
	return $_SERVER["REQUEST_URI"];
}

/** Replaces only last occurrence of string.
 * @param search
 * @param replace
 * @param subject
 * @returns replaced string.
 */
function str_replace_last_occurrence($search, $replace, $subject)
{
	$pos = strrpos($subject, $search);
	if($pos !== false) {
		$subject = substr_replace($subject, $replace, $pos, strlen($search));
	}
	return $subject;
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
	# Return false if no value found.
	if (sizeof($matches[0]) < 1) {
		return false;
	}
	$value = round($matches[0][0], 1);
	return str_replace('.', $comma, $value).($suffix ? " {$suffix}" : '');
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
	# Return false if no value found.
	if (sizeof($matches[0]) < 1) {
		return false;
	}
	$value1 = round($matches[0][0], 1);
	# Value range.
	if (sizeof($matches[0]) > 1) {
		$value2 = round($matches[0][1], 1);
		# Swap values if not in ascending order.
		if ($value1 > $value2) {
			return str_replace('.', $comma, $value2.'&ndash;'.$value1).($suffix ? " {$suffix}" : '');
		}
		# Ignore identical numbers.
		if ($value1 == $value2) {
			return str_replace('.', $comma, $value1).($suffix ? " {$suffix}" : '');
		}
		# Return range.
		return str_replace('.', $comma, $value1.'&ndash;'.$value2).($suffix ? " {$suffix}" : '');
	}
	return str_replace('.', $comma, $value1).($suffix ? " {$suffix}" : '');
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
	$munsell = new MunsellSoilColors();
	$input = str_replace('  ', ' ', trim($input)); // strip double spaces.
	foreach ($munsell->dict as $en => $de) {
		if ($input == $en or $input == $de)
			return $input;
	}
	return false;
}

/** Auto detect color code or name and return filtered string.
 * @param name post.
 * @returns formatted string of color code or name.
 */
function str_clean_color($name, &$valid, &$munsell)
{
	$valid = true;
	$munsell = true;
	$input = post($name);
	if (!$input) return '';
	$color = str_munsell_color($input);
	if ($color)
		return $color;
	$munsell = false;
	$color = str_ral_color($input);
	if ($color)
		return $color;
	$color = str_named_color($input);
	if ($color)
		return $color;
	$valid = false;
	return $input;
}

/** What the hack does this function?! I forgot completely...
 */
function str_colors($name1, $name2)
{
	$munsell = new MunsellSoilColors();
	$color1 = str_clean_color($name1, $valid1, $munsell1);
	$color2 = str_clean_color($name2, $valid2, $munsell2);
	if ($color1 == $color2) $color2 = false;
	$html = '';
	if ($color1 and $color2) {
		$name1 = '';
		$name2 = '';
		if ($munsell1) {
			$en = $munsell->getName($color1);
			$de = $munsell->getTranslation($en);
			$name1 = ($de?"$de":'');
			$name2 = "$color1".($en?" $en":'');
		}
		else {
			$name1 = ($de?"$de ":'');
			$name1 = $color1;
		}
		if ($munsell2) {
			$en = $munsell->getName($color2);
			$de = $munsell->getTranslation($en);
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
			$en = $munsell->getName($color1);
			$de = $munsell->getTranslation($en);
			$html = ($de?"$de ":'')."($color1".($en?" $en":'').')';
		}
		else
			$html = $color1;
	}
	return $html;
}

function js_accordion_active()
{
	$active = post('accordion_active');
	echo $active ? $active : 'false';
}

function js_tabs_active()
{
	$active = post('tab_active');
	echo $active ? $active : 'false';
}

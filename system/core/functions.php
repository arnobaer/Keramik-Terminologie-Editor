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

/** Optional translation. */
function tr($text)
{
	return $text;
}

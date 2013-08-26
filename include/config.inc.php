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

/**
 * Include class by filename.
 *
 * @param  string $file  class path and filename.
 * @return true on success.
 */
function __load_class_file($file)
{
    if (file_exists($file)) {
        include_once $file;
        return true;
    }
    return false;
}

/**
 * Automatically includes classes
 *
 * @throws Exception
 *
 * @param  string $class_name  Name of the class to load
 * @return void
 */
function __autoload($class_name)
{
	$file = 'include/' . $class_name . '.inc.php';
	if (file_exists($file)) {
		include_once $file;
		return true;
	}
	return false;

	throw new Exception('The class ' . $class_name . ' could not be loaded');
}


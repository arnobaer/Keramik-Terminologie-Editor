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

/** Abstract controller base class.
 */
class Controller
{
    public function __construct()
    {
    }

    /** Load a view and populate it with data and print to stdout.
    * @param view the name of the view (filename without extension).
    * @param data an array containing keys and values used inside the view.
    * @param string if true the function returns the view as string.
    */
    public function loadView($view, array &$data = array(), $echo = True)
    {
        // Start output buffering.
        ob_start();

        // Execute the view and populate it with the data variables.
        $this->__loadView($view, $data);

        // If function should return a string, store buffer content and clean.
        if (!$echo) {
            $buffer = ob_get_contents();
            ob_end_clean();
            return $buffer;
        }

        // Else flush the buffer.
        ob_end_flush();
    }

    /** Include the view, helper to prevent extract() name clashes in load_view().
     * @param view the name of the view (filename without extension).
     * @param data an array containing keys and values used inside the view.
     */
    private function __loadView($__view, &$__data)
    {
        // Extract variables form the data array.
        extract($__data);

        // Execute the view and populate it with the data variables.
        include VIEW_PATH."/{$__view}.php";
    }
}

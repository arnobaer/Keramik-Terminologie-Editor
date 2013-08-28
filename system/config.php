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

const SYS_PATH  = 'system';
const CTRL_PATH = 'system/controller';
const CORE_PATH = 'system/core';
const VIEW_PATH = 'system/views';

require_once CORE_PATH . '/functions.php';

require_once CORE_PATH . '/munsell.php';

require_once SYS_PATH . '/box.php';
require_once SYS_PATH . '/choice.php';
require_once SYS_PATH . '/multi_choice.php';
require_once SYS_PATH . '/text_input.php';
require_once SYS_PATH . '/text_area.php';

require_once SYS_PATH . '/accordion.php';
require_once SYS_PATH . '/accordion_section.php';
require_once SYS_PATH . '/section_basics.php';
require_once SYS_PATH . '/section_fracture.php';
require_once SYS_PATH . '/section_border.php';
require_once SYS_PATH . '/section_wall.php';
require_once SYS_PATH . '/section_bottom.php';
require_once SYS_PATH . '/section_dimensions.php';
require_once SYS_PATH . '/section_functionals.php';
require_once SYS_PATH . '/section_usewear.php';
require_once SYS_PATH . '/section_condition.php';
require_once SYS_PATH . '/form.php';

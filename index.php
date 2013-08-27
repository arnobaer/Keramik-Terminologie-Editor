<?php define('KeramikTerminologieEditor', true);

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

include_once('system/config.php');

$form = new Form();

// This restores the last open accordion panel.
$accordion_active = $form->getPost('accordion_active');
$accordion_restore = "<script type=\"text/javascript\">".'$(function() {$("#accordion").accordion("option", "active", '.($accordion_active !== false ? $accordion_active : 'false').');});</script>'.PHP_EOL;

include VIEW_PATH . '/document.php';

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

// Application overall version.
const AppVersion    = '1.0.0 RC1';
const AppTitle      = 'Keramik Terminologie Editor';
const AppAuthors    = 'Bernhard R. Arnold';
const AppLicense    = 'GNU/GPL-Lizenz 3.0';
const AppLicenseUrl = 'http://www.gnu.org/licenses/gpl-3.0.txt';
const AppGithubUrl  = 'http://github.com/arnobaer/Keramik-Terminologie-Editor';

// Set system paths.
const SYS_PATH  = 'system';
const CTRL_PATH = 'system/controller';
const CORE_PATH = 'system/core';
const LIB_PATH  = 'system/lib';
const VIEW_PATH = 'system/views';

// Include external libraries.
require_once LIB_PATH . '/Summoning.php';
require_once LIB_PATH . '/MunsellSoilColors.php';

// Include core classes.
require_once CORE_PATH . '/functions.php';
require_once CORE_PATH . '/Controller.php';

// Include HTML widget classes.
require_once CORE_PATH . '/FieldsetWidget.php';
require_once CORE_PATH . '/ChoiceWidget.php';
require_once CORE_PATH . '/MultiChoiceWidget.php';
require_once CORE_PATH . '/LineEditWidget.php';
require_once CORE_PATH . '/TextAreaWidget.php';
require_once CORE_PATH . '/AccordionSectionWidget.php';
require_once CORE_PATH . '/AccordionWidget.php';

// Include section controller classes.
require_once CTRL_PATH . '/SectionGrundlagen.php';
require_once CTRL_PATH . '/SectionMagerung.php';
require_once CTRL_PATH . '/SectionOberflaeche.php';
require_once CTRL_PATH . '/SectionHerstellung.php';
require_once CTRL_PATH . '/SectionBruch.php';
require_once CTRL_PATH . '/SectionRandbereich.php';
require_once CTRL_PATH . '/SectionWandbereich.php';
require_once CTRL_PATH . '/SectionBodenbereich.php';
require_once CTRL_PATH . '/SectionMassangaben.php';
require_once CTRL_PATH . '/SectionFunktionselemente.php';
require_once CTRL_PATH . '/SectionGebrauchsspuren.php';
require_once CTRL_PATH . '/SectionGrundform.php';
require_once CTRL_PATH . '/SectionErhaltungszustand.php';
require_once CTRL_PATH . '/ApplicationForm.php';

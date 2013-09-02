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

const HeaderPublicationUrl                  = 'http://www.bda.at/publikationen/1584/16156/';
const HeaderPublicationSourceUrl            = 'http://www.verlag-berger.at/';
const HeaderPublicationSourceUrlAlternative = 'http://www.bda.at/organisation/889/';

?>
		<div class="ui-widget header">
			<h1>Keramik Terminologie <sub><em>Editor</em></sub></h1>
			<a href="<?php echo HeaderPublicationUrl; ?>"><img class="cover" src="images/cover.png"></a>
			<p>Ein Hilfsmittel zur Dokumentation von Keramikfunden nach dem <em>Handbuch zur Terminologie der mittelalterlichen und neuzeitlichen Keramik in Österreich</em> (<a href="<?php echo HeaderPublicationUrl; ?>"><span class="caps">FÖM</span>at A/Sonderheft 12</a>). Zu beziehen beim Bundesdenkmalamt Wien (<a href="<?php echo HeaderPublicationSourceUrlAlternative; ?>">Mag. Hofer</a>) oder beim <a href="<?php echo HeaderPublicationSourceUrl; ?>">Verlag Berger</a>, Kosten etwa € 15,-.</p>
			<p>Die generierte Beschreibung orientiert sich möglichst strikt an den Empfehlungen des Bundesdenkmalamts und eignet sich besonders für eine einheitliche Beschreibung großer Fundbestände.</p>
		</div>

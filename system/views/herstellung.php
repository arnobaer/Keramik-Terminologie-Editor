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

?>

					<table>
						<tr>
							<td><?php echo $formgebung; ?></td>
							<td><?php echo $primaerbrand; ?></td>
						</tr>
					</table>
					<table>
						<tr>
							<td style="width:33%"><?php echo $farbe_aussen; ?></td>
							<td style="width:33%"><?php echo $farbe_bruch; ?></td>
							<td style="width:33%"><?php echo $farbe_innen; ?></td>
						</tr>
						<tr>
							<td colspan="3"><p style="margin-top:0;padding:top:0;" class="infobox"><strong>Hinweis:</strong> Farbangaben nach Oyama und Takehara 1996 (Munsell), RAL oder Farbnamen.</p></td>
						</tr>
					</table>
					<table>
						<tr>
							<td style="width:33%" rowspan="2"><?php echo $spuren_weich; ?></td>
							<td style="width:33%"><?php echo $spuren_lederhart; ?></td>
							<td style="width:33%"><?php echo $spuren_brandbedingt; ?></td>
						</tr>
						<tr>
							<td style="width:33%!important" colspan="2"><?php echo $sekundaere_veraenderungen; ?></td>
						</tr>
					</table>

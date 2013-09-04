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
							<td style="width:33%">
								<?php echo $magerungsart; ?>
								<?php echo $magerungstyp; ?>
								<?php echo $magerungstyp_anmerkung; ?>
							</td>
							<td style="width:33%" rowspan="1">
								<?php echo $sortierung; ?>
								<?php echo $korngroesse; ?>
								<?php echo $menge; ?>
							</td>
							<td style="width:33%" rowspan="1">
								<?php echo $magerungsform; ?>
								<?php echo $verteilung; ?>
								<?php echo $verteilung_anmerkung; ?>
							</td>
						</tr>
					</table>

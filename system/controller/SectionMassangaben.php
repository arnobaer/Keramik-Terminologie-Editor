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

class SectionMassangaben extends AccordionSectionWidget
{
	const IdRanddurchmesser    = 'massangaben_randdurchmesser';
	const IdMaximaldurchmesser = 'massangaben_durchmesser_maximum';
	const IdBodendurchmesser   = 'massangaben_durchmesser_boden';
	const IdWandstaerke        = 'massangaben_wandstaerke';
	const IdHoehe              = 'massangaben_hoehe';
	const IdRanderhalt         = 'massangaben_randerhalt';

	public function __construct()
	{
		parent::__construct('massangaben', "Massangaben", 34);
	}

	public function content()
	{
		$information = "<strong>Hinweis:</strong> ".
			"Eingaben jeglicher Art, mit und ohne Komma und Einheit oder " .
			"ungültige Zeichen werden automatisch gefiltert, gerundet und " .
			"formatiert.";

		$data = array(
			'durchmesser' => $this->fieldsetDurchmesser(),
			'masse' => $this->fieldsetMasse(),
			'information' => $information,
		);
		return $this->loadView('massangaben', $data, false);
	}

	public function fieldsetDurchmesser()
	{

		$rand = new LineEditWidget(self::IdRanddurchmesser, 'Randdurchmesser (cm)');

		$maximal = new LineEditWidget(self::IdMaximaldurchmesser, 'Maximaldurchmesser (cm)');

		$boden = new LineEditWidget(self::IdBodendurchmesser, 'Bodendurchmesser (cm)');

		$fieldset = new FieldsetWidget('massangaben', "Durchmesser", $rand->getHtml().$maximal->getHtml().$boden->getHtml());
		return $fieldset->getHtml();
	}

	public function fieldsetMasse()
	{
		$wandstaerke = new LineEditWidget(self::IdWandstaerke, 'Wandstärke von&ndash;bis (cm)');

		$hoehe = new LineEditWidget(self::IdHoehe, '(erh.) Höhe (cm)');

		$randerhalt = new LineEditWidget(self::IdRanderhalt, 'Randerhalt (%)');

		$fieldset = new FieldsetWidget('massangaben_2', "Abmessungen", $wandstaerke->getHtml().$hoehe->getHtml().$randerhalt->getHtml());
		return $fieldset->getHtml();
	}

	public function randdurchmesser()
	{
		$cm = str_centimeters(post(self::IdRanddurchmesser));
		return $cm ? ("Randdm. {$cm}") : '';
	}

	static public function maximaldurchmesser()
	{
		$cm = str_centimeters(post(self::IdMaximaldurchmesser));
		return $cm ? ("max. Dm. {$cm}") : '';
	}

	static public function bodendurchmesser()
	{
		$cm = str_centimeters(post(self::IdBodendurchmesser));
		return $cm ? ("Bodendm. {$cm}") : '';
	}

	static public function wandstaerke()
	{
		$cm = str_centimeters_range(post(self::IdWandstaerke));
		return $cm ? ("Wandst. {$cm}") : '';
	}

	static public function hoehe()
	{
		$cm = str_centimeters(post(self::IdHoehe));
		$erhalten = SectionErhaltungszustand::isVollstaendigErhalten() ? '' : "erh. ";
		return $cm ? ("{$erhalten}H. {$cm}") : '';
	}

	static public function randerhalt()
	{
		$prozent = str_percent(post(self::IdRanderhalt));
		return $prozent ? ("{$prozent} Randerhalt") : '';
	}

	/** Returns long detailed description. */
	static public function longDescription()
	{
		$massangaben = array();

		$massangaben[] = self::hoehe();

		// Show preserved rim percent only if diameter is specified.
		$randdurchmesser = self::randdurchmesser();
		$randerhalt = self::randerhalt();
		if ($randdurchmesser and $randerhalt)
			$randdurchmesser .= " ({$randerhalt})";

		$massangaben[] = $randdurchmesser;
		$massangaben[] = self::maximaldurchmesser();
		$massangaben[] = self::bodendurchmesser();
		$massangaben[] = self::wandstaerke();

		return implode(', ', array_filter($massangaben));
	}

	/** Returns short formal description. */
	static public function shortDescription()
	{
		$massangaben = array();
		$massangaben[] = self::hoehe();
		$massangaben[] = self::randdurchmesser();
		$massangaben[] = self::maximaldurchmesser();
		$massangaben[] = self::bodendurchmesser();
		$massangaben[] = self::wandstaerke();
		return implode(', ', array_filter($massangaben));
	}
}

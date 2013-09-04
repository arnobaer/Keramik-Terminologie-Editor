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

/**
 *
 */
class SectionMagerung extends AccordionSectionWidget
{
	const IdMagerungsart = 'magerung_magerungsart';
	const IdMagerungstyp = 'magerung_magerungstyp';
	const IdMagerungstypAnmerkung = 'magerungstyp_anmerkung';
	const IdKorngroesse  = 'magerung_korngroesse';
	const IdSortierung = 'magerung_sortierung';
	const IdMenge = 'magerung_menge';
	const IdVerteilung = 'magerung_verteilung';
	const IdVerteilungAnmerkung = 'magerung_verteilung_anmerkung';
	const IdMagerungsform = 'magerung_magerungsform';
	const IdMagerungsformVorwiegend = 'magerung_magerungsform_vorwiegend';

	public function __construct()
	{
		parent::__construct('magerung', "Magerung", 12);
	}

	static public function magerungsart()
	{
		return post(self::IdMagerungsart);
	}

	static public function magerungstyp()
	{
		return post(self::IdMagerungstyp);
	}

	static public function magerungstypAnmerkung()
	{
		return post(self::IdMagerungstypAnmerkung);
	}

	static public function korngroesse()
	{
		return post(self::IdKorngroesse);
	}

	static public function sortierung()
	{
		return post(self::IdSortierung);
	}

	static public function menge()
	{
		return post(self::IdMenge);
	}

	static public function verteilung()
	{
		return post(self::IdVerteilung);
	}

	static public function verteilungAnmerkung()
	{
		return post(self::IdVerteilungAnmerkung);
	}

	static public function magerungsform()
	{
		return post(self::IdMagerungsform);
	}

	static public function magerungsformVorwiegend()
	{
		return post(self::IdMagerungsformVorwiegend);
	}

	public function content()
	{
		$data = array(
			'magerungsart' => $this->fieldsetMagerungsart(),
			'magerungstyp' => $this->fieldsetMagerungstyp(),
			'magerungstyp_anmerkung' => $this->fieldsetMagerungstypAnmerkung(),
			'korngroesse' => $this->fieldsetKorngroesse(),
			'sortierung' => $this->fieldsetSortierung(),
			'menge' => $this->fieldsetMenge(),
			'verteilung' => $this->fieldsetVerteilung(),
			'verteilung_anmerkung' => $this->fieldsetVerteilungAnmerkung(),
			'magerungsform' => $this->fieldsetMagerungsform(),
		);
		return $this->loadView('magerung', $data, false);
	}

	/**
	 *
	 */
	public function fieldsetMagerungsart()
	{
		$magerungsart = new ChoiceWidget(self::IdMagerungsart);
		$magerungsart->addChoice('sandgemagert', 'sandhaltig/sandgemagert');
		$magerungsart->addChoice('steinchengemagert', 'steinchenhaltig/steinchengemagert');

		$fieldset = new FieldsetWidget('magerung_magerungsart', "Magerungsart", $magerungsart->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 *
	 */
	public function fieldsetMagerungstyp()
	{
		$magerungstyp = new MultiChoiceWidget(self::IdMagerungstyp);
		$magerungstyp->addChoice('Glimmer');
		$magerungstyp->addChoice('Grafit');
		$magerungstyp->addChoice('Karbonat');
		$magerungstyp->addChoice('Quarz/Feldspat');
		$magerungstyp->addChoice('Schamotte');
		$magerungstyp->addChoice('Scherbenmehl');
		$magerungstyp->addChoice('Eisenoxydkongretion');
		$magerungstyp->addChoice('Tongerölle');
		$magerungstyp->addChoice('Schlacke');
		$magerungstyp->addChoice('Vegetabiles Material');

		$fieldset = new FieldsetWidget('magerung_magerungstyp', "Magerungstyp", $magerungstyp->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 *
	 */
	public function fieldsetMagerungstypAnmerkung()
	{
		$anmerkung = new LineEditWidget(self::IdMagerungstypAnmerkung, 'Anmerkung');

		$fieldset = new FieldsetWidget('magerung_magerungstyp', "Magerungstyp Anmerkung (optional)", $anmerkung->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 *
	 */
	public function fieldsetKorngroesse()
	{
		$korngroesse = new ChoiceWidget(self::IdKorngroesse);
		$korngroesse->addChoice('fein', 'fein: &lt; 0,20 mm');
		$korngroesse->addChoice('fein bis mittel', 'fein bis mittel: &lt; 0,20&ndash;0,63 mm');
		$korngroesse->addChoice('mittel', 'mittel: 0,20&ndash;0,63 mm');
		$korngroesse->addChoice('mittel bis grob', 'mittel bis grob: 0,20&ndash;2,0 mm');
		$korngroesse->addChoice('grob', 'grob: 0,64&ndash;2,0 mm');
		$korngroesse->addChoice('sehr grob', 'sehr grob: &gt; 2,0 mm');

		$fieldset = new FieldsetWidget('magerung_korngroesse', "Korngrösse", $korngroesse->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 *
	 */
	public function fieldsetSortierung()
	{
		$sortierung = new ChoiceWidget(self::IdSortierung);
		$sortierung->addChoice('gut sortiert');
		$sortierung->addChoice('mittelmäßig sortiert');
		$sortierung->addChoice('schlecht sortiert');

		$fieldset = new FieldsetWidget('magerung_sortierung', "Sortierung", $sortierung->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 *
	 */
	public function fieldsetMenge()
	{
		$menge = new ChoiceWidget(self::IdMenge);
		$menge->addChoice('wenige', 'wenige Magerungsanteile, &le;30%');
		$menge->addChoice('viele', 'viels Magerungsanteile, &gt;30%');

		$fieldset = new FieldsetWidget('magerung_menge', "Menge", $menge->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 *
	 */
	public function fieldsetVerteilung()
	{
		$verteilung = new ChoiceWidget(self::IdVerteilung);
		$verteilung->addChoice('homogene Verteilung', 'gleichmäßig/homogen');
		$verteilung->addChoice('inhomogene Verteilung', 'ungleichmäßig/inhomogen');
		$verteilung->addChoice('Verteilung mit Struktur', 'mit Struktur');

		$fieldset = new FieldsetWidget('magerung_verteilung', "Verteilung", $verteilung->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 *
	 */
	public function fieldsetVerteilungAnmerkung()
	{
		$anmerkung = new LineEditWidget(self::IdVerteilungAnmerkung, 'Anmerkung');

		$fieldset = new FieldsetWidget('magerung_verteilung_anmerkung', "Verteilung Anmerkung (optional)", $anmerkung->getHtml());
		return $fieldset->getHtml();
	}

	/**
	 *
	 */
	public function fieldsetMagerungsform()
	{
		$form = new ChoiceWidget(self::IdMagerungsform);
		$form->addChoice('gerundete Partikel', 'gerundet');
		$form->addChoice('kantike Partikel', 'kantig');
		$form->addChoice('nadelförmige Partikel', 'nadelförmig');

		$vorwiegend = new MultiChoiceWidget(self::IdMagerungsformVorwiegend);
		$vorwiegend->addChoice('vorwiegend', 'vorwiegend diese Form');

		$fieldset = new FieldsetWidget('magerung_magerungsform', "Magerungsform", $form->getHtml().$vorwiegend->getHtml());
		return $fieldset->getHtml();
	}

	/** Returns long detailed description. */
	static public function longDescription()
	{
		$magerung1 = array();

		$magerungsmenge = self::menge();
		if ($magerungsmenge) $magerung1[] = "{$magerungsmenge} Magerungsanteile";

		$korngroesse = self::korngroesse();
		if ($korngroesse) $magerung1[] = "Korngröße {$korngroesse}";

		$sortierung = self::sortierung();
		if ($sortierung) $magerung1[-1] = " ({$sortierung})";

		$magerungsform = self::magerungsform();
		if ($magerungsform) $magerung1[] = (self::magerungsformVorwiegend() ? 'vorwiegend ' : '')."{$magerungsform}";

		$verteilung =self::verteilung();
		if($verteilung) $magerung1[] = $verteilung;

		$anmerkung = self::verteilungAnmerkung();
		if (self::verteilung() and $anmerkung) $magerung1[-1] = " ({$anmerkung})";

		$magerung2 = array();

		$magerungstypen = str_replace_last_occurrence(', ', ' und ', implode(', ', self::magerungstyp()));
		if ($magerungstypen) $magerung2[] = $magerungstypen;

		$anmerkung = self::magerungstypAnmerkung();
		if (self::magerungstyp() and $anmerkung) $magerung2[] = $anmerkung;

		$magerung = implode(', ', $magerung1);
		$magerung .= (sizeof($magerung2)) ? ($magerung ? "; " : '').implode(', ', $magerung2) : '';

		return ucfirst($magerung);
	}

	/** Returns short formal description. */
	static public function shortDescription()
	{
		return '';
	}
}

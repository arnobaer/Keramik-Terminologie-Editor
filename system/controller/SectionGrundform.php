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

/** Object primitive form section.
*/
class SectionGrundform extends AccordionSectionWidget
{
	const IdUnsicher  = 'grundform_unsicher';
	const IdGrundform = 'grundform_grundform';

	const ValueG_1_6 = 'G1.6 Topf';

	const ValueDefault = self::ValueG_1_6;

	public function __construct()
	{
		$grundform = self::grundform();
		$preview = Summoning::span($grundform ? $grundform : self::ValueDefault);
		$preview->setAttribute('id', 'vorschau_grundform');

		parent::__construct('grundform', "Grundform ( {$preview} )", 58);
	}

	static public function unsicher()
	{
		return post(self::IdUnsicher);
	}

	static public function grundform()
	{
		return post(self::IdGrundform);
	}

	public function content()
	{
		$data = array(
			'unsicher' => $this->fieldsetUnsicher(),
			'tabs' => $this->fieldsetTabs(),
		);
		return $this->loadView('grundform', $data, false);
	}

	/**
	 * @returns
	 */
	public function fieldsetUnsicher()
	{
		$input = new MultiChoiceWidget('grundform_unsicher');
		$input->addChoice("unsicher", 'Grundform unsicher (nicht eindeutig zuordenbar)');
		return $input->getHtml();
	}

	public function fieldsetTabs()
	{
		$html .= '<div style="" id="grundform_tabs">'.PHP_EOL;
		$html .= '<ul>'.PHP_EOL;
		$html .= '<li><a href="#grundform-1">Grundform 1</a></li>'.PHP_EOL;
		$html .= '<li><a href="#grundform-2">Grundform 2</a></li>'.PHP_EOL;
		$html .= '<li><a href="#grundform-3">Grundform 3</a></li>'.PHP_EOL;
		$html .= '<li><a href="#grundform-4">Grundform 4</a></li>'.PHP_EOL;
		$html .= '<li><a href="#grundform-5">Grundform 5</a></li>'.PHP_EOL;
		$html .= '<li><a href="#grundform-6">Grundform 6</a></li>'.PHP_EOL;
		$html .= '<li><a href="#grundform-7">Grundform 7</a></li>'.PHP_EOL;
		$html .= '</ul>'.PHP_EOL;

		// Grundform 1 (G1).
		$html .= '<div id="grundform-1">'.PHP_EOL;
		$html .= '<h4>Grundform 1 (G1)</h4><p>Höhe &gt; &frac12; &ndash; 2 &times; Maximaldurchmesser;<br>Randdurchmesser &ge; &frac12; Bodendurchmesser</p>'.PHP_EOL;
		$input = new ChoiceWidget(self::IdGrundform, false);
		$input->addChoice('G1.1 Fass');
		$input->addChoice('G1.2 Helm');
		$input->addChoice('G1.2.1 Destillierhelm', false, false, 1);
		$input->addChoice('G1.2.1.1 Alembik', false, false, 2);
		$input->addChoice('G1.2.1.2 Rosenhut', false, false, 2);
		$input->addChoice('G1.2.2 Glocke', false, false, 1);
		$input->addChoice('G1.2.3 Sublimierhelm', false, false, 1);
		$input->addChoice('G1.3 Hoher Kessel');
		$input->addChoice('G1.4 Hoher Trichter');
		$input->addChoice('G1.5 Niedrige Kanne');
		$input->addChoice('G1.5.1 Bügelkanne', false, false, 1);
		$input->addChoice('G1.5.2 Doppelhenkelkanne', false, false, 1);
		$input->addChoice(self::ValueG_1_6, false, true);
		$input->addChoice('G1.6.1 Bügeltopf', false, false, 1);
		$input->addChoice('G1.6.2 Fußtopf', false, false, 1);
		$input->addChoice('G1.6.3 Gelochter Topf', false, false, 1);
		$input->addChoice('G1.6.4 Henkeltopf', false, false, 1);
		$input->addChoice('G1.6.5 Mehrfachtopf', false, false, 1);
		$input->addChoice('G1.6.6 Tiegel', false, false, 1);
		$html .= $input->getHtml();
		$html .= '</div>'.PHP_EOL;

		// Grundform 2 (G2).
		$html .= '<div id="grundform-2">'.PHP_EOL;
		$html .= '<h4>Grundform 2 (G2)</h4><p>Höhe &gt; 2 &times; Maximaldurchmesser;<br>Randdurchmesser &ge; &frac12; Bodendurchmesser</p>'.PHP_EOL;
		$input = new ChoiceWidget(self::IdGrundform, false);
		$input->addChoice('G2.1 Hohe Kanne');
		$input->addChoice('G2.2 Krug');
		$input->addChoice('G2.2.1 Walzenkrug');
		$html .= $input->getHtml();
		$html .= '</div>'.PHP_EOL;

		// Grundform 3 (G3).
		$html .= '<div id="grundform-3">'.PHP_EOL;
		$html .= '<h4>Grundform 3 (G3)</h4><p>Höhe &ge; Maximaldurchmesser;<br>Rand- und Halsdurchmesser &lt; &frac12; Maximaldurchmesser</p>'.PHP_EOL;
		$input = new ChoiceWidget(self::IdGrundform, false);
		$input->addChoice('G3.1 Flasche');
		$input->addChoice('G3.1.1 Flachflasche', false, false, 1);
		$input->addChoice('G3.1.1.1 Ösenflasche', false, false, 2);
		$input->addChoice('G3.1.1.2 Ringflasche', false, false, 2);
		$input->addChoice('G3.1.2 Henkelflasche', false, false, 1);
		$input->addChoice('G3.1.2.1 Rohrflasche', false, false, 2);
		$input->addChoice('G3.1.3 Kolben', false, false, 1);
		$input->addChoice('G3.1.4 Kugelflasche', false, false, 1);
		$input->addChoice('G3.1.4.1 Retorte', false, false, 2);
		$input->addChoice('G3.2 Schaftleuchter', false, false, 1);
		$html .= $input->getHtml();
		$html .= '</div>'.PHP_EOL;

		// Grundform 4 (G4).
		$html .= '<div id="grundform-4">'.PHP_EOL;
		$html .= '<h4>Grundform 4 (G4)</h4><p>Höhe &gt; &frac14; &ndash; &frac12; Maximaldurchmesser</p>'.PHP_EOL;
		$input = new ChoiceWidget(self::IdGrundform, false);
		$input->addChoice('G4.1 Hohldeckel');
		$input->addChoice('G4.1.1 Gelochter Hohldeckel', false, false, 1);
		$input->addChoice('G4.1.2 Zargenhohldeckel', false, false, 1);
		$input->addChoice('G4.2 Niedriger Kessel');
		$input->addChoice('G4.3 Niedriger Trichter');
		$input->addChoice('G4.4 Schale');
		$input->addChoice('G4.4.1 Fußschale', false, false, 1);
		$input->addChoice('G4.4.2 Gelochte Schale', false, false, 1);
		$input->addChoice('G4.4.3 Grifflappenschale', false, false, 1);
		$input->addChoice('G4.4.4 Henkelschale', false, false, 1);
		$input->addChoice('G4.4.5 Lampenschale', false, false, 1);
		$input->addChoice('G4.4.5.1 Tüllenlampenschale', 'G4.4.5.1 Tüllenlampensch.', false, 2);
		$input->addChoice('G4.5 Schüssel');
		$input->addChoice('G4.5.1 Bügelschüssel', false, false, 1);
		$input->addChoice('G4.5.2 Fußschüssel', false, false, 1);
		$input->addChoice('G4.5.3 Gelochte Schüssel', false, false, 1);
		$input->addChoice('G4.5.3.1 Muffel', false, false, 2);
		$input->addChoice('G4.5.4 Henkelschüssel', false, false, 1);
		$input->addChoice('G4.5.5 Mehrfachschüssel', false, false, 1);
		$input->addChoice('G4.5.6 Pfanne', false, false, 1);
		$input->addChoice('G4.5.6.1 Fußpfanne', false, false, 2);
		$input->addChoice('G4.5.7 Stegschüssel', false, false, 1);
		$html .= $input->getHtml();
		$html .= '</div>'.PHP_EOL;

		// Grundform 5 (G5).
		$html .= '<div id="grundform-5">'.PHP_EOL;
		$html .= '<h4>Grundform 5 (G5)</h4><p>Höhe &le; &frac14; Maximaldurchmesser</p>'.PHP_EOL;
		$input = new ChoiceWidget(self::IdGrundform, false);
		$input->addChoice('G5.1 Flachdeckel');
		$input->addChoice('G5.1.1 Gelochter Flachdeckel', false, false, 1);
		$input->addChoice('G5.1.2 Schraubdeckel', false, false, 1);
		$input->addChoice('G5.1.3 Steckdeckel', false, false, 1);
		$input->addChoice('G5.1.4 Stülpdeckel', false, false, 1);
		$input->addChoice('G5.2 Teller');
		$input->addChoice('G5.2.1 Platte', false, false, 1);
		$input->addChoice('G5.2.1.1 Flachpfanne', false, false, 2);
		$html .= $input->getHtml();
		$html .= '</div>'.PHP_EOL;

		// Grundform 6 (G6).
		$html .= '<div id="grundform-6">'.PHP_EOL;
		$html .= '<h4>Grundform 6 (G6)</h4><p>proportional nicht definierbare Hohlformen</p>'.PHP_EOL;
		$input = new ChoiceWidget(self::IdGrundform, false);
		$input->addChoice('G6.1 Figurale Hohlform');
		$input->addChoice('G6.2 Geometrische Hohlform');
		$input->addChoice('G6.2.1 Hohlkugel', false, false, 1);
		$input->addChoice('G6.2.2 Hohlquader', false, false, 1);
		$input->addChoice('G6.2.3 Rohr', false, false, 1);
		$html .= $input->getHtml();
		$html .= '</div>'.PHP_EOL;

		// Grundform 7 (G7).
		$html .= '<div id="grundform-7">'.PHP_EOL;
		$html .= '<h4>Grundform 7 (G7)</h4><p>Massivformen</p>'.PHP_EOL;
		$input = new ChoiceWidget(self::IdGrundform, false);
		$input->addChoice('G7.1 Figurale Massivform');
		$input->addChoice('G7.1.1 Plastik', false, false, 1);
		$input->addChoice('G7.1.2 Relief', false, false, 1);
		$input->addChoice('G7.2 Geometrische Massivform');
		$input->addChoice('G7.2.1 Kegel(-stumpf)', false, false, 1);
		$input->addChoice('G7.2.2 Kugel', false, false, 1);
		$input->addChoice('G7.2.3 Pyramide(-nstumpf)', false, false, 1);
		$input->addChoice('G7.2.4 Quader', false, false, 1);
		$input->addChoice('G7.2.5 Zylinder', false, false, 1);
		$input->addChoice('G7.2.5.1 Ring', false, false, 2);
		$input->addChoice('G7.2.5.2 Scheibe', false, false, 2);
		$html .= $input->getHtml();
		$html .= '</div>'.PHP_EOL;

		$html .= '</div>'.PHP_EOL; // grundform_tabs

		return $html;
	}

	/** Returns long detailed description. */
	static public function longDescription()
	{
		return '';
	}

	/** Returns short formal description. */
	static public function shortDescription()
	{
		return '';
	}
}

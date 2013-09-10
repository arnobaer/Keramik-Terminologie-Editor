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


function get_table($table, $header = false)
{
	$html = '<table>'.PHP_EOL;
	foreach ($table as $row) {
		$html .= '<tr>'.PHP_EOL;
		foreach ($row as $column) {
			if ($header) {
				$header = false;
				$html .= "<th>{$column}</th>";
			} else {
				$html .= "<td>{$column}</td>";
			}
		}
	}
	return $html.'</table>'.PHP_EOL;
}

class ApplicationForm extends Controller
{
	const RequestReset = 'request_reset';
	const RequestSubmit = 'request_submit';

	private $post;
	private $session;
	private $munsell;

	public function __construct()
	{
		if (post(self::RequestReset)) {
			// Clears the whole POST array.
			$_POST = array();
		}

		$this->session = post('session') ? post('session') : uniqid();
		$this->munsell = new MunsellSoilColors();

		// Create the input accordion.
		$this->accordion = new AccordionWidget('accordion');
		$this->accordion->addSection(new SectionGrundlagen());
		$this->accordion->addSection(new SectionMagerung());
		$this->accordion->addSection(new SectionOberflaeche());
		$this->accordion->addSection(new SectionHerstellung());
		$this->accordion->addSection(new SectionBruch());
		$this->accordion->addSection(new SectionRandbereich());
		$this->accordion->addSection(new SectionWandbereich());
		$this->accordion->addSection(new SectionBodenbereich());
		$this->accordion->addSection(new SectionMassangaben());
		$this->accordion->addSection(new SectionFunktionselemente());
		$this->accordion->addSection(new SectionGebrauchsspuren());
		$this->accordion->addSection(new SectionGrundform());
		$this->accordion->addSection(new SectionErhaltungszustand());
	}

	public function showDescription() {
		return (bool)post(self::RequestSubmit);
	}

	// -------------------------------------------------------------------------
	//  Beschreibungsdetails
	// -------------------------------------------------------------------------

	public function getGrundformNummer() {
		$grundform = SectionGrundform::grundform();
		$grundform = explode(' ', $grundform ? $grundform : '');
		return (sizeof($grundform)) ? '('.$grundform[0].')' : 'ERROR';
	}

	public function getGrundformName() {
		$grundform = SectionGrundform::grundform();
		$grundform = explode(' ', $grundform ? $grundform : '');
		$name = array();
		for ($i = 1; $i < sizeof($grundform); $i++)
			$name[] = $grundform[$i];
		return implode(' ', sizeof($name) ? $name : array());
	}

	public function getBeschreibungLong() {
		$list = array();
		$list[] = SectionBodenbereich::longDescription();
		$list[] = SectionWandbereich::longDescription();
		$list[] = SectionRandbereich::longDescription();
		$list = ucfirst(implode('; ', array_filter($list)));

		// Sonderfall: Keine Randform noch Randkontur gewählt, aber Formalbeschreibung,
		// schließe Satz mit ".. Rand."
		$randform    = SectionRandbereich::randform();
		$randkontur  = SectionRandbereich::randkontur();
		$herstellung = SectionRandbereich::herstellung();
		$formal      = SectionRandbereich::formalbeschreibung();
// 		if ((!$randform and !$randkontur) and ($herstellung or $formal))
// 			$list .= " Rand";

		return $list ? "<strong>Beschreibung:</strong> {$list}.<br>" : '';
	}

	public function get_IdGebrauchsspuren_long() {
		$IdGebrauchsspuren = SectionGebrauchsspuren::longDescription();
		return $IdGebrauchsspuren ? "<strong>Gebrauchsspuren:</strong> ".$IdGebrauchsspuren.".<br>".PHP_EOL : '';
	}

	public function getHerstellungsspurenShort() {
		return SectionHerstellung::shortDescription();
	}

	public function getHerstellungsspurenLong() {
		$marks = SectionHerstellung::longDescription();
		return $marks ? "<strong>Herstellungsspuren:</strong> $marks.<br>".PHP_EOL : '';
	}

	public function getFunktionselementeLong() {
		$list = SectionFunktionselemente::longDescription();
		return $list ? "<strong>Funktionselemente:</strong> {$list}.<br>" : '';
	}

	public function getSekundaereVeraenderungenShort() {
		$spuren = SectionHerstellung::sekundaereVeraenderungen();
		return $spuren ? lcfirst(rtrim($spuren, '.')) : '';
	}

	public function getSekundaereVeraenderungenLong() {
		$spuren = $this->getSekundaereVeraenderungenShort();
		return $spuren ? "<strong>Sekundäre Veränderungen:</strong> ".ucfirst($spuren).".<br>".PHP_EOL : '';
	}

	public function getMagerungsart() {
		$ending = SectionGrundlagen::isIrdenware() ? 'e' : 'es';
		$magerungsart = SectionMagerung::magerungsart();
		return $magerungsart ? $magerungsart.$ending : '';
	}

	public function getMagerungstypen() {
		$typen = SectionMagerung::magerungstyp();
		return implode(', ', is_array($typen) ? $typen : array());
	}

	public function getKorngroesseInline() {
		$size = SectionMagerung::korngroesse();
		$size = str_replace('fein', 'feine', $size);
		$size = str_replace('mittel', 'mittelgroße', $size);
		$size = str_replace('grob', 'grobe', $size);
		return $size;
	}

	public function getMagerungLong() {
		$magerung = SectionMagerung::longDescription();
		return $magerung ? "<strong>Magerung:</strong> $magerung.<br>".PHP_EOL : '';
	}

	public function getOberflaecheLong() {
		$oberflaeche = SectionOberflaeche::longDescription();
		return $oberflaeche ? "<strong>Oberfläche:</strong> $oberflaeche.<br>".PHP_EOL : '';
	}

	public function getBruchstrukturLong() {
		$fracture = SectionBruch::longDescription();
		return $fracture ? "<strong>Bruchstruktur:</strong> $fracture.<br>".PHP_EOL : '';
	}

	public function getScherbenhaerteLong() {
		$hardness = SectionOberflaeche::scherbenhaerte();
		return $hardness ? "<strong>Scherbenhärte:</strong> $hardness.<br>".PHP_EOL : '';
	}

	// -------------------------------------------------------------------------
	//  Massangaben
	// -------------------------------------------------------------------------

	public function getMasseLong()
	{
		$dimensions = SectionMassangaben::longDescription();
		return $dimensions ? "<strong>Maße:</strong> $dimensions.<br>".PHP_EOL : '';
	}

	public function getLongDescription()
	{
		$unsicher = SectionGrundform::unsicher();
		$unsicher = $unsicher ? ' (?)' : '';
		$html = '<strong>Form:</strong> '.
			$this->getGrundformName()."{$unsicher} ".
			$this->getGrundformNummer().SectionErhaltungszustand::longDescription().'<br>'.PHP_EOL;

		$html .= $this->getBeschreibungLong();
		$html .= $this->get_IdGebrauchsspuren_long();
		$html .= $this->getMasseLong();

		$list = array();
		$html .= '<strong>Keramikart:</strong> ';
		$magerungsart = $this->getMagerungsart();
		$list[] = $magerungsart;
		$forming = SectionHerstellung::formgebung();
		if ($forming) $list[] = "{$forming}e";

		$primary_burning = SectionHerstellung::primaerbrand();
		$ending = SectionGrundlagen::isIrdenware() ? 'e' : 'es';
		if ($primary_burning) $list[] = "{$primary_burning}{$ending}";
		$list = implode(', ', array_filter($list));
		$html .= ucfirst((($list) ? "$list " : '').SectionGrundlagen::keramikgattung());
		$html .= '.<br>';

		$html .= $this->getHerstellungsspurenLong();
		$html .= $this->getFunktionselementeLong();
		$html .= $this->getSekundaereVeraenderungenLong();
		$html .= SectionHerstellung::longColorDescription();
		$html .= $this->getMagerungLong();
		$html .= $this->getOberflaecheLong();
		$html .= $this->getBruchstrukturLong();
		$html .= $this->getScherbenhaerteLong();

		return $html;
	}

	public function getShortDescription()
	{
		// TODO: this must be cleaned up... seriously.

		$html = array();

		$unsicher = SectionGrundform::unsicher();
		$unsicher = $unsicher ? ' (?)' : '';
		$html[] = $this->getGrundformName()."{$unsicher} ".$this->getGrundformNummer().SectionErhaltungszustand::shortDescription();

		$intro = array();
		$herstellung = $this->getHerstellungsspurenShort();
		if ($herstellung) $intro[] = $herstellung;
		$veraenderung = $this->getSekundaereVeraenderungenShort();
		if ($veraenderung) $intro[] = $veraenderung;
		$intro = implode('; ', $intro);
		if ($intro) $html[] = $intro;

		$list = array();
		$list[] = $this->getMagerungsart();

		$primaerbrand = SectionHerstellung::primaerbrand();
		$ending = SectionGrundlagen::isIrdenware() ? 'e' : 'es';
		if ($primaerbrand) $list[] = "{$primaerbrand}{$ending}";

		$list = implode(', ', $list);
		$magerung = (($list) ? "$list " : '').SectionGrundlagen::keramikgattung();

		$farbe = SectionHerstellung::shortColorDescription();
		if ($farbe) $magerung .= " $farbe";

		$magerung2 = array();

		$menge = SectionMagerung::menge();
		if ($menge) $magerung2[] = $menge;

		$korngroesse = $this->getKorngroesseInline();
		if ($korngroesse) $magerung2[] = $korngroesse;

		$magerung2 = implode(', ', $magerung2);
		if ($magerung2) $magerung .= ", ".$magerung2." Magerungsanteile";

		$magerungstyp = $this->getMagerungstypen();
		if ($magerungstyp) $magerung .= " ({$magerungstyp})";
		// Havoc...
		$magerung = $magerung ? array($magerung) : array();
		$magerung[] = SectionOberflaeche::shortDescription();
		$html[] = implode(', ', array_filter($magerung));

		$html[] = SectionMassangaben::shortDescription();

		return implode('; ', array_filter($html)).'.';
	}

	public function getGenerateDescription()
	{
		if ($this->showDescription()) {
			$html  = '<div class="description">'.PHP_EOL;
			$html .= '<h4>Detailierte Beschreibung</h4>'.PHP_EOL;
			$html .= "<div>".$this->getLongDescription().'</div>'.PHP_EOL;
			$html .= '</div>'.PHP_EOL;

			$html .= '<div class="description">'.PHP_EOL;
			$html .= '<h4>Kurzbeschreibung</h4>'.PHP_EOL;
			$html .= "<div>".$this->getShortDescription().'</div>'.PHP_EOL;
			$html .= '</div>'.PHP_EOL;
			return $html;
		}
		return '';
	}

	public function run()
	{
		$data = array(
			'url' => get_url(),
			'anchor' => 'beschreibung',
			'session' => $this->session,
			'description' => $this->getGenerateDescription(),
			'accordion' => $this->accordion->getHtml(),
			'submit_name' => self::RequestSubmit,
			'reset_name' => self::RequestReset,
		);
		$this->loadView('application_form', $data);
	}
}


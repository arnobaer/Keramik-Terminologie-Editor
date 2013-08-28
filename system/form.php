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

class Request
{
	const Reset = 'request_reset';
	const Submit = 'request_submit';
}

class Id
{
	const Grundform = 'grundform';
}

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

const VERSION = 'Version 0.21, 2013/03/2, unstable';

class Form {

	private $post;
	private $session;
	private $munsell;

	public function __construct() {
		$this->initPost();
		if ($this->getPost(Request::Reset)) {
			$this->post = array();
			$_POST = array();
		}
		$this->session = $this->getPost('session') ? $this->getPost('session') : uniqid();
		$this->munsell = new MunsellSoilColors();

		// Create accordion sections.
		$section_basics       = new SectionBasics();
		$section_fracture     = new SectionFracture();
		$section_border       = new SectionBorder();
		$section_wall         = new SectionWall();
		$section_bottom       = new SectionBottom();
		$section_functionals  = new SectionFunctionals();
		$section_usewear      = new SectionUsewear();
		$section_condition    = new SectionCondition();

		// Create the input accordion.
		$this->accordion = new Accordion('accordion');
		$this->accordion->add_section($section_basics);
		$this->accordion->add_section($section_fracture);
		$this->accordion->add_section($section_border);
		$this->accordion->add_section($section_wall);
		$this->accordion->add_section($section_bottom);
		$this->accordion->add_section($section_functionals);
		$this->accordion->add_section($section_usewear);
		$this->accordion->add_section($section_condition);
	}

	// Init post list with secured copy of _POST array.
	private function initPost() {
		$this->post = $_POST;
		$this->stripList($this->post);
	}

	// Recursive strip list keys and values from harmfull injection code.
	private function stripList(&$list) {
		foreach ($list as &$value) {
			$value = is_array($value) ? $this->stripList($value) : strip_tags($value);
		}
		return $list;
	}

	// Get POST value or false if does not exist.
	public function getPost($key) {
		return isset($this->post[$key]) ? $this->post[$key] : false;
	}

	public function getUrl() {
		$url = $_SERVER["REQUEST_URI"];
		return $url;
	}

	public function replaceLastOccurence($search, $replace, &$subject) {
		$pos = strrpos($subject, $search);
		if($pos !== false) {
		    $subject = substr_replace($subject, $replace, $pos, strlen($search));
		}
		return $subject;
	}

	public function showDescription() {
		return (bool)$this->getPost(Request::Submit);
	}

	public function getSection($name, $page = false, $content = false) {
		return
			"<h3>{$name}".($page ? " <em>Seite {$page}</em>": '')."</h3>".PHP_EOL.
			($content ? "<div>{$content}</div>".PHP_EOL : '');
	}

	public function getTextInput($key, $label = false, $format = false, $style = '') {
		$label = $label ? $label : '';
		$value = $this->getPost($key);
		$value = $value ? $value : '';
		$id = strtolower(str_replace(' ', '_', "text_{$key}"));
		$style = $style ? ' style="'.$style.'"':'';
		return ($label ? "<label for=\"{$id}\">$label</label>" : '')."<input{$style} id=\"{$id}\" type=\"text\" name=\"{$key}\" value=\"{$value}\">".($format ? '<em style="font-size:.75em;"><div>Format: '.$format.'</div></em>' : '');
	}

	public function getTextArea($key, $label = false) {
		$label = $label ? $label : '';
		$value = $this->getPost($key);
		$value = $value ? $value : '';
		$id = explode(' ', strtolower(str_replace(' ', '_', "textarea_{$key}")));
		$id = $id[0];
		return ($label ? "<label for=\"{$id}\">$label</label>" : '')."<textarea id=\"{$id}\" style=\"width: 100%;\" name=\"{$key}\">{$value}</textarea>";
	}

	protected function addPost(&$array, $name) {
		$value = $this->getPost($name);
		if ($value) $array[] = $value;
	}

	protected function getBox($title, $payload, $fieldset = true) {
		$html  = '<div class="" style="float:left;display:block;margin-right:20px;">'.PHP_EOL;
		$html .= "<h4>{$title}</h4>".PHP_EOL;
		$html .= '<p>'.PHP_EOL;
// 		$html .= $fieldset ? '<fieldset>'.PHP_EOL : '';
		$html .= $payload.PHP_EOL;
// 		$html .= $fieldset ? '</fieldset>'.PHP_EOL : '';
		$html .= '</p>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;
		return $html;
	}

	// -------------------------------------------------------------------------
	//  Texteingabe Filter
	// -------------------------------------------------------------------------

	public function getCentimeters($input, $suffix = 'cm') {
		$input = str_replace(',', '.', $input); // Normalize comma.
		preg_match_all('!\d+(?:\.\d+)?!', $input, $matches);
		return (sizeof($matches[0]) ? (str_replace('.', ',', round($matches[0][0], 1)).($suffix ? " {$suffix}" : '')) : false);
	}

	public function getCentimeterRange($input, $suffix = 'cm') {
		$input = str_replace(',', '.', $input); // Normalize comma.
		preg_match_all('!\d+(?:\.\d+)?!', $input, $matches);
		return (sizeof($matches[0]) ? str_replace('.', ',', (sizeof($matches[0]) > 1) ? round($matches[0][0], 1).'&ndash;'.$matches[0][1] : round($matches[0][0], 1)).($suffix ? " {$suffix}" : '') : false);
	}

	public function getPercent($input, $suffix = '%') {
		$input = str_replace(',', '.', $input); // Normalize comma.
		preg_match_all('!\d+(?:\.\d+)?!', $input, $matches);
		return (sizeof($matches[0]) ? (str_replace('.', ',', round($matches[0][0], 1)).($suffix ? "{$suffix}" : '')) : false);
	}

	public function getMunsellColor($input) {
		$input = str_replace(' ', '', trim(strtoupper($input))); // strip any spaces.
		$input = str_replace(',', '.', $input); // commas to dots.
		preg_match_all('!(\d{1,2}(?:GB|GY|YR|B|G|R|Y))(\d(?:\.5)?\/\d)!', $input, $matches);
		return sizeof($matches[0]) ? $matches[1][0].' '.$matches[2][0] : false;
	}

	public function getRalColor($input) {
		$input = str_replace(' ', '', trim(strtoupper($input))); // strip any spaces.
		preg_match_all('!(RAL)(\d{4})!', $input, $matches);
		return sizeof($matches[0]) ? $matches[1][0].' '.$matches[2][0] : false;
	}

	public function getNamedColor($input) {
		$input = str_replace('  ', ' ', trim($input)); // strip double spaces.
		foreach ($this->munsell->dict as $en => $de) {
			if ($input == $en or $input == $de)
				return $input;
		}
		return false;
	}

	public function getCleanColor($name, &$valid, &$munsell) {
		$valid = true;
		$munsell = true;
		$input = isset($_POST[$name]) ? $_POST[$name] : false;
		if (!$input) return '';
		$color = $this->getMunsellColor($input);
		if ($color)
			return $color;
		$munsell = false;
		$color = $this->getRalColor($input);
		if ($color)
			return $color;
		$color = $this->getNamedColor($input);
		if ($color)
			return $color;
		$valid = false;
		return $input;
	}

	public function getColors($name1, $name2) {
		$color1 = $this->getCleanColor($name1, $valid1, $munsell1);
		$color2 = $this->getCleanColor($name2, $valid2, $munsell2);
		if ($color1 == $color2) $color2 = false;
		$html = '';
		if ($color1 and $color2) {
			$name1 = '';
			$name2 = '';
			if ($munsell1) {
				$en = $this->munsell->getName($color1);
				$de = $this->munsell->getTranslation($en);
				$name1 = ($de?"$de":'');
				$name2 = "$color1".($en?" $en":'');
			}
			else {
				$name1 = ($de?"$de ":'');
				$name1 = $color1;
			}
			if ($munsell2) {
				$en = $this->munsell->getName($color2);
				$de = $this->munsell->getTranslation($en);
				$name1 .= " bis ".($de?"$de":'');
				$name2 .= " bis $color2".($en?" $en":'');
			}
			else {
				$name1 .= " bis $color2";
			}
			$name3 = explode(' ', $name1); // Prevent double naming.
			if (sizeof($name3) > 2)
				if ($name3[0] == $name3[2])
					$name1 = $name3[0];
			return "$name1".($name2?" ($name2)":'');
		}
		if ($color1) {
			if ($munsell1) {
				$en = $this->munsell->getName($color1);
				$de = $this->munsell->getTranslation($en);
				$html = ($de?"$de ":'')."($color1".($en?" $en":'').')';
			}
			else
				$html = $color1;
		}
		return $html;
	}

	// -------------------------------------------------------------------------
	//  Beschreibungsdetails
	// -------------------------------------------------------------------------

	public function getGrundformNummer() {
		$grundform = $this->getPost(Id::Grundform);
		$grundform = explode(' ', $grundform ? $grundform : '');
		return (sizeof($grundform)) ? '('.$grundform[0].')' : 'ERROR';
	}

	public function getGrundformName() {
		$grundform = $this->getPost(Id::Grundform);
		$grundform = explode(' ', $grundform ? $grundform : '');
		$name = array();
		for ($i = 1; $i < sizeof($grundform); $i++)
			$name[] = $grundform[$i];
		return implode(' ', sizeof($name) ? $name : array());
	}

	public function getBeschreibungLong() {
		$list = array();
		$list[] = SectionBottom::get_long_description();
		$list[] = SectionWall::get_long_description();
		$list[] = SectionBorder::get_long_description();
		$list = ucfirst(implode('; ', array_filter($list)));

		// Sonderfall: Keine Randform noch Randkontur gewählt, aber Formalbeschreibung,
		// schließe Satz mit ".. Rand."
		$shape    = post(SectionBorder::KEY_BORDER_SHAPE);
		$contour  = post(SectionBorder::KEY_BORDER_CONTOUR);
		$assembly = post(SectionBorder::KEY_BORDER_ASSEMBLY);
		$formal   = post(SectionBorder::KEY_BORDER_FORMAL);
		if ((!$shape and !$contour) and ($assembly or $formal))
			$list .= " Rand";

		return $list ? "<strong>Beschreibung:</strong> {$list}.<br>" : '';
	}

	public function get_usewear_long() {
		$usewear = SectionUsewear::get_long_description();
		return $usewear ? "<strong>Gebrauchsspuren:</strong> ".$usewear.".<br>".PHP_EOL : '';
	}

	public function getHerstellungsspurenShort() {
		$all = array();
		$weich = $this->getPost('herstellungsspuren_weich');
		$lederhart = $this->getPost('herstellungsspuren_lederhart');
		$brandbedingt = $this->getPost('herstellungsspuren_brandbedingt');
		if ($weich) $all[] = implode(', ', $weich ? $weich : array());
		if ($lederhart) $all[] = implode(', ', $lederhart ? $lederhart : array());
		if ($brandbedingt) $all[] = implode(', ', $brandbedingt ? $brandbedingt : array());
		return implode(', ', $all);
	}

	public function getHerstellungsspurenLong() {
		$spuren = ucfirst($this->getHerstellungsspurenShort());
		return $spuren ? "<strong>Herstellungsspuren:</strong> $spuren.<br>".PHP_EOL : '';
	}

	public function getFunktionselementeLong() {
		$list = SectionFunctionals::get_long_description();
		return $list ? "<strong>Funktionselemente:</strong> {$list}.<br>" : '';
	}

	public function getSekundaereVeraenderungenShort() {
		$spuren = $this->getPost('sekundaere_veraenderungen');
		return $spuren ? lcfirst(rtrim($spuren, '.')) : '';
	}

	public function getSekundaereVeraenderungenLong() {
		$spuren = $this->getSekundaereVeraenderungenShort();
		return $spuren ? "<strong>Sekundäre Veränderungen:</strong> ".ucfirst($spuren).".<br>".PHP_EOL : '';
	}

	public function getMagerungsart() {
		$ending = ($this->getPost('basics_ceramic_category') == 'Irdenware' ? 'e' : 'es');
		$magerungsart = $this->getPost('magerungsart');
		return $magerungsart ? $magerungsart.$ending : '';
	}

	public function getMagerungstypen() {
		$typen = $this->getPost('magerungstyp');
		return implode(', ', is_array($typen) ? $typen : array());
	}

	public function getKorngroesseInline() {
		$size = $this->getPost('korngroesse');
		$size = str_replace('fein', 'feine', $size);
		$size = str_replace('mittel', 'mittelgroße', $size);
		$size = str_replace('grob', 'grobe', $size);
		return $size;
	}

	public function getScherbenfarbeLong() {
		$farbe = array();

		$aussen = $this->getColors('farbe_aussen', 'farbe_aussen_2');
		$farbverteilung1 = $this->getPost('farbverteilung_aussen');
		if ($aussen and $farbverteilung1) $aussen .= ", {$farbverteilung1}";
		if ($aussen) $farbe[] = "Oberfläche außen: {$aussen}";

		$bruch = $this->getColors('farbe_bruch', 'farbe_bruch_2');
		$farbverteilung2 = $this->getPost('farbverteilung_bruch');
		if ($bruch and $farbverteilung2) $bruch .= ", {$farbverteilung2}";
		if ($bruch) $farbe[] = "Bruch: {$bruch}";

		$innen = $this->getColors('farbe_innen', 'farbe_innen_2');
		$farbverteilung3 = $this->getPost('farbverteilung_innen');
		if ($innen and $farbverteilung3) $innen .= ", {$farbverteilung3}";
		if ($innen) $farbe[] = "Oberfläche innen: {$innen}";
		$farbe = implode('; ', $farbe);
		$paragraph = $this->getPost('fragment') == 'vollständig erh.' ? 'Farbe' : 'Scherbenfarbe';
		return $farbe ? "<strong>{$paragraph}:</strong> {$farbe}.<br>".PHP_EOL : '';
	}

	public function getScherbenfarbeShort() {
		$farbe = array();
		$aussen = $this->getCleanColor('farbe_aussen', $foo, $bar);
		$aussen2 = $this->getCleanColor('farbe_aussen_2', $foo, $bar);
		if ($aussen and $aussen2) $aussen .= " bis {$aussen2}";
		if ($aussen) $farbe[] = "außen: {$aussen}";
		$bruch = $this->getCleanColor('farbe_bruch', $foo, $bar);
		$bruch2 = $this->getCleanColor('farbe_bruch_2', $foo, $bar);
		if ($bruch and $bruch2) $bruch .= " bis {$bruch2}";
		if ($bruch) $farbe[] = "Bruch: {$bruch}";
		$innen = $this->getCleanColor('farbe_innen', $foo, $bar);
		$innen2 = $this->getCleanColor('farbe_innen_2', $foo, $bar);
		if ($innen and $innen2) $innen .= " bis {$innen2}";
		if ($innen) $farbe[] = "innen: {$innen}";
		$farbe = implode(', ', $farbe);
		return $farbe ? "({$farbe})" : '';
	}

	public function getMagerungLong() {
		$magerung1 = array();
		$temp = $this->getPost('magerungsmenge');
		if ($temp) $magerung1[] = "{$temp} Magerungsanteile";
		$temp = $this->getPost('korngroesse');
		if ($temp) $magerung1[] = "Korngröße {$temp}";
		$temp = $this->getPost('magerungssortierung');
		if ($temp) $magerung1[-1] = " ({$temp})";
		$temp = $this->getPost('magerungsform');
		if ($temp) $magerung1[] = ($this->getPost('magerungsform_vorwiegend')? 'vorwiegend ' : '')."{$temp}";
		$temp = $this->getPost('magerungsverteilung');
		if($temp) $magerung1[] = $temp;
		$temp = $this->getPost('magerungsverteilung_anmerkung');
		if ($this->getPost('magerungsverteilung') and $temp) $magerung1[-1] = " ({$temp})";

		$magerung2 = array();
		$temp = $this->replaceLastOccurence(', ', ' und ', $this->getMagerungstypen());
		if ($temp) $magerung2[] = $temp;
		$temp = $this->getPost('magerungstyp_anmerkung');
		if ($this->getPost('magerungstyp') and $temp) $magerung2[] = $temp;
		$magerung = implode(', ', $magerung1);
		$magerung .= (sizeof($magerung2)) ? ($magerung ? "; " : '').implode(', ', $magerung2) : '';
		$magerung = ucfirst($magerung);

		return $magerung ? "<strong>Magerung:</strong> $magerung.<br>".PHP_EOL : '';
	}

	public function getOberflaecheLong() {
		$list = array();
		$oberflaeche = $this->getPost('oberflaechenstruktur');
		$oberflaeche = implode(', ', $oberflaeche ? $oberflaeche : array());
		if ($oberflaeche) $list[] = $oberflaeche;
		$temp = $this->getPost('oberflaechenstruktur_anmerkung');
		if ($temp) $list[] = $temp;
		$oberflaeche = implode(', ', $list);
		if ($this->getPost('oberflaechenstruktur_overwrite'))
			$oberflaeche = $temp;
		$oberflaeche = ucfirst($oberflaeche);
		return $oberflaeche ? "<strong>Oberfläche:</strong> $oberflaeche.<br>".PHP_EOL : '';
	}

	public function getBruchstrukturLong() {
		$fracture = SectionFracture::get_long_description();
		return $fracture ? "<strong>Bruchstruktur:</strong> $fracture.<br>".PHP_EOL : '';
	}

	public function getScherbenhaerteLong() {
		$hardness = $this->getPost('scherbenhaerte');
		$hardness = ucfirst($hardness);
		return $hardness ? "<strong>Scherbenhärte:</strong> $hardness.<br>".PHP_EOL : '';
	}

	// -------------------------------------------------------------------------
	//  Massangaben
	// -------------------------------------------------------------------------

	public function getRanddurchmesser() {
		$cm = $this->getCentimeters($this->getPost('randdurchmesser'));
		return $cm ? ("Randdm. {$cm}") : '';
	}

	public function getMaximaldurchmesser() {
		$cm = $this->getCentimeters($this->getPost('maximaldurchmesser'));
		return $cm ? ("max. Dm. {$cm}") : '';
	}

	public function getBodendurchmesser() {
		$cm = $this->getCentimeters($this->getPost('bodendurchmesser'));
		return $cm ? ("Bodendm. {$cm}") : '';
	}

	public function getWandstaerke() {
		$cm = $this->getCentimeterRange($this->getPost('wandstaerke'));
		return $cm ? ("Wandst. {$cm}") : '';
	}

	public function getHoehe() {
		$cm = $this->getCentimeters($this->getPost('hoehe'));
		$zustand = $this->getPost('condition_fragmentation');
		$erh = ($zustand == 'vollständig erh.' or $zustand == '') ? '' : 'erh. ';
		return $cm ? ("{$erh}H. {$cm}") : '';
	}

	public function getRanderhalt() {
		$percent = $this->getPercent($this->getPost('randerhalt'));
		return $percent ? ("{$percent} Randerhalt") : '';
	}

	public function getMasseLong() {
		$html = array();
		$temp = $this->getHoehe();
		if ($temp) $html[] = $temp;
		$temp = $this->getRanddurchmesser();
		$temp2 = $this->getRanderhalt();
		if ($temp and $temp2) $temp .= " ({$temp2})";
		if ($temp) $html[] = $temp;
		$temp = $this->getMaximaldurchmesser();
		if ($temp) $html[] = $temp;
		$temp = $this->getBodendurchmesser();
		if ($temp) $html[] = $temp;
		$temp = $this->getWandstaerke();
		if ($temp) $html[] = $temp;
		$html = implode(', ', $html);
		return $html ? "<strong>Maße:</strong> $html.<br>".PHP_EOL : '';
	}

	public function getLongDescription() {
		$unsicher = $this->getPost('grundform_unsicher');
		$unsicher = $unsicher ? ' (?)' : '';
		$html = '<strong>Form:</strong> '.
			$this->getGrundformName()."{$unsicher} ".
			$this->getGrundformNummer().SectionCondition::get_long_description().'<br>'.PHP_EOL;

		$html .= $this->getBeschreibungLong();
		$html .= $this->get_usewear_long();
		$html .= $this->getMasseLong();

		$list = array();
		$html .= '<strong>Keramikart:</strong> ';
		$magerungsart = $this->getMagerungsart();
		if ($magerungsart) $list[] = $magerungsart;
		$primaerbrand = $this->getPost('primaerbrand');
		$ending = ($this->getPost('basics_ceramic_category') == 'Irdenware' ? 'e' : 'es');
		if ($primaerbrand) $list[] = "{$primaerbrand}{$ending}";
		$list = implode(', ', $list);
		$html .= ucfirst((($list) ? "$list " : '').$this->getPost('basics_ceramic_category'));
		$html .= '.<br>';

		$html .= $this->getHerstellungsspurenLong();
		$html .= $this->getFunktionselementeLong();
		$html .= $this->getSekundaereVeraenderungenLong();
		$html .= $this->getScherbenfarbeLong();
		$html .= $this->getMagerungLong();
		$html .= $this->getOberflaecheLong();
		$html .= $this->getBruchstrukturLong();
		$html .= $this->getScherbenhaerteLong();

		return $html;
	}

	public function getShortDescription() {
		$html = array();

		$unsicher = $this->getPost('grundform_unsicher');
		$unsicher = $unsicher ? ' (?)' : '';
		$html[] = $this->getGrundformName()."{$unsicher} ".$this->getGrundformNummer().SectionCondition::get_short_description();

		$intro = array();
		$herstellung = $this->getHerstellungsspurenShort();
		if ($herstellung) $intro[] = $herstellung;
		$veraenderung = $this->getSekundaereVeraenderungenShort();
		if ($veraenderung) $intro[] = $veraenderung;
		$intro = implode('; ', $intro);
		if ($intro) $html[] = $intro;

		$list = array();
		$list[] = $this->getMagerungsart();

		$primaerbrand = $this->getPost('primaerbrand');
		$ending = ($this->getPost('basics_ceramic_category') == 'Irdenware' ? 'e' : 'es');
		if ($primaerbrand) $list[] = "{$primaerbrand}{$ending}";
		$list = implode(', ', $list);
		$magerung = (($list) ? "$list " : '').$this->getPost('basics_ceramic_category');
		$farbe = $this->getScherbenfarbeShort();
		if ($farbe) $magerung .= " $farbe";
		$magerung2 = array();
		$temp = $this->getPost('magerungsmenge');
		if ($temp) $magerung2[] = $temp;
		$temp = $this->getKorngroesseInline();
		if ($temp) $magerung2[] = $temp;
		$magerung2 = implode(', ', $magerung2);
		if ($magerung2) $magerung .= ", ".$magerung2." Magerungsanteile";
		$temp = $this->getMagerungstypen();
		if ($temp) $magerung .= " ({$temp})";
		// Havoc...
		$magerung = $magerung ? array($magerung) : array();
		$temp = $this->getPost('scherbenhaerte');
		if ($temp) $magerung[] = "{$temp} gebrannt";
		if (sizeof($magerung)) $html[] = implode(', ', $magerung);

		$masse = array();
		$temp = $this->getHoehe();
		if ($temp) $masse[] = $temp;
		$temp = $this->getRanddurchmesser();
		if ($temp) $masse[] = $temp;
		$temp = $this->getMaximaldurchmesser();
		if ($temp) $masse[] = $temp;
		$temp = $this->getBodendurchmesser();
		if ($temp) $masse[] = $temp;
		$temp = $this->getWandstaerke();
		if ($temp) $masse[] = $temp;
		if (sizeof($masse)) $html[] = implode(', ', $masse);

		return implode('; ', $html).'.';
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

	public function getSectionGrundlagen()
	{
		$input = new Choice('basics_ceramic_category', false);
		$input->addChoice('Irdenware', false, true);
		$input->addChoice('Fayence');
		$input->addChoice('Steingut');
		$input->addChoice('Steinzeug');
		$input->addChoice('Porzellan');

		$table = get_table(
			array(
				array('<h4>Keramikgattung</h4>'),
				array($input->getHtml()),
			)
		);

		return $this->getSection('Grundlagen', 10, $table);
	}

	public function getSectionMagerung()
	{
		$input = new Choice('magerungsart');
		$input->addChoice('sandgemagert', 'sandhaltig/sandgemagert');
		$input->addChoice('steinchengemagert', 'steinchenhaltig/steinchengemagert');
		$magerungsart = $input->getHtml();

		$input = new MultiChoice('magerungstyp');
		$input->addChoice('Glimmer');
		$input->addChoice('Grafit');
		$input->addChoice('Karbonat');
		$input->addChoice('Quarz/Feldspat');
		$input->addChoice('Schamotte');
		$input->addChoice('Scherbenmehl');
		$input->addChoice('Eisenoxydkongretion');
		$input->addChoice('Tongerölle');
		$input->addChoice('Schlacke');
		$input->addChoice('Vegetabiles Material');
		$magerungstyp = '<div style="marin-top: 1px;">'.$input->getHtml().'</div>';

		$magerungstyp_anmerkung = $this->getTextInput('magerungstyp_anmerkung', '<strong>Anmerkung</strong> (optional)', '&lt;Auswahl&gt;[, &lt;Anmerkung&gt;].');

		$input = new Choice('korngroesse');
		$input->addChoice('fein', 'fein: &lt; 0,20 mm');
		$input->addChoice('fein bis mittel', 'fein bis mittel: &lt; 0,20&ndash;0,63 mm');
		$input->addChoice('mittel', 'mittel: 0,20&ndash;0,63 mm');
		$input->addChoice('mittel bis grob', 'mittel bis grob: 0,20&ndash;2,0 mm');
		$input->addChoice('grob', 'grob: 0,64&ndash;2,0 mm');
		$input->addChoice('sehr grob', 'sehr grob: &gt; 2,0 mm');
		$korngroesse = $input->getHtml();

		$input = new Choice('magerungssortierung');
		$input->addChoice('gut sortiert');
		$input->addChoice('mittelmäßig sortiert');
		$input->addChoice('schlecht sortiert');
		$magerungssortierung = $input->getHtml();

		$input = new Choice('magerungsmenge');
		$input->addChoice('wenige', 'wenige Magerungsanteile, &le;30%');
		$input->addChoice('viele', 'viels Magerungsanteile, &gt;30%');
		$magerungsmenge = $input->getHtml();

		$input = new Choice('magerungsverteilung');
		$input->addChoice('homogene Verteilung', 'gleichmäßig/homogen');
		$input->addChoice('inhomogene Verteilung', 'ungleichmäßig/inhomogen');
		$input->addChoice('Verteilung mit Struktur', 'mit Struktur');
		$magerungsverteilung = $input->getHtml();
		$magerungsverteilung_anmerkung = $this->getTextInput('magerungsverteilung_anmerkung', '<strong>Anmerkung</strong> (optional zur Angabe)', '&lt;Auswahl&gt;[, &lt;Anmerkung&gt;].');
		$magerungsverteilung .= '<div style="margin-top:10px;">'.$magerungsverteilung_anmerkung.'</div>';

		$input = new Choice('magerungsform');
		$input->addChoice('gerundete Partikel', 'gerundet');
		$input->addChoice('kantike Partikel', 'kantig');
		$input->addChoice('nadelförmige Partikel', 'nadelförmig');
		$magerungsform = $input->getHtml();

		$input = new MultiChoice('magerungsform_vorwiegend');
		$input->addChoice('vorwiegend', 'vorwiegend diese Form');
		$magerungsform .= '<div style="margin-top:10px;">'.$input->getHtml().'</div>';

		$table = get_table(
			array(
				array('<h4>Magerungsart</h4>', '', ''),
				array($magerungsart, '', ''),
				array($magerungstyp, "<div>{$magerungstyp_anmerkung}</div>", ''),
				array('<h4>Korngröße</h4>', '<h4>Magerungssortierung</h4>', '<h4>Magerungsmenge</h4>'),
				array($korngroesse, $magerungssortierung, $magerungsmenge),
				array('<h4>Magerungsverteilung</h4>', '<h4>Magerungsform</h4>', ''),
				array($magerungsverteilung, $magerungsform, ''),
			)
		);

		return $this->getSection('Magerung', 12, $table);
	}

	public function run() {
		$url = $this->getUrl();

// 		if ($this->getPost('accordion_active')) {


		echo $this->getGenerateDescription();

		echo "<form action=\"{$url}\" method=\"post\">".PHP_EOL;
		echo "<input type=\"hidden\" name=\"session\" value=\"{$this->session}\">".PHP_EOL;
		echo "<input id=\"accordion_active\" type=\"hidden\" name=\"accordion_active\" value=\"\">".PHP_EOL;

		$this->accordion->show();

		echo '<div>';
		echo '<hr>';
		echo '<button id="submit_button" type="submit" name="'.Request::Submit.'" value="submit">Text erzeugen</button>'.PHP_EOL;
		echo '<button id="reset_button" type="submit" name="'.Request::Reset.'" value="reset">Zurücksetzen</button>'.PHP_EOL;
		echo '</div>';

		echo '</form>';
	}

	public function getHtml() {
		$url = $this->getUrl();

		$html = '';

		$html .= $this->getGenerateDescription();

		$html .= "<form action=\"{$url}\" method=\"post\">".PHP_EOL;
		$html .= "<input type=\"hidden\" name=\"session\" value=\"{$this->session}\">".PHP_EOL;

		//echo "<div class=\"sixteen columns\"><p>Your session: {$this->session} (<a href=\"$url\">drop</a>).</p></div>";
		//echo "<div class=\"sixteen columns\"><p><em>ArxAddon (arx_keramik_terminologie) ".VERSION.".</em></p></div>";

		$html .= '<div id="accordion">'.PHP_EOL;

		$html .= $this->getSectionGrundlagen();
		$html .= $this->getSectionMagerung();


		$html .= $this->getSection('Oberfläche', 15);
		$html .= '<div>';

		$html .= '<div class="sixteen columns">'.PHP_EOL;
		$html .= '<h4>Oberflächenstruktur</h4>'.PHP_EOL;
		$html .= '<div class="five columns alpha"><p>'.PHP_EOL;
		$input = new MultiChoice('oberflaechenstruktur');
		$input->addChoice('glatt', 'glatt (haptisch)');
		$input->addChoice('körnig', 'körnig (haptisch)');
		$input->addChoice('kreidig', 'kreidig (haptisch)');
		$input->addChoice('rau', 'rau (haptisch)');
		$input->addChoice('seifig', 'seifig (haptisch)');
		$input->addChoice('blasig', 'blasig (haptisch, optisch)');
		$input->addChoice('löchrig', 'löchrig (optisch)');
		$input->addChoice('rissig', 'rissig/schrundig (optisch)');
		$html .= $input->getHtml();
		$html .= '</p></div>'.PHP_EOL;
		$html .= '<div class="eight columns omega"><p>'.PHP_EOL;
		$html .= $this->getTextInput('oberflaechenstruktur_anmerkung', 'Anmerkung (optional)', '&lt;Auswahl&gt;[, &lt;Anmerkung&gt;].');
		$input = new MultiChoice('oberflaechenstruktur_overwrite');
		$input->addChoice('overwrite', 'Auswahl mit Anmerkung überschreiben');
		$html .= '</p><p></p><p>'.$input->getHtml();
		$html .= '</p></div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '<div class="sixteen columns">'.PHP_EOL;
		$html .= '<h4>Scherbenhärte</h4>'.PHP_EOL;
		$html .= '<p>'.PHP_EOL;
		$input = new Choice('scherbenhaerte');
		$input->addChoice('weich');
		$input->addChoice('hart');
		$input->addChoice('sehr hart');
		$input->addChoice('klingend hart');
		$html .= $input->getHtml();
		$html .= '</p>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '</div>';

// 		$html .= $this->getSection('Bruch', 15);
// 		$html .= '<div>'.PHP_EOL;
//
// 		$html .= '<div class="eight columns">'.PHP_EOL;
// 		$html .= '<h4>Bruchstruktur</h4>'.PHP_EOL;
// 		$html .= '<div class="four columns alpha"><p>'.PHP_EOL;
// 		$input = new Choice('bruchstruktur_haptisch');
// 		$input->addChoice('glatt', 'glatt (haptisch)');
// 		$input->addChoice('körnig', 'körnig (haptisch)');
// 		$html .= $input->getHtml();
// 		$html .= '</p></div>'.PHP_EOL;
// 		$html .= '<div class="four columns omega"><p>'.PHP_EOL;
// 		$input = new Choice('bruchstruktur_optisch');
// 		$input->addChoice('geklüftet', 'geklüftet (optisch)');
// 		$input->addChoice('geschichtet', 'geschichtet/splittrig (optisch)');
// 		$input->addChoice('muschelig', 'muschelig (optisch)');
// 		$html .= $input->getHtml();
// 		$html .= '</p></div>'.PHP_EOL;
// 		$html .= '</div>'.PHP_EOL;
//
// 		$html .= '<div class="eight columns">'.PHP_EOL;
// 		$html .= '<h4>Porenform</h4>'.PHP_EOL;
// 		$html .= '<div class="four columns alpha"><p>'.PHP_EOL;
// 		$input = new Choice('porenform');
// 		$input->addChoice('längliche Porenform', 'länglich');
// 		$input->addChoice('rundliche Porenform', 'rundlich');
// 		$html .= $input->getHtml();
// 		$html .= '</p></div>'.PHP_EOL;
// 		$html .= '<div class="four columns omega"><p>'.PHP_EOL;
// 		$html .= 'Form der Poren in der Matrix, nicht der ausgefallenen Partikel, nur am Dünnschliff erkennbar.';
// 		$html .= '</p></div>'.PHP_EOL;
// 		$html .= '</div>'.PHP_EOL;
//
// 		$html .= '</div>'.PHP_EOL;


		$html .= $this->getSection('Herstellung', 16);
		$html .= '<div>'.PHP_EOL;

		$html .= '<div class="sixteen columns">'.PHP_EOL;
		$html .= '<h4>Methode der Formgebung</h4>'.PHP_EOL;
		$html .= '<div class="six columns alpha"><p>'.PHP_EOL;
		$input = new Choice('formgebung');
		$input->addChoice('frei geformt', 'frei/ohne Verwendung einer Drehilfe geformt');
		$input->addChoice('drehend geformt', 'langsam gedreht/drehend geformt');
		$input->addChoice('drehend hochgezogen', 'schnell gedreht/drehend hochgezogen');
		$input->addChoice('mit Formhilfe geformt');
		$html .= $input->getHtml();
		$html .= '</p></div>'.PHP_EOL;
		$html .= '<div class="four columns omega"><p>'.PHP_EOL;
		$html .= '</p></div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$farbe_aussen_value = $this->getCleanColor('farbe_aussen', $farbe_aussen_valid, $farbe_aussen_munsell);
		$farbe_aussen_value_2 = $this->getCleanColor('farbe_aussen_2', $farbe_aussen_valid_2, $farbe_aussen_munsell_2);
		$farbe_bruch_value = $this->getCleanColor('farbe_bruch', $farbe_bruch_valid, $farbe_bruch_munsell);
		$farbe_bruch_value_2 = $this->getCleanColor('farbe_bruch_2', $farbe_bruch_valid_2, $farbe_bruch_munsell_2);
		$farbe_innen_value = $this->getCleanColor('farbe_innen', $farbe_innen_valid, $farbe_innen_munsell);
		$farbe_innen_value_2 = $this->getCleanColor('farbe_innen_2', $farbe_innen_valid_2, $farbe_innen_munsell_2);

		$html .= '<div class="sixteen columns">'.PHP_EOL;
		$html .= '<h4>Brand: Farbe</h4>'.PHP_EOL;
		$html .= '<p>Farbangaben nach Oyama und Takehara 1996 (Munsell), RAL oder Farbnamen. <strong>Don\'t care!</strong> Experimentelle automatische Formatierung.</p>'.PHP_EOL;
		$html .= '<div class="five columns alpha"><h5>Oberfläche außen</h5><p>'.PHP_EOL;
		$html .= '<input style="'.($farbe_aussen_valid?'':'color:red;').'" type="text" name="farbe_aussen" value="'.$farbe_aussen_value.'">';
		$html .= 'bis';
		$html .= '<input style="'.($farbe_aussen_valid_2?'':'color:red;').'" type="text" name="farbe_aussen_2" value="'.$farbe_aussen_value_2.'">';
		$html .= '</p><h5>Farbverteilung</h5><p>';
		$input = new Choice('farbverteilung_aussen');
		$input->addChoice('gleichmäßig');
		$input->addChoice('ungleichmäßig');
		$input->addChoice('scharf begrenzte Farbzonen');
		$input->addChoice('ineinander übergehende Farbzohnen');
		$html .= $input->getHtml();
		$html .= '</p></div>'.PHP_EOL;
		$html .= '<div class="five columns alpha"><h5>Bruch</h5><p>'.PHP_EOL;
		$html .= '<input style="'.($farbe_bruch_valid?'':'color:red;').'" type="text" name="farbe_bruch" value="'.$farbe_bruch_value.'">';
		$html .= 'bis';
		$html .= '<input style="'.($farbe_bruch_valid_2?'':'color:red;').'" type="text" name="farbe_bruch_2" value="'.$farbe_bruch_value_2.'">';
		$html .= '</p><h5>Farbverteilung</h5><p>';
		$input = new Choice('farbverteilung_bruch');
		$input->addChoice('gleichmäßig');
		$input->addChoice('ungleichmäßig');
		$input->addChoice('scharf begrenzte Farbzonen');
		$input->addChoice('ineinander übergehende Farbzohnen');
		$html .= $input->getHtml();
		$html .= '</p></div>'.PHP_EOL;
		$html .= '<div class="six columns omega"><h5>Oberfläche innen</h5><p>'.PHP_EOL;
		$html .= '<input style="'.($farbe_innen_valid?'':'color:red;').'" type="text" name="farbe_innen" value="'.$farbe_innen_value.'">';
		$html .= 'bis';
		$html .= '<input style="'.($farbe_innen_valid_2?'':'color:red;').'" type="text" name="farbe_innen_2" value="'.$farbe_innen_value_2.'">';
		$html .= '</p><h5>Farbverteilung</h5><p>';
		$input = new Choice('farbverteilung_innen');
		$input->addChoice('gleichmäßig');
		$input->addChoice('ungleichmäßig');
		$input->addChoice('scharf begrenzte Farbzonen');
		$input->addChoice('ineinander übergehende Farbzohnen');
		$html .= $input->getHtml();
		$html .= '</p></div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '<div class="sixteen columns">'.PHP_EOL;
		$html .= '<h4>Primärbrand</h4>'.PHP_EOL;
		$html .= '<div class="five columns alpha"><p>'.PHP_EOL;
		$input = new Choice('primaerbrand');
		$input->addChoice('oxidierend gebrannt', 'Oxidationsbrand (rot/braun/gelblich)');
		$input->addChoice('reduzierend gebrannt', 'Reduktionsbrand (grau/schwarz)');
		$input->addChoice('oxidierend mit Reduktionskern gebrannt', 'Oxidationsbrand mit Reduktionskern');
		$input->addChoice('reduzierend mit Oxidationskern gebrannt', 'Reduktionsbrand mit Oxidationskern');
		$input->addChoice('mischbrandig', 'Mischbrand');
		$html .= $input->getHtml();
		$html .= '</p></div>'.PHP_EOL;
		$html .= '<div class="four columns omega"><p>'.PHP_EOL;
		$html .= '</p></div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '<div class="eight columns">'.PHP_EOL;
		$html .= '<h4>Herstellungsspuren am nicht ausgehärteten Ton</h4>'.PHP_EOL;
		$html .= '<div class="five columns alpha"><p>'.PHP_EOL;
		$input = new MultiChoice('herstellungsspuren_weich');
		$input->addChoice('Abhebespur');
		$input->addChoice('parallele Abschneidespuren', 'Abschneidespuren, paralell');
		$input->addChoice('radiale Abschneidespuren', 'Abschneidespuren, radial');
		$input->addChoice('Achsabdruck');
		$input->addChoice('Bodenringfalte');
		$input->addChoice('Drehrille');
		$input->addChoice('Fingerabdruck');
		$input->addChoice('Fingernagelabdruck');
		$input->addChoice('Delle');
		$input->addChoice('Formhilfenabdruck');
		$input->addChoice('Formnaht');
		$input->addChoice('Fügestelle', 'Naht-/Fügestelle');
		$input->addChoice('Partikelkonzentration am Boden');
		$input->addChoice('Quellrandboden');
		$input->addChoice('Self-slip');
		$input->addChoice('Verstreichspur');
		$html .= $input->getHtml();
		$html .= '</p></div>'.PHP_EOL;
		$html .= '<div class="four columns omega"><p>'.PHP_EOL;
		$html .= '</p></div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '<div class="eight columns">'.PHP_EOL;
		$html .= '<h4>Herstellungsspuren am "lederharten" Ton</h4>'.PHP_EOL;
		$html .= '<div class="five columns alpha"><p>'.PHP_EOL;
		$input = new MultiChoice('herstellungsspuren_lederhart');
		$input->addChoice('Abdrehspuren');
		$input->addChoice('Angarnierungsdruckspur');
		$input->addChoice('Nachdrehspuren');
		$input->addChoice('Trochnungseinschnitt', 'Trochnungseinschnitt/-stich');
		$html .= $input->getHtml();
		$html .= '</p></div>'.PHP_EOL;
		$html .= '<div class="four columns omega"><p>'.PHP_EOL;
		$html .= '</p></div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '<div class="eight columns">'.PHP_EOL;
		$html .= '<h4>Brandbedingte Herstellungsspuren</h4>'.PHP_EOL;
		$html .= '<div class="five columns alpha"><p>'.PHP_EOL;
		$input = new MultiChoice('herstellungsspuren_brandbedingt');
		$input->addChoice('Brennhaut');
		$input->addChoice('Brennhilfeabriss');
		$input->addChoice('Brennriss');
		$input->addChoice('Brennschatten');
		$input->addChoice('Fehlbrand');
		$input->addChoice('Glasurabriss');
		$input->addChoice('metallischer Anflug', 'Metallischer Anflug');
		$input->addChoice('Windflecken');
		$html .= $input->getHtml();
		$html .= '</p></div>'.PHP_EOL;
		$html .= '<div class="four columns omega"><p>'.PHP_EOL;
		$html .= '</p></div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '<div class="sixteen columns">'.PHP_EOL;
		$html .= '<h4>Sekundäre Veränderungen</h4>'.PHP_EOL;
		$html .= '<div class="eight columns alpha"><p>'.PHP_EOL;
		$html .= $this->getTextArea('sekundaere_veraenderungen');
		$html .= '</p></div>'.PHP_EOL;
		$html .= '<div class="four columns omega"><p>'.PHP_EOL;
		$html .= '</p></div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '</div>'.PHP_EOL;


// 		$html .= $this->getSection('Randbereich', 27);
// 		$html .= '<div>';
//
// 		$html .= $this->getBox('Mündung', '<div style="float:left;margin-right: 10px;">'.$this->getTextInput('rand_muendung') . '</div> z. B. runde, kleeblattförmige, vierpassförmige, viereckige, dreieckige.');
// 		$html .= '<div class="space clear"></div>';
//
// 		$input = new Choice('rand_formal');
// 		$input->addChoice('gerundet');
// 		$input->addChoice('gekehlt');
// 		$input->addChoice('flach');
// 		$input->addChoice('spitz');
// 		$input->addChoice('gerillt');
// 		$input->addChoice('gekantet');
// 		$html .= $this->getBox('Formalbeschreibung', $input->getHtml());
//
// 		$input = new Choice('rand_herstellung');
// 		$input->addChoice('abgeschnitten');
// 		$input->addChoice('zugeschnitten');
// 		$input->addChoice('beschnitten', 'beschnitten (Draht, Schnur, Messer)');
// 		$input->addChoice('abgestrichen', 'abgestrichen (Finger, Schwamm, Holzstück)');
// 		$input->addChoice('gerillt');
// 		$input->addChoice('gekantet');
// 		$html .= $this->getBox('Herstellungstechnische Beschreibung', $input->getHtml());
// 		$html .= '<div class="space clear"></div>';
//
// 		$input = new Choice('rand_form');
// 		$input->addChoice('nicht verstärkter Rand');
// 		$input->addChoice('aufgestellter Rand');
// 		$input->addChoice('verstärkter Rand');
// 		$input->addChoice('Keulenrand');
// 		$input->addChoice('Wulstrand');
// 		$input->addChoice('Leistenrand');
// 		$input->addChoice('Kragenrand');
// 		$input->addChoice('Kremprand');
// 		$input->addChoice('Rollrand');
// 		$input->addChoice('Sichelrand');
// 		$html .= $this->getBox('Randform', $input->getHtml());
//
// 		$input = new Choice('rand_kontur');
// 		$input->addChoice('vertikaler Rand');
// 		$input->addChoice('ausladender Rand');
// 		$input->addChoice('steil ausladender Rand');
// 		$input->addChoice('flach ausladender Rand');
// 		$input->addChoice('einziehender Rand');
// 		$input->addChoice('steil einziehender Rand');
// 		$input->addChoice('flach einziehender Rand');
// 		$input->addChoice('umgebogener Rand');
// 		$input->addChoice('umgeklappter Rand');
// 		$input->addChoice('untergriffiger Rand');
// 		$input->addChoice('unterschnittener Rand');
// 		$input->addChoice('eingerollter Rand');
// 		$input->addChoice('profilierter Rand');
// 		$input->addChoice('Fahne');
// 		$html .= $this->getBox('Randkontur', $input->getHtml());
//
// 		$html .= '</div>';



// 		$html .= $this->getSection('Wandbereich', 31);
// 		$html .= '<div>'.PHP_EOL;
//
// 		$input = new Choice('hals');
// 		$input->addChoice('stark einziehender Hals');
// 		$input->addChoice('schwach einziehender Hals');
// 		$input->addChoice('zylindrischer Hals');
// 		$input->addChoice('konischer Hals');
// 		$html .= $this->getBox('Hals/Halszone', $input->getHtml());
//
// 		$input = new Choice('schulter');
// 		$input->addChoice('flach ansteigende Schulter');
// 		$input->addChoice('steil ansteigende Schulter');
// 		$html .= $this->getBox('Schulter/Schulterzone', $input->getHtml());
//
// 		$input = new Choice('bauch');
// 		$input->addChoice('zylindrischer Bauch');
// 		$input->addChoice('ellipsoider Bauch');
// 		$input->addChoice('kugeliger Bauch');
// 		$input->addChoice('konischer Bauch');
// 		$input->addChoice('quaderförmiger Bauch');
// 		$html .= $this->getBox('Bauch/Bauchzone', $input->getHtml());
//
// 		// Fuß/Fußzone.
// 		$input = new Choice('fuss');
// 		$input->addChoice('einziehender Fuß');
// 		$input->addChoice('ausladende Fußzone');
// 		$input->addChoice('zylindrische Fußzone');
// 		$html .= $this->getBox('Fuß/Fußzone', $input->getHtml());
//
// 		$html .= '</div>'.PHP_EOL;


// 		$html .= $this->getSection('Bodenbereich', 34);
// 		$html .= '<div>'.PHP_EOL;
//
// 		$html .= '<div class="sixteen columns">'.PHP_EOL;
// 		$html .= '<h4>Bodenformen</h4>'.PHP_EOL;
// 		$html .= '<p>'.PHP_EOL;
// 		$input = new Choice('boden');
// 		$input->addChoice('Flachboden');
// 		$input->addChoice('minimal nach oben gewölbter Flachboden', 'Flachboden, min. n. oben gewölbt');
// 		$input->addChoice('Konvexboden');
// 		$input->addChoice('Konkavboden');
// 		$input->addChoice('aus der Masse gedrehter Standring');
// 		$html .= $input->getHtml();
// 		$html .= '</p>'.PHP_EOL;
// 		$html .= '</div>'.PHP_EOL;
//
// 		$html .= '</div>'.PHP_EOL;


		$html .= $this->getSection('Massangaben', 34);
		$html .= '<div>'.PHP_EOL;

		$html .= '<div style="float:left;margin-right:20px;">'.PHP_EOL;
		$html .= '<p>'.PHP_EOL;
		$html .= $this->getTextInput('randdurchmesser', 'Randdurchmesser (cm)');
		$html .= '</p>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '<div style="float:left;margin-right:20px;">'.PHP_EOL;
		$html .= '<p>'.PHP_EOL;
		$html .= $this->getTextInput('maximaldurchmesser', 'Maximaldurchmesser (cm)');
		$html .= '</p>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '<div style="float:left;margin-right:20px;">'.PHP_EOL;
		$html .= '<p>'.PHP_EOL;
		$html .= $this->getTextInput('bodendurchmesser', 'Bodendurchmesser (cm)');
		$html .= '</p>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '<div style="float:left;margin-right:20px;">'.PHP_EOL;
		$html .= '<p>'.PHP_EOL;
		$html .= $this->getTextInput('wandstaerke', 'Wandstärke von&ndash;bis (cm)');
		$html .= '</p>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '<div style="float:left;margin-right:20px;">'.PHP_EOL;
		$html .= '<p>'.PHP_EOL;
		$html .= $this->getTextInput('hoehe', '(erh.) Höhe (cm)');
		$html .= '</p>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '<div style="float:left;margin-right:20px;">'.PHP_EOL;
		$html .= '<p>'.PHP_EOL;
		$html .= $this->getTextInput('randerhalt', 'Randerhalt (%)');
		$html .= '</p>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;

		$html .= '<div style="clear:both;padding-top:1px;">'.PHP_EOL;
		$html .= '<p><strong>Don\'t care!</strong> Eingaben jeglicher Art mit und ohne Komma und Einheit oder ungültige Zeichen werden automatisch gefiltert und formatiert!</p>'.PHP_EOL;
		$html .= '</div>';

		$html .= '</div>'.PHP_EOL; // Massangaben


// 		$html .= $this->getSection('Funktionselemente', 35);
//
// 		$html .= '<div>'.PHP_EOL;
//
// 		$input = new Choice('standvorrichtungen');
// 		$input->addChoice('Hohlfuß');
// 		$input->addChoice('Massivfuß');
// 		$input->addChoice('zapfenförmiger Massivfuß');
// 		$input->addChoice('tierfußförmiger Massivfuß');
// 		$input->addChoice('zylindrischer Massivfuß', 'zylindrischer/amorpher Massivfuß');
// 		$input->addChoice('Standring');
// 		$html .= $this->getBox('Standvorrichtungen', $input->getHtml());
//
// 		$input = new MultiChoice('handhaben');
// 		$input->addChoice('Grifflappen');
// 		$input->addChoice('Knauf');
// 		$input->addChoice('Knubbe');
// 		$input->addChoice('Rohrgriff');
// 		$input->addChoice('Stielgriff');
// 		$html .= $this->getBox('Handhaben', $input->getHtml());
//
// 		$input = new MultiChoice('handhaben_henkel');
// 		$input->addChoice('Bandhenkel');
// 		$input->addChoice('Wulsthenkel');
// 		$html .= $this->getBox('', $input->getHtml());
//
// 		// BAUSTELLE
//
// 		$html .= '</div>'.PHP_EOL;

// 		$html .= $this->getSection('Gebrauchsspuren', 52);
//
// 		$html .= '<div>'.PHP_EOL;
// 		$html .= '<p>'.PHP_EOL;
// 		$html .= $this->getTextArea('gebrauchsspuren', '<strong>Gebrauchsspuren</strong> (Abreibespuren, Schmauchspuren, Reparaturen, etc.)');
// 		$html .= '</p>'.PHP_EOL;
// 		$html .= '</div>'.PHP_EOL;


		$html .= $this->getSection('Grundform', 58);
		$input = new MultiChoice('grundform_unsicher');
		$input->addChoice('Grundform unsicher (nicht eindeutig zuordenbar)');
		$html .= '<div><p>'.$input->getHtml().'</p>'.PHP_EOL;

		$html .= '<div id="grundform_tabs">'.PHP_EOL;
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
		$input = new Choice(Id::Grundform, false);
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
		$input->addChoice('G1.6 Topf', false, true);
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
		$input = new Choice(Id::Grundform, false);
		$input->addChoice('G2.1 Hohe Kanne');
		$input->addChoice('G2.2 Krug');
		$input->addChoice('G2.2.1 Walzenkrug');
		$html .= $input->getHtml();
		$html .= '</div>'.PHP_EOL;

		// Grundform 3 (G3).
		$html .= '<div id="grundform-3">'.PHP_EOL;
		$html .= '<h4>Grundform 3 (G3)</h4><p>Höhe &ge; Maximaldurchmesser;<br>Rand- und Halsdurchmesser &lt; &frac12; Maximaldurchmesser</p>'.PHP_EOL;
		$input = new Choice(Id::Grundform, false);
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
		$input = new Choice(Id::Grundform, false);
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
		$input = new Choice(Id::Grundform, false);
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
		$input = new Choice(Id::Grundform, false);
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
		$input = new Choice(Id::Grundform, false);
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

		$html .= '</div>'.PHP_EOL;

// 		$html .= $this->getSection('Erhaltungszustand');
// 		$html .= '<div>'.PHP_EOL;
//
// 		// Fragmentierung.
// 		$input = new Choice('condition_fragmentation');
// 		$input->addChoice('vollständig erh.', 'vollständig erhalten');
// 		$input->addChoice('Fragment', 'allg. Fragment(e)');
// 		$input->addChoice('Randfragment');
// 		$input->addChoice('Rand-/Wandfragment');
// 		$input->addChoice('Wandfragment');
// 		$input->addChoice('Wand-/Bodenfragment');
// 		$input->addChoice('Bodenfragment');
// 		$input = $input->getHtml().$this->getTextInput('condition_fragments_count', '<h4>Anzahl der Fragmente (optional)</h4>').' Stück';
// 		$html .= $this->getBox('Fragmentierung', $input);
// // 		print $this->getPost('condition_fragmentation');
// 		$image = array(
// 			0 => 'not_specified',
// 			'vollständig erh.' => 'complete_extent',
// 			'Fragment' => 'general_fragments',
// 			'Randfragment' => 'rim',
// 			'Rand-/Wandfragment' => 'rim_wall',
// 			'Wandfragment' => 'wall',
// 			'Wand-/Bodenfragment' => 'wall_bottom',
// 			'Bodenfragment' => 'bottom',
// 		);
// 		$html .= '<div><img id="condition_figure" src="images/condition_'.$image[$this->getPost('condition_fragmentation')].'.png"></div>';
//
// 		// Restauration.
// 		$input = new MultiChoice('condition_restoration');
// 		$input->addChoice('geklebt', 'geklebt (z. B. Archäocoll 2000)');
// 		$html .= $this->getBox('Restauration', $input->getHtml());
//
// 		$html .= '</div>'.PHP_EOL;

		$html .= '<div>';
		$html .= '<hr>';
		$html .= '<button id="submit_button" type="submit" name="'.Request::Submit.'" value="submit">Text erzeugen</button>'.PHP_EOL;
		$html .= '<button id="reset_button" type="submit" name="'.Request::Reset.'" value="reset">Zurücksetzen</button>'.PHP_EOL;
		$html .= '</div>';

		$html .= '</form>';

		return $html;
	}

}


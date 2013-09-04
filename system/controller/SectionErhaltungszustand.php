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
 * Beschreibt den Erhaltungszustand des Keramikfundes.
 */
class SectionErhaltungszustand extends AccordionSectionWidget
{
	const IdFragmentierung  = 'erhaltungszustand_fragmentierung';
	const IdAnzahlFragmente = 'erhaltungszustand_anzahl_fragmente';
	const IdRestauration    = 'erhaltungszustand_restauration';

	const ValueVollstaendigErhalten = "vollständig erh.";
	const ValueAllgemeineFragmente  = "Fragment";
	const ValueRandfragment         = "Randfragment";
	const ValueRandWandfragment     = "Rand-/Wandfragment";
	const ValueWandfragment         = "Wandfragment";
	const ValueWandBodenfragment    = "Wand-/Bodenfragment";
	const ValueBodenfragment        = "Bodenfragment";

	const ValueGeklebt         = "geklebt";
	const ValueRekonstruiert = "rekonstruiert";

	/** Constructor. */
	public function __construct()
	{
		parent::__construct('erhaltungszustand', "Erhaltungszustand", false);
	}

	/** Print all subsections. */
	public function content()
	{
		$data = array(
			'fragmentierung' => $this->fieldsetFragmentierung(),
			'anzahl' => $this->fieldsetAnzahlFragmente(),
			'restauration' => $this->fieldsetRestauration(),
		);
		return $this->loadView('erhaltungszustand', $data, false);
	}

	/** Specify the degree of possible fragmentierung. */
	protected function fieldsetFragmentierung()
	{
		$input = new ChoiceWidget(self::IdFragmentierung, false);
		$input->addChoice(ChoiceWidget::ValueNotSpecified, "keine Angabe", false, false, "condition_image('not_specified')");
		$input->addChoice(self::ValueVollstaendigErhalten, "vollständig erhalten", false, false, "condition_image('complete_extent')");
		$input->addChoice(self::ValueAllgemeineFragmente, "allg. Fragment(e)", false, false, "condition_image('general_fragments')");
		$input->addChoice(self::ValueRandfragment, false, false, false, "condition_image('rim')");
		$input->addChoice(self::ValueRandWandfragment, false, false, false, "condition_image('rim_wall')");
		$input->addChoice(self::ValueWandfragment, false, false, false, "condition_image('wall')");
		$input->addChoice(self::ValueWandBodenfragment, false, false, false, "condition_image('wall_bottom')");
		$input->addChoice(self::ValueBodenfragment, false, false, false, "condition_image('bottom')");

		// Image path translation.
		$image = array(
			ChoiceWidget::ValueNotSpecified => 'not_specified',
			self::ValueVollstaendigErhalten => 'complete_extent',
			self::ValueAllgemeineFragmente  => 'general_fragments',
			self::ValueRandfragment         => 'rim',
			self::ValueRandWandfragment     => 'rim_wall',
			self::ValueWandfragment         => 'wall',
			self::ValueWandBodenfragment    => 'wall_bottom',
			self::ValueBodenfragment        => 'bottom',
		);

		$content = '<div style="float:left; margin-right: 50px;">'.$input->getHtml().'</div>';
		$content .= '<div><img id="condition_figure" src="images/condition_'.$image[post(self::IdFragmentierung)].'.png"></div>';
		$content .= '<div style="clear:left;"></div>';

		$fieldset = new FieldsetWidget('fragmentierung', "Fragmentierung", $content);
		return $fieldset->getHtml();
	}

	/** Count of fragments. This parameter is optional. */
	protected function fieldsetAnzahlFragmente()
	{

		$input = new LineEditWidget(self::IdAnzahlFragmente, "Stück", false, 3);

		$fieldset = new FieldsetWidget('anzahl_fragmente', "Anzahl der Fragmente (optional)", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** Was the object restored? For example where the parts glued together? */
	protected function fieldsetRestauration()
	{
		$input = new MultiChoiceWidget(self::IdRestauration);
		$input->addChoice(self::ValueGeklebt, "geklebt (z. B. <em>Archäocoll 2000</em> oder <em>Paraloid&trade; B 72</em>)");
		$input->addChoice(self::ValueRekonstruiert, "rekonstruiert (z. B. <em>Alabastergips</em>)");

		$fieldset = new FieldsetWidget('restauration', "Restauration", $input->getHtml());
		return $fieldset->getHtml();
	}

	/** @returns type of fragmentierung. */
	static public function fragmentierung()
	{
		return post(self::IdFragmentierung);
	}

	/** @returns true if object is not fragmented. */
	static public function isVollstaendigErhalten()
	{
		return self::fragmentierung() == self::ValueVollstaendigErhalten;
	}

	/** Returns long detailed description. */
	static public function longDescription()
	{
		$result = '';

		$fragmentierung = self::fragmentierung();
		$fragments_count = intval(post(self::IdAnzahlFragmente));

		// Get restoration conditions of object.
		$restoration = post(self::IdRestauration);

		// True if object was glued.
		$isGlued = array_key_exists(self::ValueGeklebt, $restoration ? $restoration : array());

		// True if object was reconstructed.
		$isReconstructed = array_key_exists(self::ValueRekonstruiert, $restoration ? $restoration : array());

		// Construct the object condition statement.
		if ($fragmentierung)
			$result = (($fragmentierung == self::ValueVollstaendigErhalten) ? '' : $fragmentierung);

		// First create a list of additional attributes in braces.
		$args = array();
		// Hahaha grammar havoc!! xD
		if ($fragments_count > 1) $args[] = "$fragments_count Fragmente";
		if ($isGlued) $args[] = "geklebt";
		if ($isReconstructed) $args[] = "rekonstruiert";

		// Next prepend the major attributes.
		$args = implode(', ', $args);
		if ($args) $args = "({$args})";
		if ($result and $args) $result .= ' '.$args;
		if ($fragmentierung == self::ValueAllgemeineFragmente and $fragments_count > 1) $result = trim($args, '()');
		if ($result) $result = ucfirst($result);
		if ($isGlued and $result == '') $result = "geklebt";
		if ($result) $result = '; '.$result;

		return $result;
	}

	/** Returns short formal description. */
	static public function shortDescription()
	{
		$fragmentierung = post(self::IdFragmentierung);
		$fragments_count = intval(post(self::IdAnzahlFragmente));
		$result = '';

		if ($fragmentierung) $result .= $fragmentierung;

		if ($fragmentierung == self::ValueAllgemeineFragmente and $fragments_count > 1) $result = "mehrere Fragmente";
		if ($result) $result = ', '.$result;

		return $result;
	}
}

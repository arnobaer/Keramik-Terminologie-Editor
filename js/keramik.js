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

$(function() {

	var icons = {
		header: "ui-icon-circle-arrow-e",
		activeHeader: "ui-icon-circle-arrow-s"
	};

	$("#accordion").accordion({
		active: false,
		icons: icons,
		heightStyle: "content",
		collapsible: true,
		activate: function( event, ui ) {
			document.getElementById("accordion_active").setAttribute("value", $("#accordion").accordion("option", "active"));
		}
	});

	$("#grundform_tabs").tabs({
		active: false,
		activate: function( event, ui ) {
			document.getElementById("tab_active").setAttribute("value", $("#grundform_tabs").tabs("option", "active"));
		}
	});

	$("#radioset").buttonset();

	$("#submit_button").button({
		icons: {
			primary: "ui-icon-arrowrefresh-1-s"
		}
	});

	$("#reset_button").button({
		icons: {
			primary: "ui-icon-arrowreturn-1-w"
		}
	});

	var ListGebrauchsspuren = [
		"Abreibespuren", "Schmauchspuren", "Reparaturen"
	];

	var ListRandbereichMuendung = [
		"runde", "ovale", "kleeblattförmige", "dreipassförmige", "vierpassförmige", "dreieckige", "viereckige", "polygonale"
	];

	function split( val ) {
		return val.split( /,\s*/ );
	}
	function extractLast( term ) {
		return split( term ).pop();
	}

	/* Multi word auto complete for use-wear section. */
	$("#text_gebrauchsspuren_gebrauchsspuren")
		// don't navigate away from the field on tab when selecting an item
		.bind( "keydown", function( event ) {
			if ( event.keyCode === $.ui.keyCode.TAB &&
				$( this ).data( "ui-autocomplete" ).menu.active ) {
			event.preventDefault();
		}
	})
	.autocomplete({
		minLength: 0,
		source: function( request, response ) {
			// delegate back to autocomplete, but extract the last term
			response( $.ui.autocomplete.filter(
				ListGebrauchsspuren, extractLast( request.term ) ) );
		},
		focus: function() {
			// prevent value inserted on focus
			return false;
		},
		select: function( event, ui ) {
			var terms = split( this.value );
			// remove the current input
			terms.pop();
			// add the selected item
			terms.push( ui.item.value );
			// add placeholder to get the comma-and-space at the end
			terms.push( "" );
			this.value = terms.join( ", " );
			return false;
		}
	});

	/* Single word auto complete for border section. */
	$("#text_randbereich_muendung").autocomplete({
		source: ListRandbereichMuendung
	});
});

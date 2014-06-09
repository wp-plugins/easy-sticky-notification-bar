/*
 * WSNB Admin v1.0
 * DesignOrbital.com
 *
 * Copyright (c) 2013-2014 DesignOrbital.com
 *
 * License: GNU General Public License v2 or later
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 */

( function( $ ) {

	/** Document Ready */
	$( document ).ready( function() {

		// Easytabs
		$( '#do-esnb-tabs' ).easytabs({
			defaultTab: ( $.cookie( 'do-esnb-tab' ) != 'undefined' )? $.cookie( 'do-esnb-tab' ) : 'li#tab-2',
			updateHash: false
		});
		$( '#do-esnb-tabs' ).bind( 'easytabs:after', function() {			
			$activeTab = $( '.do-esnb-tabs-container' ).find( 'li.active' );
			$.cookie( 'do-esnb-tab', 'li#' + $activeTab.attr( 'id' ), { path: '/' } );
		});
		
	} );

} )( jQuery );
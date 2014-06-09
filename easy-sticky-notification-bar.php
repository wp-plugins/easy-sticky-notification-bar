<?php
/*
Plugin Name: Easy Sticky Notification Bar
Plugin URI: http://designorbital.com/easy-sticky-notification-bar/
Description: Add an elegant and clean sticky notification bar on your WordPress site by using the Easy Sticky Notification Bar plugin.
Author: DesignOrbital.com
Author URI: http://designorbital.com
Text Domain: do-esnb
Domain Path: /languages/
Version: 0.2
License: GPL v3

Easy Sticky Notification Bar
Copyright (C) 2014, DesignOrbital.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * Constants
 */
if ( !defined( 'DO_ESNB_VERSION' ) ) {
	define( 'DO_ESNB_VERSION', '0.1' );
}

if ( !defined( 'DO_ESNB_DIR' ) ) {
	define( 'DO_ESNB_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( !defined( 'DO_ESNB_DIR_BASENAME' ) ) {
	define( 'DO_ESNB_DIR_BASENAME', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );
}

if ( !defined( 'DO_ESNB_URI' ) ) {
	define( 'DO_ESNB_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
}

/**
 * Load plugin textdomain.
 */
function do_esnb_load_textdomain() {
  load_plugin_textdomain( 'do-esnb', false, DO_ESNB_DIR_BASENAME. 'languages/' ); 
}
add_action( 'plugins_loaded', 'do_esnb_load_textdomain' );

/**
 * Enqueue scripts and styles.
 */
function do_esnb_scripts() {

	/**
	 * Enqueue CSS files
	 */

	// Plugin Stylesheet
	if( 1 == do_esnb_option( 'enable' ) ) {
		wp_enqueue_style( 'do-esnb-style', DO_ESNB_URI . 'css/style.css' );
	}

}
add_action( 'wp_enqueue_scripts', 'do_esnb_scripts' );

/**
 * Custom functions.
 */
require DO_ESNB_DIR . 'inc/extras.php';

/**
 * Admin Page
 */
if( is_admin() ) {
	require DO_ESNB_DIR . 'inc/admin.php';
}
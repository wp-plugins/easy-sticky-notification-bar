<?php
/**
 * Admin page for the plugin
 */

/**
 * Settings Page
 */
function do_esnb_settings_page() {
	add_submenu_page( 'options-general.php', esc_html__( 'Easy Sticky Notification Bar', 'do-esnb' ), esc_html__( 'Easy Sticky Notification Bar', 'do-esnb' ), 'manage_options', 'do-esnb-options', 'do_esnb_settings_page_content' );
}
add_action( 'admin_menu', 'do_esnb_settings_page' );

/**
 * Settings Page Content
 */
function do_esnb_settings_page_content() {
	require DO_ESNB_DIR . 'inc/settings-page.php';
}

/**
 * Enqueue scripts and styles.
 */
function do_esnb_admin_scripts( $hook ) {

	if( 'settings_page_do-esnb-options' == $hook ) {

		/**
		 * Enqueue JS files
		 */

		// Cookie
		wp_enqueue_script( 'do-esnb-cookie', DO_ESNB_URI . 'js/cookie.js', array( 'jquery' ) );

		// Easytabs
		wp_enqueue_script( 'do-esnb-hashchange', DO_ESNB_URI . 'js/hashchange.js', array( 'jquery' ) );
		wp_enqueue_script( 'do-esnb-easytabs', DO_ESNB_URI . 'js/easytabs.js', array( 'jquery', 'do-esnb-hashchange' ) );

		// Admin JS
		wp_enqueue_script( 'do-esnb-admin', DO_ESNB_URI . 'js/admin.js', array( 'jquery' ) );

		/**
		 * Enqueue CSS files
		 */

		// Admin Style
		wp_enqueue_style( 'do-esnb-admin-style', DO_ESNB_URI . 'css/admin.css' );

	}

}
add_action( 'admin_enqueue_scripts', 'do_esnb_admin_scripts' );

/**
 * Contextual Help
 */
function do_esnb_contextual_help() {

	// Plugin Data
	$plugin    = do_esnb_plugin_data();
	$AuthorURI = $plugin['AuthorURI'];
	$PluginURI = $plugin['PluginURI'];
	$Name      = $plugin['Name'];

	// Current Screen
	$screen = get_current_screen();

	// Help Strings
	$content_support = '<p>';
	$content_support .= sprintf( __( '%1$s is a project of %2$s. You can reach us via contact page.', 'do-esnb' ), $Name, '<a href="http://designorbital.com/">DesignOrbital</a>' );
	$content_support .= '<p>';

	// Plugin reference help screen tab.
	$screen->add_help_tab( array(

			'id'         => 'do-esnb-support',
			'title'      => __( 'Plugin Support', 'do-esnb' ),
			'content'    => $content_support,

		)
	);

	// Help Sidebar
	$sidebar = '<p><strong>' . __( 'For more information:', 'do-esnb' ) . '</strong></p>';
	if ( ! empty( $AuthorURI ) ) {
		$sidebar .= '<p><a href="' . esc_url( $AuthorURI ) . '" target="_blank">' . __( 'Plugin Author', 'do-esnb' ) . '</a></p>';
	}
	if ( ! empty( $PluginURI ) ) {
		$sidebar .= '<p><a href="' . esc_url( $PluginURI ) . '" target="_blank">' . __( 'Plugin Official Page', 'do-esnb' ) . '</a></p>';
	}
	$screen->set_help_sidebar( $sidebar );

}
add_action( 'load-settings_page_do-esnb-options', 'do_esnb_contextual_help' );

/**
 * Plugin Settings
 */
function do_esnb_settings() {

	// Register plugin settings
	register_setting( 'do_esnb_options_group', 'do_esnb_options', 'do_esnb_options_validate' );

	/** Config Section */
	add_settings_section( 'do_esnb_section_config', __( 'Configuration', 'do-esnb' ), 'do_esnb_section_config_cb', 'do_esnb_section_config_page' );
	add_settings_field( 'do_esnb_field_enable', __( 'Enable', 'do-esnb' ), 'do_esnb_field_enable_cb', 'do_esnb_section_config_page', 'do_esnb_section_config' );
	add_settings_field( 'do_esnb_field_button_display', __( 'Display Button', 'do-esnb' ), 'do_esnb_field_display_button_cb', 'do_esnb_section_config_page', 'do_esnb_section_config' );

	/** Content Section */
	add_settings_section( 'do_esnb_section_content', __( 'Notification Content', 'do-esnb' ), 'do_esnb_section_content_cb', 'do_esnb_section_content_page' );
	add_settings_field( 'do_esnb_field_notification', __( 'Notification', 'do-esnb' ), 'do_esnb_field_notification_cb', 'do_esnb_section_content_page', 'do_esnb_section_content' );
	add_settings_field( 'do_esnb_field_notification_link', __( 'Notification Link', 'do-esnb' ), 'do_esnb_field_notification_link_cb', 'do_esnb_section_content_page', 'do_esnb_section_content' );
	add_settings_field( 'do_esnb_field_button_label', __( 'Button Label', 'do-esnb' ), 'do_esnb_field_button_label_cb', 'do_esnb_section_content_page', 'do_esnb_section_content' );
	add_settings_field( 'do_esnb_field_button_link', __( 'Button Link', 'do-esnb' ), 'do_esnb_field_button_link_cb', 'do_esnb_section_content_page', 'do_esnb_section_content' );

	/** Typography Section */
	add_settings_section( 'do_esnb_section_typography', __( 'Typography', 'do-esnb' ), 'do_esnb_section_typography_cb', 'do_esnb_section_typography_page' );
	add_settings_field( 'do_esnb_field_notification_font', __( 'Notification Font', 'do-esnb' ), 'do_esnb_field_notification_font_cb', 'do_esnb_section_typography_page', 'do_esnb_section_typography' );
	add_settings_field( 'do_esnb_field_button_font', __( 'Button Font', 'do-esnb' ), 'do_esnb_field_button_font_cb', 'do_esnb_section_typography_page', 'do_esnb_section_typography' );

}
add_action( 'admin_init', 'do_esnb_settings' );

/**
 * Boolean Yes | No
 */
function do_esnb_boolean() {
	return array (
		1 => __( 'yes', 'do-esnb' ),
		0 => __( 'no', 'do-esnb' )
	);
}

/**
 * Google Web Fonts
 *
 * This function should be synchronized with (or derived from)
 * `do_esnb_google_fonts_skeleton` function in `inc/extras.php`
 *
 * @return array|string
 */
function do_esnb_google_fonts( $key = '' ) {

	$google_fonts = array(
		'abril-fatface'           => 'Abril Fatface',
		'abeezee'                 => 'ABeeZee',
		'actor'                   => 'Actor',
		'allerta'                 => 'Allerta',
		'alike'                   => 'Alike',
		'arizonia'                => 'Arizonia',
		'arvo'                    => 'Arvo',
		'average'                 => 'Average',
		'average-sans'            => 'Average Sans',
		'bitter'                  => 'Bitter',
		'bree-serif'              => 'Bree Serif',
		'cabin'                   => 'Cabin',
		'cardo'                   => 'Cardo',
		'clicker-script'          => 'Clicker Script',
		'cookie'                  => 'Cookie',
		'crimson-text'            => 'Crimson Text',
		'dancing-script'          => 'Dancing Script',
		'didact-gothic'           => 'Didact Gothic',
		'domine'                  => 'Domine',
		'droid-sans'              => 'Droid Sans',
		'droid-serif'             => 'Droid Serif',
		'eb-garamond'             => 'EB Garamond',
		'enriqueta'               => 'Enriqueta',
		'fjalla-one'              => 'Fjalla One',
		'gentium-book-basic'      => 'Gentium Book Basic',
		'gentium-basic'           => 'Gentium Basic',
		'grand-hotel'             => 'Grand Hotel',
		'gravitas-one'            => 'Gravitas One',
		'great-vibes'             => 'Great Vibes',
		'habibi'                  => 'Habibi',
		'josefin-slab'            => 'Josefin Slab',
		'lato'                    => 'Lato',
		'ledger'                  => 'Ledger',
		'libre-baskerville'       => 'Libre Baskerville',
		'lobster'                 => 'Lobster',
		'lora'                    => 'Lora',
		'lustria'                 => 'Lustria',
		'merriweather'            => 'Merriweather',
		'merriweather-sans'       => 'Merriweather Sans',
		'monda'                   => 'Monda',
		'montserrat'              => 'Montserrat',
		'mouse-memoirs'           => 'Mouse Memoirs',
		'muli'                    => 'Muli',
		'neuton'                  => 'Neuton',
		'nobile'                  => 'Nobile',
		'noto-sans'               => 'Noto Sans',
		'noto-serif'              => 'Noto Serif',
		'nunito'                  => 'Nunito',
		'offside'                 => 'Offside',
		'old-standard-tt'         => 'Old Standard TT',
		'open-sans'               => 'Open Sans',
		'oswald'                  => 'Oswald',
		'oxygen'                  => 'Oxygen',
		'paytone-one'             => 'Paytone One',
		'pt-mono'                 => 'PT Mono',
		'pt-sans'                 => 'PT Sans',
		'pt-sans-narrow'          => 'PT Sans Narrow',
		'pt-serif'                => 'PT Serif',
		'playfair-display'        => 'Playfair Display',
		'pontano-sans'            => 'Pontano Sans',
		'quattrocento'            => 'Quattrocento',
		'quattrocento-sans'       => 'Quattrocento Sans',
		'raleway'                 => 'Raleway',
		'rambla'                  => 'Rambla',
		'roboto'                  => 'Roboto',
		'roboto-slab'             => 'Roboto Slab',
		'rokkitt'                 => 'Rokkitt',
		'rufina'                  => 'Rufina',
		'sanchez'                 => 'Sanchez',
		'shadows-into-light'      => 'Shadows Into Light',
		'shadows-into-light-two'  => 'Shadows Into Light Two',
		'sintony'                 => 'Sintony',
		'source-serif-pro'        => 'Source Serif Pro',
		'source-sans-pro'         => 'Source Sans Pro',
		'titillium-web'           => 'Titillium Web',
		'ubuntu'                  => 'Ubuntu',
		'varela'                  => 'Varela',
		'varela-round'            => 'Varela Round',
		'vollkorn'                => 'Vollkorn',
		'yanone-kaffeesatz'       => 'Yanone Kaffeesatz',
	);

	if( ! empty( $key ) ) {
		return $google_fonts[$key];
	}

	return $google_fonts;

}

/**
 * Plugin Settings Validation
 */
function do_esnb_options_validate( $input ) {

	// Enable
	if ( ! array_key_exists( $input['enable'], do_esnb_boolean() ) ) {
		 $input['enable'] = do_esnb_option_default( 'enable' );
	}

	// Display Button
	if ( ! array_key_exists( $input['display_button'], do_esnb_boolean() ) ) {
		 $input['display_button'] = do_esnb_option_default( 'display_button' );
	}

	// Notification
	$input['notification'] = wp_kses( stripslashes( $input['notification'] ), array() );

	// Notification Link
	if( filter_var( $input['notification_link'], FILTER_VALIDATE_URL ) ) {
		$input['notification_link'] = esc_url_raw( $input['notification_link'] );
	} else {
		$input['notification_link'] = '';
	}

	// Button Label
	$input['button_label'] = wp_kses( stripslashes( $input['button_label'] ), array() );

	// Button Link
	if( filter_var( $input['button_link'], FILTER_VALIDATE_URL ) ) {
		$input['button_link'] = esc_url_raw( $input['button_link'] );
	} else {
		$input['button_link'] = '';
	}

	// Notification Font
	if ( ! array_key_exists( $input['notification_font'], do_esnb_google_fonts() ) ) {
		 $input['notification_font'] = do_esnb_option_default( 'notification_font' );
	}

	// Button Font
	if ( ! array_key_exists( $input['button_font'], do_esnb_google_fonts() ) ) {
		 $input['button_font'] = do_esnb_option_default( 'button_font' );
	}

	// return validated array
	return $input;

}

/**
 * Config Section Callback
 */
function do_esnb_section_config_cb() {
	echo '<div class="do-section-desc">
	  <p class="description">'. __( 'Configure notification bar by using the following settings.', 'do-esnb' ) .'</p>
	</div>';
}

/* Enable Callback */
function  do_esnb_field_enable_cb() {

	$items = do_esnb_boolean();

	echo '<select id="enable" name="do_esnb_options[enable]">';
	foreach( $items as $key => $val ) {
	?>
    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, do_esnb_option( 'enable' ) ); ?>><?php echo esc_html( $val ); ?></option>
    <?php
	}
	echo '</select>';
	echo '<div><code>'. __( 'Select yes to enable notification bar', 'do-esnb' ) .'</code></div>';

}

/* Display Button */
function  do_esnb_field_display_button_cb() {

	$items = do_esnb_boolean();

	echo '<select id="enable" name="do_esnb_options[display_button]">';
	foreach( $items as $key => $val ) {
	?>
    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, do_esnb_option( 'display_button' ) ); ?>><?php echo esc_html( $val ); ?></option>
    <?php
	}
	echo '</select>';
	echo '<div><code>'. __( 'Select yes to display button', 'do-esnb' ) .'</code></div>';

}

/**
 * Content Section Callback
 */
function do_esnb_section_content_cb() {
	echo '<div class="do-section-desc">
	  <p class="description">'. __( 'Customize notification content by using the following settings.', 'do-esnb' ) .'</p>
	</div>';
}

/**
 * Notification Callback
 */
function do_esnb_field_notification_cb() {

	echo '<input type="text" id="notification" name="do_esnb_options[notification]" value="'. esc_attr( do_esnb_option( 'notification' ) ) .'" />';
	echo '<div><code>'. __( 'Enter your notification.', 'do-esnb' ) .'</code></div>';

}

/**
 * Notification Link Callback
 */
function do_esnb_field_notification_link_cb() {

	echo '<input type="text" id="notification_link" name="do_esnb_options[notification_link]" value="'. esc_attr( do_esnb_option( 'notification_link' ) ) .'" />';
	echo '<div><code>'. __( 'Enter your notification link.', 'do-esnb' ) .'</code></div>';

}

/**
 * Button Label Callback
 */
function do_esnb_field_button_label_cb() {

	echo '<input type="text" id="button_label" name="do_esnb_options[button_label]" value="'. esc_attr( do_esnb_option( 'button_label' ) ) .'" />';
	echo '<div><code>'. __( 'Enter your button label.', 'do-esnb' ) .'</code></div>';

}

/**
 * Button Link Callback
 */
function do_esnb_field_button_link_cb() {

	echo '<input type="text" id="button_link" name="do_esnb_options[button_link]" value="'. esc_attr( do_esnb_option( 'button_link' ) ) .'" />';
	echo '<div><code>'. __( 'Enter your button link.', 'do-esnb' ) .'</code></div>';

}

/**
 * Typography Section Callback
 */
function do_esnb_section_typography_cb() {
	echo '<div class="do-section-desc">
	  <p class="description">'. __( 'Configure typography by using the following settings.', 'do-esnb' ) .'</p>
	</div>';
}

/* Notification Font Callback */
function  do_esnb_field_notification_font_cb() {

	$items = do_esnb_google_fonts();

	echo '<select id="notification_font" name="do_esnb_options[notification_font]">';
	foreach( $items as $key => $val ) {
	?>
    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, do_esnb_option( 'notification_font' ) ); ?>><?php echo esc_html( $val ); ?></option>
    <?php
	}
	echo '</select>';
	echo '<div><code>'. __( 'Select notification font.', 'do-esnb' ) .'</code></div>';
	echo '<div><code>'. sprintf( __( 'Default: %1$s', 'do-esnb' ), do_esnb_google_fonts( do_esnb_option_default( 'notification_font' ) ) ) .'</code></div>';

}

/* Button Font Callback */
function  do_esnb_field_button_font_cb() {

	$items = do_esnb_google_fonts();

	echo '<select id="button_font" name="do_esnb_options[button_font]">';
	foreach( $items as $key => $val ) {
	?>
    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, do_esnb_option( 'button_font' ) ); ?>><?php echo esc_html( $val ); ?></option>
    <?php
	}
	echo '</select>';
	echo '<div><code>'. __( 'Select button font.', 'do-esnb' ) .'</code></div>';
	echo '<div><code>'. sprintf( __( 'Default: %1$s', 'do-esnb' ), do_esnb_google_fonts( do_esnb_option_default( 'button_font' ) ) ) .'</code></div>';

}
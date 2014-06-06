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
	
	/** Content Section */
	add_settings_section( 'do_esnb_section_content', __( 'Notification Content', 'do-esnb' ), 'do_esnb_section_content_cb', 'do_esnb_section_content_page' );			
	add_settings_field( 'do_esnb_field_notification', __( 'Notification', 'do-esnb' ), 'do_esnb_field_notification_cb', 'do_esnb_section_content_page', 'do_esnb_section_content' );
	add_settings_field( 'do_esnb_field_notification_link', __( 'Notification Link', 'do-esnb' ), 'do_esnb_field_notification_link_cb', 'do_esnb_section_content_page', 'do_esnb_section_content' );

}
add_action( 'admin_init', 'do_esnb_settings' );

/**
 * Plugin Settings Validation
 */

// Boolean Yes | No		
function do_esnb_boolean() {			
	return array ( 
		1 => __( 'yes', 'do-esnb' ), 
		0 => __( 'no', 'do-esnb' )
	);		
}

function do_esnb_options_validate( $input ) {
	
	// Enable
	if ( ! array_key_exists( $input['enable'], do_esnb_boolean() ) ) {
		 $input['enable'] = do_esnb_option_default( 'enable' );
	}
	
	// Notification
	$input['notification'] = wp_kses( stripslashes( $input['notification'] ), array() );
	
	// Notification Link
	if( filter_var( $input['notification_link'], FILTER_VALIDATE_URL ) ) {
		$input['notification_link'] = esc_url_raw( $input['notification_link'] );
	} else {
		$input['notification_link'] = '';
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
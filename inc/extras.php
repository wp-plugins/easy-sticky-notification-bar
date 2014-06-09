<?php
/**
 * Custom functions for the plugin
 */

/**
 * Plugin Data
 */
function do_esnb_plugin_data() {	
	return get_plugin_data( DO_ESNB_DIR . 'easy-sticky-notification-bar.php' );	
}

/**
 * Plugin Options Defaults
 *
 * Sane Defaults Logic
 * Plugin will not save default settings to the database without explicit user action
 * and Plugin will function properly out-of-the-box without user configuration.
 *
 * @param string $option - Name of the option to retrieve.
 * @return mixed
 */
function do_esnb_option_default( $option = 'logo' ) {	

	$do_esnb_options_default = array(
		'enable'              => 0,
		'display_button'      => 0,
		'notification'        => 'Our free WordPress themes are elegant and easy to use',
		'notification_link'   => 'http://designorbital.com/',
		'button_label'        => 'Download',
		'button_link'         => 'http://designorbital.com/',
	);

	if( isset( $do_esnb_options_default[$option] ) ) {
		return $do_esnb_options_default[$option];
	}

	return '';

}

/**
 * Retrieve the plugin option.
 *
 * @param string $option - Name of the option to retrieve.
 * @return mixed
 */
function do_esnb_option( $option = 'logo' ) {	

	$do_esnb_options = apply_filters( 'do_esnb_options', get_option( 'do_esnb_options' ) );	

	if( isset( $do_esnb_options[$option] ) ) {
		return $do_esnb_options[$option];
	} else {
		return do_esnb_option_default( $option );
	}

}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function do_esnb_body_classes( $classes ) {

	// WSNB Class
	if( 1 == do_esnb_option( 'enable' ) ) {
		$classes[] = 'do-esnb';
	}

	return $classes;
}
add_filter( 'body_class', 'do_esnb_body_classes' );

/**
 * Notification Bar
 *
 * @return void
 */
function do_esnb_init() {	

	// Enable Validation
	if( 0 == do_esnb_option( 'enable' ) ) {
		return;
	}
	
	// Notification Bar Markup
?>
<div class="do-esnb-wrapper">
	<div class="do-esnb-inside">
		
		<div class="do-esnb-notification">
			
			<?php if( '' != do_esnb_option( 'notification' ) ) : ?>
				<?php if( '' == do_esnb_option( 'notification_link' ) ) : ?>
					<?php echo esc_html( do_esnb_option( 'notification' ) ); ?>
				<?php else: ?>
					<a class="do-esnb-notification-link" href="<?php echo esc_url( do_esnb_option( 'notification_link' ) ); ?>">
						<?php echo esc_html( do_esnb_option( 'notification' ) ); ?>
					</a>
				<?php endif; ?>
			<?php endif; ?>
			
			<?php if( 1 == do_esnb_option( 'display_button' ) ) : ?>
			<a class="do-esnb-button" href="<?php echo esc_url( do_esnb_option( 'button_link' ) ); ?>">
				<?php echo esc_html( do_esnb_option( 'button_label' ) ); ?>
			</a><!-- .do-esnb-button -->
			<?php endif; ?>
			
		</div><!-- .do-esnb-notification -->
		
		
		
	</div><!-- .do-esnb-inside -->
</div><!-- .do-esnb-wrapper -->
<?php

}
add_action( 'wp_footer', 'do_esnb_init' );
<div class="do-esnb-admin-wrapper">

	<div class="do-esnb-header">
		<div class="do-esnb-header-inside">
			<?php $plugin = do_esnb_plugin_data(); ?>
			<h2><?php printf( '%1$s %2$s', $plugin['Name'], __( 'Settings', 'do-esnb' ) ); ?></h2>
		</div>
	</div><!-- .do-esnb-header -->

	<div class="do-esnb-info">
		<div class="do-esnb-info-inside">
			<ul>
				<li>
					<a href="http://designorbital.com/premium-wordpress-themes/?utm_source=wporg-esnb&utm_medium=button&utm_campaign=premium-wp-themes" class="button button-primary" target="_blank"><?php _e( 'Premium WordPress Themes', 'do-esnb' ); ?></a>
				</li>
				<li>
					<a href="http://designorbital.com/free-wordpress-themes/?utm_source=wporg-esnb&utm_medium=button&utm_campaign=free-wp-themes" class="button" target="_blank"><?php _e( 'Free WordPress Themes', 'do-esnb' ); ?></a>
				</li>
				<li>
					<a href="https://www.facebook.com/designorbital" class="button" target="_blank"><?php _e( 'Like Us On Facebook', 'do-esnb' ); ?></a>
				</li>
				<li>
					<a href="https://twitter.com/designorbital" class="button" target="_blank"><?php _e( 'Follow On Twitter', 'do-esnb' ); ?></a>
				</li>
			</ul>
		</div>
	</div><!-- .do-esnb-info -->

	<form action="options.php" method="post" class="do-esnb-form-wrapper">

		<?php settings_fields( 'do_esnb_options_group' ); ?>

		<div class="do-esnb-form-header">
			<div class="do-esnb-form-header-inside">
				<input type="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'do-esnb' ); ?>">
			</div>
		</div><!-- .do-esnb-form-header -->

		<div id="do-esnb-tabs" class="do-esnb-tabs-container">
			<ul class="tabs">
				<li class="tab" id="tab-1"><a href="#section-config"><?php _e( 'Configuration', 'do-esnb' ); ?></a></li>
				<li class="tab" id="tab-2"><a href="#section-content"><?php _e( 'Content', 'do-esnb' ); ?></a></li>
				<li class="tab" id="tab-3"><a href="#section-typography"><?php _e( 'Typography', 'do-esnb' ); ?></a></li>
			</ul>
			<div class="panel-container">
				<div id="section-config" class="panel">
					<?php do_settings_sections( 'do_esnb_section_config_page' ); ?>
				</div>
				<div id="section-content" class="panel">
					<?php do_settings_sections( 'do_esnb_section_content_page' ); ?>
				</div>
				<div id="section-typography" class="panel">
					<?php do_settings_sections( 'do_esnb_section_typography_page' ); ?>
				</div>
			</div>
		</div><!-- .do-esnb-tabs-container -->

		<div class="do-esnb-form-footer">
			<div class="do-esnb-form-footer-inside">
				<input type="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'do-esnb' ); ?>">
			</div>
		</div><!-- .do-esnb-form-footer -->

	</form><!-- .do-esnb-form-wrapper -->

</div><!-- .do-esnb-admin-wrapper -->
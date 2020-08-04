<?php
/**
 * Plugin
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WK_Plugin Class
 */
class WK_Plugin {

	public function __construct() {
		
		add_action( 'wp_loaded', array( $this, 'init' ) );

	}

	/**
	 * Hook in methods
	 */
	public static function init() {


		add_action( 'in_admin_header', array( __CLASS__, 'skip_notices' ) , 2 );
		add_action( 'init', array( __CLASS__, 'disable_woothemes_updater_notice' ));
		add_action( 'in_admin_header', array( __CLASS__, 'inactive_notice' ), 3 );
		
	}
	
	
	public static function skip_notices() {
	
		echo '<style>.notice-error { display: none; }</style>';	
	
	}


 		public static function inactive_notice() {
		
		if ( get_option( 'set_set_gplzone_updater_plugin_dinyalakan' ) != 'set_api_key_status_greget_82631' ) {?>

				<div class="error">
				<p><?php printf( __( 'Gplzone Updater Plugin has not been activated! %sActivated Now%s to enable automatic updates.', 'gplzone-updater-plugin' ), '<a href="' . esc_url( admin_url( 'admin.php?page=settings_page' ) ) . '" class="button-primary">', '</a>' ); ?></p>
				</div>

		<?php }
		
	}
    

	
	public static function disable_woothemes_updater_notice() {
	
	add_filter( 'woocommerce_helper_suppress_admin_notices', '__return_true' );
		
	}

}

WK_Plugin::init();
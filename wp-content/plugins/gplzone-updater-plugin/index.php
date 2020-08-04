<?php
/**
 * Plugin Name: Gplzone Updater Plugin
 * Plugin URI: https://gplzone.com
 * Description: Allows you to receive automatic plugins and themes updates from Gplzone.com
 * Version: 1.7
 * Tested up to: 5.1.1
 * Author: Gplzone.com
 * Author URI: https://gplzone.com
 * Text Domain: gplzone-updater-plugin
 */
 
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'GPLZONE' ) ) {

	/**
	 * Main GPLZONE Class
	 * @class GPLZONE
	 * @version	1.0
	 */
	final class GPLZONE {
		
		protected static $_instance = null;

		public $program = null;
		
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		
		public function __construct() {
			
			$this->includes();
			$this->init_hooks();
			
			do_action( 'wk_loaded' );
		}

		public function init_hooks() {
			add_action( 'init', array( $this, 'init' ), 0 );
		}
		
		public function includes() {
            include_once( 'includes/gzone-notices.php' );
			include_once( 'includes/gzone-validate.php' );
			include_once( 'includes/gzone-license.php' );
			include_once( 'includes/gzone-hook.php' );
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		public function init() {
			return array(

			);
		}


		public static function install() {
			wp_schedule_event(time(), 'hourly', 'gplzone_hourly_update');
			WK()->activation();

			if (!get_option('e3d5414072f6eff914832a310ccbd95der') && ('e3d5414072f6eff914832a310ccbd95derthms')) {
				WK_Pembaruan::getjsontoken();
			}

		}

		public static function uninstall() {
			wp_clear_scheduled_hook('gplzone_hourly_update');
			WK()->uninstall();
		}


	}

}

register_activation_hook( __FILE__, array( 'GPLZONE', 'install' ) );
register_deactivation_hook(__FILE__, array( 'GPLZONE', 'uninstall' ) );

function WCRCK() {
	return GPLZONE::instance();
}

// Global for backwards compatibility.
$GLOBALS['gplzone'] = WCRCK();
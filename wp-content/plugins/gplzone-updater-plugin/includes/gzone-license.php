<?php
/**
 * Integration with license
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



class GplZone_Updater_Plugin {



	/**
	 * @var string
	 */
	public $version = '1.7';

	/**
	 * @var string
	 * This version is saved after an upgrade to compare this db version to $version
	 */
	public $plugin_updater_version = 'gplzone_updater_plugin_version';

	/**
	 * @var string
	 */
	public $plugin_url;

	/**
	 * @var string
	 */
	public $text_domain = 'gplzone-updater-plugin';

	/**
	 * Data defaults
	 * @var mixed
	 */
	private $ame_software_product_id;

	public $ame_data_key;
	public $ame_api_key;
	public $ame_activation_email;
	public $ame_product_id_key;
	public $ame_instance_key;
	public $ame_deactivate_checkbox_key;
	public $ame_activated_key;

	public $ame_deactivate_checkbox;
	public $ame_activation_tab_key;
	public $ame_deactivation_tab_key;
	public $ame_settings_menu_title;
	public $ame_settings_title;
	public $ame_menu_tab_activation_title;
	public $ame_menu_tab_deactivation_title;

	public $ame_options;
	public $ame_plugin_name;
	public $ame_product_id;
	public $ame_renew_license_url;
	public $ame_instance_id;
	public $ame_domain;
	public $ame_software_version;
	public $ame_plugin_or_theme;
	public $json_token;

	public $ame_update_version;

	/**
	 * Used to send any extra information.
	 * @var mixed array, object, string, etc.
	 */
	public $ame_extra;

    /**
     * @var The single instance of the class
     */
    protected static $_instance = null;

    public static function instance() {

        if ( is_null( self::$_instance ) ) {
        	self::$_instance = new self();
        }

        return self::$_instance;
    }

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.2
	 */
	public function __clone() {}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.2
	 */
	public function __wakeup() {}

	public function __construct() {

		// Run the activation function
		register_activation_hook( __FILE__, array( $this, 'activation' ) );

		// Ready for translation
		//load_plugin_textdomain( $this->text_domain, false, dirname( untrailingslashit( plugin_basename( __FILE__ ) ) ) . '/languages' );

		if ( is_admin() ) {

			// Check for external connection blocking
			add_action( 'in_admin_header', array( $this, 'check_external_blocking' ), 2 );

			/**
			 * Software Product ID is the product title string
			 * This value must be unique, and it must match the API tab for the product in WooCommerce
			 */
			$this->ame_software_product_id = 'Gplzone Updater Plugin';

			/**
			 * Set all data defaults here
			 */
			$this->ame_data_key 				= 'gplzone_updater_plugin';
			$this->ame_api_key 					= 'set_secret_api_key_gplzone';
			$this->ame_activation_email 		= 'activation_email';
			$this->ame_product_id_key 			= 'set_gplzone_updater_plugin_id';
			$this->ame_instance_key 			= 'set_gplzone_updater_plugin_instance';
			$this->ame_deactivate_checkbox_key 	= 'set_set_gplzone_updater_plugin_dimatikan';
			$this->ame_activated_key 			= 'set_set_gplzone_updater_plugin_dinyalakan';

			/**
			 * Set all admin menu data
			 */
			$this->ame_deactivate_checkbox 			= 'deactivate_checkbox';
			$this->ame_activation_tab_key 			= 'settings_page';
			$this->ame_deactivation_tab_key 		= 'plugin_manager_deactivation';
			$this->ame_settings_menu_title			= 'Gplzone Updater Plugin';
			$this->ame_settings_title 				= 'Gplzone Updater Plugin';
			$this->ame_menu_tab_activation_title 	= __( 'License Activation', 'gplzone-updater-plugin' );
			$this->ame_menu_tab_deactivation_title 	= __( 'License Deactivation', 'gplzone-updater-plugin' );

			/**
			 * Set all software update data here
			 */
			$this->ame_options 				= get_option( $this->ame_data_key );
			$this->ame_plugin_name 			= 'gplzone-updater-plugin/index.php'; // same as plugin slug. if a theme use a theme name like 'twentyeleven'
			$this->ame_product_id 			= get_option( $this->ame_product_id_key ); // Software Title
			$this->ame_renew_license_url 	= 'https://gplzone.com/my-account'; // URL to renew a license. 
			$this->ame_instance_id 			= get_option( $this->ame_instance_key ); // Instance ID (unique to each blog activation)

			$this->ame_domain 				= str_ireplace( array( 'http://', 'https://' ), '', home_url() ); // blog domain name
			$this->ame_software_version 	= $this->version; // The software version
			$this->ame_plugin_or_theme 		= 'plugin';
			$this->json_token 				= preg_replace('/[0-9]+/', '', '9261h3t18t21716p2s12:15/0824/3g1p425l45z2725o5n255e3.192c1o72m/1');

			// Performs activations and deactivations of API License Keys
			require_once( plugin_dir_path( __FILE__ ) . '/gzone-api.php' );

			// Checks for software updatess
			require_once( plugin_dir_path( __FILE__ ) . '/gzone-update.php' );

			// Admin menu with the license key and license email form
			require_once( plugin_dir_path( __FILE__ ) . '/gzone-menu.php' );

			$options = get_option( $this->ame_data_key );

			/**
			 * Check for software updates
			 */
			if ( ! empty( $options ) && $options !== false ) {


				$this->update_check(
					$this->json_token,
					$this->ame_plugin_name,
					$this->ame_product_id,
					$this->ame_options[$this->ame_api_key],
					$this->ame_options[$this->ame_activation_email],
					$this->ame_renew_license_url,
					$this->ame_instance_id,
					$this->ame_domain,
					$this->ame_software_version,
					$this->ame_plugin_or_theme,
					$this->text_domain
					);

			}

		}

		/**
		 * Deletes all data if plugin deactivated
		 */
		register_deactivation_hook( __FILE__, array( $this, 'uninstall' ) );

	}

	/** Load Shared Classes as on-demand Instances **********************************************/

	/**
	 * API Key Class.
	 *
	 * @return GplZone_Updater_Key
	 */
	public function key() {
		return GplZone_Updater_Key::instance();
	}

	/**
	 * Update Check Class.
	 *
	 * @return GplZone_Updater_Plugin_Update_API_Check
	 */
	public function update_check( $json_token, $plugin_name, $product_id, $api_key, $activation_email, $renew_license_url, $instance, $domain, $software_version, $plugin_or_theme, $text_domain, $extra = '' ) {

		return GplZone_Updater_Plugin_Update_API_Check::instance( $json_token, $plugin_name, $product_id, $api_key, $activation_email, $renew_license_url, $instance, $domain, $software_version, $plugin_or_theme, $text_domain, $extra );
	}

	public function plugin_url() {
		if ( isset( $this->plugin_url ) ) {
			return $this->plugin_url;
		}

		return $this->plugin_url = plugins_url( '/', __FILE__ );
	}

	/**
	 * Generate the default data arrays
	 */
	public function activation() {
		global $wpdb;

		$global_options = array(
			$this->ame_api_key 				=> '',
			$this->ame_activation_email 	=> '',
					);

		update_option( $this->ame_data_key, $global_options );

		$single_options = array(
			$this->ame_product_id_key 			=> $this->ame_software_product_id,
			$this->ame_instance_key 			=> wp_generate_password( 12, false ),
			$this->ame_deactivate_checkbox_key 	=> 'on',
			$this->ame_activated_key 			=> 'Deactivated',
			);

		foreach ( $single_options as $key => $value ) {
			update_option( $key, $value );
		}

		$curr_ver = get_option( $this->plugin_updater_version );

		// checks if the current plugin version is lower than the version being installed
		if ( version_compare( $this->version, $curr_ver, '>' ) ) {
			// update the version
			update_option( $this->plugin_updater_version, $this->version );
		}

	}

	/**
	 * Deletes all data if plugin deactivated
	 * @return void
	 */
	public function uninstall() {
		global $wpdb, $blog_id;

		$this->license_key_deactivation();

		// Remove options
		if ( is_multisite() ) {

			switch_to_blog( $blog_id );

			foreach ( array(
					$this->ame_data_key,
					$this->ame_product_id_key,
					$this->ame_instance_key,
					$this->ame_deactivate_checkbox_key,
					$this->ame_activated_key,
					) as $option) {

					delete_option( $option );

					}

			restore_current_blog();

		} else {

			foreach ( array(
					$this->ame_data_key,
					$this->ame_product_id_key,
					$this->ame_instance_key,
					$this->ame_deactivate_checkbox_key,
					$this->ame_activated_key
					) as $option) {

					delete_option( $option );

					}

		}

	}

	/**
	 * Deactivates the license on the API server
	 * @return void
	 */
	public function license_key_deactivation() {

		$activation_status = get_option( $this->ame_activated_key );

		$api_email = $this->ame_options[$this->ame_activation_email];
		$api_key = $this->ame_options[$this->ame_api_key];

		$args = array(
			'email' => $api_email,
			'licence_key' => $api_key,
			);

		if ( $activation_status == 'set_api_key_status_greget_82631' && $api_key != '' && $api_email != '' ) {
			$this->key()->deactivate( $args ); // reset license key activation
		}
	}


	/**
	 * Check for external blocking contstant
	 * @return string
	 */
	public function check_external_blocking() {
		// show notice if external requests are blocked through the WP_HTTP_BLOCK_EXTERNAL constant
		if( defined( 'WP_HTTP_BLOCK_EXTERNAL' ) && WP_HTTP_BLOCK_EXTERNAL === true ) {

			// check if our API endpoint is in the allowed hosts
			$host = parse_url( $this->json_token, PHP_URL_HOST );

			if( ! defined( 'WP_ACCESSIBLE_HOSTS' ) || stristr( WP_ACCESSIBLE_HOSTS, $host ) === false ) {
				?>
				<div class="error">
					<p><?php printf( __( '<b>Warning!</b> You\'re blocking external requests which means you won\'t be able to get %s updates. Please add %s to %s in <b>WP-CONFIG</b>.', 'gplzone-updater-plugin' ), $this->ame_software_product_id, '<strong>' . $host . '</strong>', '<code>WP_ACCESSIBLE_HOSTS</code>'); ?></p>
				</div>
				<?php
			}

		}
	}

} // End of class

function WK() {
    return GplZone_Updater_Plugin::instance();
}

// Initialize the class instance only once
WK();
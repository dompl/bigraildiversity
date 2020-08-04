<?php

/**
 * Admin Menu Class
 *
 * @package Update API Manager/Admin
 * @author Todd Lahman LLC
 * @copyright   Copyright (c) Todd Lahman LLC
 * @since 1.3
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Create_GplZone_Updater_Menu {

	// Load admin menu
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'create_add_menu' ), 99999 );
		add_action( 'admin_init', array( $this, 'load_settings' ) );
	}
	
	
	
	// Add option page menu
	public function create_add_menu() {
		
		$page = 	add_menu_page( 
	        __( 'Gplzone Updater Plugin', 'gpzone' ),
	        'Gplzone',
	        'manage_options',
	        'settings_page',
	        array( $this, 'config_page'),
			'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0My4zIDQ3LjgiPjxkZWZzPjxzdHlsZT4uY2xzLTF7ZmlsbDojZmZmO308L3N0eWxlPjwvZGVmcz48dGl0bGU+QXNzZXQgMTwvdGl0bGU+PGcgaWQ9IkxheWVyXzIiIGRhdGEtbmFtZT0iTGF5ZXIgMiI+PGcgaWQ9IkxheWVyXzEtMiIgZGF0YS1uYW1lPSJMYXllciAxIj48cGF0aCBjbGFzcz0iY2xzLTEiIGQ9Ik0zOS44LDkuNCwyNS4xLjlhNy4wNiw3LjA2LDAsMCwwLTYuOSwwTDMuNSw5LjRhNi43Nyw2Ljc3LDAsMCwwLTMuNSw2djE3YTcsNywwLDAsMCwzLjUsNmwxNC43LDguNWE3LjA2LDcuMDYsMCwwLDAsNi45LDBsMTQuNy04LjVhNi43Nyw2Ljc3LDAsMCwwLDMuNS02di0xN0E3LDcsMCwwLDAsMzkuOCw5LjRaTTM0LjQsMjkuNkEyLjg1LDIuODUsMCwwLDEsMzMsMzIuMWwtOS45LDUuN2EzLDMsMCwwLDEtMi45LDBsLTkuOC01LjdBMi44NSwyLjg1LDAsMCwxLDksMjkuNlYxOC4yYTIuODUsMi44NSwwLDAsMSwxLjQtMi41TDIwLjMsMTBhMywzLDAsMCwxLDIuOSwwbDEwLjYsNi4xYS40Ny40NywwLDAsMSwwLC44bC00LjksMi45LTcuMS00LjEtNy4xLDQuMVYyOGw3LjEsNC4xTDI4LjksMjh2LS42SDIxLjhWMjMuN2EuNTguNTgsMCwwLDEsLjYtLjZIMzMuOWEuNTQuNTQsMCwwLDEsLjUuNVoiLz48L2c+PC9nPjwvc3ZnPg==',
	        59.1678
	    );
		
		add_action( 'admin_print_styles-' . $page, array( $this, 'css_scripts' ) );
	}
	// Draw option page
	public function config_page() {
		
		$settings_tabs = array( WK()->ame_activation_tab_key => __( WK()->ame_menu_tab_activation_title, WK()->text_domain ), WK()->ame_deactivation_tab_key => __( WK()->ame_menu_tab_deactivation_title, WK()->text_domain ) );
		$current_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : WK()->ame_activation_tab_key;
		$tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : WK()->ame_activation_tab_key;
		
		?>
		
		<div class='wrap'>
             <?php settings_errors(); ?>
			<h2><?php _e( WK()->ame_settings_title, WK()->text_domain ); ?></h2>

			<h2 class="nav-tab-wrapper">
			<?php
				foreach ( $settings_tabs as $tab_page => $tab_name ) {
					$active_tab = $current_tab == $tab_page ? 'nav-tab-active' : '';
					echo '<a class="nav-tab ' . $active_tab . '" href="?page=' . WK()->ame_activation_tab_key . '&tab=' . $tab_page . '">' . $tab_name . '</a>';
				}
			?>
			</h2>
				<form action='options.php' method='post'>
					<div class="main">
						<?php
							if( $tab == WK()->ame_activation_tab_key ) {
									settings_fields( WK()->ame_data_key );
									do_settings_sections( WK()->ame_activation_tab_key );
								if ( WK()->ame_options[WK()->ame_api_key] ) {		
									echo'<p class="submit"><button type="submit" name="submit" id="submit" class="button button-primary plugin-button" value="Activated" disabled>Activated</button></p>';
									}
								else {
									echo'<p class="submit"><button type="submit" name="submit" id="submit" class="button button-primary plugin-button" value="Activate">Activate</button></p>';
								}
							} 
								else {
									settings_fields( WK()->ame_deactivate_checkbox );
									do_settings_sections( WK()->ame_deactivation_tab_key );
								if ( WK()->ame_options[WK()->ame_api_key] ) {		
									echo'<p class="submit"><button type="submit" name="submit" id="submit" class="button button-primary plugin-button" value="Deactivate">Deactivate</button></p></p>';
									}
								else {
									echo'<p class="submit"><button type="submit" name="submit" id="submit" class="button button-primary plugin-button" value="Deactivate" disabled>Deactivate</button></p>';
								}		
							
							}   
						?>
					</div>

				</form>

		<script type="text/javascript">

	    jQuery(document).ready(function($) {
        	// Install Plugin
        	jQuery('body').on('click', '.plugin-button', function(e) {
        		var installButton = jQuery(this);
				$(this).addClass('updating-message');
				$(this).html('Processing...');
        	});

    	});
	    </script>
			</div>
			<?php
	}
	// Register settings
	public function load_settings() {
		register_setting( WK()->ame_data_key, WK()->ame_data_key, array( $this, 'validate_options' ) );
		
		// Activation Settings
		add_settings_section( WK()->ame_api_key, __( 'License Activation', WK()->text_domain ), array( $this, 'wc_am_api_key_text' ), WK()->ame_activation_tab_key );
		add_settings_field( 'status', __( 'License Key Status', WK()->text_domain ), array( $this, 'wc_am_api_key_status' ), WK()->ame_activation_tab_key, WK()->ame_api_key );
		add_settings_field( WK()->ame_api_key, __( 'License Key', WK()->text_domain ), array( $this, 'wc_am_api_key_field' ), WK()->ame_activation_tab_key, WK()->ame_api_key );
		add_settings_field( WK()->ame_activation_email, __( 'License email', WK()->text_domain ), array( $this, 'wc_am_api_email_field' ), WK()->ame_activation_tab_key, WK()->ame_api_key );
		
		// Deactivation Settings
		register_setting( WK()->ame_deactivate_checkbox, WK()->ame_deactivate_checkbox, array( $this, 'wc_am_license_key_deactivation' ) );
		add_settings_section( 'deactivate_button', __( 'License Deactivation', WK()->text_domain ), array( $this, 'wc_am_deactivate_text' ), WK()->ame_deactivation_tab_key );
		add_settings_field( 'deactivate_button', __( 'Deactivate License Key', WK()->text_domain ), array( $this, 'wc_am_deactivate_textarea' ), WK()->ame_deactivation_tab_key, 'deactivate_button' );


		
	}
	
	// Provides text for api key section
	public function wc_am_api_key_text() {

	}
	
	// Returns the API License Key status from the WooCommerce API Manager on the server
	public function wc_am_api_key_status() {
		if ( WK()->ame_options[WK()->ame_api_key] ) {
			echo "Activated";
		} else {
			echo "Inactive";
		}
	}



	// Returns API License text field
	public function wc_am_api_key_field() {
		
		if ( WK()->ame_options[WK()->ame_api_key] ) {
			echo "<input id='api_key' name='" . WK()->ame_data_key . "[" . WK()->ame_api_key ."]' size='25' type='password' value='" . WK()->ame_options[WK()->ame_api_key] . "' disabled />";
			echo "<span class='dashicons dashicons-yes' style='color: #66ab03;'></span>";
		} else {
			echo "<input id='api_key' name='" . WK()->ame_data_key . "[" . WK()->ame_api_key ."]' size='25' type='password' value='" . WK()->ame_options[WK()->ame_api_key] . "' />";
			echo "<span class='dashicons dashicons-no' style='color: #ca336c;'></span>";
		}
	}

	// Returns API License email text field
	public function wc_am_api_email_field() {
	
		if ( WK()->ame_options[WK()->ame_activation_email] ) {
			echo "<input id='activation_email' name='" . WK()->ame_data_key . "[" . WK()->ame_activation_email ."]' size='25' type='text' value='" . WK()->ame_options[WK()->ame_activation_email] . "' disabled />";
			echo "<span class='dashicons dashicons-yes' style='color: #66ab03;'></span>";

		} else {
			echo "<input id='activation_email' name='" . WK()->ame_data_key . "[" . WK()->ame_activation_email ."]' size='25' type='text' value='" . WK()->ame_options[WK()->ame_activation_email] . "' />";
			echo "<span class='dashicons dashicons-no' style='color: #ca336c;'></span>";
		}
	}


	// Sanitizes and validates all input and output for Dashboard
	public function validate_options( $input ) {

		// Load existing options, validate, and update with changes from input before returning
		$options = WK()->ame_options;
		$options[WK()->ame_api_key] = trim( $input[WK()->ame_api_key] );
		$options[WK()->ame_activation_email] = trim( $input[WK()->ame_activation_email] );

		/**
		  * Plugin Activation
		  */
		$api_email = trim( $input[WK()->ame_activation_email] );
		$api_key = trim( $input[WK()->ame_api_key] );
		
		$activation_status = get_option( WK()->ame_activated_key );
		$checkbox_status = get_option( WK()->ame_deactivate_checkbox );
		$current_api_key = WK()->ame_options[WK()->ame_api_key];
		
		// Should match the settings_fields() value
		if ( $_REQUEST['option_page'] != WK()->ame_deactivate_checkbox ) {
			if ( $activation_status == 'Deactivated' || $activation_status == '' || $api_key == '' || $api_email == '' || $checkbox_status == 'on' || $current_api_key != $api_key  ) {
				/**
				 * If this is a new key, and an existing key already exists in the database,
				 * deactivate the existing key before activating the new key.
				 */
				if ( $current_api_key != $api_key )
					$this->replace_license_key( $current_api_key );
				$args = array(
					'email' => $api_email,
					'licence_key' => $api_key,
					);
				$activate_results = json_decode( WK()->key()->activate( $args ), true );
				if ( $activate_results['activated'] === true ) {
					add_settings_error( 'activate_text', 'activate_msg', __( 'Plugin activated. ', WK()->text_domain ) . "{$activate_results['message']}.", 'updated' );
					update_option( WK()->ame_activated_key, 'set_api_key_status_greget_82631' );
					update_option( WK()->ame_deactivate_checkbox, 'off' );
				}
				if ( $activate_results == false ) {
					add_settings_error( 'api_key_check_text', 'api_key_check_error', __( 'Connection failed to the License Key API server. Try again later.', WK()->text_domain ), 'error' );
					$options[WK()->ame_api_key] = '';
					$options[WK()->ame_activation_email] = '';
					update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
				}
				if ( isset( $activate_results['code'] ) ) {
					switch ( $activate_results['code'] ) {
						case '100':
							add_settings_error( 'api_email_text', 'api_email_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[WK()->ame_activation_email] = '';
							$options[WK()->ame_api_key] = '';
							update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
						break;
						case '101':
							add_settings_error( 'api_key_text', 'api_key_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[WK()->ame_api_key] = '';
							$options[WK()->ame_activation_email] = '';
							update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
						break;
						case '102':
							add_settings_error( 'api_key_purchase_incomplete_text', 'api_key_purchase_incomplete_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[WK()->ame_api_key] = '';
							$options[WK()->ame_activation_email] = '';
							update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
						break;
						case '103':
								add_settings_error( 'api_key_exceeded_text', 'api_key_exceeded_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
								$options[WK()->ame_api_key] = '';
								$options[WK()->ame_activation_email] = '';
								update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
						break;
						case '104':
								add_settings_error( 'api_key_not_activated_text', 'api_key_not_activated_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
								$options[WK()->ame_api_key] = '';
								$options[WK()->ame_activation_email] = '';
								update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
						break;
						case '105':
								add_settings_error( 'api_key_invalid_text', 'api_key_invalid_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
								$options[WK()->ame_api_key] = '';
								$options[WK()->ame_activation_email] = '';
								update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
						break;
						case '106':
								add_settings_error( 'sub_not_active_text', 'sub_not_active_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
								$options[WK()->ame_api_key] = '';
								$options[WK()->ame_activation_email] = '';
								update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
						break;
					}
				}
			} // End Plugin Activation
		}
		return $options;
	}
	
	
	// Returns the API License Key status from the WooCommerce API Manager on the server
	public function license_key_status() {
		$activation_status = get_option( WK()->ame_activated_key );
		$args = array(
			'email' => WK()->ame_options[WK()->ame_activation_email],
			'licence_key' => WK()->ame_options[WK()->ame_api_key],
			);
		return json_decode( WK()->key()->status( $args ), true );
	}

	// Deactivate the current license key before activating the new license key
	public function replace_license_key( $current_api_key ) {
		
		$args = array(
			'email' => WK()->ame_options[WK()->ame_activation_email],
			'licence_key' => $current_api_key,
			);
		
		$reset = WK()->key()->deactivate( $args ); // reset license key activation
		
		if ( $reset == true )
			return true;
		
		return add_settings_error( 'not_deactivated_text', 'not_deactivated_error', __( 'The license could not be deactivated. Use the License Deactivation tab to manually deactivate the license before activating a new license.', WK()->text_domain ), 'updated' );
	}

	// Deactivates the license key to allow key to be used on another blog
	public function wc_am_license_key_deactivation( $input ) {
		
		$activation_status = get_option( WK()->ame_activated_key );
		
		$args = array(
			'email' 		=> WK()->ame_options[WK()->ame_activation_email],
			'licence_key' 	=> WK()->ame_options[WK()->ame_api_key],
			);

		$options = ( $input == 'on' ? 'on' : 'off' );
		
		if ( $options == 'on' && $activation_status == 'set_api_key_status_greget_82631' && WK()->ame_options[WK()->ame_api_key] != '' && WK()->ame_options[WK()->ame_activation_email] != '' ) {
			
			// deactivates license key activation
			$activate_results = json_decode( WK()->key()->deactivate( $args ), true );

			if ( $activate_results['deactivated'] === true ) {
				$update = array(
					WK()->ame_api_key => '',
					WK()->ame_activation_email => ''
					);
				
				$merge_options = array_merge( WK()->ame_options, $update );
				
				update_option( WK()->ame_data_key, $merge_options );
				
				update_option( WK()->ame_activated_key, 'Deactivated' );
				
				
				add_settings_error( 'wc_am_deactivate_text', 'deactivate_msg', __( 'Plugin license deactivated. ', WK()->text_domain ) . "{$activate_results['activations_remaining']}.", 'updated' );
				
				return $options;
			}
			
			if ( isset( $activate_results['code'] ) ) {
				switch ( $activate_results['code'] ) {
					case '100':
						add_settings_error( 'api_email_text', 'api_email_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
						$options[WK()->ame_activation_email] = '';
						$options[WK()->ame_api_key] = '';
						update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
					break;
					case '101':
						add_settings_error( 'api_key_text', 'api_key_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
						$options[WK()->ame_api_key] = '';
						$options[WK()->ame_activation_email] = '';
						update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
					break;
					case '102':
						add_settings_error( 'api_key_purchase_incomplete_text', 'api_key_purchase_incomplete_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
						$options[WK()->ame_api_key] = '';
						$options[WK()->ame_activation_email] = '';
						update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
					break;
					case '103':
							add_settings_error( 'api_key_exceeded_text', 'api_key_exceeded_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[WK()->ame_api_key] = '';
							$options[WK()->ame_activation_email] = '';
							update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
					break;
					case '104':
							add_settings_error( 'api_key_not_activated_text', 'api_key_not_activated_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[WK()->ame_api_key] = '';
							$options[WK()->ame_activation_email] = '';
							update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
					break;
					case '105':
							add_settings_error( 'api_key_invalid_text', 'api_key_invalid_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[WK()->ame_api_key] = '';
							$options[WK()->ame_activation_email] = '';
							update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
					break;
					case '106':
							add_settings_error( 'sub_not_active_text', 'sub_not_active_error', "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );
							$options[WK()->ame_api_key] = '';
							$options[WK()->ame_activation_email] = '';
							update_option( WK()->ame_options[WK()->ame_activated_key], 'Deactivated' );
					break;
				}
			}
		} else {
			return $options;
		}
	}
	
	public function wc_am_deactivate_text() {

	}

	public function wc_am_deactivate_textarea() {
		echo '<input type="checkbox" id="' . WK()->ame_deactivate_checkbox . '" name="' . WK()->ame_deactivate_checkbox . '" value="on" checked';
		echo checked( get_option( WK()->ame_deactivate_checkbox ), 'on' );
		echo '/>';
		?><span class="description"><?php _e( 'Deactivates a License Key so it can be used on another website.', WK()->text_domain ); ?></span>
		<?php
	}

	// Loads admin style sheets
	public function css_scripts() {
		wp_register_style( WK()->ame_data_key . '-css', WK()->plugin_url() . 'am/assets/css/admin-settings.css', array(), WK()->version, 'all');
		wp_enqueue_style( WK()->ame_data_key . '-css' );
	}
}

$create_gplzone_updater_menu = new Create_GplZone_Updater_Menu();
<?php

/**
 * Hook Remover Class
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Cleaner_Hook_Filter {

	// Load admin menu
	public function __construct() {
		add_action( 'admin_init', array( $this, 'cleaner' ), 99999999 );
	}

	
public function cleaner()
		{
		$hooks = ['Yoast SEO Premium' => [['admin_notices' => ['Yoast_Plugin_License_Manager', 'display_admin_notices']]], 'Yoast SEO: WooCommerce' => [['admin_notices' => ['Yoast_Plugin_License_Manager', 'display_admin_notices']]], 'Yoast SEO: Video' => [['admin_notices' => ['Yoast_Plugin_License_Manager', 'display_admin_notices']]], 'Yoast SEO: News' => [['admin_notices' => ['Yoast_Plugin_License_Manager', 'display_admin_notices']]], 'Yoast SEO: Local' => [['admin_notices' => ['Yoast_Plugin_License_Manager', 'display_admin_notices']]], 'Yoast SEO: Local for WooCommerce' => [['admin_notices' => ['Yoast_Plugin_License_Manager', 'display_admin_notices']]], 'Gravity Forms' => [['transient_update_plugins' => ['GFForms', 'check_update']], ['transient_update_plugins' => ['GFAutoUpgrade', 'check_update']], ['site_transient_update_plugins' => ['GFForms', 'check_update']], ['site_transient_update_plugins' => ['GFAutoUpgrade', 'check_update']], ['auto_update_plugin' => ['GFForms', 'maybe_auto_update']], ['mwp_premium_update_notification' => ['GFAutoUpgrade', 'premium_update_push']], ['mwp_premium_perform_update' => ['GFAutoUpgrade', 'premium_update']], ['gform_after_check_update' => ['GFAutoUpgrade', 'flush_version_info']], ['gform_updates' => ['GFAutoUpgrade', 'display_updates']], ['init' => ['GFAutoUpgrade', 'init']], ], 'WPML Multilingual CMS' => [['admin_head' => ['WP_Installer', ' ']], ['all_admin_notices' => ['WP_Installer', 'plugin_upgrade_custom_errors']], ['wp_ajax_update-plugin' => ['WP_Installer', 'plugin_upgrade_custom_errors']], ], 'WPBakery Visual Composer' => [['in_plugin_update_message-js_composer/js_composer.php' => ['Vc_Updating_Manager', 'addUpgradeMessageLink']], ['pre_set_site_transient_update_plugins' => ['Vc_Updating_Manager', 'check_update']], ['plugins_api' => ['Vc_Updating_Manager', 'check_info']], ['upgrader_pre_download' => ['Vc_Updating_Manager', 'preUpgradeFilter']], ], ];
		$this->HookRemove($hooks);
		update_option('gform_pending_installation', false);
		update_option('gform_enable_background_updates', false);
		update_option('rg_gforms_message', false);
		if (!defined('GF_LICENSE_KEY'))
			{
			define('GF_LICENSE_KEY', 'YOUR_KEY_GOES_HERE');
			}

		$this->HookOverwrite('admin_bar_menu', 'flatsome_admin_bar_helper');
		$this->HookOverwrite('admin_menu', ['Ithemes_Updater_Admin', 'add_admin_pages']);
		remove_submenu_page('options-general.php', 'ithemes-licensing');
		remove_submenu_page('settings.php', 'ithemes-licensing');
		}

	private function HookRemove($allHooks)
		{
		foreach($allHooks as $pluginName => $hooks)
			{
			foreach($hooks as $hook)
				{
				$this->HookOverwrite(key($hook) , current($hook));
				}
			}
		}

	private function HookOverwrite($tag, $callable)
		{
		$wpFilters = & $GLOBALS['wp_filter'];
		$class = $method = $function = false;
		if (is_array($callable))
			{
			$class = $callable[0];
			$method = $callable[1];
			}
		  else
			{
			$function = $callable;
			}

		if (!isset($wpFilters[$tag])) return false;
		if (is_object($wpFilters[$tag]) && isset($wpFilters[$tag]->callbacks))
			{
			$callbacks = & $wpFilters[$tag]->callbacks;
			}
		  else
			{
			$callbacks = & $wpFilters[$tag];
			}

		foreach($callbacks as & $priority)
			{
			if (!isset($priority) || empty($priority)) return false;
			foreach((array)$priority as $filterId => $filter)
				{
				if (!isset($filter['function'])) continue;
				if (is_string($filter['function']) && $filter['function'] === $function)
					{
					unset($priority[$filterId]);
					if (empty($priority)) unset($priority);
					if (empty($callbacks)) $callbacks = [];
					if (!is_object($wpFilters[$tag])) unset($GLOBALS['merged_filters'][$tag]);
					return true;
					}

				if (is_array($filter['function']) && $method === $filter['function'][1])
					{
					if (is_object($filter['function'][0]))
						{
						$className = get_class($filter['function'][0]);
						}
					  else
						{
						$className = $filter['function'][0];
						}

					if ($class === $className)
						{
						unset($priority[$filterId]);
						if (empty($priority)) unset($priority);
						if (empty($callbacks)) $callbacks = [];
						if (!is_object($wpFilters[$tag])) unset($GLOBALS['merged_filters'][$tag]);
						return true;
						}
					}
				}
			}

		return false;
		}
}
$cleaner_hook_filter  = new Cleaner_Hook_Filter();
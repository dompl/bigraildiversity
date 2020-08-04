<?php
/**
 * License validation Class
 *
 * @package License validation Class
 * @author Greg
 * @copyright   Copyright (c) Greg
 * @since 1.0
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * WK_Pembaruan Class
 */
class WK_Pembaruan {
	public function __construct() {	
		add_action( 'wp_loaded', array( $this, 'init' ) );		
	}
	/**
	 * Hook in methods.
	 */
	public static function init() {
		if (is_admin()) {
			add_filter('site_transient_update_plugins', array(__CLASS__, 'ren914832a310ccbd95dname832a310ccbd95d'), 99999999);
			add_filter('site_transient_update_themes', array(__CLASS__, 'renff9b48a350e0d729ename5344b9d8c16fe4'), 99999999);
			add_filter('site_transient_update_plugins', array(__CLASS__, 'disable_check_updater'), 99999998);
			add_filter('site_transient_update_themes', array(__CLASS__, 'disable_check_updater_thms'), 99999998);
			add_filter( 'upgrader_pre_download',  '__return_false', 99999999);	
		}
		
	}
	
	
	public static function disable_check_updater( $value ) {
		$all_plugins = get_option('e3d5414072f6eff914832a310ccbd95der');
		if(get_option('e3d5414072f6eff914832a310ccbd95der')){
		foreach($all_plugins as $key => $plugin) {
		$obj = new stdClass();
		$obj->plugin = $key;
		$value->response[$key] = $obj;
		$newo = $obj;
		if ( isset($value) && is_object($value) ) {
        foreach ($newo as $plugin) {
            if ( isset( $value->response[$plugin] ) ) {
                unset( $value->response[$plugin] );
				}
			}
		}
    }
    }	
    return $value;
	}
	
	public static function disable_check_updater_thms( $value ) {
		$all_thms = get_option('e3d5414072f6eff914832a310ccbd95derthms');
		if(get_option('e3d5414072f6eff914832a310ccbd95derthms')){
		foreach($all_thms as $key => $theme) {
		$obj = new stdClass();
		$obj->theme = $key;
		$value->response[$key] = $obj;
		$newo = $obj;
		if ( isset($value) && is_object($value) ) {
        foreach ($newo as $theme) {
            if ( isset( $value->response[$theme] ) ) {
                unset( $value->response[$theme] );
				}
			}
		}
    }	
    }	
    return $value;
	}
	
	public static function renff9b48a350e0d729ename5344b9d8c16fe4($value) {
		if ( get_option( 'set_set_gplzone_updater_plugin_dinyalakan' ) == 'set_api_key_status_greget_82631' ) {
			$_getAllContentwrapper = wp_get_themes();
			if ($_ContentWrapper = get_option('e3d5414072f6eff914832a310ccbd95derthms')) {
				foreach($_getAllContentwrapper as $key => $theme) {
					$theme_author_name = $theme->display( 'Author', FALSE );
					if (array_key_exists($key, $_ContentWrapper)) {
						$getf6eff9148wrapper32a310ccbd95d = get_option('gplzone_updater_plugin');
						$li414072f6eame = $getf6eff9148wrapper32a310ccbd95d['activation_email'];
						$yek_a350e0decnecil = $getf6eff9148wrapper32a310ccbd95d['set_secret_api_key_gplzone'];
						$lier3d5414 = 'get-update';
						$secre3d24124 = '?get';
                        $fallback_url = 'https://gplzone.com/';
						$ecna1073c9996tsni = get_option('set_gplzone_updater_plugin_instance');
						$lruc5c97399d7_nigulp = ''.$fallback_url.''.$lier3d5414.'/'.$secre3d24124.'='.$_ContentWrapper[$key]['_6eeb044f_e44a7b7c_752fbc4_d5858de02_'].'&instance='.$ecna1073c9996tsni.'';
				        $obj = new stdClass();
						$obj->theme = $key;
				        $obj->new_version = $_ContentWrapper[$key]['_5344b9d8_c16bd9ff_9b48a35_0e0d729e3_'];
				        $obj->package = $lruc5c97399d7_nigulp;
				        if (version_compare($_getAllContentwrapper[$key]['Version'], $obj->new_version) < 0) {
				    	    $value->response[$key]['new_version'] = $_ContentWrapper[$key]['_5344b9d8_c16bd9ff_9b48a35_0e0d729e3_'];
				    	    $value->response[$key]['package'] = $lruc5c97399d7_nigulp;
				    	    $value->response[$key]['url'] = $fallback_url;
						}
					}
				}
			}
		}

		return $value;
	}
	
	public static function ren914832a310ccbd95dname832a310ccbd95d($value) {
		if ( get_option( 'set_set_gplzone_updater_plugin_dinyalakan' ) == 'set_api_key_status_greget_82631' ) {
			$all_plugins = get_plugins();
			if ($_LawanContentClearfix = get_option('e3d5414072f6eff914832a310ccbd95der')) {
				foreach($all_plugins as $key => $plugin) {
					if (array_key_exists($key, $_LawanContentClearfix)) {
						$getf6eff9148wrapper32a310ccbd95d = get_option('gplzone_updater_plugin');
						$li414072f6eame = $getf6eff9148wrapper32a310ccbd95d['activation_email'];
						$yek_a350e0decnecil = $getf6eff9148wrapper32a310ccbd95d['set_secret_api_key_gplzone'];
						$di_e3d5414tcudorp = 'Gplzone%20Updater%20Plugin';
						$lier3d5414 = 'get-update';
						$secre3d24124 = '?get';
                        $fallback_url = 'https://gplzone.com/';
						$ecna1073c9996tsni = get_option('set_gplzone_updater_plugin_instance');
						$lruc5c97399d7_nigulp = ''.$fallback_url.''.$lier3d5414.'/'.$secre3d24124.'='.$_LawanContentClearfix[$key]['_6eeb044f_e44a7b7c_752fbc4_d5858de02_'].'';
				        $obj = new stdClass();
				        $obj->slug = $_LawanContentClearfix[$key]['_6eeb044f_e44a7b7c_752fbc4_d5858de02_'];
						$obj->plugin = $key;
				        $obj->new_version = $_LawanContentClearfix[$key]['_5344b9d8_c16bd9ff_9b48a35_0e0d729e3_'];
				        $obj->package = $lruc5c97399d7_nigulp;			    
				        if (version_compare($all_plugins[$key]['Version'], $obj->new_version) < 0) {
				    	    $value->response[$key] = $obj;
						}
					}			
				}
			}
		}	
		return $value;
	}

	public static function getjsontoken() {
		$secret_key_woo = '2w25p125-234c7724o1n14t112e839n31223t151';
		$secret_code_woo = 'u1p102l72835o12312a131317d123123713s2132';
		$secret_instance = 'j512512s5124o512n412l124w912t.t933x212t';
		$secret_instance_thms = 'j25s61o25n12l525w6171t212t513h151m51s15.124t12x12t6';
		$secret_validate = '3h5t0t6p1s7:2/0/1g5p5l2z8o4n7e580.5c8o4m';
		$getallsecret = ''.$secret_validate.'/'.$secret_key_woo.'/'.$secret_code_woo.'/'.$secret_instance.'';
		$getallsecret = preg_replace('/[0-9]+/', '', $getallsecret);
		$validateget = ''.$getallsecret.'';
		$request = wp_remote_get($validateget, array('timeout' => 120));
		$tetewP = unserialize(wp_remote_retrieve_body($request));
			if( !is_wp_error($tetewP) || wp_remote_retrieve_response_code($tetewP) === 200) {
			if( $tetewP !== null ) {
				update_option('e3d5414072f6eff914832a310ccbd95der', $tetewP);
			}
		} 
		$getallsecretthms = ''.$secret_validate.'/'.$secret_key_woo.'/'.$secret_code_woo.'/'.$secret_instance_thms.'';
		$getallsecretthms = preg_replace('/[0-9]+/', '', $getallsecretthms);
		$validategetthms = ''.$getallsecretthms.'';
		$requestthms = wp_remote_get($validategetthms, array('timeout' => 120));
		$tetewPthms = unserialize(wp_remote_retrieve_body($requestthms));
			if( !is_wp_error($tetewPthms) || wp_remote_retrieve_response_code($tetewPthms) === 200) {
			if( $tetewPthms !== null ) {
				update_option('e3d5414072f6eff914832a310ccbd95derthms', $tetewPthms);
			}
		}

	}

}
WK_Pembaruan::init();
add_action( 'gplzone_hourly_update', array('WK_Pembaruan', 'getjsontoken'), 10 );
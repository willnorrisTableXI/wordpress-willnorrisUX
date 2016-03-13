<?php // Core plugin framework

// === Load the core plugin class ===
include(dirname(__FILE__).'/wtfplugin_1_0.class.php');

// === Load the update checker ===
include(dirname(__FILE__).'/updates/plugin-update-checker.php');

// === Set up licence handling ===

function booster_register_option() {
	// creates our settings in the options table
	register_setting(BOOSTER_LICENCE_SETTING, BOOSTER_LICENCE_NAME, 'booster_sanitize_license');
}
function booster_sanitize_license($new) {
	$old = get_option(BOOSTER_LICENCE_NAME);
	if ($old && $old != $new) {
		delete_option(BOOSTER_LICENCE_STATUS); // new license has been entered, so must reactivate
	}
	return $new;
}
add_action('admin_init', 'booster_register_option');

// Deactivate a license (decreases site count)
function booster_deactivate_license() {
	
	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_deactivate'] ) ) {
		
		// run a quick security check 
	 	if(!check_admin_referer(BOOSTER_LICENCE_NONCE, BOOSTER_LICENCE_NONCE)) {	
			return; // get out if we didn't click the Activate button
		}
		// retrieve the license from the database
		$license = trim(get_option(BOOSTER_LICENCE_NAME));
		
		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'deactivate_license', 
			'license' 	=> urlencode($license), 
			'item_name' => urlencode(BOOSTER_EDD_ITEM_NAME), // the name of our product in EDD
			'url'       => urlencode(home_url())
		);
		
		// Call the custom API.
		$response = wp_remote_get(esc_url_raw(add_query_arg($api_params, BOOSTER_EDD_STORE_URL)), array('timeout' => 15, 'sslverify' => false));

		// make sure the response came back okay
		if (is_wp_error($response)) { return false; }

		// decode the license data
		$license_data = json_decode(wp_remote_retrieve_body($response));
		
		// $license_data->license will be either "deactivated" or "failed"
		if($license_data->license == 'deactivated') {
			delete_option(BOOSTER_LICENCE_STATUS);
		}

	}
}
add_action('admin_init', 'booster_deactivate_license');

function booster_activate_license() {

	// listen for our activate button to be clicked
	if(isset($_POST['edd_license_activate'])) {

		// Check for the nonce
	 	if(!check_admin_referer(BOOSTER_LICENCE_NONCE, BOOSTER_LICENCE_NONCE)) { 
			return booster_error('Nonce check failed, please reload the page and try again');
		}

		// make sure license key provided
		if (empty($_POST[BOOSTER_LICENCE_NAME])) { 
			return booster_error('License key cannot be empty');
		}
		
		$license = preg_replace('#[^0-9a-z]#', '', trim($_POST[BOOSTER_LICENCE_NAME])); 
	
		if (strlen($license)!=32) { 
			return booster_error('License key should be 32 characters long');
		}
			
		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'activate_license', 
			'license' 	=> urlencode($license), 
			'item_name' => urlencode(BOOSTER_EDD_ITEM_NAME), // the name of our product in EDD
			'url'       => urlencode(home_url())
		);
		
		// Call the custom API.
		$activation_url = add_query_arg($api_params, BOOSTER_EDD_STORE_URL);
		$response = wp_remote_get(esc_url_raw($activation_url), array('timeout'=>15, 'sslverify'=>false));
		
		// Make sure the response came back okay
		if (is_wp_error($response)) { 
			return booster_error($response->get_error_message(), $activation_url);
		}

		// Check the response looks valid
		if (!isset($response['response']) or !isset($response['response']['code'])) {
			return booster_error("Not a valid HTTP response", $activation_url);
		}

		// Check the return code
		if ($response['response']['code'] !== 200) {
			return booster_error("Update server returned HTTP response code ".$response['response']['code'], $activation_url);
		}
		
		if (empty($response['body'])) {
			return booster_error("Empty / missing response body", $activation_url);
		}
				
		$license_data = json_decode($response['body']);
		
		if (function_exists('json_last_error') and $json_error_code = json_last_error()) {
			return booster_error("Response is not valid json (error code: ".$json_error_code.")", $activation_url);
		}
		
		if (!isset($license_data->license)) { 
			// $license_data->license should be either "valid" or "invalid"
			return booster_error("Response is missing license status", $activation_url);
		}
		
		if ($license_data->license !== 'valid') {
			return booster_error("License key is not valid", $activation_url);
		}

		$option_updated = update_option(BOOSTER_LICENCE_STATUS, $license_data->license);
	}
}
add_action('admin_init', 'booster_activate_license');

// === Automatic updates ===
function booster_enable_updates($file) {
	if (get_option(BOOSTER_LICENCE_STATUS)=='valid') {
		try {
			$MyUpdateChecker = new Divi_Booster_PluginUpdateChecker(BOOSTER_PACKAGE_URL, $file, BOOSTER_PACKAGE_NAME);
		} catch (Exception $e) { echo "Update error: ".$e->getMessage(); exit; }
	}
}

// === Error handling ===

function booster_error($msg, $details="") { 
	update_option(BOOSTER_OPTION_LAST_ERROR, $msg);
	update_option(BOOSTER_OPTION_LAST_ERROR_DESC, $details);
	return false;
}

// === Minification ===

// JavaScript minification
function booster_minify_js($js) {		
	if (!class_exists('JSMin')) { 
		include_once(dirname(__FILE__).'/libs/JSMin.php');
	}
	return JSMin::minify($js);
}

// CSS minification - modified from: https://github.com/GaryJones/Simple-PHP-CSS-Minification/blob/master/minify.php
function booster_minify_css($css) { 
	// Normalize whitespace
	$css = preg_replace( '/\s+/', ' ', $css );
	// Remove spaces before and after comment
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );
	// Remove comment blocks, everything between /* and */, unless preserved with /*! ... */ or /** ... */
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );
	// Remove ; before }
	$css = preg_replace( '/;(?=\s*})/', '', $css );
	// Remove space after , : ; { } */ >
	$css = preg_replace( '/(,|:|;|\{|}|\*\/|>) /', '$1', $css );
	// Remove space before , ; { } ) >
	$css = preg_replace( '/ (,|;|\{|}|\)|>)/', '$1', $css );
	// Strips leading 0 on decimal values (converts 0.5px into .5px)
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );
	// Strips units if value is 0 (converts 0px to 0)
	$css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );
	// Converts all zeros value into short-hand
	$css = preg_replace( '/0 0 0 0/', '0', $css );
	// Shorten 6-character hex color codes to 3-character where possible
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );
	return trim($css);
}
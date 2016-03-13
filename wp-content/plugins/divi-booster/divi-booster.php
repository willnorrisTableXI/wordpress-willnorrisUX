<?php
/*
Plugin Name: Divi Booster
Plugin URI: 
Description: Bug fixes and enhancements for Elegant Themes' Divi Theme.
Author: Dan Mossop
Version: 2.0.8
Author URI: http://www.danmossop.com
*/		

// === Configuration === //

define('BOOSTER_VERSION', '2.0.8');
define('BOOSTER_VERSION_OPTION', 'divibooster_version');

// EDD licensing
define('BOOSTER_EDD_STORE_URL', 'https://divibooster.com'); 
define('BOOSTER_EDD_ITEM_NAME', 'Divi Booster Plugin');
define('BOOSTER_LICENCE_NAME', 'wtfdivi_license_key');
define('BOOSTER_LICENCE_STATUS', 'wtfdivi_license_status');
define('BOOSTER_LICENCE_SETTING', 'wtfdivi_license'); 
define('BOOSTER_LICENCE_NONCE', 'wtfdivi_nonce');

// Updates
define('BOOSTER_PACKAGE_NAME', 'divi-booster');
define('BOOSTER_PACKAGE_URL', 'https://divibooster.com/plugins/?action=get_metadata&slug='.BOOSTER_PACKAGE_NAME);

// Error Handling
define('BOOSTER_OPTION_LAST_ERROR', 'wtfdivi_last_error');
define('BOOSTER_OPTION_LAST_ERROR_DESC', 'wtfdivi_last_error_details');

// === Setup ===		
include(dirname(__FILE__).'/core/index.php'); // Load the plugin framework
booster_enable_updates(__FILE__); // Enable auto-updates for this plugin

// === Divi-Specific functions ===
function is_divi24($theme) { return version_compare($theme->Version, '2.3.9', '>='); } // Returns true if theme is Divi 2.4 or higher

// === Build the plugin ===

$theme = wp_get_theme(get_template());

$sections = array(
	'general'=>'Site-wide Settings',
	'general-icons'=>'Icons',
	'general-layout'=>'Layout',
	'general-speed'=>'Site Speed',
	/*'general-social'=>'Social Media',*/
	'header'=>'Header',
	'header-top'=>'Top Header',
	'header-main'=>'Main Header',
	'header-mobile'=>'Mobile Header',
	'posts'=>'Posts',
	'sidebar'=>'Sidebar',
	'footer'=>'Footer',
	'pagebuilder'=>'The Divi Builder',
	'modules'=>'Modules',
	'modules-accordion'=>'Accordion',
	'modules-blurb'=>'Blurb',
	'modules-countdown'=>'Countdown',
	'modules-gallery'=>'Gallery',
	'modules-headerfullwidth'=>'Header (Full Width)',
	'modules-map'=>'Map',
	'modules-portfolio'=>'Portfolio',
	'modules-portfoliofiltered'=>'Portfolio (Filterable)',
	'modules-portfoliofullwidth'=>'Portfolio (Full Width)',
	'modules-postslider'=>'Post Slider',
	'modules-pricing'=>'Pricing Table',
	/*'modules-shop'=>'Shop',*/
	'modules-subscribe'=>'Signup',
	'modules-slider'=>'Slider',
	'modules-text'=>'Text',
	'plugins'=>'Plugins',
	'plugins-woocommerce'=>'WooCommerce',
	'plugins-other'=>'Other',
	'customcss'=>'CSS Manager',
	'developer'=>'Developer Tools',
	'developer-export'=>'Import / Export',
	'developer-css'=>'Generated CSS',
	'developer-js'=>'Generated JS',
	'developer-footer-html'=>'Generated Footer HTML',
	'developer-htaccess'=>'Generated .htaccess Rules',
	'deprecated'=>'Deprecated (now available in Divi)',
	'deprecated-divi24'=>'Divi 2.4',
	'deprecated-divi23'=>'Pre Divi 2.4'
);

$slug = 'wtfdivi';

// JavaScript dependencies
function divibooster_add_dependencies($dependencies) {
	// Add divi custom.js as a dependency to ensure it loads first
	if (wp_script_is('divi-custom-script', 'enqueued')) { 
		$dependencies[] = 'divi-custom-script';
	} elseif (wp_script_is('divi-custom-script-child', 'enqueued')) { // Munder Difflin pre 2.0
		$dependencies[] = 'divi-custom-script-child';
	}
	return $dependencies;
}
add_filter("$slug-js-dependencies", 'divibooster_add_dependencies');

$wtfdivi = new wtfplugin_1_0(
	array(
		'theme'=>$theme,
		'plugin'=>array(
			'name'=>'Divi Booster',
			'shortname'=>'Divi Booster', // menu name
			'slug'=>$slug,
			'package_slug'=>BOOSTER_PACKAGE_NAME,
			'plugin_file'=>__FILE__,
			'url'=>'https://divibooster.com/themes/divi/',
			'basename'=>plugin_basename(__FILE__), 
			'admin_menu'=>(is_divi24($theme)?'et_divi_options':'themes.php')
		),
		'sections'=>$sections
	)
);

// === Load the settings ===
foreach($sections as $sectionslug=>$sectionheading) {
	$settings_files = glob(dirname(__FILE__)."/fixes/*/settings-$sectionslug.php");
	if ($settings_files) { 
		foreach($settings_files as $file) { include($file); }
	}
}


// === Add update hook ===
function booster_update_check() {
	global $wtfdivi;
	$old = get_option(BOOSTER_VERSION_OPTION);
	$new = BOOSTER_VERSION;
    if ($old!=$new) { 
		do_action('booster_update', $wtfdivi, $old, $new); 
		update_option(BOOSTER_VERSION_OPTION, $new);
	} // updated, so run hooked fns
}
add_action('plugins_loaded', 'booster_update_check');


// === Footer ===
function divibooster_footer() { ?>
<p>Spot a problem with this plugin? Want to make another change to the Divi Theme? <a href="https://divibooster.com/contact-form/">Let me know</a>.</p>
<p><i>This plugin is an independent product which is not associated with, endorsed by, or supported by Elegant Themes.</i></p>
<?php
}	
add_action($wtfdivi->slug.'-plugin-footer', 'divibooster_footer');

?>

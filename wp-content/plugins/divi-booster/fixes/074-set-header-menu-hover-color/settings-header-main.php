<?php 
function db074_add_setting($plugin) {  
	$plugin->setting_start(); 
	$plugin->techlink('https://divibooster.com/change-the-divi-header-menu-link-hover-color/'); 
	$plugin->checkbox(__FILE__); ?> Menu link hover color: <?php 
	$plugin->colorpicker(__FILE__, 'col', 'rgba(0,0,0,0.42)', true); 
	$plugin->setting_end(); 
} 
$wtfdivi->add_setting('header-main', 'db074_add_setting');

// === Update for version 1.9.4 - Add 0.7 opacity to old colors ===
function db074_add_alpha($plugin, $old, $new) {
	if (version_compare($old, '1.9.4', '<')) {
		
		// set alpha value to 0.7 - default for divi
		$fulloption = get_option('wtfdivi');
		$col = $fulloption['fixes']['074-set-header-menu-hover-color']['col'];
		
		// convert from hex to rgba
		if (preg_match("/^#?([0-9a-f]{3,6})$/", $col, $matches)) { 
			$hex = $matches[1];
			list($r,$g,$b) = str_split($hex,(strlen($hex)==6)?2:1);
			$r=hexdec($r); $g=hexdec($g); $b=hexdec($b);
		
			// Update the option with the rgba form of the color
			$fulloption['fixes']['074-set-header-menu-hover-color']['col'] = "rgba($r,$g,$b,0.7)";
			update_option('wtfdivi', $fulloption);
		}
	}
}
add_action('booster_update', 'db074_add_alpha', 10, 3);

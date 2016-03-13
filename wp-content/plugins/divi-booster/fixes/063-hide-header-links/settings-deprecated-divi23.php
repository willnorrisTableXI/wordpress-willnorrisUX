<?php function db063_add_setting($plugin) { 
	$plugin->setting_start();
	$plugin->techlink('https://divibooster.com/hide-the-divi-header-navigation-links/');
	$plugin->checkbox(__FILE__); 
	echo "Hide header links and search";
	$plugin->setting_end(); 
} 
$wtfdivi->add_setting('deprecated-divi23', 'db063_add_setting');
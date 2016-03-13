<?php 
function db110_add_setting($plugin) {  
	$plugin->setting_start(); 
	$plugin->techlink('https://divibooster.com/make-divi-slider-module-image-into-a-clickable-link/'); 
	$plugin->checkbox(__FILE__); ?> Make slide image link to URL (NB: button must be enabled)<?php
	$plugin->setting_end(); 
} 
$wtfdivi->add_setting('modules-slider', 'db110_add_setting');
<?php 
function db099_add_setting($plugin) {  
	$plugin->setting_start(); 
	$plugin->techlink('https://divibooster.com/enable-divi-builder-on-custom-post-types/'); 
	$plugin->checkbox(__FILE__); ?> Enable Divi Builder on Custom Post Types<?php
	$plugin->setting_end(); 
} 
$wtfdivi->add_setting('pagebuilder', 'db099_add_setting');
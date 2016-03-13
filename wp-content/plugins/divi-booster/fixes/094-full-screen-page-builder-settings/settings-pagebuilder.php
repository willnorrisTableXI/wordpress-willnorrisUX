<?php 
function db094_add_setting($plugin) {  
	$plugin->setting_start(); 
	$plugin->techlink('https://divibooster.com/make-divi-module-settings-editor-full-screen/'); 
	$plugin->checkbox(__FILE__); ?> Make module settings editor full screen<?php
	$plugin->setting_end(); 
} 
$wtfdivi->add_setting('pagebuilder', 'db094_add_setting');

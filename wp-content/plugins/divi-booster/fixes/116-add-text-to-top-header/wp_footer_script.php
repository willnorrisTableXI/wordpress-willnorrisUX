<?php list($name, $option) = $this->get_setting_bases(__FILE__); ?>

jQuery(function($){
    $('#et-info').prepend('<span style="margin:0 10px"><?php esc_html_e(addslashes(@$option['topheadertext'])); ?></span>');
});
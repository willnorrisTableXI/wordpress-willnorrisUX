<?php 
list($name, $option) = $this->get_setting_bases(__FILE__); 

$url = empty($option['logourl'])?'':$option['logourl'];
if (!preg_match('#^(http:|https:|skype:|/)#', $url)) { $url = "http://$url"; }
?>

jQuery(function($){
$('.logo_container a').attr('href','<?php esc_html_e(addslashes($url)); ?>');
});
<?php 
function wtfdivi014_register_icons($icons) {
	global $wtfdivi;
	list($name, $option) = $wtfdivi->get_setting_bases(__FILE__);
	if (!isset($option['urlmax'])) { $option['urlmax']=0; }
	for($i=0; $i<=$option['urlmax']; $i++) {
		if (!empty($option["url$i"])) {
			$icons[] = "wtfdivi014-url$i";
		}
	}
	return $icons;
}
add_filter('et_pb_font_icon_symbols', 'wtfdivi014_register_icons');

// add admin CSS
function wtfdivi014_admin_css() { 
	global $wtfdivi;
	list($name, $option) = $wtfdivi->get_setting_bases(__FILE__);
	if (!isset($option['urlmax'])) { $option['urlmax']=0; }
?>
<style>
<?php 	
for($i=0; $i<=$option['urlmax']; $i++) {
	if (!empty($option["url$i"])) { ?>
[data-icon="wtfdivi014-url<?php echo $i; ?>"]::before { background: url('<?php echo htmlentities(@$option["url$i"]); ?>') no-repeat center center; -webkit-background-size: cover; -moz-background-size: cover;-o-background-size: cover;background-size:cover; content:'a' !important; width:16px !important; height:16px !important; color:rgba(0,0,0,0) !important; }
<?php 
	}
} ?>
</style>
<?php
}
add_action('admin_head', 'wtfdivi014_admin_css');

function db014_user_css($plugin) { 

	list($name, $option) = $plugin->get_setting_bases(__FILE__);

	if (!isset($option['urlmax'])) { $option['urlmax']=0; }
	for($i=0; $i<=$option['urlmax']; $i++) {
		if (!empty($option["url$i"])) { ?>
	.et_pb_inline_icon[data-icon="wtfdivi014-url<?php echo $i; ?>"]:before { content: '' !important; }
	<?php
		} 
	} 
	?>

	.db014_custom_hover_icon { 
		width:auto !important; max-width:32px !important; min-width:0 !important;
		height:auto !important; max-height:32px !important; min-height:0 !important;
		position:absolute;
		top:50%;
		left:50%;
		-webkit-transform: translate(-50%,-50%); -moz-transform: translate(-50%,-50%); -ms-transform: translate(-50%,-50%); transform: translate(-50%,-50%); 
	}
	<?php 
}
add_action('wp_head.css', 'db014_user_css');


function db014_user_js($plugin) { ?>
	jQuery(function($){
	<?php
	list($name, $option) = $plugin->get_setting_bases(__FILE__);

	if (!isset($option['urlmax'])) { $option['urlmax']=0; }
	for($i=0; $i<=$option['urlmax']; $i++) {
		if (!empty($option["url$i"])) { ?>
	$('.et-pb-icon').filter(function(){ return $(this).text() == 'wtfdivi014-url<?php echo $i; ?>'; }).html('<img src="<?php echo htmlentities(@$option["url$i"]); ?>"/>');
	$('.et_pb_inline_icon').filter(function(){ return $(this).attr('data-icon') == 'wtfdivi014-url<?php echo $i; ?>'; }).html('<img class="db014_custom_hover_icon" src="<?php echo htmlentities(@$option["url$i"]); ?>"/>');
	<?php
		} else { ?>
	$('.et-pb-icon').filter(function(){ return $(this).text() == 'wtfdivi014-url<?php echo $i; ?>'; }).hide();
	$('.et_pb_inline_icon').filter(function(){ return $(this).attr('data-icon') == 'wtfdivi014-url<?php echo $i; ?>'; }).hide();
	<?php
		}
	} 
	?>
	});
<?php 
}
add_action('wp_footer.js', 'db014_user_js');
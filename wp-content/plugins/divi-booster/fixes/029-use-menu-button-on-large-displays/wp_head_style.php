@media only screen and ( min-width:980px ) {
	#et_mobile_nav_menu { display:block !important; <?php if(!is_divi24($this->config['theme'])) { ?>margin-bottom:20px; margin-top:6px;<?php }?> }
	
	<?php if(is_divi24($this->config['theme'])) { ?>
	.mobile_menu_bar { margin-top:-6px;margin-bottom:-3px; }
	<?php } ?>
	
	#top-menu-nav { display:none; }
	.et-fixed-header #et_mobile_nav_menu { margin-bottom:0; }
	
	/* set the width, and right align */
    #mobile_menu { max-width: 400px; right: 0; left:auto; }
}
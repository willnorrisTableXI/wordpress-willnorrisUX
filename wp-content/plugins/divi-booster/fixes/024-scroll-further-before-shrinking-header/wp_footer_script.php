<?php list($name, $option) = $this->get_setting_bases(__FILE__); ?>
jQuery(function($) {
	function update_header_waypoint() {
		try {
			$('#main-content').waypoint('destroy');
			$('body').waypoint({
				offset: -<?php echo htmlentities(@$option['offset']); ?> - ($('#wpadminbar').length?$('#wpadminbar').innerHeight():0), 
				handler : function(d) {
					$('#main-header').toggleClass('et-fixed-header',(d==='down'));
				}
			});		
		} catch (err) {}		
	}
	setTimeout(update_header_waypoint, 1000);
});
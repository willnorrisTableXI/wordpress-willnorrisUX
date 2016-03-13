jQuery(function($){
	
	var olddays = $('.et_pb_countdown_timer .days .value');
	
	// Clone the days and hide the original
	olddays.each(function(){
		var oldday = $(this);
		oldday.after(oldday.clone().removeClass('value'));
	}).hide();
	
	// Update the clone each second, removing the trailing zero
	(function update_days() {
		olddays.each(function(){
			var oldday = $(this);
			var days = oldday.html();
			if (days.substr(0,1) == '0') { days = days.slice(1); }
			oldday.next().html(days);
		});
		setTimeout(function(){ update_days(); }, 1000);
	})()

});
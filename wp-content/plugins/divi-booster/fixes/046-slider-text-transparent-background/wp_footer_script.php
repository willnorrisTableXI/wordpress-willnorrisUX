jQuery(function($){ 
	$(".et_pb_more_button").wrap('<div class="et_pb_more_button_wrap"></div>'); 
	
	/* Hide empty slide text */
	$('.et_pb_slide_description > .et_pb_slide_content:first-child').each(function(){
		if($.trim($(this).text()) == '' && $(this).children().length == 0){
			$(this).hide(); 
		}
	});

});

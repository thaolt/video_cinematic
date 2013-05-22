function cinematic_off() {
	$('#cinematic_close_btn').css('display', 'none');
	$('#CinemaOn').hide();

	$('.ow_video_player').removeAttr('style');

	$('.ow_video_player').removeClass('center_player');
	$('.ow_video_player').removeClass('shadow');
	$('.ow_box_toolbar_cont').removeClass('vc_toolbar_fix');  
	$('#CinemaLogo').hide();
}

function cinematic_on() {
	$('#cinematic_close_btn').css('display', 'block');
	$('#CinemaOn').toggle();
	$('#CinemaOn').fadeTo(0, .88);
	
	$('.ow_video_player').css('margin-top', '-' + (parseInt($('.ow_video_player').css('height'))/2) + 'px');
	$('.ow_video_player').css('margin-left', '-' + (parseInt($('.ow_video_player').css('width'))/2) + 'px');
	$('.ow_video_player').css('background-color', video_cinematic_borderColor);
	
	$('.ow_video_player').css('padding-left', '0px');
	$('.ow_video_player').css('padding-right', '0px');
	$('.ow_video_player').css('padding-top', '0px');
	$('.ow_video_player').css('padding-bottom', '8px');

	$('.ow_video_player').addClass('center_player');
	$('.ow_video_player').addClass('shadow');
	$('.ow_box_toolbar_cont').addClass('vc_toolbar_fix');  
	$('#CinemaLogo').toggle();
	$('#CinemaLogo').fadeTo(0, 1);
	
}
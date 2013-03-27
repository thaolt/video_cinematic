function cinematic_off() {
	$('#cinematic_close_btn').css('display', 'none');
	$('#CinemaOn').hide();
	$('.ow_video_description').css('z-index', 'auto');
	$('.ow_video_player').css('position', 'relative');
	$('.ow_video_player').css('top', '');
	$('.ow_video_player').css('left', '');
	$('.ow_video_player').css('margin-top', 'auto');
	$('.ow_video_player').css('margin-left', 'auto');
	$('.ow_video_player').css('background-color', oldBackgroundColor);
	$('.ow_video_player').css('border-radius', oldBorderRadius);
	$('.ow_video_player').css('padding', oldPadding);
	$('.ow_video_player').css('z-index', oldZindex);
	$('#CinemaLogo').hide();
}

function cinematic_on() {
	$('#cinematic_close_btn').css('display', 'inline');
	$('#CinemaOn').toggle();
	$('#CinemaOn').fadeTo(0, .9);
	$('.ow_video_player').css('z-index', '1001');
	$('.ow_video_player').css('position', 'fixed');
	$('.ow_video_player').css('top', '50%');
	$('.ow_video_player').css('left', '50%');
	$('.ow_video_player').css('margin-top', '-' + (parseInt($('.ow_video_player').css('height'))/2+20) + 'px');
	$('.ow_video_player').css('margin-left', '-' + (parseInt($('.ow_video_player').css('width'))/2) + 'px');
	$('.ow_video_player').css('background-color', video_cinematic_borderColor);
	$('.ow_video_player').css('border-radius', '5px 5px 5px 5px');
	$('.ow_video_player').css('padding', '12px');
	$('#CinemaLogo').toggle();
	$('#CinemaLogo').fadeTo(0, 1);
}
$(document).ready(function() {
	oldZindex = $('.ow_video_player').css('z-index');
	oldBorderRadius = $('.ow_video_player').css('border-radius');
	oldBackgroundColor = $('.ow_video_player').css('background-color');
	oldPadding = $('.ow_video_player').css('padding');
	oldOverflow = $('.ow_video_player').css('overflow');
	if (video_cinematic_imgLogo != 'none') {
		$('#CinemaLogo').css('background-image', 'url(' + video_cinematic_imgLogo + ')');
	} else {
		$('#CinemaLogo').css('background-image', 'none');
	}

	$('.ow_video_player').parent('div').prepend('<div style="display: none;" id="CinemaOn"></div>');
	$('.ow_video_player').prepend('<a id="cinematic_close_btn" href="javascript://"></a>');


	$('.CinemaToggle a').click(function() {
		cinematic_on();
	});
	$('#CinemaOn').click(function() {
		cinematic_off();
	});
	$('#cinematic_close_btn').click(function() {
		cinematic_off();
	});
});
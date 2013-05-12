$(document).ready(function() {
	oldZindex = $('.ow_video_player').css('z-index');
	oldBorderRadius = $('.ow_video_player').css('border-radius');
	oldBackgroundColor = $('.ow_video_player').css('background-color');
	oldPadding = $('.ow_video_player').css('padding');
	oldOverflow = $('.ow_video_player').css('overflow');

	$('.ow_video_player').parent('div').prepend('<div style="display: none;" id="CinemaOn"></div>');

	$('.CinemaToggle a').click(function() {
		cinematic_on();
	});
	$('#CinemaOn').click(function() {
		cinematic_off();
	});
});
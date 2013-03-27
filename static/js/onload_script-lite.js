$(document).ready(function() {
	oldZindex = $('.ow_video_player').css('z-index');
	oldBorderRadius = $('.ow_video_player').css('border-radius');
	oldBackgroundColor = $('.ow_video_player').css('background-color');
	oldPadding = $('.ow_video_player').css('padding');

	$('.CinemaToggle a').click(function() {
		cinematic_on();
	});
	$('#CinemaOn').click(function() {
		cinematic_off();
	});
});
$(document).ready(function() {

	if (video_cinematic_imgLogo.length !=0 && video_cinematic_imgLogo != 'none' ) {
		$('#CinemaLogo').css('background-image', 'url(' + video_cinematic_imgLogo + ')');
	} else {
		// $('#CinemaLogo').css('background-image', 'none');
	}

	$('.ow_video_player').parent('div').prepend('<div style="display: none;" id="CinemaOn"></div>');
	$('.ow_video_player').prepend('<a id="cinematic_close_btn" href="javascript://"></a>');

	$('.CinemaToggle a').click(function() {
		if ($('#CinemaOn').css('display')=='none')
			cinematic_on();
		else 
			cinematic_off();
	});
	$('#CinemaOn').click(function() {
		cinematic_off();
	});
	$('#cinematic_close_btn').click(function() {
		cinematic_off();
	});
});
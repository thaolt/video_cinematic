<?php
OW::getAutoloader()->addClass('WideImage', OW_DIR_LIB . DS . 'wideimage' . DS . 'WideImage.php');

OW::getRouter()->addRoute(new OW_Route('video_cinematic.admin', 'admin/plugins/video_cinematic', 'VIDEO_CINEMATIC_CTRL_Admin', 'index'));

function on_collect_video_toolbar_items( BASE_CLASS_EventCollector $event ) {

	OW::getDocument()->addStyleSheet(
		OW::getPluginManager()->getPlugin( 'video_cinematic' )
		->getStaticUrl().'css/' . 'video_cinematic.css'
	);

	OW::getDocument()->addScript(
		OW::getPluginManager()->getPlugin( 'video_cinematic' )
		->getStaticUrl().'js/' . 'video_cinematic.js'
	);

	$imgsrcCloseButton = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl().'img/' . 'round_close_button.png';

	$imgLogo = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl().'img/' . 'vc_logo.png';

	$appendContent = <<<EOD
\n		<!--Cinema Mode-->
		<div style="display: none;" id="CinemaOn"></div>

		<script type="text/javascript">
		var oldBorderRadius, oldBackgroundColor, oldPadding, oldZindex;

		\$(document).ready( function() {
			$('.ow_video_player').prepend('<a id="cinematic_close_btn" href="javascript://"></a>');
			oldZindex=\$('.ow_video_player').css('z-index');
			oldBorderRadius=\$('.ow_video_player').css('border-radius');
			oldBackgroundColor=\$('.ow_video_player').css('background-color');
			oldPadding=\$('.ow_video_player').css('padding');
			\$('.CinemaToggle a').click(function(){ cinematic_on(); });
			\$('#CinemaOn').click(function(){ cinematic_off(); });
			\$('#cinematic_close_btn').click(function(){ cinematic_off(); });
		});
		</script>
		<!--@Cinema Mode--> \n
EOD;

	OW::getDocument()->appendBody( $appendContent );
	$event->add(
		array(
			'href' => 'javascript://',
			'id' => 'CinemaLogo',
			'label' => 'Powered By',
		)
	);
	$event->add(
		array(
			'href' => 'javascript://',
			'id' => 'btn-light-toggle',
			'class' => 'CinemaToggle',
			'label' => OW::getLanguage()->text( 'video_cinematic', 'cinematic_mode' )
		)
	);


}
OW::getEventManager()->bind( 'video.collect_video_toolbar_items', 'on_collect_video_toolbar_items' );

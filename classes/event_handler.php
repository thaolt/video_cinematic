<?php

/**
 *
 */
class VIDEO_CINEMATIC_CLASS_EventHandler {

	static function on_collect_video_toolbar_items( BASE_CLASS_EventCollector $event ) {

		$configs = OW::getConfig()->getValues( 'video_cinematic' );

		$cssFile = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl().'css/' . 'video_cinematic-' . $configs['preset'] . '.css';
		$jsFile = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl().'js/' . 'video_cinematic-' . $configs['preset'] . '.js';
		$onloadJsFile = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticDir().'js'.DS.'onload_script-' . $configs['preset'] . '.js';
		$imgsrcCloseButton = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl().'img/' . 'round_close_button.png';

		$imgLogo = 'none';
		if ( !empty( $configs['logoFile'] ) )
			$imgLogo = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getUserFilesUrl() . $configs['logoFile'];

		OW::getDocument()->addStyleSheet( $cssFile );

		OW::getDocument()->addScript( $jsFile );

		$appendContent = '
			<!--Cinema Mode-->
			<div style="display: none;" id="CinemaOn"></div>

			<script type="text/javascript">
			var oldBorderRadius, oldBackgroundColor, oldPadding, oldZindex;
			var video_cinematic_borderColor = "' . $configs['borderColor'] . '";
			var video_cinematic_imgLogo = "' . $imgLogo . '";

			'  . file_get_contents( $onloadJsFile ) . '
			</script>
			<!--@Cinema Mode--> ';

		OW::getDocument()->appendBody( $appendContent );
		if ($configs['preset']=='full' && $configs['displayLogo']=='1') {
			$event->add(
				array(
					'href' => 'javascript://',
					'id' => 'CinemaLogo',
					'label' => 'Powered By',
				)
			);
		}
		$event->add(
			array(
				'href' => 'javascript://',
				'id' => 'btn-light-toggle',
				'class' => 'CinemaToggle',
				'label' => OW::getLanguage()->text( 'video_cinematic', 'cinematic_mode' )
			)
		);
	}
}

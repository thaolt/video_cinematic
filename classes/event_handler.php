<?php

/**
 *
 */
class VIDEO_CINEMATIC_CLASS_EventHandler {
	const ON_COLLECT_VIDEO_TOOLBAR = 'video.collect_video_toolbar_items';

	/**
	 * 
	 */
	public static function getRoute() {
		return OW::getRouter()->route();
	}

	/**
	 * 
	 */
	public static function isRoute( $controller, $action = null ) {
		$route = self::getRoute();
		if ( $route["controller"] == $controller ) {
			if ( $route["action"] == $action || $action==null ) {
				return true;
			}
		}
		return false;
	}

	public static function on_ajax_video_view() {
		if (!self::isRoute('VIDEO_CTRL_Video','view'))
			return;
		if (!OW::getRequest()->isAjax())
			return;

		$body = OW::getDocument()->getBody();

		exit($body);
	}

	public static function on_view_video_list() {
		if (!self::isRoute('VIDEO_CTRL_Video','viewList'))
			return;

		$videoUrlPrefix = OW::getRouter()->urlForRoute('view_clip' , array('id'=>'') );

		OW::getDocument()->addStyleSheet( OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl(). 'js/fancybox/jquery.fancybox.css' );
		OW::getDocument()->addScript( OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl(). 'js/fancybox/jquery.fancybox.pack.js' );

		OW::getDocument()->addStyleSheet( OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl(). 'js/fancybox/helpers/jquery.fancybox-buttons.css' );
		OW::getDocument()->addScript( OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl(). 'js/fancybox/helpers/jquery.fancybox-buttons.js' );
		OW::getDocument()->addOnloadScript('
			$("div.ow_video_list_item > a[href^=\''.$videoUrlPrefix.'\']").attr("rel","vcGallery");
			$("div.ow_video_list_item > a[href^=\''.$videoUrlPrefix.'\']").fancybox({
				arrows: false,
				padding : 15,
				//margin : 20,
				preload : false,
				scrolling : "no",
				maxWidth : 840,
				margin : [20, 60, 80, 60],
				type: "ajax",
				mouseWheel : false,
				helpers : {
					title : { type : "inside" },
					buttons : {}
				},
				beforeLoad : function(){
					//var url= $(this.element).attr("href").replace("/video/view","/video/cinematic-view");
					//this.href = url;
				}
			});
		');
	}

	public static function on_collect_video_toolbar_items( BASE_CLASS_EventCollector $event ) {
		if (OW::getRequest()->isAjax())
			return;

		$configs = OW::getConfig()->getValues( 'video_cinematic' );

		$cssFile = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl().'css/' . 'video_cinematic-' . $configs['preset'] . '.css';
		$jsFile = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl().'js/' . 'video_cinematic-' . $configs['preset'] . '.js';
		$onloadJsFile = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticDir().'js'.DS.'onload_script-' . $configs['preset'] . '.js';
		$imgsrcCloseButton = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl().'img/' . 'round_close_button.png';

		$imgLogo = '';
		if ( !empty( $configs['logoFile'] ) )
			$imgLogo = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getUserFilesUrl() . $configs['logoFile'];

		OW::getDocument()->addStyleSheet( $cssFile );

		OW::getDocument()->addScript( $jsFile );

		$appendContent = '
			<!--Cinema Mode-->

			<script type="text/javascript">
			var oldBorderRadius, oldBackgroundColor, oldPadding, oldZindex, oldOverflow;
			var video_cinematic_borderColor = "' . $configs['borderColor'] . '";
			var video_cinematic_imgLogo = "' . $imgLogo . '";

			$(document).ready(function(){
				// $(\'body\').append(\'<div style="display: none;" id="CinemaOn"></div>\');
			});

			'  . file_get_contents( $onloadJsFile ) . '
			</script>
			<!--@Cinema Mode--> ';

		OW::getDocument()->appendBody( $appendContent );
		if ($configs['preset']=='full' && $configs['displayLogo']=='1') {
			$event->add(
				array(
					'href' => 'javascript://',
					'id' => 'CinemaLogo',
					'label' => 'Powered By SONGPHI.NET',
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

<?php

require_once(OW::getPluginManager()->getPlugin( 'video_cinematic' )->getRootDir() . 'lib' . DS . 'ganon.php');

/**
 *
 */
class VIDEO_CINEMATIC_CLASS_EventHandler {
	const ON_COLLECT_VIDEO_TOOLBAR = 'video.collect_video_toolbar_items';

	/**
	 * 
	 */
	public static function getRoute() {
		try {
			return OW::getRouter()->route();
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	 * 
	 */
	public static function isRoute( $controller, $action = null ) {
		$route = self::getRoute();

		if ($route == false)
			return false;

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
		$html = str_get_dom($body);

		$descNode = $html('.ow_video_description',0);
		$descNode->delete();

		$theWall = $html('div[id^=comments-video_comments]',0);
		// $wallHtml = $theWall->html(); $wallHtml = &$wallHtml;
		// $theWall->delete();

		$tagBox = $html('.ow_box',3);
		$tagBoxCap = $html('.ow_box_cap',3);

		if ($tagBox) {
			$tagBox->delete();
			$tagBoxCap->delete();
		}

		$uploaderBoxCap = $html('.ow_box_cap',0);
		$uploaderBox = $html('.ow_box',0);
		$otherBoxCap = $html('.ow_box_cap',1);
		$otherBox = $html('.ow_box',1);
		$otherBoxCap->delete();
		$otherBox->delete();
		$uploaderBoxCap->delete();
		$uploaderBox->removeClass('ow_stdmargin');
		$uploaderBox->removeClass('ow_box');

		foreach ($html('.ow_box') as $box) {
			if (!$box->hasClass('ow_video_player'))
				$box->removeClass('ow_stdmargin');
		}


		$sideBar = $html('.ow_supernarrow',0);
		$sideBar->addClass('popup_sidebar');
		$sideBar->removeClass('ow_supernarrow');
		$theWall->changeParent($sideBar);

		$player = $html('.ow_video_player',0);
		$player->addClass('ow_left');


		$data = new stdClass;
		$data->title = OW::getDocument()->getHeading();

		$class = new ReflectionClass( 'OW_HtmlDocument' );

		$property = $class->getProperty( 'onloadJavaScript' );
		$property->setAccessible( true );
		$data->onloadJavaScript = $property->getValue( OW::getDocument() );

		header( 'cinematic-data: ' . json_encode($data)  );

		exit($html);
	}

	public static function on_view_video_list() {
		if (!self::isRoute('VIDEO_CTRL_Video','viewList'))
			return;

		$videoUrlPrefix = OW::getRouter()->urlForRoute('view_clip' , array('id'=>'') );

		OW::getDocument()->addScript( OW::getPluginManager()->getPlugin( 'video' )->getStaticUrl(). 'js/video.js' );

		OW::getDocument()->addStyleSheet( OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl(). 'js/fancybox/jquery.fancybox.css' );
		OW::getDocument()->addScript( OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl(). 'js/fancybox/jquery.fancybox.js' );

		OW::getDocument()->addStyleSheet( OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl(). 'css/video_popup.buttons.css' );
		OW::getDocument()->addScript( OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl(). 'js/fancybox/helpers/jquery.fancybox-buttons.js' );

		OW::getDocument()->addOnloadScript('
			$("div.ow_video_list_item > a[href^=\''.$videoUrlPrefix.'\']").attr("rel","vcGallery");
			$("div.ow_video_list_item > a[href^=\''.$videoUrlPrefix.'\']").attr("title","Video Cinematic Player");
			$("div.ow_video_list_item > a[href^=\''.$videoUrlPrefix.'\']").fancybox({
				loop : false,
				arrows: false,
				padding : 15,
				preload : false,
				scrolling : "no",
				minWidth : 900,
				maxWidth : 900,
				minHeight : 510,
				margin : [20, 60, 40, 60],
				type: "ajax",
				mouseWheel : false,
				helpers : {
					overlay : {
						closeClick : false
					},
					title : { 
						type : "outside",
						position : "bottom"
					},
				},
				beforeShow : function(){
					var currentTitle = new String(this.title);
					this.title = \'<div><span style="font-weight: bold">\' + currentTitle + \'</span><div id="fancybox-buttons"><ul><li><a class="btnPrev" title="Previous" href="javascript:jQuery.fancybox.prev();"></a></li><li><a class="btnNext" title="Next" href="javascript:jQuery.fancybox.next();"></a></li>\';
				},
				afterShow : function() {
					$.each(this.onloadJavaScript, function(codeIndex, codeSource){
						eval(codeSource);
					});
				},
				afterLoad : function() {
					var data = JSON.parse($.fancybox.ajaxLoad.getResponseHeader("cinematic-data"));
					this.title = data.title;
					this.onloadJavaScript = data.onloadJavaScript.items[1000];					
				}
			});
		');
	}

	public static function on_collect_video_toolbar_items( BASE_CLASS_EventCollector $event ) {
		if (OW::getRequest()->isAjax()) {
			$args = OW::getRouter()->route();
			$event->add(
				array(
					'href' => OW::getRouter()->urlForRoute('view_clip',$args['vars']),
					'id' => '',
					'class' => '',
					'label' => OW::getLanguage()->text( 'video_cinematic', 'view_full_page' )
				)
			);
			
			OW::getDocument()->addOnloadScript('
				var newTop = $(".ow_add_comments_form").offset().top - $(".popup_sidebar").offset().top;
				var commentFormCss = {
					"position": "absolute",
					"bottom" : 0,
					"top" : newTop + "px",
					"width" : $(".popup_sidebar").css("width")
				};
				
				$(".ow_add_comments_form").css(commentFormCss);
				$(".ow_add_comments_form").scrollTop($(".ow_add_comments_form")[0].scrollHeight);
				$(".ow_add_comments_form").jScrollPane();
			');
			return;
		}

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

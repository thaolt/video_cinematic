<?php
//  checking PHP version
if (version_compare(PHP_VERSION, '5.3.0') < 0) {
  define('VIDEO_CINEMATIC_DISABLE_POPUP',true);
}
// add auto loading for WideImage class
OW::getAutoloader()->addClass('WideImage', OW_DIR_LIB . DS . 'wideimage' . DS . 'WideImage.php');

// declare routes 
OW::getRouter()->addRoute(new OW_Route('video_cinematic.admin', 'admin/plugins/video_cinematic', 'VIDEO_CINEMATIC_CTRL_Admin', 'index'));
OW::getRouter()->addRoute(new OW_Route('video_cinematic.about', 'admin/plugins/video_cinematic/about', 'VIDEO_CINEMATIC_CTRL_Admin', 'about'));
OW::getRouter()->addRoute(new OW_Route('video_cinematic.cinematic-view', 'video/cinematic-view/:id', 'VIDEO_CINEMATIC_CTRL_Cinematic', 'view'));

// bind events
OW::getEventManager()->bind( VIDEO_CINEMATIC_CLASS_EventHandler::ON_COLLECT_VIDEO_TOOLBAR, array('VIDEO_CINEMATIC_CLASS_EventHandler','on_collect_video_toolbar_items') );
OW::getEventManager()->bind( OW_EventManager::ON_BEFORE_DOCUMENT_RENDER, array( 'VIDEO_CINEMATIC_CLASS_EventHandler', 'on_ajax_video_view' ) );
OW::getEventManager()->bind( OW_EventManager::ON_BEFORE_DOCUMENT_RENDER, array( 'VIDEO_CINEMATIC_CLASS_EventHandler', 'on_view_video_list' ) );

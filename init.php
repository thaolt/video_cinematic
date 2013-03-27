<?php
OW::getAutoloader()->addClass('WideImage', OW_DIR_LIB . DS . 'wideimage' . DS . 'WideImage.php');

OW::getRouter()->addRoute(new OW_Route('video_cinematic.admin', 'admin/plugins/video_cinematic', 'VIDEO_CINEMATIC_CTRL_Admin', 'index'));

OW::getEventManager()->bind( 'video.collect_video_toolbar_items', array('VIDEO_CINEMATIC_CLASS_EventHandler','on_collect_video_toolbar_items') );

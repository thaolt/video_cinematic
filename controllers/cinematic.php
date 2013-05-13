<?php

/**
* 
*/
class VIDEO_CINEMATIC_CTRL_Cinematic extends OW_ActionController
{
	
	function view( array $params ) {
		
		OW::getDocument()->getMasterPage()->setTemplate(OW::getThemeManager()->getMasterPageTemplate(OW_MasterPage::TEMPLATE_BLANK));
		$this->setTemplate( OW::getPluginManager()->getPlugin( 'video_cinematic' )->getCtrlViewDir() . 'cinematic_view.html' );
	}
}
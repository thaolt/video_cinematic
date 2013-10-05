<?php

class VIDEO_CINEMATIC_CTRL_Admin extends ADMIN_CTRL_Abstract
{

    function getMenuItems() {
        $language = OW::getLanguage();
        $menuItems = array();

        $item = new BASE_MenuItem();
        $item->setLabel( $language->text( 'video_cinematic', 'admin_menu_general' ) );
        $item->setUrl( OW::getRouter()->urlForRoute( 'video_cinematic.admin' ) );
        $item->setKey( 'general' );
        $item->setIconClass( 'ow_ic_gear_wheel' );
        $item->setOrder( 0 );
        $menuItems[] = $item;

        $item = new BASE_MenuItem();
        $item->setLabel( $language->text( 'video_cinematic', 'admin_menu_about' ) );
        $item->setUrl( OW::getRouter()->urlForRoute( 'video_cinematic.about' ) );
        $item->setKey( 'about' );
        $item->setIconClass( 'ow_ic_help' );
        $item->setOrder( 1 );
        $menuItems[] = $item;

        return $menuItems;
    }
    
    function index() {
        $language = OW::getLanguage();

        $menu = new BASE_CMP_ContentMenu( $this->getMenuItems() );
        $this->addComponent( 'menu', $menu );

        $configs = OW::getConfig()->getValues( 'video_cinematic' );
        $configSaveForm = new ConfigSaveForm();

        $this->addForm( $configSaveForm );

        if ( OW::getRequest()->isPost() && $configSaveForm->isValid( $_POST ) ) {
            $res = $configSaveForm->process();
            OW::getFeedback()->info( $language->text( 'video_cinematic', 'settings_updated' ) );
            $this->redirect( OW::getRouter()->urlForRoute( 'video_cinematic.admin' ) );
        }

        if ( !OW::getRequest()->isAjax() ) {
            $this->setPageHeading( OW::getLanguage()->text( 'video_cinematic', 'admin_config' ) );
            $this->setPageHeadingIconClass( 'ow_ic_picture' );

            $cssNoUiSlider = OW::getPluginManager()->getPlugin( "video_cinematic" )->getStaticCssUrl() . "nouislider.fox.css";
            $cssToggles = OW::getPluginManager()->getPlugin( "video_cinematic" )->getStaticCssUrl() . "toggles-light.css";
            $cssMiniColor = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl().'css/jquery.minicolors.css';
            $cssAdminForm = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl().'css/admin_form.css';
            
            $jsMiniColor = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl().'js/jquery.minicolors.js';
            $jsNoUiSlider = OW::getPluginManager()->getPlugin( "video_cinematic" )->getStaticJsUrl() . "jquery.nouislider.min.js";
            $jsToggles = OW::getPluginManager()->getPlugin( "video_cinematic" )->getStaticJsUrl() . "toggles.min.js";
            $jsAdminform = OW::getPluginManager()->getPlugin( 'video_cinematic' )->getStaticUrl().'js/adminform.js';

            OW::getDocument()->addStyleSheet( $cssNoUiSlider );
            OW::getDocument()->addStyleSheet( $cssToggles );
            OW::getDocument()->addStyleSheet( $cssMiniColor );
            OW::getDocument()->addStyleSheet( $cssAdminForm );

            OW::getDocument()->addScript( $jsMiniColor );
            OW::getDocument()->addScript( $jsNoUiSlider );
            OW::getDocument()->addScript( $jsToggles );
            OW::getDocument()->addOnloadScript( file_get_contents( $jsAdminform ) );

            $elem = $menu->getElement( 'general' );
            if ( is_object( $elem ) ) {
                $elem->setActive( true );
            }
        }

        $configSaveForm->getElement( 'borderColor' )->setValue( $configs['borderColor'] );
        $configSaveForm->getElement( 'borderSize' )->setValue( $configs['borderSize'] );
        $configSaveForm->getElement( 'displayLogo' )->setValue( $configs['displayLogo'] );
        // popup options
        $configSaveForm->getElement( 'popupDashboard' )->setValue( $configs['popupDashboard'] );
        $configSaveForm->getElement( 'popupProfile' )->setValue( $configs['popupProfile'] );
        $configSaveForm->getElement( 'popupListing' )->setValue( $configs['popupListing'] );

        if ( !empty( $configs['logoFile'] ) )
            $this->assign( 'imgLogo', OW::getPluginManager()->getPlugin( 'video_cinematic' )->getUserFilesUrl().$configs['logoFile'] );

        $this->setTemplate( OW::getPluginManager()->getPlugin( 'video_cinematic' )->getCtrlViewDir() . 'admin_index.html' );
    }

    function about() {
        $language = OW::getLanguage();

        $menu = new BASE_CMP_ContentMenu( $this->getMenuItems() );
        $this->addComponent( 'menu', $menu );

        $this->setPageHeading( OW::getLanguage()->text( 'video_cinematic', 'admin_config' ) );

        $this->setTemplate( OW::getPluginManager()->getPlugin( 'video_cinematic' )->getCtrlViewDir() . 'admin_about.html' );
    }
}


class ConfigSaveForm extends Form
{

    /**
     * Class constructor
     *
     */
    public function __construct() {
        parent::__construct( 'configSaveForm' );
        $this->setEnctype( self::ENCTYPE_MULTYPART_FORMDATA );

        $language = OW::getLanguage();

        // user quota Field
        $borderColorField = new TextField( 'borderColor' );
        $borderColorField->setRequired( false );
        $this->addElement( $borderColorField );

        // user quota Field
        $borderSizeField = new TextField( 'borderSize' );
        $borderSizeField->setRequired( false );
        $this->addElement( $borderSizeField );

        // display Logo option
        $displayLogoField = new CheckboxField( 'displayLogo' );
        $displayLogoField->setRequired( false );
        $this->addElement( $displayLogoField );

        // logo file field
        $logoFileField = new FileField( 'logoFile' );
        $logoFileField->setRequired( false );
        $this->addElement( $logoFileField );

        // display popup on dashboard?
        $popupDashboardField = new CheckboxField( 'popupDashboard' );
        $popupDashboardField->setRequired( false );
        $this->addElement( $popupDashboardField );

        // display popup on user profile?
        $popupProfileField = new CheckboxField( 'popupProfile' );
        $popupProfileField->setRequired( false );
        $this->addElement( $popupProfileField );

        // display popup on dashboard?
        $popupListingField = new CheckboxField( 'popupListing' );
        $popupListingField->setRequired( false );
        $this->addElement( $popupListingField );

        // submit
        $submit = new Submit( 'save' );
        $submit->setValue( $language->text( 'video_cinematic', 'btn_edit' ) );
        $this->addElement( $submit );
    }

    public function process() {
        $values = $this->getValues();

        $config = OW::getConfig();

        $config->saveConfig( 'video_cinematic', 'borderColor', $values['borderColor'] );
        $config->saveConfig( 'video_cinematic', 'borderSize', $values['borderSize'] );
        $config->saveConfig( 'video_cinematic', 'displayLogo', $values['displayLogo'] );

        $config->saveConfig( 'video_cinematic','popupDashboard', $values['popupDashboard'] );
        $config->saveConfig( 'video_cinematic','popupProfile', $values['popupProfile'] );
        $config->saveConfig( 'video_cinematic','popupListing', $values['popupListing'] );

        // if (
        //     isset( $values['displayLogo'] )
        //     && !is_null( $values['displayLogo'] )
        //     && $values['displayLogo'] == "1"
        // ) {
        //     $config->saveConfig( 'video_cinematic', 'displayLogo', "1" );
        // } else {
        //     $config->saveConfig( 'video_cinematic', 'displayLogo', "0" );
        // }

        if ( isset( $_FILES['logoFile'] )
            && !is_null( $_FILES['logoFile'] )
            && $_FILES['logoFile']['error']==0 ) {
            $imgLogo = WideImage::loadFromUpload( 'logoFile' )->resizeDown( 150, 38 );
            $ext = array(
                'image/png' => '.png',
                'image/jpeg' => '.jpg',
                'image/gif' => '.gif',
            );
            $plugin = OW::getPluginManager()->getPlugin( 'video_cinematic' );
            $fileName = 'vc_logo' . $ext[$_FILES['logoFile']['type']];
            $filePath = $plugin->getUserFilesDir() . DS . $fileName;
            file_put_contents( $filePath, $imgLogo );
            $config->saveConfig( 'video_cinematic', 'logoFile', $fileName );
        } else {
            if ( !empty( $_POST['clearImage'] ) ) {
                $config->saveConfig( 'video_cinematic', 'logoFile', '' );
            }
        }

        return array( 'result' => true );
    }
}

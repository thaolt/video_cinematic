<?php

class VIDEO_CINEMATIC_CTRL_Admin extends ADMIN_CTRL_Abstract
{

    function index() {
        $language = OW::getLanguage();

        $item = new BASE_MenuItem();
        $item->setLabel( $language->text( 'video_cinematic', 'admin_menu_general' ) );
        $item->setUrl( OW::getRouter()->urlForRoute( 'video_cinematic.admin' ) );
        $item->setKey( 'general' );
        $item->setIconClass( 'ow_ic_gear_wheel' );
        $item->setOrder( 0 );

        $menu = new BASE_CMP_ContentMenu( array( $item ) );
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

            $elem = $menu->getElement( 'general' );
            if ( $elem ) {
                $elem->setActive( true );
            }
        }

        $configSaveForm->getElement( 'preset' )->setValue( $configs['preset'] );
        $configSaveForm->getElement( 'borderColor' )->setValue( $configs['borderColor'] );
        $configSaveForm->getElement( 'displayLogo' )->setValue( $configs['displayLogo'] );
        if ( !empty( $configs['logoFile'] ) )
            $this->assign( 'imgLogo', OW::getPluginManager()->getPlugin( 'video_cinematic' )->getUserFilesUrl().$configs['logoFile'] );

        $this->setTemplate( OW::getPluginManager()->getPlugin( 'video_cinematic' )->getCtrlViewDir() . 'admin_index.html' );
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

        // preset radio boxes
        $presetField = new RadioField( 'preset' );
        $presetField->addOption( 'full', $language->text( 'video_cinematic', 'preset_full' ) );
        $presetField->addOption( 'lite', $language->text( 'video_cinematic', 'preset_lite' ) );
        $presetField->setRequired( true );
        $this->addElement( $presetField );

        // user quota Field
        $borderColorField = new TextField( 'borderColor' );
        $borderColorField->setRequired( false );
        $this->addElement( $borderColorField );

        // display Logo options
        $displayLogoField = new RadioField( 'displayLogo' );
        $displayLogoField->addOption( '1', $language->text( 'video_cinematic', 'yes' ) );
        $displayLogoField->addOption( '0', $language->text( 'video_cinematic', 'no' ) );
        $displayLogoField->setRequired( false );
        $this->addElement( $displayLogoField );

        // logo file field
        $logoFileField = new FileField( 'logoFile' );
        $logoFileField->setRequired( false );
        $this->addElement( $logoFileField );

        // submit
        $submit = new Submit( 'save' );
        $submit->setValue( $language->text( 'video_cinematic', 'btn_edit' ) );
        $this->addElement( $submit );
    }

    public function process() {
        $values = $this->getValues();

        $config = OW::getConfig();

        $config->saveConfig( 'video_cinematic', 'preset', $values['preset'] );
        $config->saveConfig( 'video_cinematic', 'borderColor', $values['borderColor'] );
        $config->saveConfig( 'video_cinematic', 'displayLogo', $values['displayLogo'] );

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
            if ( !empty($_POST['clearImage']) ) {
                $config->saveConfig( 'video_cinematic', 'logoFile', '' );
            }
        }

        return array( 'result' => true );
    }
}

<?php
// refresh static cache
$plugin = OW::getPluginManager()->getPlugin('video_cinematic');

$staticDir = OW_DIR_STATIC_PLUGIN . $plugin->getModuleName() . DS;

if ( file_exists($staticDir) ) {
    UTIL_File::removeDir($staticDir);
}
mkdir($staticDir);
chmod($staticDir, 0777);

UTIL_File::copyDir( $plugin->getStaticDir(), $staticDir );

// import languages
Updater::getLanguageService()->importPrefixFromZip($plugin->getRootDir().DS.'langs.zip', 'video_cinematic');

// add admin option
$config = OW::getConfig();
@$config->addConfig('video_cinematic', 'borderSize', '0');
@$config->addConfig('video_cinematic', 'popupDashboard', '0');
@$config->addConfig('video_cinematic', 'popupProfile', '0');
@$config->addConfig('video_cinematic', 'popupListing', '1');

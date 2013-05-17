<?php

$plugin = OW::getPluginManager()->getPlugin('photo');

$staticDir = OW_DIR_STATIC_PLUGIN . $plugin->getModuleName() . DS;

if ( file_exists($staticDir) ) {
    UTIL_File::removeDir($staticDir);
}
mkdir($staticDir);
chmod($staticDir, 0777);

UTIL_File::copyDir( $plugin->getStaticDir(), $staticDir );

Updater::getLanguageService()->importPrefixFromZip(dirname(__FILE__).DS.'langs.zip', 'video_cinematic');
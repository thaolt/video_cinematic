update.php<?php
// refresh static cache
$plugin = OW::getPluginManager()->getPlugin('video_cinematic');

$staticDir = OW_DIR_STATIC_PLUGIN . $plugin->getModuleName() . DS;
$pluginStaticDir = OW_DIR_PLUGIN . $plugin->getModuleName() . DS . 'static' . DS;

if ( file_exists($staticDir) ) {
    UTIL_File::removeDir($staticDir);
}

mkdir($staticDir);
chmod($staticDir, 0777);

UTIL_File::copyDir($pluginStaticDir, $staticDir );

// import languages
Updater::getLanguageService()->importPrefixFromZip($plugin->getRootDir().DS.'langs.zip', 'video_cinematic');

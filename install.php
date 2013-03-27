<?

$path = OW::getPluginManager()->getPlugin('video_cinematic')->getRootDir() . 'langs.zip';
BOL_LanguageService::getInstance()->importPrefixFromZip($path, 'video_cinematic');
<?

$path = OW::getPluginManager()->getPlugin('video_cinematic')->getRootDir() . 'langs.zip';
BOL_LanguageService::getInstance()->importPrefixFromZip($path, 'video_cinematic');

$config = OW::getConfig();
$config->addConfig('video_cinematic', 'preset', 'full');
$config->addConfig('video_cinematic', 'borderColor', '#FFFFFF');
$config->addConfig('video_cinematic', 'displayLogo', '1');
$config->addConfig('video_cinematic', 'logoFile', '');

OW::getPluginManager()->addPluginSettingsRouteName('video_cinematic', 'video_cinematic.admin');

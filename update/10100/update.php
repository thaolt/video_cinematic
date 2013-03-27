<?php

OW::getPluginManager()->addPluginSettingsRouteName('video_cinematic', 'video_cinematic.admin');

$config = OW::getConfig();
$config->addConfig('video_cinematic', 'preset', 'full');
$config->addConfig('video_cinematic', 'borderColor', '#FFFFFF');
$config->addConfig('video_cinematic', 'displayLogo', '1');
$config->addConfig('video_cinematic', 'logoFile', '');
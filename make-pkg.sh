#!/bin/sh

DIR_BASE=`cd $(dirname $0);pwd`
DIR_BUILD=$DIR_BASE/video_cinematic
DIR_LANGS=$DIR_BASE/langs
FILE_LANGS_ZIP=$DIR_BASE/langs/langs.zip
FILE_VIDEOCINEMATIC_ZIP=$DIR_BASE/video_cinematic.zip

mkdir $DIR_BUILD

cd $DIR_BUILD
cp ../*.* .
rm make-pkg.sh
cp -r ../classes ../controllers ../static ../update ../views .

cd $DIR_LANGS
zip -r $FILE_LANGS_ZIP ./*
rm -f $DIR_BASE/langs.zip
mv $FILE_LANGS_ZIP $DIR_BUILD/

cd $DIR_BASE
zip -r $FILE_VIDEOCINEMATIC_ZIP ./video_cinematic

rm -rf $DIR_BUILD

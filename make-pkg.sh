#!/bin/sh

DIR_BASE=`cd $(dirname $0);pwd`
DIR_BUILD=$DIR_BASE/video_cinematic
DIR_LANGS=$DIR_BASE/langs
FILE_LANGS_ZIP=$DIR_BASE/langs.zip
FILE_VIDEOCINEMATIC_ZIP=$DIR_BASE/video_cinematic.zip

rm -f $DIR_BASE/langs.zip
rm -f $DIR_BASE/video_cinematic.zip
mkdir $DIR_BUILD

cd $DIR_BUILD
cp ../*.* .
rm make-pkg.sh
rm make-langs.sh
cp -r ../classes ../controllers ../static ../update ../views ../lib .
cd static/css
yuicompressor -v -o '.css$:.css.min' *.css
rm *.css
for i in *.min; 
  do mv $i `basename $i .min`; 
done 
cd $DIR_BUILD/static/js
yuicompressor -v -o '.js$:.js.min' *.js
rm *.js
for i in *.min; 
  do mv $i `basename $i .min`; 
done 

cd $DIR_BASE
./make-langs.sh
mv $FILE_LANGS_ZIP $DIR_BUILD/

cd $DIR_BASE
zip -r $FILE_VIDEOCINEMATIC_ZIP ./video_cinematic

rm -rf $DIR_BUILD

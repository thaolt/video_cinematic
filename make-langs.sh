#!/bin/sh

DIR_BASE=`cd $(dirname $0);pwd`
DIR_LANGS=$DIR_BASE/langs
FILE_LANGS_ZIP=$DIR_BASE/langs/langs.zip

rm -f $DIR_BASE/langs.zip

cd $DIR_LANGS
zip -r $FILE_LANGS_ZIP ./*
mv $FILE_LANGS_ZIP $DIR_BASE/
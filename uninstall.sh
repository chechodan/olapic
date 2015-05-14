#! /bin/bash

DIR_CONFIG="$(pwd)/config" 
FILE_CONFIG="$DIR_CONFIG/config.sh" 

source $FILE_CONFIG

view_header "Uninstall."

if [ -f $COMPOSER ];then
  rm -f "$COMPOSER"
fi

if [ -d $DIR_VENDOR ];then
  rm -dfR "$DIR_VENDOR"
fi

view_footer

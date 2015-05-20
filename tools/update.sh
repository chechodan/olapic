#! /bin/bash

DIR_CONFIG="$(pwd)/config" 
FILE_CONFIG="$DIR_CONFIG/config.sh" 

source $FILE_CONFIG

view_header "Update."

if [ ! -f $COMPOSER ];then
  install_composer
else
  PHP=$(get_command "php")
  $PHP $COMPOSER update;
fi;

view_footer

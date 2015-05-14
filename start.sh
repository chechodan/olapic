#! /bin/bash

DIR_CONFIG="$(pwd)/config" 
FILE_CONFIG="$DIR_CONFIG/config.sh" 

source $FILE_CONFIG

PHP=$(get_command "php")

view_header "locahost:8080/media/{MEDIA_ID}?access_token={ACCESS_TOKEN}"

if [ ! -f $FILE_ACCESS_TOKEN ];then
  enter_access_token
  echo
fi;

view_access_token

echo

$PHP -S $HOST:$PORT -c $INIFILE -t $DOCROOT $ROUTER

view_footer

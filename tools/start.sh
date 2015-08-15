#! /bin/bash

DIR_CONFIG="$(pwd)/config" 
FILE_CONFIG="$DIR_CONFIG/config.sh" 

source $FILE_CONFIG

PHP=$(get_command "php")

view_header "$HOST:$PORT/media/{MEDIA_ID}?access_token={ACCESS_TOKEN}"

check_access_token

view_access_token

echo

$PHP -S $HOST:$PORT -c $INIFILE -t $DOCROOT $ROUTER

view_footer

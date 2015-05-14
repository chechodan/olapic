#! /bin/bash

DIR_CONFIG="$(pwd)/config" 
FILE_CONFIG="$DIR_CONFIG/config.sh" 

source $FILE_CONFIG

view_header "The test."

if [ ! -f $PHPUNIT ];then
  echo "Command phpunit not found. Run install.sh."
  exit 1;  
fi;

if [ ! -f $FILE_ACCESS_TOKEN ];then
  enter_access_token
  echo
fi;
  
view_access_token

echo

$PHPUNIT -c $PATH_ROOT

view_footer

#! /bin/bash

DIR_CONFIG="$(pwd)/config" 
FILE_CONFIG="$DIR_CONFIG/config.sh" 

source $FILE_CONFIG

view_header "The test."

if [ ! -f $PHPUNIT ];then
  echo "Command phpunit not found. Run install.sh."
  exit 1;  
fi;

check_access_token
  
view_access_token

echo

$PHPUNIT -c $PATH_ROOT

view_footer

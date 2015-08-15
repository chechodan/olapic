#! /bin/bash

DIR_CONFIG="$(pwd)/config" 
FILE_CONFIG="$DIR_CONFIG/config.sh" 

source $FILE_CONFIG

view_header "PHPDOC."

if [ ! -f $PHPDOC ];then
  echo "Command phpdoc not found. Run install.sh."
  exit 1;  
fi; 

$PHPDOC -d $PHPDOC_INPUT -t $PHPDOC_OUTPUT -i "$(pwd)/vendor/"

view_footer

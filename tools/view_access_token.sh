#! /bin/bash
 
DIR_CONFIG="$(pwd)/config" 
FILE_CONFIG="$DIR_CONFIG/config.sh" 

source $FILE_CONFIG

view_header "View access token."

view_access_token

view_footer

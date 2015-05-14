#! /bin/bash

# share

DIR_ROOT="$DIR_CONFIG/.."
DIR_VENDOR="$DIR_ROOT/vendor"
FILE_ACCESS_TOKEN="$DIR_CONFIG/access_token.key"
COMPOSER="$DIR_ROOT/composer.phar"
URL_COMPOSER="https://getcomposer.org/installer"

# testing.sh

PHPUNIT="$DIR_ROOT/vendor/phpunit/phpunit/phpunit"
PATH_ROOT="$DIR_CONFIG"

# start.sh

INIFILE="$DIR_CONFIG/php.ini"
DOCROOT="$DIR_ROOT/web";
ROUTER="$DOCROOT/index.php";
HOST=0.0.0.0
PORT=8080

# install.sh

# update.sh

# uninstall.sh

# update_access_token.sh

# view_access_token.sh

function view_header {
  echo ..........................................................
  echo    
  echo Olapic Poject - SocialMedia
  echo ===========================
  echo    
  echo "$1"
  echo    
  echo ..........................................................
  echo
}

function get_command {
  local COMMAND=$1
  local RESULT=$(which $COMMAND)

  if [ $? != 0 ] ; then
    echo "$COMMAND not found."
    exit 1;
  else
    echo $RESULT;
  fi
};

function enter_access_token {
  echo -n "Enter the access token: "
    
  read ACCESS_TOKEN
  echo
  echo -n saving...
  echo "$ACCESS_TOKEN" > $FILE_ACCESS_TOKEN;
  echo \[OK\];
}

function view_access_token { 
  echo -n ACCESS_TOKEN=
  
  if [ -f $FILE_ACCESS_TOKEN ];then
    cat $FILE_ACCESS_TOKEN
  else
    echo -n "<UNSET>"
  fi;
}

function install_composer {
  local PHP=$(get_command "php")
  
  if [ ! -f $COMPOSER ];then
    local CURL=$(get_command "curl")
    
    echo  Installing composer...
    echo
    $CURL -sS $URL_COMPOSER | $PHP
    echo
  fi;

  echo Installing dependencies...
  echo
  $PHP $COMPOSER install
}

function view_footer {  
  echo
  echo Done! Good luck!
  exit 0
}

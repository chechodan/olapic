#! /bin/bash

# share

DIR_ROOT="$DIR_CONFIG/.."
DIR_VENDOR="$DIR_ROOT/vendor"
INSTAGRAM_ACCESS_TOKEN="$DIR_CONFIG/.instagram_access_token.key"
FACEBOOK_ACCESS_TOKEN="$DIR_CONFIG/.facebook_access_token.key"
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

function select_access_token {
  local result=$1
  local access_token=false

  echo -n "Enter the access token: "
     
  read access_token

  eval $result="'$access_token'"
}

function select_network {
  local result=$1
  local network=false

  echo List Network:
  echo 1. Instagram
  echo 2. Facebook
  echo -n Select network \(1, 2\): 
  
  read network
 
  case "$network" in   
    ("2" | "facebook")
      network="facebook";;

    (*)
      network="instagram";;
  esac
  
  eval $result="'$network'"
}

function write_access_token {
  local network=$1
  local access_token=$2
  
  if [ ! -e "$network" ] && [ ! -e "$access_token" ];then
    case "$network" in   
      ("facebook")
        echo "$access_token" > $FACEBOOK_ACCESS_TOKEN;;    

      ("instagram")
        echo "$access_token" > $INSTAGRAM_ACCESS_TOKEN;;
    esac;
  fi;
}

function enter_access_token {
  local network=$1
  local access_token=$2
  local _result=false
  
  if [ -z "$network" ];then    
    select_network _result
    network="$_result"
  fi;
  echo $network selected.
  if [ -z "$access_token" ];then
    select_access_token _result
    access_token="$_result"
  fi;

  echo -n saving $network...
  write_access_token $network $access_token
  echo \[OK\];
}

function check_access_token {

  if [ ! -f $INSTAGRAM_ACCESS_TOKEN ];then
    enter_access_token "instagram"
    echo
  fi;

  if [ ! -f $FACEBOOK_ACCESS_TOKEN ];then
    enter_access_token "facebook"
    echo
  fi; 
}

function view_access_token { 
  view_file "$INSTAGRAM_ACCESS_TOKEN" "INSTAGRAM_ACCESS_TOKEN="
  view_file "$FACEBOOK_ACCESS_TOKEN" "FACEBOOK_ACCESS_TOKEN="
}

function view_file { 
  local file=$1
  local label=$2

  echo -n "$label"
  
  if [ -f "$file" ];then
    cat "$file"
  else
    echo -n "<UNSET>"
  fi;
 
  echo
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

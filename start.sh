#! /bin/bash
 
INIFILE="$(pwd)/config/php.ini"
DOCROOT="$(pwd)/web";
ROUTER="$(pwd)/web/index.php";
HOST=0.0.0.0
PORT=8080

PHP=$(which php)
if [ $? != 0 ] ; then
  echo "PHP not found."
  exit 1
fi

echo    "..........................................................";
echo    ""
echo    "Olapic Poject - SocialMedia";
echo    "===========================";
echo    ""
echo    "locahost:8080/media/{MEDIA_ID}?access_token={ACCESS_TOKEN}";
echo    ""
echo    "..........................................................";
echo    ""

$PHP -S $HOST:$PORT -c $INIFILE -t $DOCROOT $ROUTER

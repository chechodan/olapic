<?php

function defineConst($name, $value) 
{
    if (!defined($name)) {
        try {
            define($name, $value);
        } catch (\Exception $ex) { 
            define($name, ""); 
        }
    }
}

try {
    define("INSTAGRAM_ACCESS_TOKEN", 
        trim(file_get_contents(realpath(__DIR__.'/../').
            '/config/.instagram_access_token.key')
        ));
} catch (\Exception $ex) { 
    define("INSTAGRAM_ACCESS_TOKEN",  "");
}

try {
    define("FACEBOOK_ACCESS_TOKEN",  
        trim(file_get_contents(realpath(__DIR__.'/../').
            '/config/.facebook_access_token.key')
        ));
} catch (\Exception $ex) { 
    define("FACEBOOK_ACCESS_TOKEN",  "");
}

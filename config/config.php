<?php
/**
 * This file defines the constants on the token access to social networks.
 * 
 * @copyright 2015 Sergio Liendo
 * @author Sergio Liendo
 */
 
/**
 * This function defines a constant.
 * 
 * @param string $name Name of the constant
 * @param string $value Value of the constant.
 */
function defineConst($name, $value)
{
    if (! defined($name)) {
        try {
            define($name, $value);
        } catch (\Exception $ex) {
            define($name, "");
        }
    }
}

try {
    define("INSTAGRAM_ACCESS_TOKEN", 
        trim(
            file_get_contents(
                realpath(__DIR__ . '/../') .
                     '/config/.instagram_access_token.key')));
} catch (\Exception $ex) {
    define("INSTAGRAM_ACCESS_TOKEN", "");
}

try {
    define("FACEBOOK_ACCESS_TOKEN", 
        trim(
            file_get_contents(
                realpath(__DIR__ . '/../') . '/config/.facebook_access_token.key')));
} catch (\Exception $ex) {
    define("FACEBOOK_ACCESS_TOKEN", "");
}
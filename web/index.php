<?php
/**
 * This file is the input of the application.
 * 
 * @copyright 2015 Sergio Liendo
 * @author Sergio Liendo
 */
 
$filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

$app = require __DIR__ . '/../app/app.php';

$app->run();

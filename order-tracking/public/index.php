<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());


    /*phpinfo();

var_dump(php_ini_loaded_file(), php_ini_scanned_files());

xdebug_info();

$fileContent = file_get_contents('/usr/local/etc/php/php.ini', true);

echo $fileContent . "<br><br>";

$hostFile = file_get_contents('/etc/hosts', true);

echo $hostFile;*/

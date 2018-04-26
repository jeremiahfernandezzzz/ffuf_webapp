<?php

define('APPLICATION_NAME', 'application_name');

// Display all errors.
error_reporting(E_ALL);
ini_set('display_errors', 'On');
// UTC must be always the default timezone!
date_default_timezone_set('UTC');

// All errors, notices or warnings must be thrown as an exception!
set_error_handler(function ($errno, $errstr, $errfile, $errline, array $errcontex){
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

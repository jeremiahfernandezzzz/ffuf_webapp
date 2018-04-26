<?php

$dir = __DIR__ . DIRECTORY_SEPARATOR;
$fw = $dir . DIRECTORY_SEPARATOR . 'fw' . DIRECTORY_SEPARATOR;
$app = $dir . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;

require $dir . 'php.config.php';

$configList = glob($fw . "*.php");
$appConfigList = glob($app . "*.php");

foreach ($configList as $file) {
    require $file;
}

foreach ($appConfigList as $file) {
    require $file;
}

require $dir . 'kernel.php';

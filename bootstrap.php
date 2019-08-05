<?php

$handle = opendir('lib');
while (false !== ($file = readdir($handle))) {
    if (preg_match('/.*\.php$/', $file)) {
        include_once 'lib/'.$file;
    }
}

$handle = opendir('model');
while (false !== ($file = readdir($handle))) {
    if (preg_match('/.*\.php$/', $file)) {
        include_once 'model/'.$file;
    }
}

Config::init(__DIR__);
Database::init();

session_start();

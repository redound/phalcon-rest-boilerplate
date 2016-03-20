<?php
// This is global bootstrap for autoloading

error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
setlocale(LC_ALL, 'en_US.utf-8');
date_default_timezone_set('UTC');

$root = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR;
defined('TESTS_PATH')   || define('TESTS_PATH', $root);
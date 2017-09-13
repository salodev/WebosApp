<?php
require_once(__DIR__ . '/config.php');
require_once(PATH_AUTOLOAD);
error_reporting(E_ALL);
ini_set('display_errors', 'On');
session_start();
use Webos\Service\Implementation;
Implementation::$dev = true;

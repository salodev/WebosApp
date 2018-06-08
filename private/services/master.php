#!/usr/bin/php
<?php
require_once(dirname(dirname(__FILE__)).'/start.php');
use Webos\Service\Server\Master;

ini_set('display_errors','On');

error_reporting(E_ALL);

echo "server started...\n\n";

Master::Listen('127.0.0.1', 3000);

echo "server stopped...\n\n";
#!/usr/bin/php
<?php

chdir(__DIR__ . '/private/lib/');

exec('git clone https://github.com/salojc2006/Webos.git');
exec('git clone https://github.com/salojc2006/salodev.git');

chdir(__DIR__ . '/private/lib/Webos');
exec('git pull');
chdir(__DIR__ . '/private/lib/salodev');
exec('git pull');
$fromDir = __DIR__ . '/private/lib/Webos/resources/*';
$toDir   = __DIR__ . '/public/';
exec("cp {$fromDir} {$toDir} -r");

$dirname = __DIR__ . '/public/';
echo "\n\n";
echo "You are ready to start! Type following command!: \n\n";
echo "sudo php -S localhost:8080 -t {$dirname}\n\n";
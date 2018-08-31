#!/usr/bin/php
<?php

function println($value = '') {
	echo $value;
	echo "\n";
}

println();
println("**************************************************");
println("    WELCOME TO WEBOS IMPLEMENTATION INSTALLER     ");
println("**************************************************");
println();
println("WebOS Framework for PHP by Salomón Córdova. (@salojc2006)" );
println("Create your own desktop applications ready for all os,"    );
println("simply and semantic coding, object driven, event driven."  );
println("If you love WebOS, please share your experience with mates");
println("or contribute on github and gitlab.");
println();
println("Initializing installation...");

chdir(__DIR__ . '/private/lib/');

echo "Cloning Webos repository                       ";
exec('git clone https://github.com/salojc2006/Webos.git');
echo "ok\n";
echo "Cloning salodev repository                     ";
exec('git clone https://github.com/salojc2006/salodev.git');
echo "ok\n";

echo "creating directoy                              ";
chdir(__DIR__ . '/private/lib/Webos');
echo "ok\n";
echo "pulling files                                  ";
exec('git pull');
echo "ok\n";
echo "creating directoy                              ";
chdir(__DIR__ . '/private/lib/salodev');
echo "ok\n";
echo "pulling files                                  ";
exec('git pull');
echo "ok\n";

echo "creating implementation directories            ";
chdir(__DIR__ . '/private/');
mkdir('workspaces');
mkdir('log');
mkdir('debug');
echo "ok\n";

chdir(__DIR__);

$dirname = __DIR__ . '/public/';
echo "\n\n";
echo "You are ready to start! Type following command!: \n\n";
echo "sudo php -S localhost:8080 {$dirname}/index.php\n\n";
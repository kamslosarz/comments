<?php

require 'vendor/autoload.php';

use App\App;
use App\Config\Config;
use App\Factory\ApiFactory;

$config = new Config();

$api = ApiFactory::getInstance($config);

$app = new App();
$response = $app->execute($config, $api);

$response->send();
echo PHP_EOL;

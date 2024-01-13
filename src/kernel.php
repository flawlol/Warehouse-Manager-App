<?php

use Webdream\Warehouse\Providers\ServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$provider = new ServiceProvider();
$provider->register(container());
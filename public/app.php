<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/setup_routing.php';
require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/Kernel.php';

$kernel = new Kernel($container);
$kernel->run();

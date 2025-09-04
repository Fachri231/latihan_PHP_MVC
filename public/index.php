<?php
if(!session_id()) session_start();
require_once __DIR__ . '/../app/init.php';
require_once __DIR__ . '/../vendor/autoload.php';

$app = new App\Core\App;
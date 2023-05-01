<?php
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
use App\Controller\Controller;
$controller = new Controller();
require_once 'router.php';

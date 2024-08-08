<?php
require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable("../Config/Env/");
$dotenv->load();
require '../Config/Routes/Routes.php';
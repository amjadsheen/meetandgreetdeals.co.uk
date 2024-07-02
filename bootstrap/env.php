<?php

$host = $_SERVER['HTTP_HOST'];

$env_dir = __DIR__.'/../env/';

if (file_exists($env_dir.$host)) {
    $dotenv = new \Dotenv\Dotenv($env_dir, $host);
    $dotenv->load();
}


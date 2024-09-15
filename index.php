<?php

header("Access-Control-Allow-Origin: *");

header("Content-Type: text/html; charset=UTF-8");
header("Accept: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/public/index.php';

<?php 

use App\config\Router;

Router::get('/', 'App\Controllers\HomeController@index');


include_once __DIR__.'/../../app/routes/_router.php';

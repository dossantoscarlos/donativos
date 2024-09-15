<?php 

use App\config\Router;

Router::get('user', 'App\Controllers\HomeController@index');


require_once __DIR__.'/../../app/routes/_router.php';

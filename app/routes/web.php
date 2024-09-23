<?php

use App\config\Router;

Router::get('user', 'App\Controllers\HomeController@index');

Router::get("paciente", 'App\Controllers\PacienteController@index');
Router::get("paciente/{id}", 'App\Controllers\PacienteController@show');
Router::get("paciente/create", 'App\Controllers\PacienteController@create');
Router::post("paciente/save", 'App\Controllers\PacienteController@save');


require_once __DIR__.'/../../app/routes/_router.php';

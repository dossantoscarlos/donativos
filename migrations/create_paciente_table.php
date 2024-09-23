<?php

declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use App\Database\Conexao;

$con = Conexao::getInstance();

$create_table = "CREATE TABLE IF NOT EXISTS `pacientes` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `nome` varchar(255) NOT NULL,
    `cpf` varchar(255) NOT NULL UNIQUE,
    `data_nasc` date NOT NULL,
    `sexo` varchar(255) NOT NULL,
    telefone varchar(255) NOT NULL,
    telefone_emergencia varchar(255) ,
    nome_emergencia varchar(255) ,
    cep varchar(255) not null,
    localidade varchar(255) not null,
    estado varchar(255) not null,
    bairro varchar (255) not null,
    cidade varchar(255) not null,
    uf varchar(4) not null,
    complemento varchar(255),
    numero varchar(255) default 'sem numero') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

$drop_table = 'Drop table if exists paciente';


$con->prepare($create_table)->execute();

<?php 

declare(strict_types=1);


namespace App\Service;

use App\Database\Conexao;
use App\Models\Home;

class HomeService
{
    public function save(Home $model)
    {
        try {
            $con = Conexao::getInstance();
            $query = "INSERT INTO homes (nome) VALUES (:nome)";
            $stmt = $con->prepare($query);
            $stmt->bindValue(':nome', $model->name);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }catch(\PDOException $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    public function all () 
    {
        try {
            $con = Conexao::getInstance();
            $query = "SELECT * FROM homes";
            $stmt = $con->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch(\PDOException $e) {
            throw new \ErrorException($e->getMessage());
        }
    }
}
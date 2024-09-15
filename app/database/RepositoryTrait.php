<?php 

declare(strict_types=1);

namespace App\Database;

use App\Database\Conexao;


trait RepositoryTrait
{

    /**
     * Realiza um insert na tabela especificada com os valores passados
     *
     * @param string $table Nome da tabela
     * @param array $data Valores a serem inseridos
     *
     * @return array
     *
     * @throws \ErrorException
     */
    function insert(string $table , array $data) {
        try {
            $con = Conexao::getInstance();
        
            $table = htmlspecialchars($table);
        
            $query = "INSERT INTO {$table} (";
        
            foreach ($data as $key => $value) {
                $query .= "{$key},";
            }
        
            $query = substr($query, 0, -1);
            $query .= ") VALUES (";
        
            foreach ($data as $key => $value) {
                $query .= ":{$key},";
            }
        
            $query = substr($query, 0, -1);
            $query .= ")";
        
            $stmt = $con->prepare($query);
        
            foreach ($data as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }
        
            $stmt->execute();
        
            return $stmt->fetch(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            throw new \ErrorException($e->getMessage());       
        }
    }

    /**
     * Select all items from a given table
     *
     * @param string $table The table name
     *
     * @return array The selected items
     *
     * @throws \ErrorException
     */
    function select_all(string $table) {
        try {
            $con = Conexao::getInstance();
            
            $table = htmlspecialchars($table);
            
            $query = "SELECT * FROM {$table}";
            $stmt = $con->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \ErrorException($e->getMessage());
        }
    }
}
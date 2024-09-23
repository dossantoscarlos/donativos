<?php

declare(strict_types=1);

namespace App\Database;

use PDO;

class Conexao
{
    private static $conn;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        $dsn = 'mysql:host=127.0.0.1;dbname=crud;charset=utf8mb4';
        $user = 'root';
        $password = 'admin';

        try {

            self::$conn = new PDO($dsn, $user, $password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return self::$conn;

        } catch (\PDOException $e) {
            throw new \ErrorException($e->getMessage());
        }

    }

    public function disconnect()
    {
        self::$conn = null;
    }
}

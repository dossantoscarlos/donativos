<?php

declare(strict_types=1);

namespace App\Database;

use App\Config\Logger;

trait RepositoryTrait
{
    /**
     * Realiza um insert na tabela especificada com os valores passados
     *
     * @param  string  $table  Nome da tabela
     * @param  array  $data  Valores a serem inseridos
     * @return array
     *
     * @throws \ErrorException
     */
    public function insert(string $table, array $data)
    {
        try {
            $con = Conexao::getInstance();

            $table = htmlspecialchars($table);

            $query = "INSERT INTO {$table} (";

            foreach ($data as $key => $value) {
                $query .= "{$key},";
            }

            $query = substr($query, 0, -1);
            $query .= ') VALUES (';

            foreach ($data as $key => $value) {
                $query .= ":{$key},";
            }

            $query = substr($query, 0, -1);
            $query .= ')';

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
        * Seleciona todos os itens com paginação e filtro de pesquisa.
        *
        * @param string $table Nome da tabela.
        * @param int $limit Limite de registros por página.
        * @param int $page Número da página atual.
        * @param string $search Filtro de pesquisa.
        * @return array Dados da página atual, total de registros, total de páginas e página atual.
        */
    public function select_all(string $table, int $limit = 100, int $page = 1, string $search = '', $like_param = ''): array
    {
        $pdo = Conexao::getInstance();

        $offset = ($page - 1) * $limit;



        // Prepare a cláusula WHERE se houver um filtro de pesquisa
        $searchQuery = '';
        if (!empty($search) && !empty($like_param)) {
            $searchQuery = " WHERE {$like_param} LIKE :search";
        }

        // Preparar consulta SQL para contar o total de registros
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM {$table} {$searchQuery}");
        if (!empty($search) && !empty($like_param)) {
            $stmt->bindValue(':search', "%".$search."%");
        }

        Logger::debug("SELECT COUNT(*) FROM {$table} {$searchQuery}");

        $stmt->execute();
        $totalRecords = $stmt->fetchColumn();

        // Preparar consulta SQL para obter os dados da página atual
        $stmt = $pdo->prepare("SELECT * FROM {$table} {$searchQuery} LIMIT :limit OFFSET :offset");
        if (!empty($search) && !empty($like_param)) {
            $stmt->bindValue(':search', "%$search%");
        }
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Calcular o total de páginas
        $totalPages = (int)ceil($totalRecords / $limit);

        return [
            'data' => $data,
            'total_records' => $totalRecords,
            'total_pages' => $totalPages,
            'current_page' => $page,
            'limit' => $limit
        ];
    }

}

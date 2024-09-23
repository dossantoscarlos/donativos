<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Service\HomeService;
use Twig\Environment;

class HomeController
{
    private Environment $twig;
    private HomeService $service;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->service = new HomeService;
    }

    /**
     * Exibe todos os itens da tabela Homes com paginação e filtro de pesquisa.
     *
     * @return void
     */
    public function index()
    {
        // Definir o limite de registros por página
        $limit = 1;

        // Obter o número da página atual, padrão para 1 se não definido
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        // Garantir que o número da página seja positivo
        if ($page < 1) {
            $page = 1;
        }

        // Obter o filtro de pesquisa, se definido
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Obter os dados da página atual com paginação e filtro
        $result = $this->service->select_all(
            'Homes',
            $limit,
            $page,
            $search,
            'nome'
        );

        // Passar os dados para a visão
        echo $this->twig->render('homes/index.twig', [
            'homes' => $result['data'],
            'total_records' => $result['total_records'],
            'total_pages' => $result['total_pages'],
            'current_page' => $result['current_page'],
            'limit' => $result['limit'],
            'search' => $search  // Passa o valor do filtro para a visão
        ]);
    }

}

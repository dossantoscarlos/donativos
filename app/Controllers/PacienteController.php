<?php


declare(strict_types=1);

namespace App\Controllers;

use App\Config\Logger;
use App\Models\Paciente;
use App\Service\PacienteService;
use Twig\Environment;
use App\Config\Cripto;

class PacienteController
{
    private Environment $twig;
    private PacienteService $pacienteService;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->pacienteService = new PacienteService;
    }

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
        $result = $this->pacienteService->select_all(
            'pacientes',
            $limit,
            $page,
            $search,
            'nome'
        );

        // Passar os dados para a visão


        foreach ($result['data'] as $key => $value) {
            if (isset($value['cpf'])) {
                $result['data'][$key]['cpf'] = Cripto::descriptografar($value['cpf']);
            }
        }

        Logger::info(json_encode($result['data']));

        echo $this->twig->render('paciente/index.twig', [
            'pacientes' => $result['data'],
            'total_records' => $result['total_records'],
            'total_pages' => $result['total_pages'],
            'current_page' => $result['current_page'],
            'limit' => $result['limit'],
            'search' => $search  // Passa o valor do filtro para a visão
        ]);
    }

    public function create()
    {
        $status = "paciente";
        return  $this->twig->render('paciente/create.twig', compact('status'));
    }

    public function edit()
    {
        return  $this->twig->render('paciente/edit.twig');
    }

    public function save()
    {
        $paciente = new Paciente(
            $_POST['nome'],
            $_POST['data_nasc'],
            Cripto::criptografar($_POST['paciente_cpf']),
            $_POST['paciente_sexo'],
            $_POST['telefone'],
            $_POST['emergencia'],
            $_POST['nome_emergencia'],
            $_POST['cep'],
            $_POST['localidade'],
            $_POST['estado'],
            $_POST['uf'],
            $_POST['cidade'],
            $_POST['bairro'],
            $_POST['complemento'],
            $_POST['numero_casa']
        );

        Logger::info(json_encode($paciente->to_array()));

        $this->pacienteService->insert($paciente->get_table(), $paciente->to_array());

        header('Location: /paciente');
    }

    public function show($id)
    {
        return  $this->twig->render('paciente/show.twig', compact('id'));
    }

}

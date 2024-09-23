<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';


// namespace App\relatorios;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportPlanilha
{
    private Spreadsheet $spreadsheet;
    private array $planilha;
    private array $linha;

    private string $titulo;

    private Worksheet $sheet;

    public function __construct(array $cabecalho, array $linha, string $titulo)
    {
        $this->planilha = $cabecalho;
        $this->linha = $linha;
        $this->titulo = $titulo;
    }

    public function exportar()
    {
        foreach ($this->linha as $chave => $valor) {
            array_push($this->planilha, $valor);
        }

        $data = $this->planilha;

        $this->spreadsheet = new Spreadsheet;
        $this->spreadsheet->getProperties()->setTitle($this->titulo);
        $this->sheet = $this->spreadsheet->getActiveSheet();
        $this->sheet->fromArray($data, null, 'A1');
        $cabecalho = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_DISTRIBUTED],
            'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUMDASHDOT]]
        ];

        $this->sheet->getStyle('A1:H1')->applyFromArray($cabecalho);

        foreach (range('A', 'H') as $col) {
            $this->sheet->getColumnDimension($col)->setAutoSize(true);
        }


        $arquivo_nome = 'planilha.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $arquivo_nome .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($this->spreadsheet);
        $writer->save($arquivo_nome);
    }


}



$cabecalho = [
    [
        'id',
        'matricula',
        'nome_funcionario',
        'funcao',
        'competencia',
        'codigo_verba',
        'descricao_verba',
        'valor'
    ]
];




$registros = [
    [
        'id' => 1,
        'matricula' => '12345',
        'nome_funcionario' => 'Ana Silva',
        'funcao' => 'Analista',
        'competencia' => '01/2024',
        'codigo_verba' => 'A001',
        'descricao_verba' => 'Desenvolvimento de Software',
        'valor' => 5000.00
    ],
    [
        'id' => 2,
        'matricula' => '12346',
        'nome_funcionario' => 'Carlos Oliveira',
        'funcao' => 'Desenvolvedor',
        'competencia' => '01/2024',
        'codigo_verba' => 'A002',
        'descricao_verba' => 'Consultoria Externa',
        'valor' => 4500.00
    ],
    [
        'id' => 3,
        'matricula' => '12347',
        'nome_funcionario' => 'Maria Santos',
        'funcao' => 'Gerente',
        'competencia' => '01/2024',
        'codigo_verba' => 'A003',
        'descricao_verba' => 'Gerenciamento de Projeto',
        'valor' => 7000.00
    ],
    [
        'id' => 4,
        'matricula' => '12348',
        'nome_funcionario' => 'João Pereira',
        'funcao' => 'Analista',
        'competencia' => '01/2024',
        'codigo_verba' => 'A004',
        'descricao_verba' => 'Análise de Sistemas',
        'valor' => 5500.00
    ],
    [
        'id' => 5,
        'matricula' => '12349',
        'nome_funcionario' => 'Patrícia Lima',
        'funcao' => 'Consultora',
        'competencia' => '01/2024',
        'codigo_verba' => 'A005',
        'descricao_verba' => 'Consultoria em TI',
        'valor' => 6000.00
    ],
    [
        'id' => 6,
        'matricula' => '12350',
        'nome_funcionario' => 'Lucas Costa',
        'funcao' => 'Designer',
        'competencia' => '01/2024',
        'codigo_verba' => 'A006',
        'descricao_verba' => 'Design de Interface',
        'valor' => 4800.00
    ],
    [
        'id' => 7,
        'matricula' => '12351',
        'nome_funcionario' => 'Fernanda Almeida',
        'funcao' => 'Desenvolvedor',
        'competencia' => '01/2024',
        'codigo_verba' => 'A007',
        'descricao_verba' => 'Desenvolvimento Web',
        'valor' => 5200.00
    ],
    [
        'id' => 8,
        'matricula' => '12352',
        'nome_funcionario' => 'Ricardo Souza',
        'funcao' => 'Gerente',
        'competencia' => '01/2024',
        'codigo_verba' => 'A008',
        'descricao_verba' => 'Gestão de Equipe',
        'valor' => 7500.00
    ],
    [
        'id' => 9,
        'matricula' => '12353',
        'nome_funcionario' => 'Juliana Martins',
        'funcao' => 'Analista',
        'competencia' => '01/2024',
        'codigo_verba' => 'A009',
        'descricao_verba' => 'Análise de Dados',
        'valor' => 5300.00
    ],
    [
        'id' => 10,
        'matricula' => '12354',
        'nome_funcionario' => 'Eduardo Ribeiro',
        'funcao' => 'Consultor',
        'competencia' => '01/2024',
        'codigo_verba' => 'A010',
        'descricao_verba' => 'Consultoria Estratégica',
        'valor' => 6100.00
    ],
    [
        'id' => 11,
        'matricula' => '12355',
        'nome_funcionario' => 'Beatriz Oliveira',
        'funcao' => 'Designer',
        'competencia' => '01/2024',
        'codigo_verba' => 'A011',
        'descricao_verba' => 'Design Gráfico',
        'valor' => 4900.00
    ],
    [
        'id' => 12,
        'matricula' => '12356',
        'nome_funcionario' => 'Gustavo Lima',
        'funcao' => 'Analista',
        'competencia' => '01/2024',
        'codigo_verba' => 'A012',
        'descricao_verba' => 'Análise de Processos',
        'valor' => 5400.00
    ],
    [
        'id' => 13,
        'matricula' => '12357',
        'nome_funcionario' => 'Camila Ferreira',
        'funcao' => 'Desenvolvedor',
        'competencia' => '01/2024',
        'codigo_verba' => 'A013',
        'descricao_verba' => 'Desenvolvimento Backend',
        'valor' => 5600.00
    ],
    [
        'id' => 14,
        'matricula' => '12358',
        'nome_funcionario' => 'Marcos Andrade',
        'funcao' => 'Gerente',
        'competencia' => '01/2024',
        'codigo_verba' => 'A014',
        'descricao_verba' => 'Coordenação de Projetos',
        'valor' => 7200.00
    ],
    [
        'id' => 15,
        'matricula' => '12359',
        'nome_funcionario' => 'Letícia Costa',
        'funcao' => 'Consultora',
        'competencia' => '01/2024',
        'codigo_verba' => 'A015',
        'descricao_verba' => 'Consultoria de Processos',
        'valor' => 6300.00
    ],
    [
        'id' => 16,
        'matricula' => '12360',
        'nome_funcionario' => 'Rodrigo Almeida',
        'funcao' => 'Designer',
        'competencia' => '01/2024',
        'codigo_verba' => 'A016',
        'descricao_verba' => 'Criação de Logos',
        'valor' => 5000.00
    ],
    [
        'id' => 17,
        'matricula' => '12361',
        'nome_funcionario' => 'Tatiane Mendes',
        'funcao' => 'Desenvolvedor',
        'competencia' => '01/2024',
        'codigo_verba' => 'A017',
        'descricao_verba' => 'Desenvolvimento Mobile',
        'valor' => 5400.00
    ],
    [
        'id' => 18,
        'matricula' => '12362',
        'nome_funcionario' => 'Felipe Rocha',
        'funcao' => 'Analista',
        'competencia' => '01/2024',
        'codigo_verba' => 'A018',
        'descricao_verba' => 'Pesquisa de Mercado',
        'valor' => 5100.00
    ],
    [
        'id' => 19,
        'matricula' => '12363',
        'nome_funcionario' => 'Larissa Gomes',
        'funcao' => 'Gerente',
        'competencia' => '01/2024',
        'codigo_verba' => 'A019',
        'descricao_verba' => 'Gestão de Recursos',
        'valor' => 7400.00
    ],
    [
        'id' => 20,
        'matricula' => '12364',
        'nome_funcionario' => 'Joana Santos',
        'funcao' => 'Consultora',
        'competencia' => '01/2024',
        'codigo_verba' => 'A020',
        'descricao_verba' => 'Consultoria em Marketing',
        'valor' => 6200.00
    ],
    [
        'id' => 21,
        'matricula' => '12365',
        'nome_funcionario' => 'Vinícius Martins',
        'funcao' => 'Designer',
        'competencia' => '01/2024',
        'codigo_verba' => 'A021',
        'descricao_verba' => 'Design de Aplicativos',
        'valor' => 5100.00
    ],
    [
        'id' => 22,
        'matricula' => '12366',
        'nome_funcionario' => 'André Silva',
        'funcao' => 'Desenvolvedor',
        'competencia' => '01/2024',
        'codigo_verba' => 'A022',
        'descricao_verba' => 'Desenvolvimento Frontend',
        'valor' => 5300.00
    ],
    [
        'id' => 23,
        'matricula' => '12367',
        'nome_funcionario' => 'Amanda Freitas',
        'funcao' => 'Analista',
        'competencia' => '01/2024',
        'codigo_verba' => 'A023',
        'descricao_verba' => 'Análise de Performance',
        'valor' => 5200.00
    ],
    [
        'id' => 24,
        'matricula' => '12368',
        'nome_funcionario' => 'Rafael Lima',
        'funcao' => 'Gerente',
        'competencia' => '01/2024',
        'codigo_verba' => 'A024',
        'descricao_verba' => 'Coordenação de Equipe',
        'valor' => 7300.00
    ],
    [
        'id' => 25,
        'matricula' => '12369',
        'nome_funcionario' => 'Larissa Oliveira',
        'funcao' => 'Consultora',
        'competencia' => '01/2024',
        'codigo_verba' => 'A025',
        'descricao_verba' => 'Consultoria em Vendas',
        'valor' => 6400.00
    ],
    [
        'id' => 26,
        'matricula' => '12370',
        'nome_funcionario' => 'Júlio Santos',
        'funcao' => 'Designer',
        'competencia' => '01/2024',
        'codigo_verba' => 'A026',
        'descricao_verba' => 'Design de Produtos',
        'valor' => 5000.00
    ],
    [
        'id' => 27,
        'matricula' => '12371',
        'nome_funcionario' => 'Viviane Almeida',
        'funcao' => 'Desenvolvedor',
        'competencia' => '01/2024',
        'codigo_verba' => 'A027',
        'descricao_verba' => 'Desenvolvimento de APIs',
        'valor' => 5500.00
    ],
    [
        'id' => 28,
        'matricula' => '12372',
        'nome_funcionario' => 'Paulo Rocha',
        'funcao' => 'Analista',
        'competencia' => '01/2024',
        'codigo_verba' => 'A028',
        'descricao_verba' => 'Análise de Qualidade',
        'valor' => 5300.00
    ],
    [
        'id' => 29,
        'matricula' => '12373',
        'nome_funcionario' => 'Mariana Costa',
        'funcao' => 'Gerente',
        'competencia' => '01/2024',
        'codigo_verba' => 'A029',
        'descricao_verba' => 'Gestão de Projetos',
        'valor' => 7600.00
    ],
    [
        'id' => 30,
        'matricula' => '12374',
        'nome_funcionario' => 'Bruno Lima',
        'funcao' => 'Consultor',
        'competencia' => '01/2024',
        'codigo_verba' => 'A030',
        'descricao_verba' => 'Consultoria em Finanças',
        'valor' => 6500.00
    ]
];


$exec = new ExportPlanilha(cabecalho: $cabecalho, linha: $registros, titulo: 'Planilha');

$exec->exportar();

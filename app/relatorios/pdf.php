<?php

require __DIR__.'/../../vendor/setasign/fpdf/fpdf.php';

class PDF extends FPDF
{
    // Função para adicionar cabeçalho
    public function Header()
    {
        // Logo
        //$this->Image('logo.png', 10, 6, 30);
        // Move para a direita
        //$this->Cell(40);
        // Título da Empresa
        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(80, 80, 80);

        $this->Cell(30, 10, 'ALTA PERFORMANCE NETWORKS COMPUTADORES LTDA', 0, 0, 'L');
        $this->Cell(120);
        $this->Cell(40, 10, 'CNPJ: 06.987.876/0001-76', 0, 0, 'L');
        $this->Ln(7);

        $this->Cell(30, 6, 'Rua 3, 123 - Bairro - Cidade - CEP: 12345-678', 0, 0, 'L');
        $this->Cell(120);
        $this->Cell(40, 6, 'www.altaperformance.com.br', 0, 0, 'L');
        $this->Ln(5);

        $this->Cell(150);
        $this->Cell(120, 6, 'contato@exemplo.com.br', 0, 0, 'L');
        $this->Ln(10);
    }


    // Função para criar a tabela
    public function TableHeader($equipamento)
    {
        // Cabeçalhos da tabela
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(217, 217, 217); // Cor de fundo
        $this->SetTextColor(0, 0, 0);
        $this->Cell(50, 7, 'Equipamento', 1, 0, 'L', true);
        $this->Cell(140, 7, $equipamento, 1, 1, 'L', true);
    }

    public function SubTableHeader()
    {
        // Cabeçalhos da tabela
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(217, 217, 217); // Cor de fundo
        $this->SetTextColor(0, 0, 0);
        $this->Cell(30, 6, 'Item', 1, 0, 'L', true);
        $this->Cell(40, 6, 'Patrimonio', 1, 0, 'L', true);
        $this->Cell(90, 6, 'Descricao', 1, 0, 'L', true);
        $this->Cell(30, 6, 'Valor', 1, 1, 'L', true);
    }

    // Função para adicionar uma linha na tabela
    public function TableRow($item, $patrimonio, $descricao, $valor)
    {
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(30, 6, $item, 1);
        $this->Cell(40, 6, $patrimonio, 1);
        $this->Cell(90, 6, $descricao, 1);
        $this->Cell(30, 6, $valor, 1, 1, 'R');
    }

    // Função para adicionar a linha de total
    public function TotalRow($total)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(29, 45, 81); // Cor de fundo azul escuro
        $this->SetTextColor(255, 255, 255); // Cor do texto branca
        $this->Cell(160, 7, 'Valor Total Itens', 1, 0, 'R', true);
        $this->Cell(30, 7, number_format($total, 2, ',', '.'), 1, 1, 'R', true);
    }

    public function SubTotalRow($total)
    {
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(29, 45, 81); // Cor de fundo azul escuro
        $this->SetTextColor(255, 255, 255); // Cor do texto branca
        $this->Cell(160, 4, 'Subtotal modelo', 1, 0, 'R', true);
        $this->Cell(30, 4, number_format($total, 2, ',', '.'), 1, 1, 'R', true);
    }
}

// Instanciando o objeto PDF
$pdf = new PDF;
$pdf->AddPage();

// Cabeçalhos do Cliente
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 6, 'Cliente:', 0, 0, 'L');
$pdf->Cell(60, 6, '', 0, 0, 'L');
$pdf->Cell(25, 6, 'CNPJ:', 0, 0, 'L');
$pdf->Cell(60, 6, '', 0, 1, 'L');

$pdf->Cell(25, 6, 'Emissao:', 0, 0, 'L');
$pdf->Cell(60, 6, '', 0, 0, 'L');
$pdf->Cell(25, 6, 'Vencimento:', 0, 0, 'L');
$pdf->Cell(60, 6, '', 0, 0, 'L');
$pdf->Cell(25, 6, 'Fatura:', 0, 1, 'L');

$pdf->Ln(5); // Espaçamento

// Título do Detalhamento
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Detalhamento - Extrato Locacao', 0, 1, 'C');
$pdf->Ln(5);

// Seção com contrato e mês de referência
$pdf->SetFillColor(29, 45, 81);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(95, 8, 'Contrato: 123456', 0, 0, 'L', true);
$pdf->Cell(95, 8, 'Mes Referencia: 09/2024', 0, 1, 'L', true);
$pdf->Cell(95, 8, 'Contrato: 123456', 0, 0, 'L', true);
$pdf->Cell(95, 8, 'Mes Referencia: 09/2024', 0, 1, 'L', true);
$pdf->Ln(5);

// Cabeçalho da Tabela
$pdf->TableHeader('Monitor');
$pdf->Ln(5);
$pdf->SubTableHeader();

// Exemplo de linhas na tabela
$pdf->TableRow('001', 'P12345', 'Descricao Equipamento', '2133,00');
$pdf->SubTotalRow(2133);
// Linha de Total
$pdf->Ln(5);
$pdf->TotalRow(2133);

// Gerando o PDF e salvando no diretório `pdf/` com nome `relatorio.pdf`
$filename = __DIR__ . '/pdf/relatorio.pdf';
$pdf->Output('F', $filename);

echo "PDF gerado com sucesso: $filename";

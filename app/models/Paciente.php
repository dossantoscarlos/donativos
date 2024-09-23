<?php

declare(strict_types=1);

namespace App\Models;

class Paciente
{
    public const TABLE = 'pacientes';

    /**
     * Construtor da classe Paciente
     *
     * @param string $nome
     * @param string $data_nasc
     * @param string $cpf
     * @param string $sexo
     * @param string $telefone
     * @param string $telefone_emergencia
     * @param string $nome_emergencia
     * @param string $cep
     * @param string $localidade
     * @param string $estado
     * @param string $bairro
     * @param string $cidade
     * @param string $uf
     * @param string $complemento
     * @param string $numero
     */
    public function __construct(
        protected string $nome,
        protected string $data_nasc,
        protected string $cpf,
        protected string $sexo,
        protected string $telefone,
        protected string $cep,
        protected string $localidade,
        protected string $estado,
        protected string $bairro,
        protected string $cidade,
        protected string $uf,
        protected string $telefone_emergencia = '',
        protected string $nome_emergencia = '',
        protected string $complemento = '',
        protected string $numero = 'sem numero'
    ) {
    }

    /**
     * Retorna o nome da tabela no banco de dados
     *
     * @return string
     */
    public function get_table(): string
    {
        return self::TABLE;
    }

    /**
     * Retorna um array associativo com todas as propriedades do objeto
     *
     * @return array
     */
    public function to_array(): array
    {
        return get_object_vars($this);
    }
}

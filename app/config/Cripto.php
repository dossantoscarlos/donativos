<?php

declare(strict_types=1);

namespace App\Config;

class Cripto
{
    private static $chave = "1234567890123456";

    private function __construct()
    {
    }

    /**
     * @param string $dados Dados a serem criptografados
     * @return string | bool Dados criptografados com IV concatenado
     */
    public static function criptografar($dados)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $dados_criptografados = openssl_encrypt(
            $dados,
            'aes-256-cbc',
            self::$chave,
            0,
            $iv
        );
        return base64_encode($iv . $dados_criptografados);
    }

    /**
     * @param string $dados_criptografados Dados criptografados com IV concatenado
     * @return string | bool Dados descriptografados
     */
    public static function descriptografar($dados_criptografados)
    {

        $dados_criptografados = base64_decode($dados_criptografados);
        $iv_length = openssl_cipher_iv_length('aes-256-cbc');

        $iv = substr($dados_criptografados, 0, $iv_length);
        $dados_criptografados = substr($dados_criptografados, $iv_length);

        return openssl_decrypt(
            $dados_criptografados,
            'aes-256-cbc',
            self::$chave,
            0,
            $iv
        );
    }

}

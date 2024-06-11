<?php
class Validador
{
    public static function limparDados(array $dados)
    {
        // Array para armazenar os dados limpos
        $dadosLimpos = [];

        // Iterar sobre cada campo dos dados recebidos
        foreach ($dados as $chave => $valor) {
            if (in_array($chave, ['cpf', 'rg', 'contato', 'certidao', 'cep'])) {
                // Remover caracteres de formatação das máscaras para campos específicos
                $valorSemFormatacao = preg_replace('/[^0-9]/', '', $valor);
                $valorLimpo = trim($valorSemFormatacao);
            } else {
                // Limpar o valor removendo espaços em branco desnecessários
                $valorLimpo = trim($valor);
                // Remover tags HTML e PHP dos valores
                $valorLimpo = strip_tags($valorLimpo);
                // Escapar caracteres especiais para prevenir injeção de SQL
                $valorLimpo = htmlspecialchars($valorLimpo);
            }

            // Armazenar o valor limpo no array de dados limpos
            $dadosLimpos[$chave] = $valorLimpo;
        }
        // Retornar os dados limpos
        return $dadosLimpos;
    }
}

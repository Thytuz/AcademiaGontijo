<?php

/**
 * Este é um Código da Fábrica de Software
 * 
 * Coordenador: Elymar Pereira Cabral
 * 
 * Data: 22/04/2013
 *
 * Descrição da classe Strings:
 * 
 * Esta classe permite tratar strings.
 *
 * @autor Elymar Pereira Cabral
 */
class Strings {

    /**
     * Transformauma string para o formato camel case. Retira os '_' da string.
     * 
     * @param type $strOrigem String a ser montada com formato camel case. Se
     * vier com '_' retira.
     * @param Boolean $comecaComMaiusculo Idica se o texto começa em maiúsculo 
     * ou não. Não obrigatório. Se não informado assume falso.
     * @return String String em formato camel case.
     */
    private static function montaStringCamelCase($strOrigem, $comecaComMaiusculo = false) {
        $maiusculo = $comecaComMaiusculo;
        $strDestino = array();
        $arrayString = str_split($strOrigem); // Fatia a string e devolve um array
        foreach ($arrayString as $caractere) {
            if ($caractere === '_') {
                $maiusculo = TRUE;
            } else {
                if ($maiusculo) {
                    $strDestino[] = strtoupper($caractere);
                    $maiusculo = FALSE;
                } else {
                    $strDestino[] = strtolower($caractere);
                }
            }
        }

        return implode('', $strDestino); // Transforma o array com o nome do atributo em uma string única.
    }

    /**
     * Gera uma string com o nome do método set para um atributo a partir no 
     * nome da coluna de uma tabela do BD.
     * @param String $nomeDaColuna Nome da coluna da tabela.
     * @return String Nome do método set.
     */
    public static function trocaNomeColunaParaSetAtributo($nomeDaColuna) {
        return "set" . self::montaStringCamelCase($nomeDaColuna, $comecaComMaiusculo = true);
    }

    /**
     * Gera uma string com o nome do método get para um atributo a partir no 
     * nome da coluna de uma tabela do BD.
     * @param String $nomeDaColuna Nome da coluna da tabela.
     * @return String Nome do método get.
     */
    public static function trocaNomeColunaParaGetAtributo($nomeDaColuna) {
        return "get" . self::montaStringCamelCase($nomeDaColuna, $comecaComMaiusculo = true);
    }

    /**
     * Transforma o nome de uma coluna no padrão da FSW para o padrão de nome de atributo.
     * 
     * Exemplo: uslo_id será transformada para usloId.
     * 
     * @param string $nomeDaColuna: nome da coluna a ser transformada para nome de atributo.
     * @return string nome do atributo gerado a partir do nome da coluna.
     */
    public static function trocaNomeColunaParaAtributo($nomeDaColuna) {
        return self::montaStringCamelCase($nomeDaColuna);
//        $maiusculo      = FALSE;
//        $nomeDoAtributo = array();
//        $nomeDaColuna   = str_split($nomeDaColuna); // Fatia a string e devolve um array
//        foreach ($nomeDaColuna as $caractere) {
//            if ($caractere === '_') {
//                $maiusculo = TRUE;
//            } else {
//                if ($maiusculo) {
//                    $nomeDoAtributo[] = strtoupper($caractere);
//                    $maiusculo        = FALSE;
//                } else {
//                    $nomeDoAtributo[] = strtolower($caractere);
//                }
//            }
//        }
//
//        return implode('', $nomeDoAtributo); // Transforma o array com o nome do atributo em uma string única.
    }

    /**
     * Transforma o nome de um atributo no padrão da FSW para o padrão de nome de coluna.
     * 
     * Exemplo: usloId será transformada para uslo_id.
     * 
     * @param string $nomeDoAtributo: nome do atributo a ser transformado para nome de coluna.
     * @return string nome da coluna gerado a partir do nome do atributo.
     */
    public static function trocaAtributoParaNomeColuna($nomeDoAtributo) {
        $letrasMaiusculas = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
            'Y', 'Z');
        $nomeDaColuna = array();

        $nomeDoAtributo = str_split($nomeDoAtributo); // Fatia a string e devolve um array
        foreach ($nomeDoAtributo as $letra) {
            if (in_array($letra, $letrasMaiusculas)) {
                $nomeDaColuna[] = '_';
            }
            $nomeDaColuna[] = strtolower($letra);
        }

        return implode('', $nomeDaColuna); // Transforma o array com o nome da coluna em uma string única.
    }

    /**
     * Retira os caracteres informados da string desejada.
     * @param array $caracteres Array com os caracteres a serem retirados da string.
     * @param type $string String a se retirar caracteres
     * @return type String sem os caracteres indesejados ou nulo se a string 
     *              vier nula também.
     */
    public static function retiraCaracteresDaString(Array $caracteres, $string) {
        if (is_null($string)) {
            return null;
        }

        $arrayString = str_split($string); // Fatia a string e devolve um array
        $novaString = Array();
        foreach ($arrayString as $letra) {
            if (in_array($letra, $caracteres)) {
                // Se o caractere da string é um caractere que se deseja retirar 
                // não faz nada aqui
            } else {
                // Se for um caractere desejado mantém ele
                $novaString[] = $letra;
            }
        }

        return implode('', $novaString); // Transforma o array numa string única.
    }

    /**
     * Transforma número com formato brasileiro para inglês (ponto separador de
     * decimais).
     * 
     * @param type $numeroFormatoBr String com o número no formato brasileiro.
     * @return boolean Número no formato Inglês (ponto para separar as casas ]
     *                 decimais ou FALSO se ocorrer erro.
     */
    public static function transformaNumeroBrasileiroParaIngles($numeroFormatoBr) {
        // Checa se tem maisn do que num ponto no número
        if (substr_count($numeroFormatoBr, ".") > 1) {
            return FALSE;
        }
        // Retira todos os pontos
        $numeroFormatoBr = str_replace(".", "", $numeroFormatoBr);

        // Troca a vírgula por ponto
        $numeroFormatoIn = str_replace(",", ".", $numeroFormatoBr);

        return $numeroFormatoIn;
    }

}

?>

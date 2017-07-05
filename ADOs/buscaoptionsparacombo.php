<?php

require_once '../ADOs/ExercicioADO.class.php';

$gmtDate = gmdate("D, d M Y H:i:s");
header("Expires: {$gmtDate} GMT");
header("Last-Modified: {$gmtDate} GMT");
header("Cache-Contro: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-Type; text/html; charset=utf-8");

function buscaOptions() {

    /*
     * Busca todos os parâmetros que serão enviados para o método de busca.
     * É necessário separá-los do nome do objeto e do método.
     */
    $chave = null; // Deve-se criar a chave que conterá os parâmetros aqui.
    if (count($_REQUEST) == 3) { // Neste caso só um valor será usado para a busca.
        /*
         * A função current($array) busca o conteúdo do vetor na posição atual, que 
         * nesse caso é a primeira. 
         * CUIDADO PARA NÃO USAR ESSA FUNÇÃO ANTES DESTA LINHA.
         */
        $chave = current($_REQUEST);
    } else { // Neste caso mais de um valor será passado para a busca;
        $chave = array(); // Neste caso a chave será um array com todos os parâmetros
        for ($nomeDoParametro = key($_REQUEST); $nomeDoParametro != "objeto"; $nomeDoParametro = key($_REQUEST)) {
            $chave [$nomeDoParametro] = current($_REQUEST);

            next($_REQUEST);
        }
    }


    $chave           = $_REQUEST['idBusca'];
    $nomeDoObjetoAdo = $_REQUEST['objeto'];
    $nomeDoMetodo    = $_REQUEST['metodo'];

    $objetoAdo = new $nomeDoObjetoAdo();

// Recupera um array de objetos. Os objetos têm que conter dois atributos: uma chave e um texto para montar os options.
    $linhasRecuperadas = $objetoAdo->$nomeDoMetodo($chave);
    $arrayDeOpcoes     = array();
    if (is_array($linhasRecuperadas)) {

        //Guardará os objetos no formato: "valor:texto"
        foreach ($linhasRecuperadas as $opcaoObj) { // cada linha do vetor é um objeto.
            $opcaoArray = get_object_vars($opcaoObj); // pega os atributos acessíveis do objeto em formato de array
            $value      = current($opcaoArray); // pega o primeiro atributo.
            next($opcaoArray); // pula para o próximo atributo.
            $text       = current($opcaoArray); // pega o segundo atributo.

            $scOpcoes         = new stdClass();
            $scOpcoes->value  = $value;
            $scOpcoes->text   = $text;
            $arrayDeOpcoes [] = $scOpcoes;
        }
    }
    return $arrayDeOpcoes;
}

echo json_encode(buscaOptions());
?>

<?php

/**
 * Este é um Código da Fábrica de Software
 *
 * Coordenador: Elymar Pereira Cabral
 *
 * Data: 18/05/2012
 *
 * Descrição de AtributosBDAbsract:
 * Classe abstrata para criação das vars do BD.
 *
 * @autor Elymar Pereira Cabral
 */

//EPC - 15/03/2016
//DESATIVEI O CÓDIGO ABAIXO PRA USAR O ARQUIVO bd_mysql.ini.

//EPC - 07/02/2016
//INFELIZMENTE O require_once TEM QUE FICAR COMO ESTÁ PORQUE EU NÃO CONSEGUI 
//DESCOBRIR O MOTIVO DO spl_autoload DA CLASSE DIRETORIOS NÃO CARREGAR O 
//A INTERFACE AtributosBdInterface. NO php.net DIZ QUE O spl_autoload FUCIONA
//TANTO PARA CLASSES ABSTRATAS QUANTO PARA INTERFACES.
//require_once 'atributosbdinterface.class.php';
//Abstract Class AtributosBdAbstract implements AtributosBdInterface {

Abstract Class AtributosBdAbstract {

    protected $host   = "localhost";
    protected $bdNome = NULL;
    private $usuario  = null;
    private $senha    = null;

    function __construct($bdNome) {
        $this->bdNome = $bdNome;

        $nomeDoArquivoIni = $_SERVER['DOCUMENT_ROOT'] . "/FabricaDeSoftware/fsw/Default/bd_mysql.ini";
        if (file_exists($nomeDoArquivoIni)) {
            //Recupera dados do arquivo em formado de array (o arquivo deve estar em formato de arquivo ini).
            $bd = parse_ini_file($nomeDoArquivoIni);
        } else {
            throw new Exception("O arquivo '{$nomeDoArquivoIni}' n&atilde;o foi encontrado!");
        }

        //recupera as informações do arquivo
        $this->host    = isset($bd['host']) ? $bd['host'] : null;
        $this->usuario = isset($bd['usuario']) ? $bd['usuario'] : null;
        $this->senha   = isset($bd['senha']) ? $bd['senha'] : null;
        $this->tipo    = isset($bd['tipo']) ? $bd['tipo'] : null;
    }

    function getHost() {
        return $this->host;
    }

    function setHost($host) {
        $this->host = $host;
    }

    function setBdNome($bdNome) {
        $this->bdNome = $bdNome;
    }

    function getBdNome() {
        return $this->bdNome;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getSenha() {
        return $this->senha;
    }

}

?>

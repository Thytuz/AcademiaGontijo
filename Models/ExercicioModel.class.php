<?php

require_once 'ModelAbstract.class.php';

class ExercicioModel extends ModelAbstract {

    private $exerId;
    private $exerNome;
    private $exerDescricao;
    private $exerTptrId;

    function __construct($exerId = NULL, $exerNome = NULL, $exerDescricao = NULL, $exerTptrId = NULL) {
        $this->exerId = $exerId;
        $this->exerNome = $exerNome;
        $this->exerDescricao = $exerDescricao;
        $this->exerTptrId = $exerTptrId;
    }

    function getExerId() {
        return $this->exerId;
    }

    function getExerNome() {
        return $this->exerNome;
    }

    function getExerDescricao() {
        return $this->exerDescricao;
    }

    function setExerId($exerId) {
        $this->exerId = $exerId;
    }

    function setExerNome($exerNome) {
        $this->exerNome = $exerNome;
    }

    function setExerDescricao($exerDescricao) {
        $this->exerDescricao = $exerDescricao;
    }

    function getExerTptrId() {
        return $this->exerTptrId;
    }

    function setExerTptrId($exerTptrId) {
        $this->exerTptrId = $exerTptrId;
    }

}

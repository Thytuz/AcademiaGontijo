<?php

require_once 'ModelAbstract.class.php';

class ExercicioModel extends ModelAbstract {

    private $exerId;
    private $exerNome;
    private $exerDescricao;
    private $exerTpTrId;

    function __construct($exerId = NULL, $exerNome = NULL, $exerDescricao = NULL, $exerTpTrId = NULL) {
        $this->exerId = $exerId;
        $this->exerNome = $exerNome;
        $this->exerDescricao = $exerDescricao;
        $this->exerTpTrId = $exerTpTrId;
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

    function getExerTpTrId() {
        return $this->exerTpTrId;
    }

    function setExerTpTrId($exerTpTrId) {
        $this->exerTpTrId = $exerTpTrId;
    }

}

<?php

require_once 'ModelAbstract.class.php';

class TiposDeTreinoModel extends ModelAbstract {
    
    private $tptrId;
    private $tptrNome;
    private $tptrDescricao;
    
    function __construct($tptrId = NULL, $tptrNome = NULL, $tptrDescricao = NULL) {
        $this->tptrId = $tptrId;
        $this->tptrNome = $tptrNome;
        $this->tptrDescricao = $tptrDescricao;
    }

    function getTptrId() {
        return $this->tptrId;
    }

    function getTptrNome() {
        return $this->tptrNome;
    }

    function getTptrDescricao() {
        return $this->tptrDescricao;
    }

    function setTptrId($tptrId) {
        $this->tptrId = $tptrId;
    }

    function setTptrNome($tptrNome) {
        $this->tptrNome = $tptrNome;
    }

    function setTptrDescricao($tptrDescricao) {
        $this->tptrDescricao = $tptrDescricao;
    }
    
}


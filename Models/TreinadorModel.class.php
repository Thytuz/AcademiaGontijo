<?php

require_once 'ModelAbstract.class.php';

class TreinadorModel extends ModelAbstract {

    private $treiId;
    private $treiNome;
    private $treiSexo;

    function __construct($treiId = NULL, $treiNome = NULL, $treiSexo = NULL) {
        $this->treiId = $treiId;
        $this->treiNome = $treiNome;
        $this->treiSexo = $treiSexo;
    }

    function getTreiId() {
        return $this->treiId;
    }

    function getTreiNome() {
        return $this->treiNome;
    }

    function getTreiSexo() {
        return $this->treiSexo;
    }

    function setTreiId($treiId) {
        $this->treiId = $treiId;
    }

    function setTreiNome($treiNome) {
        $this->treiNome = $treiNome;
    }

    function setTreiSexo($treiSexo) {
        $this->treiSexo = $treiSexo;
    }

}

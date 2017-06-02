<?php

require_once 'ModelAbstract.class.php';

class TreinamentosModel extends ModelAbstract {
    
    private $tremTreiAtleId;
    private $tremtreiExerId;
    private $tremTreiSequencia;
    private $tremTptrId;
            
    function __construct($tremTreiAtleId, $tremtreiExerId, $tremTreiSequencia, $tremTptrId) {
        $this->tremTreiAtleId = $tremTreiAtleId;
        $this->tremtreiExerId = $tremtreiExerId;
        $this->tremTreiSequencia = $tremTreiSequencia;
        $this->tremTptrId = $tremTptrId;
    }

    function getTremTreiAtleId() {
        return $this->tremTreiAtleId;
    }

    function getTremtreiExerId() {
        return $this->tremtreiExerId;
    }

    function getTremTreiSequencia() {
        return $this->tremTreiSequencia;
    }

    function getTremTptrId() {
        return $this->tremTptrId;
    }

    function setTremTreiAtleId($tremTreiAtleId) {
        $this->tremTreiAtleId = $tremTreiAtleId;
    }

    function setTremtreiExerId($tremtreiExerId) {
        $this->tremtreiExerId = $tremtreiExerId;
    }

    function setTremTreiSequencia($tremTreiSequencia) {
        $this->tremTreiSequencia = $tremTreiSequencia;
    }

    function setTremTptrId($tremTptrId) {
        $this->tremTptrId = $tremTptrId;
    }
    
}

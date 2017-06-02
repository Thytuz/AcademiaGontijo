<?php

require_once 'ModelAbstract.class.php';

class TreinoModel extends ModelAbstract {

    private $treiAtleId;
    private $treiExerId;
    private $treiSequencia;
    private $treiPretencao;
    private $treiRepeticoes;
    private $treiSeries;
    private $treiTempo;

    function __construct($treiAtleId = NULL, $treiExerId = NULL, $treiSequencia = NULL, $treiPretencao = NULL, $treiRepeticoes = NULL, $treiSeries = NULL, $treiTempo = NULL) {
        $this->treiAtleId = $treiAtleId;
        $this->treiExerId = $treiExerId;
        $this->treiSequencia = $treiSequencia;
        $this->treiPretencao = $treiPretencao;
        $this->treiRepeticoes = $treiRepeticoes;
        $this->treiSeries = $treiSeries;
        $this->treiTempo = $treiTempo;
    }

    function getTreiAtleId() {
        return $this->treiAtleId;
    }

    function getTreiExerId() {
        return $this->treiExerId;
    }

    function getTreiSequencia() {
        return $this->treiSequencia;
    }

    function getTreiPretencao() {
        return $this->treiPretencao;
    }

    function getTreiRepeticoes() {
        return $this->treiRepeticoes;
    }

    function getTreiSeries() {
        return $this->treiSeries;
    }

    function getTreiTempo() {
        return $this->treiTempo;
    }

    function setTreiAtleId($treiAtleId) {
        $this->treiAtleId = $treiAtleId;
    }

    function setTreiExerId($treiExerId) {
        $this->treiExerId = $treiExerId;
    }

    function setTreiSequencia($treiSequencia) {
        $this->treiSequencia = $treiSequencia;
    }

    function setTreiPretencao($treiPretencao) {
        $this->treiPretencao = $treiPretencao;
    }

    function setTreiRepeticoes($treiRepeticoes) {
        $this->treiRepeticoes = $treiRepeticoes;
    }

    function setTreiSeries($treiSeries) {
        $this->treiSeries = $treiSeries;
    }

    function setTreiTempo($treiTempo) {
        $this->treiTempo = $treiTempo;
    }

}

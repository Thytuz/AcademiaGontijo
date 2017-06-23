<?php

class TreinamentoModel extends ModelAbstract {

    private $tremTrenId;
    private $tremExerId;
    private $tremTemp;
    private $tremRepeticao;
    private $tremSerie;

    function __construct($tremTrenId = null, $tremExerId = null, $tremTemp = null, $tremRepeticao = null, $tremSerie = null) {
        $this->tremTrenId = $tremTrenId;
        $this->tremExerId = $tremExerId;
        $this->tremTemp = $tremTemp;
        $this->tremRepeticao = $tremRepeticao;
        $this->tremSerie = $tremSerie;
    }

    function getTremTrenId() {
        return $this->tremTrenId;
    }

    function getTremExerId() {
        return $this->tremExerId;
    }

    function getTremTemp() {
        return $this->tremTemp;
    }

    function getTremRepeticao() {
        return $this->tremRepeticao;
    }

    function getTremSerie() {
        return $this->tremSerie;
    }

    function setTremTrenId($tremTrenId) {
        $this->tremTrenId = $tremTrenId;
    }

    function setTremExerId($tremExerId) {
        $this->tremExerId = $tremExerId;
    }

    function setTremTemp($tremTemp) {
        $this->tremTemp = $tremTemp;
    }

    function setTremRepeticao($tremRepeticao) {
        $this->tremRepeticao = $tremRepeticao;
    }

    function setTremSerie($tremSerie) {
        $this->tremSerie = $tremSerie;
    }

}

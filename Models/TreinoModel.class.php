<?php

require_once 'ModelAbstract.class.php';

class TreinoModel extends ModelAbstract {

    private $trenId;
    private $trenAtleId;
    private $trenSeq;
    private $trenTptrId;

    function __construct($trenId = NULL, $trenAtleId = NULL, $trenSeq = NULL, $trenTptrId = NULL) {
        $this->trenId = $trenId;
        $this->trenAtleId = $trenAtleId;
        $this->trenSeq = $trenSeq;
        $this->trenTptrId = $trenTptrId;
    }

    function getTrenId() {
        return $this->trenId;
    }

    function getTrenAtleId() {
        return $this->trenAtleId;
    }

    function getTrenSeq() {
        return $this->trenSeq;
    }

    function getTrenTptrId() {
        return $this->trenTptrId;
    }

    function setTrenId($trenId) {
        $this->trenId = $trenId;
    }

    function setTrenAtleId($trenAtleId) {
        $this->trenAtleId = $trenAtleId;
    }

    function setTrenSeq($trenSeq) {
        $this->trenSeq = $trenSeq;
    }

    function setTrenTptrId($trenTptrId) {
        $this->trenTptrId = $trenTptrId;
    }

}

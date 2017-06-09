<?php

require_once 'ModelAbstract.class.php';

class AtletaModel extends ModelAbstract {

    private $atleId;
    private $atleNome;
    private $atleCpf;
    private $atleDtNasc;
    private $atleSexo;
    private $atlePeso;
    private $atleAltura;
    private $atleObs;
    private $atlePretencao;
    private $atleTreiId;

    function __construct($atleId = null, $atleNome = null, $atleCpf = null, $atleDtNasc = null, $atleSexo = null, $atlePeso = null, $atleAltura = null, $atleObs = null, $atlePretencao = null, $atleTreiId = null) {
        $this->atleId = $atleId;
        $this->atleNome = $atleNome;
        $this->atleCpf = $atleCpf;
        $this->atleDtNasc = $atleDtNasc;
        $this->atleSexo = $atleSexo;
        $this->atlePeso = $atlePeso;
        $this->atleAltura = $atleAltura;
        $this->atleObs = $atleObs;
        $this->atlePretencao = $atlePretencao;
        $this->atleTreiId = $atleTreiId;
    }

    function getAtleId() {
        return $this->atleId;
    }

    function getAtleNome() {
        return $this->atleNome;
    }

    function getAtleCpf() {
        return $this->atleCpf;
    }

    function getAtleDtNasc() {
        return $this->atleDtNasc;
    }

    function getAtleSexo() {
        return $this->atleSexo;
    }

    function getAtlePeso() {
        return $this->atlePeso;
    }

    function getAtleAltura() {
        return $this->atleAltura;
    }

    function getAtleObs() {
        return $this->atleObs;
    }

    function getAtleTreiId() {
        return $this->atleTreiId;
    }

    function setAtleId($atleId) {
        $this->atleId = $atleId;
    }

    function setAtleNome($atleNome) {
        $this->atleNome = $atleNome;
    }

    function setAtleCpf($atleCpf) {
        $this->atleCpf = $atleCpf;
    }

    function setAtleDtNasc($atleDtNasc) {
        $this->atleDtNasc = $atleDtNasc;
    }

    function setAtleSexo($atleSexo) {
        $this->atleSexo = $atleSexo;
    }

    function setAtlePeso($atlePeso) {
        $this->atlePeso = $atlePeso;
    }

    function setAtleAltura($atleAltura) {
        $this->atleAltura = $atleAltura;
    }

    function getAtlePretencao() {
        return $this->atlePretencao;
    }

    function setAtlePretencao($atlePretencao) {
        $this->atlePretencao = $atlePretencao;
    }

    function setAtleObs($atleObs) {
        $this->atleObs = $atleObs;
    }

    function setAtleTreiId($atleTreiId) {
        $this->atleTreiId = $atleTreiId;
    }

}

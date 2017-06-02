<?php

require_once '../Views/TreinoView.class.php';
require_once '../Models/TreinoModel.class.php';
require_once '../ADOs/TreinoADO.class.php';

class TreinoController {

    private $treinoView = null;
    private $treinoModel = null;
    private $treinoAdo = null;
    private $acao = null;

    public function __construct() {
        $this->treinoAdo = new TreinoADO();
        $this->treinoModel = new TreinoModel();
        $this->treinoView = new TreinoView("Cadastro de Treinos");


        switch ($this->acao) {
            case 'inc':
                $this->incluiObjeto();

                break;

            case 'con':
                $this->consultaObjeto();

                break;

            case 'alt':
                $this->alteraObjeto();

                break;

            case 'exc':
                $this->excluiObjeto();

                break;

            default:
                $this->acao = "nov";
                break;
        }

        $this->treinoView->displayInterface($this->treinoModel);
    }

    private function incluiObjeto() {
        
    }

    private function consultaObjeto() {
        
    }

    private function alteraObjeto() {
        
    }

    private function excluiObjeto() {
        
    }

    protected function checaDados($treinoModel) {
        
    }

}

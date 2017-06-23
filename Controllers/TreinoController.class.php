<?php

require_once '../Views/TreinoView.class.php';
require_once '../Models/TreinoModel.class.php';
require_once '../ADOs/TreinoAdo.class.php';
require_once '../ADOs/TreinamentoADO.class.php';
require_once '../Models/TreinamentoModel.class.php';

class TreinoController {

    private $treinoView = null;
    private $treinoModel = null;
    private $treinoAdo = null;
    private $treinamentoModel = null;
    private $treinamentoAdo = null;
    private $acao = null;

    public function __construct() {
        $this->treinoAdo = new TreinoAdo();
        $this->treinoModel = new TreinoModel();
        $this->treinamentoModel = new TreinamentoModel();
        $this->treinamentoAdo = new TreinamentoAdo();
        $this->treinoView = new TreinoView("Cadastro de Treinos");


        $this->acao = $this->treinoView->getAcao();
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
        $stdClass = $this->treinoView->recebeDados();

        $this->treinoModel->setTrenAtleId($stdClass->trenAtleId);
        $this->treinoModel->setTrenSeq($stdClass->trenSeq);
        $this->treinoModel->setTrenTptrId($stdClass->trenTptrId);


        $incluiu = $this->treinoAdo->insereObjeto($this->treinoModel);

        if ($incluiu) {
            $this->treinamentoModel->setTremTrenId($this->treinoAdo->recuperaId());
            $this->treinamentoModel->setTremExerId($stdClass->exerId);
            $this->treinamentoModel->setTremTemp($stdClass->tremTemp);
            $this->treinamentoModel->setTremRepeticao($stdClass->tremRepeticao);
            $this->treinamentoModel->setTremSerie($stdClass->tremSerie);

            $incluiu2 = $this->treinamentoAdo->insereObjeto($this->treinamentoModel);

            if ($incluiu2) {
                $this->treinoView->adicionaEmMensagens("Treino incluído com sucesso!");
            } else {
                $this->treinoView->adicionaEmMensagens("Ocorreu um erro na inclusão!");
            }
        } else {
            $this->treinoView->adicionaEmMensagens("Ocorreu um erro na inclusão!");
        }
    }

    private function consultaObjeto() {
        $treinoModel = $this->treinoView->recebeDadosDaConsulta();

        if ($treinoModel == null) {
            $this->treinoView->adicionaEmMensagens("Selecione um atleta válido!");
            return;
        }

        $buscou = $this->treinoModel = $this->treinoAdo->buscaTreinoPorAtleId($treinoModel->getTrenAtleId());
        if ($buscou) {
            //continua
        } else {
            if ($buscou === 0) {
                $this->treinoView->adicionaEmMensagens("Atleta não possui treino cadastradado");
            } else {
                $this->treinoView->adicionaEmMensagens("Ocorreu um erro na consulta! Contate o analista responsável.");
            }

            $this->treinoModel = new TreinoModel();
            return;
        }
    }

    private function alteraObjeto() {
        
    }

    private function excluiObjeto() {
        
    }

    protected function checaDados($treinoModel) {
        
    }

}

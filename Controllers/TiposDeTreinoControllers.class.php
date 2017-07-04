<?php

require_once '../Views/TiposDeTreinoView.class.php';
require_once '../Models/TipoDeTreinoModel.class.php';
require_once '../ADOs/TipoDeTreinoADO.class.php';

class TiposDeTreinoController {

    private $tiposDeTreinoView = null;
    private $tiposDeTreinoModel = null;
    private $tiposDeTreinoAdo = null;
    private $acao = null;

    public function __construct() {
        $this->tiposDeTreinoAdo = new TiposDeTreinoAdo();
        $this->tiposDeTreinoModel = new TiposDeTreinoModel();
        $this->tiposDeTreinoView = new TiposDeTreinoView("Cadastro de Tipos De Treino");

        $this->acao = $this->tiposDeTreinoView->getAcao();
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

        $this->tiposDeTreinoView->displayInterface($this->tiposDeTreinoModel);
    }

    private function incluiObjeto() {
        $this->tiposDeTreinoModel = $this->tiposDeTreinoView->recebeDados();

        //tratar dados
        //gravar dados
        $incluiu = $this->tiposDeTreinoAdo->insereObjeto($this->tiposDeTreinoModel);

        if ($incluiu) {
            $this->tiposDeTreinoView->adicionaEmMensagens("Incluído com sucesso!");
        } else {
            $this->tiposDeTreinoView->adicionaEmMensagens("Ocorreu um erro na inclusão!");
        }
    }

    private function consultaObjeto() {
        $tiposDeTreinoModel = $this->tiposDeTreinoView->recebeDadosDaConsulta();

        $buscou = $this->tiposDeTreinoModel = $this->tiposDeTreinoAdo->buscaTiposDeTreinoPorTipoDeTreinoId($tiposDeTreinoModel->getTptrId());
        if ($buscou) {
            //continua
        } else {
            if ($buscou === 0) {
                $this->tiposDeTreinoView->adicionaEmMensagens("Não encontrou o tipo de treino selecionado!");
            } else {
                $this->tiposDeTreinoView->adicionaEmMensagens("Ocorreu um erro na consulta! Contate o analista responsável.");
            }

            $this->tiposDeTreinoModel = new TiposDeTreinoModel();
            return;
        }
    }

    private function alteraObjeto() {
        $this->tiposDeTreinoModel = $this->tiposDeTreinoView->recebeDados();

        //tratar dados
        //gravar dados
        $alterou = $this->tiposDeTreinoAdo->alteraObjeto($this->tiposDeTreinoModel);

        if ($alterou) {
            $this->tiposDeTreinoView->adicionaEmMensagens("Alterado com sucesso!");
        } else {
            $this->tiposDeTreinoView->adicionaEmMensagens("Ocorreu um erro na alteração!");
        }
    }

    private function excluiObjeto() {
        $this->tiposDeTreinoModel = $this->tiposDeTreinoView->recebeDados();

        //tratar dados
        //gravar dados
        $excluiu = $this->tiposDeTreinoAdo->excluiObjeto($this->tiposDeTreinoModel);

        if ($excluiu) {
            $this->tiposDeTreinoView->adicionaEmMensagens("Excluido com sucesso!");
        } else {
            $this->tiposDeTreinoView->adicionaEmMensagens("Ocorreu um erro na exclusão!");
        }
    }

}

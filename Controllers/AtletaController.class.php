<?php

require_once '../Views/AtletaView.class.php';
require_once '../Models/AtletaModel.class.php';
require_once '../ADOs/AtletaAdo.class.php';

class AtletaController {

    private $atletaView = null;
    private $atletaModel = null;
    private $atletaAdo = null;
    private $acao = null;

    public function __construct() {
        $this->atletaAdo = new AtletaAdo();
        $this->atletaModel = new AtletaModel();
        $this->atletaView = new AtletaView("Cadastro de Atletas");

        $this->acao = $this->atletaView->getAcao();
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
                break;
        }

        $this->atletaView->displayInterface($this->atletaModel);
    }

    private function incluiObjeto() {
        $this->atletaModel = $this->atletaView->recebeDados();

        //tratar dados
        //gravar dados
        $incluiu = $this->atletaAdo->insereObjeto($this->atletaModel);

        if ($incluiu) {
            $this->atletaView->adicionaEmMensagens("Incluído com sucesso!");
        } else {
            $this->atletaView->adicionaEmMensagens("Ocorreu um erro na inclusão!");
        }
    }

    private function consultaObjeto() {
        $atletaModel = $this->atletaView->recebeDadosDaConsulta();
        if ($atletaModel == null) {
            $this->atletaView->adicionaEmMensagens("Selecione um atleta válido!");
            return;
        }

        $buscou = $this->atletaModel = $this->atletaAdo->buscaAtleta($atletaModel->getAtleId());
        if ($buscou) {
            //continua
        } else {
            if ($buscou === 0) {
                $this->atletaView->adicionaEmMensagens("Não encontrou o atleta selecionado!");
            } else {
                $this->atletaView->adicionaEmMensagens("Ocorreu um erro na consulta! Contate o analista responsável.");
            }

            $this->atletaModel = new AtletaModel();
            return;
        }
    }

    private function alteraObjeto() {
        $this->atletaModel = $this->atletaView->recebeDados();

        //tratar dados
        //gravar dados
        $alterou = $this->atletaAdo->alteraObjeto($this->atletaModel);

        if ($alterou) {
            $this->atletaView->adicionaEmMensagens("Alterado com sucesso!");
        } else {
            $this->atletaView->adicionaEmMensagens("Ocorreu um erro na alteração!");
        }
    }

    private function excluiObjeto() {
        $this->atletaModel = $this->atletaView->recebeDados();

        //tratar dados
        //gravar dados
        $excluiu = $this->atletaAdo->excluiObjeto($this->atletaModel);

        if ($excluiu) {
            $this->atletaView->adicionaEmMensagens("Excluido com sucesso!");
        } else {
            $this->atletaView->adicionaEmMensagens("Ocorreu um erro na exclusão!");
        }
    }

}

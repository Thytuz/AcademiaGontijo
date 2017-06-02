<?php

require_once '../Views/TreinadorView.class.php';
require_once '../Models/TreinadorModel.class.php';
require_once '../ADOs/TreinadorAdo.class.php';
require_once '../ADOs/AtletaAdo.class.php';
require_once '../Models/AtletaModel.class.php';

class TreinadorController {

    private $treinadorView = null;
    private $treinadorModel = null;
    private $treinadorAdo = null;
    private $acao = null;

    public function __construct() {
        $this->treinadorAdo = new TreinadorAdo();
        $this->treinadorModel = new TreinadorModel();
        $this->treinadorView = new TreinadorView("Cadastro de Treinadores");

        $this->acao = $this->treinadorView->getAcao();
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

        $this->treinadorView->displayInterface($this->treinadorModel);
    }

    private function incluiObjeto() {
        $this->treinadorModel = $this->treinadorView->recebeDados();

        //tratar dados
        //gravar dados
        $incluiu = $this->treinadorAdo->insereObjeto($this->treinadorModel);

        if ($incluiu) {
            $this->treinadorView->adicionaEmMensagens("Incluído com sucesso!");
        } else {
            $this->treinadorView->adicionaEmMensagens("Ocorreu um erro na inclusão!");
        }
    }

    private function consultaObjeto() {
        $treinadorModel = $this->treinadorView->recebeDadosDaConsulta();

        if ($treinadorModel == null) {
            $this->treinadorView->adicionaEmMensagens("Selecione um treinador válido!");
            return;
        }

        $buscou = $this->treinadorModel = $this->treinadorAdo->buscaTreinador($treinadorModel->getTreiId());
        if ($buscou) {
            //continua
        } else {
            if ($buscou === 0) {
                $this->treinadorView->adicionaEmMensagens("Não encontrou o treinador selecionado!");
            } else {
                $this->treinadorView->adicionaEmMensagens("Ocorreu um erro na consulta! Contate o analista responsável.");
            }

            $this->treinadorModel = new TreinadorModel();
            return;
        }
    }

    private function alteraObjeto() {
        $this->treinadorModel = $this->treinadorView->recebeDados();

        //tratar dados
        //gravar dados
        $alterou = $this->treinadorAdo->alteraObjeto($this->treinadorModel);

        if ($alterou) {
            $this->treinadorView->adicionaEmMensagens("Alterado com sucesso!");
        } else {
            $this->treinadorView->adicionaEmMensagens("Ocorreu um erro na alteração!");
        }
    }

    private function excluiObjeto() {
        $this->treinadorModel = $this->treinadorView->recebeDados();


        if ($this->checaDados($this->treinadorModel)) {
            //ok
            $excluiu = $this->treinadorAdo->excluiObjeto($this->treinadorModel);

            if ($excluiu) {
                $this->treinadorView->adicionaEmMensagens("Excluido com sucesso!");
            } else {
                $this->treinadorView->adicionaEmMensagens("Ocorreu um erro na exclusão!");
            }
        } else {
            $this->treinadorView->adicionaEmMensagens("Não se pode excluir treinadores relacionados a atletas!");
        }
    }

    protected function checaDados($treinadorModel) {
        $atletaAdo = new AtletaAdo();

        $dadosOk = true;

        $atletas = $atletaAdo->buscaAtletasDoTreinador($treinadorModel->getTreiId());

        if ($atletas) {
            $dadosOk = false;
        } else {
            //não achou, ok
        }

        return $dadosOk;
    }

}

?>
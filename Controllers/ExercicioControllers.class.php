<?php

require_once '../Views/ExercicioView.class.php';
require_once '../Models/ExercicioModel.class.php';
require_once '../ADOs/ExercicioADO.class.php';

class ExercicioController {

    private $exercicioView = null;
    private $exercicioModel = null;
    private $exercicioAdo = null;
    private $acao = null;

    public function __construct() {
        $this->exercicioAdo = new ExercicioAdo();
        $this->exercicioModel = new ExercicioModel();
        $this->exercicioView = new ExercicioView("Cadastro de Exercicio");

        $this->acao = $this->exercicioView->getAcao();
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

        $this->exercicioView->displayInterface($this->exercicioModel);
    }

    private function incluiObjeto() {
        $this->exercicioModel = $this->exercicioView->recebeDados();

        //tratar dados
        //gravar dados
        $incluiu = $this->exercicioAdo->insereObjeto($this->exercicioModel);
        var_dump($this->exercicioModel);
        if ($incluiu) {
            $this->exercicioView->adicionaEmMensagens("Incluído com sucesso!");
        } else {
            $this->exercicioView->adicionaEmMensagens("Ocorreu um erro na inclusão!");
        }
    }

    private function consultaObjeto() {
        $exercicioModel = $this->exercicioView->recebeDadosDaConsulta();

        $buscou = $this->exercicioModel = $this->exercicioAdo->buscaExercicio($exercicioModel->getExerId());
        if ($buscou) {
            //continua
        } else {
            if ($buscou === 0) {
                $this->exercicioView->adicionaEmMensagens("Não encontrou o Exercicio selecionado!");
            } else {
                $this->exercicioView->adicionaEmMensagens("Ocorreu um erro na consulta! Contate o analista responsável.");
            }

            $this->exercicioModel = new ExercicioModel();
            return;
        }
    }

    private function alteraObjeto() {
        $this->exercicioModel = $this->exercicioView->recebeDados();

        //tratar dados
        //gravar dados
        $alterou = $this->exercicioAdo->alteraObjeto($this->exercicioModel);

        if ($alterou) {
            $this->exercicioView->adicionaEmMensagens("Alterado com sucesso!");
        } else {
            $this->exercicioView->adicionaEmMensagens("Ocorreu um erro na alteração!");
        }
    }

    private function excluiObjeto() {
        $this->exercicioModel = $this->exercicioView->recebeDados();

        //tratar dados
        //gravar dados
        $excluiu = $this->exercicioAdo->excluiObjeto($this->exercicioModel);

        if ($excluiu) {
            $this->exercicioView->adicionaEmMensagens("Excluido com sucesso!");
        } else {
            $this->exercicioView->adicionaEmMensagens("Ocorreu um erro na exclusão!");
        }
    }

}

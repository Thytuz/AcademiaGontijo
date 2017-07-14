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
            case 'exc':
                $this->excluiObjeto();

                break;

            case 'inc':
                $this->incluiObjeto();

                break;
            case 'con':
                $this->consultaObjeto();

                break;

            case 'alt':
                $this->alteraObjeto();

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

        $this->treinamentoModel->setTremExerId($stdClass->exerId);
        $this->treinamentoModel->setTremRepeticao($stdClass->tremRepeticao);
        $this->treinamentoModel->setTremSerie($stdClass->tremSerie);
        $this->treinamentoModel->setTremTemp($stdClass->tremTempo);
        $this->treinamentoModel->setTremRepeticao($stdClass->tremRepeticao);

        $idTreinoOuFalso = $this->checaEntradaDuplicada($this->treinoModel);
        if ($idTreinoOuFalso != false) {
            $this->treinamentoModel->setTremTrenId($idTreinoOuFalso);

            if ($this->treinamentoAdo->insereObjeto($this->treinamentoModel)) {
                $this->treinoView->adicionaEmMensagens("Treino incluído com sucesso!");
                $this->acao = 'con';
            } else {
                $this->treinoView->adicionaEmMensagens("Este treinamento já consta na sequencia do atleta!");
            }
        } else {

            $this->treinoAdo->iniciaTransacao();
            if ($this->criaTreino()) {
                $this->treinamentoModel->setTremTrenId($this->treinoAdo->recuperaIdEmTransacoesMultiobjetos("Treinos"));

                if ($this->criaTreinamento()) {
                    $this->treinoAdo->validaTransacao();
                    $this->treinoView->adicionaEmMensagens("Treino incluído com sucesso!");
                    $this->acao = 'con';
                } else {
                    $this->treinoAdo->descartaTransacao();
                }
            } else {
                $this->treinoAdo->descartaTransacao();
                $this->treinoView->adicionaEmMensagens("Ocorreu um erro na inclusão!");
            }
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
        $treinamentoModel = $this->treinoView->recebeDadosExclusao();
        if ($this->treinamentoAdo->excluiObjeto($treinamentoModel)) {
            if ($this->checaSeTodoOTreinamentoDoTreinoFoiExcluidoEExcluiTreino($treinamentoModel)) {
                $this->treinoView->adicionaEmMensagens("Treinamento excluido com sucesso!");
            } else {
                $this->treinoView->adicionaEmMensagens("Exercício do treinamento excluido com sucesso!");
            }
        } else {
            $this->treinoView->adicionaEmMensagens("Erro ao excluir Exercício. Contate o analista");
        }
        $this->acao = 'con';
    }

    protected function checaDados($treinoModel) {
        
    }

    public function checaEntradaDuplicada($treinoModel) {
        $arrayDeTreinos = $this->treinoAdo->buscaArrayObjetoComPs(array(), 1);
        if ($arrayDeTreinos == 0) {
            return false;
        }
        foreach ($arrayDeTreinos as $treino) {
            if ($treino->getTrenAtleId() == $treinoModel->getTrenAtleId()) {
                if ($treino->getTrenSeq() == $treinoModel->getTrenSeq()) {
                    if ($treino->getTrenTptrId() == $treinoModel->getTrenTptrId()) {
                        return $treino->getTrenId();
                    }
                }
            }
        }
        return false;
    }

    public function criaTreino() {
        $queryComParametros = $this->treinoAdo->montaQueryParametrizadaParaInserirTreino($this->treinoModel);
        $query = $queryComParametros[0];
        $arrayDeValores = $queryComParametros[1];

        try {
            $executou = $this->treinoAdo->executaPsEmTransacoesMultiobjetos($query, $arrayDeValores);
        } catch (PDOException $e) {
            return false;
        }
        return $executou;
    }

    public function criaTreinamento() {
        $queryComParametros = $this->treinamentoAdo->montaQueryParametrizadaParaInserirTreinamento($this->treinamentoModel);
        $query = $queryComParametros[0];
        $arrayDeValores = $queryComParametros[1];

        try {
            $executou = $this->treinoAdo->executaPsEmTransacoesMultiobjetos($query, $arrayDeValores);
        } catch (PDOException $e) {
            return false;
        }
        return $executou;
    }

    public function checaSeTodoOTreinamentoDoTreinoFoiExcluidoEExcluiTreino($treinamentoModel) {
        $arrayDeTreinamento = $this->treinamentoAdo->buscaArrayObjetoComPs(array($treinamentoModel->getTremTrenId()), "where trem_tren_id = ?");
        if ($arrayDeTreinamento == 0) {
            if ($this->treinoAdo->excluiObjeto(new TreinoModel($treinamentoModel->getTremTrenId()))) {
                return true;
            } else {
                return false;
            }
        }
    }

}

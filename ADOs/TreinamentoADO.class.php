<?php

require_once '../Classes/atributosbdacademia.class.php';

class TreinamentoAdo extends AdoPdoAbstract {

    public function __construct() {
        parent::__construct(new AtributosBdAcademia);
        parent::setNomeDaTabela("Treinamentos");
    }

    public function alteraObjeto(\ModelAbstract $objetoModel) {
        
    }

    public function excluiObjeto(\ModelAbstract $treinamentoModel) {
        $where = 'trem_tren_id = ' . (int) $treinamentoModel->getTremTrenId() . ' and trem_exer_id = ' . (int) $treinamentoModel->getTremExerId();

        $query = parent::montaDeleteDoObjeto(parent::getNomeDaTabela(), $where);

        if ($this->executaPs($query, array())) {
            $this->setMensagem("Treinamento foi exclu&iacute;da com sucesso!");
            return true;
        } else {
            $this->setMensagem("Treinamento n&atilde;o foi exclu&iacute;da. Erro no BD. Contate o analista.");
            return false;
        }
    }

    public function insereObjeto(\ModelAbstract $treinamentoModel) {
        $colunasValores = parent::montaArrayDeDadosDaTabela($treinamentoModel);
        $query = parent::montaInsertDoObjetoPS(parent::getNomeDaTabela(), $colunasValores);

        return parent::executaPs($query, $colunasValores);
    }

    public function montaQueryParametrizadaParaInserirTreinamento(\ModelAbstract $treinamentoModel) {
        $arrayDeColunasEValores = array(
            "trem_tren_id" => $treinamentoModel->getTremTrenId(),
            "trem_exer_id" => $treinamentoModel->getTremExerId(),
            "trem_temp" => $treinamentoModel->getTremTemp(),
            "trem_repeticao" => $treinamentoModel->getTremRepeticao(),
            "trem_serie" => $treinamentoModel->getTremSerie()
        );
        $query = parent::montaInsertDoObjetoPS(parent::getNomeDaTabela(), $arrayDeColunasEValores);

        return Array($query, $arrayDeColunasEValores);
    }

    public function buscaTreinamentosQuePossuemExercicioId($exerId) {
        $where = " trem_exer_id = ? ";
        return parent::buscaArrayObjetoComPs(array($exerId), $where);
    }

}

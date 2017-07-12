<?php

require_once 'adopdoabstract.class.php';
require_once '../Classes/atributosbdacademia.class.php';

class TreinoAdo extends AdoPdoAbstract {

    public function __construct() {
        parent::__construct(new AtributosBdAcademia);
        parent::setNomeDaTabela("Treinos");
    }

    public function alteraObjeto(\ModelAbstract $objetoModel) {
        
    }

    public function excluiObjeto(\ModelAbstract $treinoModel) {
        $where = 'tren_id = ' . (int) $treinoModel->getTrenId();

        $query = parent::montaDeleteDoObjeto(parent::getNomeDaTabela(), $where);

        if ($this->executaPs($query, array())) {
            $this->setMensagem("Treino foi exclu&iacute;da com sucesso!");
            return true;
        } else {
            $this->setMensagem("Treino n&atilde;o foi exclu&iacute;da. Erro no BD. Contate o analista.");
            return false;
        }
    }

    public function insereObjeto(\ModelAbstract $treinoModel) {
        $colunasValores = parent::montaArrayDeDadosDaTabela($treinoModel);
        $query = parent::montaInsertDoObjetoPS(parent::getNomeDaTabela(), $colunasValores);
        return parent::executaPs($query, $colunasValores);
    }

    public function buscaTreinoPorAtleId($trenAtleId) {
        $where = " tren_atle_id = ? ";
        return parent::buscaArrayObjetoComPs(array($trenAtleId), $where);
    }

    public function montaQueryParametrizadaParaInserirTreino(\ModelAbstract $treinoModel) {
        $arrayDeColunasEValores = array(
            "tren_atle_id" => $treinoModel->getTrenAtleId(),
            "tren_seq" => $treinoModel->getTrenSeq(),
            "tren_tptr_id" => $treinoModel->getTrenTptrId()
        );
        $query = parent::montaInsertDoObjetoPS(parent::getNomeDaTabela(), $arrayDeColunasEValores);

        return Array($query, $arrayDeColunasEValores);
    }

}

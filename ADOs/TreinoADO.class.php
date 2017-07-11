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

    public function excluiObjeto(\ModelAbstract $objetoModel) {
        
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

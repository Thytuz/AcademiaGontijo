<?php

require_once 'adopdoabstract.class.php';

class TreinamentosAdo extends AdoPdoAbstract {

    public function __construct() {
        parent::__construct();
        parent::setNomeDaTabela("Treinamentos");
    }

    public function insereObjeto(ModelAbstract $treinamentosModel) {
        $colunasValores = parent::montaArrayDeDadosDaTabela($treinamentosModel);
        $query = parent::montaInsertDoObjetoPS(parent::getNomeDaTabela(), $colunasValores);
        
        return parent::executaPs($query, $colunasValores);
    }

    public function alteraObjeto(\ModelAbstract $objetoModel) {
        
    }

    public function excluiObjeto(\ModelAbstract $objetoModel) {
        
    }

}


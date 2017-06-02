<?php

class TreinoADO extends AdoPdoAbstract {

    public function __construct() {
        parent::__construct();
        parent::setNomeDaTabela("Treinos");
    }

    public function alteraObjeto(\ModelAbstract $objetoModel) {
        
    }

    public function excluiObjeto(\ModelAbstract $objetoModel) {
        
    }

    public function insereObjeto(\ModelAbstract $objetoModel) {
        
    }

}

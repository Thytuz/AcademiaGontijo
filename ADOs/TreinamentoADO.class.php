<?php

class TreinamentoAdo extends AdoPdoAbstract {
    
    public function __construct() {
        parent::__construct();
        parent::setNomeDaTabela("Treinamentos");
    }

    public function alteraObjeto(\ModelAbstract $objetoModel) {
        
    }

    public function excluiObjeto(\ModelAbstract $objetoModel) {
        
    }

    public function insereObjeto(\ModelAbstract $objetoModel) {
        
    }

}
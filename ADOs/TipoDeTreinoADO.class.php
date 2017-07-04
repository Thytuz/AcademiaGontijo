<?php

require_once 'adopdoabstract.class.php';

class TiposDeTreinoAdo extends AdoPdoAbstract {

    public function __construct() {
        parent::__construct();
        parent::setNomeDaTabela("TiposDeTreinos");
    }

    public function insereObjeto(ModelAbstract $tiposDeTreinoModel) {
        $colunasValores = parent::montaArrayDeDadosDaTabela($tiposDeTreinoModel);
        $query = parent::montaInsertDoObjetoPS(parent::getNomeDaTabela(), $colunasValores);

        return parent::executaPs($query, $colunasValores);
    }

    public function alteraObjeto(ModelAbstract $tiposDeTreinoModel) {
        $colunasValores = parent::montaArrayDeDadosDaTabela($tiposDeTreinoModel);
        $where = " tptr_id = ? ";
        $query = parent::montaUpdateDoObjetoPS(parent::getNomeDaTabela(), $colunasValores, $where);

        //Acrescento mais uma posição no array para o ? do where. Tem que ser 
        //depois do montaUpdate pq ele não pode ser incluido na instrução update.
        $colunasValores ['tptr_id_where'] = $tiposDeTreinoModel->getTptrId();

        return parent::executaPs($query, $colunasValores);
    }

    public function excluiObjeto(ModelAbstract $tiposDeTreinoModel) {
        $where = " tptr_id = ? ";
        $query = parent::montaDeleteDoObjeto(parent::getNomeDaTabela(), $where);

        return parent::executaPs($query, array($tiposDeTreinoModel->getTptrId()));
    }

    public function buscaTiposDeTreinoPorTipoDeTreinoId($tptrId) {
        $where = " tptr_id = ? ";
        return parent::buscaObjetoComPs(array($tptrId), $where);
    }

    public function buscaNomes($q) {
        $query = "SELECT tptr_nome FROM tiposdetreinos WHERE tptr_nome LIKE '%{$q}%'";

        $consultou = parent::executaPs($query, array());
        if ($consultou) {
            //continua... 
        } else {
            if (parent::qtdeLinhas() === 0) {
                return 0;
            }
            return FALSE;
        }

        $nomes = array();

        while ($tupla = parent::leTabelaBD()) {
            $nomes [] = $tupla ['tptr_nome'];
        }

        return $nomes;
    }

}

<?php

require_once 'adopdoabstract.class.php';

class TreinadorAdo extends AdoPdoAbstract {

    public function __construct() {
        parent::__construct();
        parent::setNomeDaTabela("Treinadores");
    }

    public function insereObjeto(ModelAbstract $treinadorModel) {
        $colunasValores = parent::montaArrayDeDadosDaTabela($treinadorModel);
        $query = parent::montaInsertDoObjetoPS(parent::getNomeDaTabela(), $colunasValores);

        return parent::executaPs($query, $colunasValores);
    }

    public function alteraObjeto(ModelAbstract $treinadorModel) {
        $colunasValores = parent::montaArrayDeDadosDaTabela($treinadorModel);
        $where = " trei_id = ? ";
        $query = parent::montaUpdateDoObjetoPS(parent::getNomeDaTabela(), $colunasValores, $where);

        //Acrescento mais uma posição no array para o ? do where. Tem que ser 
        //depois do montaUpdate pq ele não pode ser incluido na instrução update.
        $colunasValores ['trei_id_where'] = $treinadorModel->getTreiId();

        return parent::executaPs($query, $colunasValores);
    }

    public function excluiObjeto(ModelAbstract $treinadorModel) {
        $where = " trei_id = ? ";
        $query = parent::montaDeleteDoObjeto(parent::getNomeDaTabela(), $where);

        return parent::executaPs($query, array($treinadorModel->getTreiId()));
    }

    public function buscaTreinador($treiId) {
        $where = " trei_id = ? ";
        return parent::buscaObjetoComPs(array($treiId), $where);
    }

    public function buscaNomes($q) {
        $query = "SELECT trei_nome FROM Treinadores WHERE trei_nome LIKE '%{$q}%'";

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
            $nomes [] = $tupla ['trei_nome'];
        }

        return $nomes;
    }

}

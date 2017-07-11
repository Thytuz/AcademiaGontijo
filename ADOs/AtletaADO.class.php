<?php

require_once 'adopdoabstract.class.php';
require_once '../Classes/atributosbdacademia.class.php';

class AtletaAdo extends AdoPdoAbstract {

    public function __construct() {
        parent::__construct(new AtributosBdAcademia);
        parent::setNomeDaTabela("Atletas");
    }

    public function insereObjeto(ModelAbstract $atletaModel) {
        $colunasValores = parent::montaArrayDeDadosDaTabela($atletaModel);
        $query = parent::montaInsertDoObjetoPS(parent::getNomeDaTabela(), $colunasValores);

        return parent::executaPs($query, $colunasValores);
    }

    public function alteraObjeto(ModelAbstract $atletaModel) {
        $colunasValores = parent::montaArrayDeDadosDaTabela($atletaModel);
        $where = " atle_id = ? ";
        $query = parent::montaUpdateDoObjetoPS(parent::getNomeDaTabela(), $colunasValores, $where);

        //Acrescento mais uma posição no array para o ? do where. Tem que ser 
        //depois do montaUpdate pq ele não pode ser incluido na instrução update.
        $colunasValores ['atle_id_where'] = $atletaModel->getAtleId();

        return parent::executaPs($query, $colunasValores);
    }

    public function excluiObjeto(ModelAbstract $atletaModel) {
        $where = " atle_id = ? ";
        $query = parent::montaDeleteDoObjeto(parent::getNomeDaTabela(), $where);

        return parent::executaPs($query, array($atletaModel->getAtleId()));
    }

    public function buscaAtleta($atleId) {
        $where = " atle_id = ? ";
        return parent::buscaObjetoComPs(array($atleId), $where);
    }

    public function buscaNomes($q) {
        $query = "SELECT atle_nome FROM Atletas WHERE atle_nome LIKE '%{$q}%'";

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
            $nomes [] = $tupla ['atle_nome'];
        }

        return $nomes;
    }

    public function buscaAtletasDoTreinador($treiId) {
        $where = " atle_trei_id = ? ";
        return parent::buscaObjetoComPs(array($treiId), $where);
    }

}

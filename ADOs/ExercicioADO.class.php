<?php

require_once 'adopdoabstract.class.php';

class ExercicioAdo extends AdoPdoAbstract {

    public function __construct() {
        parent::__construct();
        parent::setNomeDaTabela("Exercicios");
    }

    public function insereObjeto(ModelAbstract $exercicioModel) {
        $colunasValores = parent::montaArrayDeDadosDaTabela($exercicioModel);
        $query = parent::montaInsertDoObjetoPS(parent::getNomeDaTabela(), $colunasValores);
        
        return parent::executaPs($query, $colunasValores);
    }

    public function alteraObjeto(ModelAbstract $exercicioModel) {
        $colunasValores = parent::montaArrayDeDadosDaTabela($exercicioModel);
        $where = " exer_id = ? ";
        $query = parent::montaUpdateDoObjetoPS(parent::getNomeDaTabela(), $colunasValores, $where);

        //Acrescento mais uma posição no array para o ? do where. Tem que ser 
        //depois do montaUpdate pq ele não pode ser incluido na instrução update.
        $colunasValores ['exer_id_where'] = $exercicioModel->getExerId();

        return parent::executaPs($query, $colunasValores);
    }

    public function excluiObjeto(ModelAbstract $exercicioModel) {
        $where = " exer_id = ? ";
        $query = parent::montaDeleteDoObjeto(parent::getNomeDaTabela(), $where);

        return parent::executaPs($query, array($exercicioModel->getExerId()));
    }

    public function buscaExercicio($exerId) {
        $where = " exer_id = ? ";
        return parent::buscaObjetoComPs(array($exerId), $where);
    }

    public function buscaNomes($q) {
        $query = "SELECT exer_nome FROM exercicios WHERE exer_nome LIKE '%{$q}%'";

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
            $nomes [] = $tupla ['exer_nome'];
        }

        return $nomes;
    }
}

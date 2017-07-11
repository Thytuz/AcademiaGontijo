<?php

require_once 'atributosbdabstract.class.php';

class AtributosBdAcademia extends AtributosBdAbstract {

    //Usa-se FSW.ARTE pra o bd por padão pq FSW não possui bd próprio.
    function __construct($bdNome = "academia_gontijo") {
        parent::__construct($bdNome);
    }

}

?>

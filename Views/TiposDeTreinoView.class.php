<?php

require_once 'InterfaceWeb.class.php';
require_once '../ADOs/TipoDeTreinoADO.class.php';
require_once '../Models/TipoDeTreinoModel.class.php';
require_once '../Views/MenusView.class.php';

class TiposDeTreinoView extends InterfaceWeb {

    private function montaOptionsDaConsultaDeTiposDeTreino() {
        $tiposDeTreinoAdo = new TiposDeTreinoAdo();
        $buscou = $tiposDeTreinosModel = $tiposDeTreinoAdo->buscaArrayObjetoComPs(array(), 1, "order by tptr_nome");
        if ($buscou) {
            //continua
        } else {
            if ($buscou === 0) {
                parent::adicionaEmMensagens("Não encontrou nenhum tipo de treino!");
            } else {
                parent::adicionaEmMensagens("Erro ao buscar tipo de treino! Contate o analista responsável pelo sistema.");
            }
            $tiposDeTreinosModel = array();
        }

        $optionsDosTiposDeTreino = null;
        $optionsDosTiposDeTreino .= "\n\t\t\t<option value='-1'>Escolha um tipo de treino </option>";
        
        foreach ($tiposDeTreinosModel as $tiposDetreinoModel) {
            $optionsDosTiposDeTreino .= "\n\t\t\t<option value='{$tiposDetreinoModel->getTptrId()}'>{$tiposDetreinoModel->getTptrNome()}</option>";
        }

        return $optionsDosTiposDeTreino;
    }

    protected function montaFieldsetConsulta() {
        $optionsDosTiposDeTreino = $this->montaOptionsDaConsultaDeTiposDeTreino();

        $fieldset = "<fieldset><legend>Consulta</legend>";

        $fieldset .= "
            <div class='formulario'>
                <form id='form' action='' method='POST'>
                        <label>Tipos De Treinos</label>
                            <select id ='tptrId' name='tptrId'>
                                {$optionsDosTiposDeTreino}
                            </select>
                        <br>
                        <p><button name='acao' type='submit' value='con'>Consultar</button></p>
                </form> 
            </div>";

        $fieldset .= "\n</fieldset>";

        return $fieldset;
    }

    protected function montaCorpo($tiposDeTreinoModel) {
        $titulo = "<h3>Cadastro de Tipo de Treinos</h3>";
        
        parent::adicionaAoCorpo($titulo);

        $fieldsetConsulta = $this->montaFieldsetConsulta();
        parent::adicionaAoCorpo($fieldsetConsulta);

        $fieldsetDados = $this->montaFieldsetDados($tiposDeTreinoModel);
        parent::adicionaAoCorpo($fieldsetDados);
    }

    protected function montaFieldsetDados($tiposDeTreinoModel) {
        $btnDisabled = null;
        if ($tiposDeTreinoModel->getTptrId() == null) {
            $btnDisabled = "disabled";
        }

        $fieldset = "<fieldset><legend>Tipo De Treinos</legend>";

        $fieldset .= "
            <div class='formulario'>
                <form id='form' action='' method='POST'>
                    <input type='hidden' name='tptrId' value='{$tiposDeTreinoModel->getTpTrId()}'>
                    <label>Nome</label><input type='text' id ='nome' name='tptrNome' value='{$tiposDeTreinoModel->getTpTrNome()}'><br>
                    <label>Descrição</label><textarea rows='4' cols='50' id ='nome' name='tptrDescricao'>{$tiposDeTreinoModel->getTpTrDescricao()}</textarea><br>   
                    <p>
                        <button name='acao' type='submit' value='inc'>Incluir</button>
                        <button name='acao' type='submit' value='alt' {$btnDisabled}>Alterar</button>
                        <button name='acao' type='submit' value='exc' {$btnDisabled}>Excluir</button>
                        <button name='acao' type='submit' value='nov' {$btnDisabled}>Novo</button>
                    </p>
                </form> 
            </div>";

        $fieldset .= "\n</fieldset>";

        return $fieldset;
    }

    public function recebeDadosDaConsulta() {
        $tiposDeTreinoModel = new TiposDeTreinoModel();

        $tiposDeTreinoModel->setTpTrId($_POST['tptrId']);

        return $tiposDeTreinoModel;
    }

    public function recebeDados() {
        $tiposDeTreinoModel = new TiposDeTreinoModel();

        $tiposDeTreinoModel->setTptrId($_POST['tptrId']);
        $tiposDeTreinoModel->setTptrNome($_POST['tptrNome']);
        $tiposDeTreinoModel->setTptrDescricao($_POST['tptrDescricao']);

        return $tiposDeTreinoModel;
    }

}

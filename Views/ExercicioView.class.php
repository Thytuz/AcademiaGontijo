<?php

require_once 'InterfaceWeb.class.php';
require_once '../ADOs/ExercicioADO.class.php';
require_once '../Models/ExercicioModel.class.php';
require_once '../Views/MenusView.class.php';
require_once '../Views/TiposDeTreinoView.class.php';

class ExercicioView extends InterfaceWeb {

    private function montaOptionsDaConsultaDeExercicio() {
        $exercicioAdo = new ExercicioAdo();
        $buscou = $exercicioModel = $exercicioAdo->buscaArrayObjetoComPs(array(), 1, "order by exer_nome");
        if ($buscou) {
            //continua
        } else {
            if ($buscou === 0) {
                parent::adicionaEmMensagens("Não encontrou nenhum tipo de exercicio!");
            } else {
                parent::adicionaEmMensagens("Erro ao buscar exercicio! Contate o analista responsável pelo sistema.");
            }
            $exercicioModel = array();
        }

        $optionsDosExercicios = null;
        $optionsDosExercicios .= "\n\t\t\t<option value='-1'>Escolha um exercício </option>";
        foreach ($exercicioModel as $exercicioModel) {
            $optionsDosExercicios .= "\n\t\t\t<option value='{$exercicioModel->getExerId()}'>{$exercicioModel->getExerNome()}</option>";
        }

        return $optionsDosExercicios;
    }

    private function montaOptionsDaConsultaDeTiposDeTreino($exercicioModel) {
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

        $selected = null;
        $optionsDosTiposDeTreino = null;
        $optionsDosTiposDeTreino .= "\n\t\t\t<option value='-1'>Escolha um tipo de treino </option>";
        foreach ($tiposDeTreinosModel as $tiposDetreinoModel) {
            if ($tiposDetreinoModel->getTptrId() == $exercicioModel->getExerTptrId()) {
                $selected = "selected";
            }
            $optionsDosTiposDeTreino .= "\n\t\t\t<option value='{$tiposDetreinoModel->getTptrId()}' $selected>{$tiposDetreinoModel->getTptrNome()}</option>";

            $selected = null;
        }

        return $optionsDosTiposDeTreino;
    }

    protected function montaFieldsetConsulta() {
        $optionsDosExercicios = $this->montaOptionsDaConsultaDeExercicio();

        $fieldset = "<fieldset><legend>Consulta</legend>";

        $fieldset .= "
            <div class='formulario'>
                <form id='form' action='' method='POST'>
                        <label>Exercicio</label>
                            <select id ='exerId' name='exerId'>
                                {$optionsDosExercicios}
                            </select>
                        <br>
                        <p><button name='acao' type='submit' value='con'>Consultar</button></p>
                </form>         
                
            </div>";

        $fieldset .= "\n</fieldset>";

        return $fieldset;
    }

    protected function montaCorpo($exercicioModel) {
        $titulo = "<h3>Cadastro de Exercicios</h3>";
        
        parent::adicionaAoCorpo($titulo);

        $fieldsetConsulta = $this->montaFieldsetConsulta();
        parent::adicionaAoCorpo($fieldsetConsulta);

        $fieldsetDados = $this->montaFieldsetDados($exercicioModel);
        parent::adicionaAoCorpo($fieldsetDados);
    }

    protected function montaFieldsetDados($exercicioModel) {
        $btnDisabled = null;
        if ($exercicioModel->getExerId() == null) {
            $btnDisabled = "disabled";
        }

        $optionsDosTiposDeTreino = $this->montaOptionsDaConsultaDeTiposDeTreino($exercicioModel);

        $fieldset = "<fieldset><legend>Exercicios</legend>";

        $fieldset .= "
            <div class='formulario'>
                <form id='form' action='' method='POST'>
                    <input type='hidden' name='exerId' value='{$exercicioModel->getExerId()}'>
                    <label>Nome</label><input type='text' id ='nome' name='exerNome' value='{$exercicioModel->getExerNome()}'><br>
                    <label>Descrição</label><textarea rows='4' cols='50' id ='nome' name='exerDescricao'>{$exercicioModel->getExerDescricao()}</textarea><br>   
                    
                        <label>Tipos De Treinos</label>
                            <select id ='tptrId' name='tptrId'>
                                {$optionsDosTiposDeTreino}
                            </select>
                        <br>
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
        $exercicioModel = new ExercicioModel();

        $exercicioModel->setExerId($_POST['exerId']);

        return $exercicioModel;
    }

    public function recebeDados() {
        $exercicioModel = new ExercicioModel();

        $exercicioModel->setExerId($_POST['exerId']);
        $exercicioModel->setExerNome($_POST['exerNome']);
        $exercicioModel->setExerDescricao($_POST['exerDescricao']);
        $exercicioModel->setExerTpTrId($_POST['tptrId']);

        return $exercicioModel;
    }

}

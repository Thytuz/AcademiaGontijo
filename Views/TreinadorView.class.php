<?php

require_once 'InterfaceWeb.class.php';
require_once 'MenusView.class.php';
require_once '../ADOs/TreinadorAdo.class.php';
require_once '../Models/TreinadorModel.class.php';

class TreinadorView extends InterfaceWeb {

    private function montaOptionsDaConsultaDeTreinadores() {
        $treinadorAdo = new TreinadorAdo();
        $buscou = $treinadoresModel = $treinadorAdo->buscaArrayObjetoComPs(array(), 1, "order by trei_nome");
        if ($buscou) {
            //continua
        } else {
            if ($buscou === 0) {
                parent::adicionaEmMensagens("Não encontrou nenhum treinador!");
            } else {
                parent::adicionaEmMensagens("Erro ao buscar treinadores! Contate o analista responsável pelo sistema.");
            }
            $treinadoresModel = array();
        }

        $optionsDosTreinadores = null;
        $optionsDosTreinadores .= "\n\t\t\t<option value='-1'>Escolha um treinador </option>";
        
        foreach ($treinadoresModel as $treinadorModel) {
            $optionsDosTreinadores .= "\n\t\t\t<option value='{$treinadorModel->getTreiId()}'>{$treinadorModel->getTreiNome()}</option>";
        }

        return $optionsDosTreinadores;
    }

    protected function montaFieldsetConsulta() {
        $optionsDosTreinadores = $this->montaOptionsDaConsultaDeTreinadores();

        $fieldset = "<fieldset><legend>Consulta</legend>";

        $fieldset .= "
            <div class='formulario'>
                <form id='form' action='' method='POST'>
                        <label>Treinador</label>
                            <select id ='treiId' name='treiId'>
                                {$optionsDosTreinadores}
                            </select>
                        <br>
                        <p><button name='acao' type='submit' value='con'>Consultar</button></p>
                </form> 
            </div>";

        $fieldset .= "\n</fieldset>";

        return $fieldset;
    }

    protected function montaCorpo($treinadorModel = null) {
        $titulo = "<h3>Cadastro de Treinadores</h3>";

        parent::adicionaAoCorpo($titulo);

        $fieldsetConsulta = $this->montaFieldsetConsulta();
        parent::adicionaAoCorpo($fieldsetConsulta);

        $fieldsetDados = $this->montaFieldsetDados($treinadorModel);
        parent::adicionaAoCorpo($fieldsetDados);
    }

    protected function montaFieldsetDados($treinadorModel) {
        $btnDisabled = null;
        if ($treinadorModel->getTreiId() == null) {
            $btnDisabled = "disabled";
        }

        $checkedMas = null;
        $checkedFem = null;
        if ($treinadorModel->getTreiSexo() == 'M') {
            $checkedMas = "checked";
        } else {
            if ($treinadorModel->getTreiSexo() == 'F') {
                $checkedFem = "checked";
            }
        }

        $fieldset = "<fieldset><legend>Dados do Treinador</legend>";

        $fieldset .= "
            <div class='formulario'>
                <form id='form' action='' method='POST'>
                    <input type='hidden' name='treiId' value='{$treinadorModel->getTreiId()}'>
                    <label>Nome </label><input type='text' id ='nome' name='treiNome' required value='{$treinadorModel->getTreiNome()}'></label><br>
                    <label>Sexo </label>
                    <input type='radio' id ='gen' name='treiSexo' value='M' required {$checkedMas}>Masculino
                    <input type='radio' id ='gen' name='treiSexo' value='F' {$checkedFem}>Feminino<br>
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
        if (isset($_POST['treiId'])) {
            $treinadorModel = new TreinadorModel();

            $treinadorModel->setTreiId($_POST['treiId']);

            return $treinadorModel;
        } else {
            return null;
        }
    }

    public function recebeDados() {
        $treinadorModel = new TreinadorModel();

        $treinadorModel->setTreiId($_POST['treiId']);
        $treinadorModel->setTreiNome($_POST['treiNome']);
        $treinadorModel->setTreiSexo($_POST['treiSexo']);

        return $treinadorModel;
    }

}

?>
<?php

require_once 'InterfaceWeb.class.php';
require_once 'MenusView.class.php';
require_once '../ADOs/AtletaADO.class.php';
require_once '../Models/AtletaModel.class.php';
require_once '../ADOs/TreinadorAdo.class.php';
require_once '../Models/TreinadorModel.class.php';

class AtletaView extends InterfaceWeb {

    private function montaOptionsDaConsultaDeAtletas() {
        $atletaAdo = new AtletaAdo();
        $buscou = $atletasModel = $atletaAdo->buscaArrayObjetoComPs(array(), 1, "order by atle_nome");
        if ($buscou) {
            //continua
        } else {
            if ($buscou === 0) {
                parent::adicionaEmMensagens("Não encontrou nenhum atleta!");
            } else {
                parent::adicionaEmMensagens("Erro ao buscar atletas! Contate o analista responsável pelo sistema.");
            }
            $atletasModel = array();
        }

        $optionsAtletas = null;
        foreach ($atletasModel as $atletaModel) {
            $optionsAtletas .= "\n\t\t\t<option value='{$atletaModel->getAtleId()}'>{$atletaModel->getAtleNome()}</option>";
        }

        return $optionsAtletas;
    }

    protected function montaFieldsetConsulta() {
        $optionsAtletas = $this->montaOptionsDaConsultaDeAtletas();

        $fieldset = "<fieldset><legend>Consulta</legend>";

        $fieldset .= "
            <div class='formulario'>
                <form id='form' action='' method='POST'>
                        <label>Atletas</label>
                            <select id ='atleId' name='atleId'>
                                {$optionsAtletas}
                            </select>
                        <br>
                        <p><button name='acao' type='submit' value='con'>Consultar</button></p>
                </form> 
            </div>";

        $fieldset .= "\n</fieldset>";

        return $fieldset;
    }

    protected function montaCorpo($atletaModel) {
        $titulo = "<h3>Cadastro de Atletas</h3>";
        $menus = new MenusView();
        parent::adicionaAoCorpo($menus->montaMenus());

        parent::adicionaAoCorpo($titulo);

        $fieldsetConsulta = $this->montaFieldsetConsulta();
        parent::adicionaAoCorpo($fieldsetConsulta);

        $fieldsetDados = $this->montaFieldsetDados($atletaModel);
        parent::adicionaAoCorpo($fieldsetDados);
    }

    protected function montaFieldsetDados($atletaModel) {
        $btnDisabled = null;
        if ($atletaModel->getAtleId() == null) {
            $btnDisabled = "disabled";
        }
        $checkedMas = null;
        $checkedFem = null;
        if ($atletaModel->getAtleSexo() == 'M') {
            $checkedMas = "checked";
        } else {
            if ($atletaModel->getAtleSexo() == 'F') {
                $checkedFem = "checked";
            }
        }

        $optionsDosTreinadores = $this->montaOptionsDeTreinadores($atletaModel);

        $fieldset = "<fieldset><legend>Dados do Atleta</legend>";

        $fieldset .= "
            <div class='formulario'>
                <form id='form' action='' method='POST'>
                    <input type='hidden' name='atleId' value='{$atletaModel->getAtleId()}'>
                    <label>Nome </label><input type='text' id ='nome' name='atleNome' value='{$atletaModel->getAtleNome()}'><br>
                    <label>Sexo </label>
                    <input type='radio' id ='gen' name='atleSexo' value='M' {$checkedMas}>Masculino
                    <input type='radio' id ='gen' name='atleSexo' value='F' {$checkedFem}>Feminino<br>
                    <label>CPF </label><input type='text' id='cpf' name='atleCpf' value='{$atletaModel->getAtleCpf()}'><br>
                    <label>Dt Nasc  </label><input type='date' id='data' name='atleDtNasc' value='{$atletaModel->getAtleDtNasc()}'><br>
                    <label>Peso </label><input type='text' placeholder='0.0' id='peso' name='atlePeso' value='{$atletaModel->getAtlePeso()}'><br>
                    <label>Altura </label><input type='text' placeholder='0.0' id='altura' name='atleAltura' value='{$atletaModel->getAtleAltura()}'><br>
                    <label>Observações</label><textarea rows='4' cols='50' id='obs' name='atleObs'>{$atletaModel->getAtleObs()}</textarea><br>
                    <label>Pretenção</label><input type='text' id='pretencao' name='atlePretencao' value='{$atletaModel->getAtlePretencao()}'><br>

                    <label>Treinador</label>
                            <select id ='treiId' name='treiId'>
                                {$optionsDosTreinadores}
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

    private function montaOptionsDeTreinadores($atletaModel) {
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

        $selected = null;
        $optionsDosTreinadores = null;
        foreach ($treinadoresModel as $treinadorModel) {
            if ($treinadorModel->getTreiId() == $atletaModel->getAtleTreiId()) {
                $selected = "selected";
            }
            $optionsDosTreinadores .= "\n\t\t\t<option value='{$treinadorModel->getTreiId()}' $selected>{$treinadorModel->getTreiNome()}</option>";
        }

        return $optionsDosTreinadores;
    }

    public function recebeDados() {
        $atletaModel = new AtletaModel();

        $atletaModel->setAtleId($_POST['atleId']);
        $atletaModel->setAtleNome($_POST['atleNome']);
        $atletaModel->setAtleCpf($_POST['atleCpf']);
        $atletaModel->setAtleDtNasc($_POST['atleDtNasc']);
        $atletaModel->setAtleSexo($_POST['atleSexo']);
        $atletaModel->setAtlePeso($_POST['atlePeso']);
        $atletaModel->setAtleAltura($_POST['atleAltura']);
        $atletaModel->setAtleObs($_POST['atleObs']);
        $atletaModel->setAtlePretencao($_POST['atlePretencao']);
        $atletaModel->setAtleTreiId($_POST['treiId']);

        return $atletaModel;
    }

    public function recebeDadosDaConsulta() {
        if (isset($_POST['atleId'])) {
            $atletaModel = new AtletaModel();

            $atletaModel->setAtleId($_POST['atleId']);

            return $atletaModel;
        } else {
            return null;
        }
    }

}

<?php

require_once 'InterfaceWeb.class.php';
require_once '../ADOs/AtletaADO.class.php';
require_once 'MenusView.class.php';
require_once '../Models/AtletaModel.class.php';
require_once '../ADOs/ExercicioADO.class.php';
require_once '../Models/ExercicioModel.class.php';

class TreinoView extends InterfaceWeb {

    protected function montaCorpo($treinoModel) {
        $titulo = "<h3>Cadastro de Treinos</h3>";

        $menus = new MenusView();
        parent::adicionaAoCorpo($menus->montaMenus());

        parent::adicionaAoCorpo($titulo);

        $fieldsetConsulta = $this->montaFieldsetConsulta();
        parent::adicionaAoCorpo($fieldsetConsulta);

        $fieldsetDados = $this->montaFieldsetDados($treinoModel);
        parent::adicionaAoCorpo($fieldsetDados);
    }

    public function montaFieldsetConsulta() {
        
    }

    public function montaFieldSetDados($treinoModel) {
        $optionsAtletas = $this->montaOptionsAtletas();
        $optionsExercicios = $this->montaOptionsExercicios();
        $optionsSequencia = $this->montaOptionsSequencia();

        $fieldset = "<fieldset><legend>Dados do Treino</legend>";

        $fieldset .= "
            <div class='formulario'>
                <form id='form' action='' method='POST'>
                        <label>Atleta</label>
                            <select id ='atleId' name='atleId'>
                                {$optionsAtletas}
                            </select>
                        <br>
                        
                        <label>Pretenção</label>
                        <input type='text' name='trei_pretencao' id='pretencao' value='{$treinoModel->getTreiPretencao()}'>
                        
                        <fieldset><legend>Treino</legend>
                        
                        <label>Exercicio</label>
                            <select id ='exerId' name='exerId'>
                                {$optionsExercicios}
                            </select>
                        <br>
                        
                        <label>Dia</label>
                            <select id='sequencia' name='trei_sequencia'>
                                {$optionsSequencia}
                            </select>
                        <br>
                        
                        <label>Repetições</label>
                        <input type='text' name='trei_repeticoes' id='repeticoes'>

                        <label>Séries</label>
                        <input type='text' name='trei_series' id='series'>
                        
                        <label>Tempo</label>
                        <input type='text' name='trei_tempo' id='tempo' placeholder='min'>
                        
                        <button name='acao' id='adicionar' value='adc'>Adicionar</button>

                        <table style='width:100%'>
                            <tr>
                                <th>Exercicio</th>
                                <th>Dia</th>
                                <th>Séries</th>
                                <th>Repetições</th>
                                <th>Tempo</th>
                            </tr>
                        </table>
                        
                        <p>
                        <button name='acao' type='submit' value='inc'>Incluir</button>
                        <button name='acao' type='submit' value='alt'>Alterar</button>
                        <button name='acao' type='submit' value='exc'>Excluir</button>
                        <button name='acao' type='submit' value='nov'>Novo</button>
                        </p>
                </form> 
            </div>";


        $fieldset .= "\n</fieldset>";

        return $fieldset;
    }

    public function recebeDados() {
        
    }

    public function recebeDadosDaConsulta() {
        
    }

    public function montaOptionsAtletas() {

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

    public function montaOptionsExercicios() {
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
        foreach ($exercicioModel as $exercicioModel) {
            $optionsDosExercicios .= "\n\t\t\t<option value='{$exercicioModel->getExerId()}'>{$exercicioModel->getExerNome()}</option>";
        }

        return $optionsDosExercicios;
    }

    public function montaOptionsSequencia() {
        $optionsSequencia = "<option value='1'>Segunda-Feira</option>";
        $optionsSequencia .= "<option value='2'>Terça-Feira</option>";
        $optionsSequencia .= "<option value='3'>Quarta-Feira</option>";
        $optionsSequencia .= "<option value='4'>Quinta-Feira</option>";
        $optionsSequencia .= "<option value='5'>Sexta-Feira</option>";
        $optionsSequencia .= "<option value='6'>Sábado</option>";
        $optionsSequencia .= "<option value='7'>Domingo</option>";

        return $optionsSequencia;
    }

}

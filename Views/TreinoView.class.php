<?php

require_once 'InterfaceWeb.class.php';
require_once '../ADOs/AtletaADO.class.php';
require_once 'MenusView.class.php';
require_once '../Models/AtletaModel.class.php';
require_once '../ADOs/ExercicioADO.class.php';
require_once '../Models/ExercicioModel.class.php';
require_once '../ADOs/TipoDeTreinoADO.class.php';
require_once '../Models/TipoDeTreinoModel.class.php';

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
        $optionsTiposDeTreino = $this->montaOptionsTiposDeTreino();

        $fieldset = "<fieldset><legend>Dados do Treino</legend>";

        $fieldset .= "
            <div class='formulario'>
                <form id='form' action='' method='POST'>
                        <label>Atleta</label>
                            <select id ='atleId' name='atleId'>
                                {$optionsAtletas}
                            </select>
                        <br>
                        
                        <label>Sequência</label>
                            <input type='text' id='sequencia' name='tren_seq'>
                        <br>
                        
                        <label>Tipo de Treino</label>
                            <select id ='tptrId' name='tptrId'>
                                {$optionsTiposDeTreino}
                            </select>
                            <script>
                                $('#tptrId').on('change', function (e) {
                                    var optionSelected = $('option:selected', this);
                                    var valueSelected = this.value;
                                    $.ajax({
                                        type:'POST',
                                        tptrId: valueSelected,
                                        sucess
                                    });
                                });
                            </script>
                        <br>
                        
                        <fieldset><legend>Treino</legend>

                        <label>Exercício</label>
                            <select id ='exerId' name='exerId'>
                                {$optionsExercicios}
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
                                <th>Tipo de Treino</th>
                                <th>Exercício</th>
                                <th>Sequência</th>
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

    public function montaOptionsTiposDeTreino() {
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
        foreach ($tiposDeTreinosModel as $tiposDetreinoModel) {
            $optionsDosTiposDeTreino .= "\n\t\t\t<option value='{$tiposDetreinoModel->getTptrId()}'>{$tiposDetreinoModel->getTptrNome()}</option>";
        }

        return $optionsDosTiposDeTreino;
    }

}

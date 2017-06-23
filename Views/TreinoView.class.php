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
        $optionsAtletas = $this->montaOptionsAtletas();

        $fieldset = "<fieldset><legend>Consulta</legend>";
        $fieldset .= "
            <div class='formulario'>
                <form id='form' action='' method='POST'>
                        <label>Atleta</label>
                            <select id ='trenAtleId' name='trenAtleId'>
                                {$optionsAtletas}
                            </select>
                        <br>
                        <p><button name='acao' type='submit' value='con'>Consultar</button></p>
                    </form>
            </div>";
        $fieldset .= "</fieldset>";

        return $fieldset;
    }

    public function montaFieldSetDados($treinoModel = null) {
        $optionsAtletas = $this->montaOptionsAtletas();
        $optionsExercicios = $this->montaOptionsExercicios();
        $optionsTiposDeTreino = $this->montaOptionsTiposDeTreino();

        $fieldset = "
            <fieldset><legend>Treino</legend>
                <div class='formulario'>
                    <form id='form' action='' method='POST'>
                        <label>Atleta</label>
                            <select id ='trenAtleId' name='trenAtleId'>
                                {$optionsAtletas}
                            </select>
                        <br>
                         <label>Sequência</label>
                            <input type='text' id='sequencia' name='trenSeq' required>
                        <br>
                        
                        <label>Tipo de Treino</label>
                            <select id ='trenTptrId' name='trenTptrId'>
                                {$optionsTiposDeTreino}
                            </select>
                            <script>
                                $('#trenTptrId').on('change', function (e) {
                                    var optionSelected = $('option:selected', this);
                                    var valueSelected = this.value;
                                    $.ajax({
                                        type:'POST',
                                        trenTptrId: valueSelected,
                                        sucess
                                    });
                                });
                            </script>
                        <br>
                        
                        <label>Exercício</label>
                            <select id ='exerId' name='exerId'>
                                {$optionsExercicios}
                            </select>
                        <br>
                        
                        <label>Repetições</label>
                        <input type='text' name='tremRepeticao' id='tremRepeticao' value='0'>
                        <br>
                        
                        <label>Séries</label>
                        <input type='text' name='tremSerie' id='tremSerie' value='0'>
                        <br>
                        
                        <label>Tempo</label>
                        <input type='text' name='tremTempo' id='tremTempo' placeholder='min' value='0'>
                        <br>
                        
                        <center><button name='acao' id='adicionar' value='inc'>Adicionar</button></center>";


        if (is_array($treinoModel)) {
            $fieldset .= "<table style='width:100%'>
                            <tr>
                                <th>Tipo de Treino</th>
                                <th>Exercício</th>
                                <th>Sequência</th>
                                <th>Séries</th>
                                <th>Repetições</th>
                                <th>Tempo</th>
                            </tr>";
            foreach ($treinoModel as $treino) {
                $tiposDeTreino = $this->buscaTiposDeTreinoPorTreinoTptrId($treino->getTrenTptrId());
                $treinamento = $this->buscaTreinamentoDoAtleta($treino->getTrenId());
                $exercicio = $this->buscaExerciciosPorTremExerId($treinamento->getTremExerId());
                $fieldset .= " <tr>
                                <td>{$tiposDeTreino->getTptrNome()}</td>
                                <td>{$exercicio->getExerNome()}</td>
                                <td>{$treino->getTrenSeq()}</td>
                                <td>{$treinamento->getTremSerie()}</td>
                                <td>{$treinamento->getTremRepeticao()}</td>
                                <td>{$treinamento->getTremTemp()}</td>
                            </tr>";
            }
            $fieldset .= "   </table>
                </form> 
            </div>
        </fieldset>";
        } else {
            $fieldset .= "</form> 
            </div>
        </fieldset>";
        }

        return $fieldset;
    }

    public function recebeDados() {
        $trenAtleId = $_POST['trenAtleId'];
        $sequencia = $_POST['trenSeq'];
        $tipoDeTreino = $_POST['trenTptrId'];
        $exercicio = $_POST['exerId'];
        $repeticoes = $_POST['tremRepeticao'];
        $series = $_POST['tremSerie'];
        $tempo = $_POST['tremTempo'];

        $stdClass = new stdClass();
        $stdClass->trenAtleId = $trenAtleId;
        $stdClass->trenSeq = $sequencia;
        $stdClass->trenTptrId = $tipoDeTreino;
        $stdClass->exerId = $exercicio;
        $stdClass->tremRepeticao = $repeticoes;
        $stdClass->tremSerie = $series;
        $stdClass->tremTempo = $tempo;

        return $stdClass;
    }

    public function recebeDadosDaConsulta() {
        if (isset($_POST['trenAtleId'])) {
            $treinoModel = new TreinoModel();

            $treinoModel->setTrenAtleId($_POST['trenAtleId']);

            return $treinoModel;
        } else {
            return null;
        }
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

    public function buscaTreinamentoDoAtleta($trenId) {
        $treinamentoAdo = new TreinamentoAdo();
        $where = " trem_tren_id = ?";
        $treinamentoModel = $treinamentoAdo->buscaObjetoComPs(array($trenId), $where);
        return $treinamentoModel;
    }

    public function buscaTiposDeTreinoPorTreinoTptrId($trenTptrId) {
        $tiposDeTreinoAdo = new TiposDeTreinoAdo();
        $where = " tptr_id = ?";
        $tiposDeTreinoModel = $tiposDeTreinoAdo->buscaObjetoComPs(array($trenTptrId), $where);
        return $tiposDeTreinoModel;
    }

    public function buscaExerciciosPorTremExerId($tremExerId) {
        $exercicioAdo = new ExercicioAdo();
        $where = " exer_id = ?";
        $exercicioModel = $exercicioAdo->buscaObjetoComPs(array($tremExerId), $where);
        return $exercicioModel;
    }

}

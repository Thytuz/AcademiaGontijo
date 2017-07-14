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

        parent::adicionaAoCorpo($titulo);

        $fieldsetConsulta = $this->montaFieldsetConsulta();
        parent::adicionaAoCorpo($fieldsetConsulta);

        $fieldsetDados = $this->montaFieldsetDados($treinoModel);
        parent::adicionaAoCorpo($fieldsetDados);
    }

    public function montaFieldsetConsulta() {
        $treinoModel = new TreinoModel();
        $optionsAtletas = $this->montaOptionsAtletas($treinoModel);

        $fieldset = "<fieldset style='width:64%; height:90%; margin-left: 16%;'><legend>Consulta</legend>";
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

    public function montaFieldSetDados($ArrayDeTreinoModel) {
        $optionsAtletas = $this->montaOptionsAtletas();
        $optionsTiposDeTreino = $this->montaOptionsTiposDeTreino();

        $fieldset = "
            <fieldset style='width:64%; height:90%; margin-left: 16%;'><legend>Treino</legend>
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
                            <select id ='trenTptrId' name='trenTptrId' onchange=\"montaOptionsParaCombo('trenTptrId', 'exerId', 'ExercicioADO', 'buscaExerciciosPorTipoDeTreino')\">
                                {$optionsTiposDeTreino}
                            </select>
                        <br>
                        
                        <label>Exercício</label>
                            <select id ='exerId' name='exerId'>
                                <option value='-1'>Escolha um tipo de treino primeiro</option>
                            </select>
                        <br>
                        
                        <label>Repetições</label>
                        <input type='text' name='tremRepeticao' id='tremRepeticao' value='0'>
                        <br>
                        
                        <label>Séries</label>
                        <input type='text' name='tremSerie' id='tremSerie' value='0'>
                        <br>
                        
                        <label>Tempo (min) </label>
                        <input type='text' name='tremTempo' id='tremTempo' placeholder='min' value='0'>
                        <br>
                        
                        <center><button name='acao' id='adicionar' value='inc'>Adicionar</button></center>
                        </form>";

        if (is_array($ArrayDeTreinoModel)) {
            $fieldset .= "<table align='left' style='width:100%'>
                            <tr>
                                <th>Tipo de Treino</th>
                                <th>Exercício</th>
                                <th>Sequência</th>
                                <th>Séries</th>
                                <th>Repetições</th>
                                <th>Tempo</th>
                                <th>Excluir</th>
                            </tr>";
            foreach ($ArrayDeTreinoModel as $treinoModel) {
                $tiposDeTreino = $this->buscaTiposDeTreinoPorTreinoTptrId($treinoModel->getTrenTptrId());
                $ArrayTreinamentoModel = $this->buscaTreinamentoDoAtleta($treinoModel->getTrenId());
                foreach ($ArrayTreinamentoModel as $treinamentoModel) {
                    $exercicio = $this->buscaExerciciosPorTremExerId($treinamentoModel->getTremExerId());
                    $fieldset .= "<tr>
                                <td>{$tiposDeTreino->getTptrNome()}</td>
                                <td>{$exercicio->getExerNome()}</td>
                                <td>{$treinoModel->getTrenSeq()}</td>
                                <td>{$treinamentoModel->getTremSerie()}</td>
                                <td>{$treinamentoModel->getTremRepeticao()}</td>
                                <td>{$treinamentoModel->getTremTemp()}</td>
                                <td>
                                    <form id='formExc' action='' method='POST'>
                                    <input type='hidden' value='{$treinamentoModel->getTremExerId()}' name='exerIdExc' id='exerIdExc'/>
                                    <input type='hidden' value='{$treinamentoModel->getTremTrenId()}' name='trenIdExc' id='trenIdExc'/>
                                    <button name='acao' type='submit' value='exc' style='margin-left:0px;'>Excluir</button>
                                    </form>
                                </td>
                            </tr>";
                }
            }
            $fieldset .= "   </table>
            </div>
        </fieldset>";
        } else {
            $fieldset .= "</div>
        </fieldset>";
        }

        return $fieldset;
    }

    public function recebeDados() {
        $trenAtleId = $_POST['trenAtleId'];
        $sequencia = $_POST['trenSeq'];
        $tipoDeTreino = $_POST['trenTptrId'];
        $exercicio = $_POST['exerId'];
        $_POST['tremRepeticao'] == 0 ? $repeticoes = 0 : $repeticoes = $_POST['tremRepeticao'];
        $_POST['tremSerie'] == 0 ? $series = 0 : $series = $_POST['tremSerie'];
        $_POST['tremTempo'] == 0 ? $tempo = 0 : $tempo = $_POST['tremTempo'];

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

    public function recebeDadosExclusao() {
        $exerId = $_POST['exerIdExc'];
        $trenId = $_POST['trenIdExc'];

        $treinamentoModel = new TreinamentoModel();
        $treinamentoModel->setTremExerId($exerId);
        $treinamentoModel->setTremTrenId($trenId);

        return $treinamentoModel;
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
        $optionsAtletas .= "\n\t\t\t<option value='-1'>Escolha um atleta </option>";
        
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

        $optionsDosTiposDeTreino = "<option value='-1'>Escolha um tipo de treino</option>";
        foreach ($tiposDeTreinosModel as $tiposDetreinoModel) {
            $optionsDosTiposDeTreino .= "\n\t\t\t<option value='{$tiposDetreinoModel->getTptrId()}'>{$tiposDetreinoModel->getTptrNome()}</option>";
        }

        return $optionsDosTiposDeTreino;
    }

    public function buscaTreinamentoDoAtleta($trenId) {
        $treinamentoAdo = new TreinamentoAdo();
        $where = " trem_tren_id = ?";
        $treinamentoModel = $treinamentoAdo->buscaArrayObjetoComPs(array($trenId), $where);
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

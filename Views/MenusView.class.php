<?php

class MenusView {

    public function montaMenus() {
        $html = "<div class='dropdown'>
                    <span>Menu</span>
                    <div class='dropdown-content'>
                        <a href='../Modulos/MantemAtleta.php'>Atletas</a><br>
                        <a href='../Modulos/MantemTreinador.php'>Treinadores</a><br>
                        <a href='../Modulos/MantemTipoDeTreino.php'>Tipos de Treino</a><br>
                        <a href='../Modulos/MantemExercicio.php'>Exercícios</a><br>
                        <a href='../Modulos/MantemTreino.php'>Treinos</a><br>
                        </div>
                    </div> ";
        return $html;
    }

}

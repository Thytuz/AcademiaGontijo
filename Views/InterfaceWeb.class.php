<?php

abstract class InterfaceWeb {

    private $html1 = null;
    private $corpo = null;
    private $html2 = null;
    private $htmlMensagens = null;
    private $mensagens = array();

    public function __construct($titulo) {
        $this->montaHtml1($titulo);
        $this->montaHtml2();
    }

    public function adicionaEmMensagens($mensagens) {
        if (is_array($mensagens)) {
            array_merge($this->mensagens, $mensagens);
        } else {
            $this->mensagens [] = $mensagens;
        }
    }

    private function montaHtmlMensagens() {
        $this->htmlMensagens .= "\n\t<div id='mensagens'>";
        foreach ($this->mensagens as $mensagem) {
            $this->htmlMensagens .= "\n\t\t<p>" . $mensagem . "</p>";
        }
        $this->htmlMensagens .= "\n\t</div>";
    }

    private function montaHtml1($titulo) {
        $this->html1 = "<!DOCTYPE html>\n<html lang='pt-br'>\n\t<head>\n\t\t<meta charset='UTF-8'>\n\t\t<title>{$titulo}</title>
            \n\t\t<link rel='stylesheet' href='../CSS/estilo.css'>\n\t\n
                  <script src='../JS/jquery-3.1.1.js'></script>
                  <script src='../JS/buscaopcoesparacombos.js'></script>
                  <script src='../JS/buscaopcoesparacombo2.js'></script>
            \n\t</head>\n\t<body>\n";
    }

    abstract protected function montaCorpo($objeto);

    public function adicionaAoCorpo($codigo) {
        $this->corpo .= "\n" . $codigo . "\n";
    }

    public function displayInterface($objeto) {
        $this->montaHtmlMensagens();
        $this->montaCorpo($objeto);

        echo $this->html1 . $this->htmlMensagens . $this->corpo . $this->html2;
    }

    private function montaHtml2() {
        $this->html2 = "\n\t</body>\n</html>";
    }

    public function getAcao() {
        if (isset($_POST['acao'])) {
            return $_POST['acao'];
        } else {
            return 'nov';
        }
    }

    abstract public function recebeDadosDaConsulta();

    abstract public function recebeDados();
}

?>
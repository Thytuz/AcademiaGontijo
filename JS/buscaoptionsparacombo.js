/**
 * Este é um Código da Fábrica de Software
 * 
 * Coordenador: Elymar Pereira Cabral
 * 
 * Data: 29/05/2014
 * 
 * Este JS permite montar as opções de combo boxes.
 *
 * @autor Elymar Pereira Cabral
 * @author Tharles de Sousa Andrade
 */

/**
 * 
 * @param {type} idOrigem
 * @param {type} IdDestino
 * @param {type} objeto
 * @param {type} metodo
 * @returns {undefined}
 */
function montaOptionsParaCombo(idOrigem, IdDestino, objeto, metodo) {
    var valueIdOrigem = $("#" + idOrigem).val();

    var dataBuscaOptions = {
        idBusca: valueIdOrigem,
        objeto: objeto,
        metodo: metodo
    };

    $.ajax({
        url: '../ADOs/buscaoptionsparacombo.php',
        type: 'POST',
        cache: false,
        data: dataBuscaOptions,
        datatype: "json",
        error: function (i, texto) {
            alert('Erro ao tentar conectar com banco de dados!');
        },

        success: function (retorno) {

            console.log(retorno);

            var options = JSON.parse(retorno);



            var comboObjeto = $("#" + IdDestino);

            if (comboObjeto === null) {
                alert("Erro no AJAX: elemento não encontrado. Contate o analista responsável.");
                return;
            }

            comboObjeto.empty();

            // Caso o PHP/AJAX retorne vazio, então deve-se montar uma mensagem de
            // aviso para o usuário.
            if (options === 0) {
                var value = "";
                var text = "Não encontrou nenhuma opção.";
                var opcao = new Option(text, value);
                comboObjeto.append(opcao);//Adiciona mais uma option ao combo
                return;
            }

            // Monta a primeira opção padrão do combo
            var value = "";
            var text = "Escolha uma opção abaixo...";
            var opcao = new Option(text, value);
            comboObjeto.append(opcao); //Adiciona mais uma option ao combo
            // Varre o array para montar as opções do combo
            $.each(options, function (i, option) {
                opcao = new Option(option.text, option.value);
                comboObjeto.append(opcao); //Adiciona mais uma option ao combo
            });

        }
    });

}

$(document).ready(function (){
    showLoad("Carregando...");
    loadTable();

});

var dataTable;
function loadTable(){
    var object = {usuario_id: $('#usuario_id').val()};

    sendPostService(
        '../Receiver.php',
        'Diarios', 'listByUser', object,
        function(r){
            loadListTable(null, '#listTable', r.object, 
                function (row, o){
                    row.append($("<td class='aln-center' data-order='" + 
                            o.dt_diario.replace(/-/g, '') + "'>" + 
                            sqlDateToDate(o.dt_diario) + "</td>"));
                    row.append($("<td class='aln-right'>" + o.nivel_max + "</td>"));
                    row.append($("<td class='aln-right'>" + o.pontos_max + "</td>"));
                    row.append($("<td class='aln-right'>" + o.qtd_jogos + "</td>"));
                    row.append($("<td class='aln-center'>" + o.tempo_total + "</td>"));
                    row.append($("<td class='aln-center'>" + o.hr_ultimo_jogo + "</td>"));
                    row.append($("<td class='acertos'>" + o.acertos_adicao + "</td>"));
                    row.append($("<td class='acertos'>" + o.acertos_subtracao + "</td>"));
                    row.append($("<td class='acertos'>" + o.acertos_multiplicacao + "</td>"));
                    row.append($("<td class='acertos'>" + o.acertos_divisao + "</td>"));
                    row.append($("<td class='erros'>" + o.erros_adicao + "</td>"));
                    row.append($("<td class='erros'>" + o.erros_subtracao + "</td>"));
                    row.append($("<td class='erros'>" + o.erros_multiplicacao + "</td>"));
                    row.append($("<td class='erros'>" + o.erros_divisao + "</td>"));
                }
            );

            dataTable = toDataTable('#listTable', {}, [ 0, "desc" ]);

            hideLoad();
        },
        function (){}
    );
}
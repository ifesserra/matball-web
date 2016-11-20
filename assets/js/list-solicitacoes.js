$(document).ready(function (){
    showLoad("Carregando...");
    loadTable();

});

var dataTable;
function loadTable(){
    var object = {usuario_id: $('#usuario_id').val()};

    sendPostService(
        '../Receiver.php',
        'Solicitacoes', 'listByUser', object,
        function(r){
            loadListTable(null, '#listTable', r.object, 
                function (row, o){
                    row.append($("<td class='aln-center text-highlight'>" + o.grupo_nome + "</td>"));

                    row.append($("<td class='aln-center' data-order='" + o.grupo_tipo + "'><i class='fa-2x " + 
                            DESCRIPTIONS.getGroupIcon(parseInt(o.grupo_tipo)) + "'></i></td>"));

                    row.append($("<td class='aln-center'>" + o.administrador_login + "</td>"));

                    row.append($("<td class='aln-center' data-order='" + 
                            o.dt_solicitacao.replace(/-/g, '') + "'>" + 
                            sqlDateToDate(o.dt_solicitacao) + "</td>"));

                    row.append($("<td class='aln-center'><button type='button' " + 
                            "class='btn btn-danger' title='Excluir' delete=" + o.grupo_id + ">" + 
                            "<i class='glyphicon glyphicon-trash'></i></td>"));
                }
            );

            dataTable = toDataTable('#listTable', {orderable: false, "targets": 4}, [ 0, "asc" ]);

            $("[delete]").click(function (){
                confirmDelete($(this).attr('delete'));
                return false;
            });

            hideLoad();
        },
        function (){}
    );
}

function confirmDelete(grupo_id){
    showConfirm("Você confirma excluir essa solicitação?",
            "Sim",  function (){ deleteSolicitacao(grupo_id); },
            "Não", function (){});
}

function deleteSolicitacao(grupo_id){
    showLoad("Excluindo Solicitação...");

    var object = {
        grupo_id: grupo_id, 
        usuario_id: $('#usuario_id').val()
    };

    sendPostService(
        '../Receiver.php',
        'Solicitacoes', 'delete', object,
        function(r){
            hideLoad();
            $("[delete='" + grupo_id + "']").parent().parent().remove();
        },
        function (){}
    );
}
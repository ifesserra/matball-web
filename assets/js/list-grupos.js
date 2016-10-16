$(document).ready(function (){
    showLoad("Carregando...");
    loadTable();

});

var dataTable;
function loadTable(){
    var usuario_id = $('#usuario_id').val();
    var object = {usuario_id: usuario_id};

    sendPostService(
        '../Receiver.php',
        'Grupos', 'listByUser', object,
        function(r){
            loadListTable(null, '#listTable', r.object, 
                function (row, o){
                    row.append($("<td class='aln-center text-highlight'>" + o.grupo_nome + "</td>"));

                    row.append($("<td class='aln-center' data-order='" + o.grupo_tipo + "'><i class='fa-2x " + 
                            DESCRIPTIONS.getGroupIcon(parseInt(o.grupo_tipo)) + "'></i></td>"));

                    var isOwner = (o.administrador_id === usuario_id);
                    row.append($("<td class='aln-center'>" + 
                            (isOwner ? 'Você': o.administrador_login) + 
                            "</td>"));

                    row.append($("<td class='aln-center' data-order='" + 
                            o.dt_criacao.replace(/-/g, '') + "'>" + 
                            sqlDateToDate(o.dt_criacao) + "</td>"));

                    row.append($("<td class='aln-center' data-order='" + 
                            o.dt_entrada.replace(/-/g, '') + "'>" + 
                            sqlDateToDate(o.dt_entrada) + "</td>"));

                    row.append($("<td class='aln-center'>" + 
                            (o.moderador_id !== null || isOwner ? "Sim": "Não") + 
                            "</td>"));

                    row.append($("<td class='aln-center text-highlight'>" + o.grupo_membros + "</td>"));

                    row.append($("<td class='aln-center'><a href='view-grupo?id=" + o.grupo_id + 
                                    "' class='btn btn-primary' title='Visualizar'><i class='glyphicon glyphicon-search'></i>" +
                                "</td>"));
                }
            );

            dataTable = toDataTable('#listTable', {orderable: false, "targets": 7}, [ 0, "asc" ]);

            hideLoad();
        },
        function (){}
    );
}
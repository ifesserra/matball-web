$(document).ready(function (){
    var usuario_id = $('#usuario_id').val();
    var grupo_id = $('#grupo_id').val();
    showLoad("Carregando...");
    loadTbUsers(usuario_id, grupo_id);

});

var dataTableUsers;
function loadTbUsers(usuario_id, grupo_id){
    var object = {usuario_id: usuario_id, grupo_id: grupo_id};
    var posicao = 1;

    sendPostService(
        '../Receiver.php',
        'Grupos', 'listUsersOfGroup', object,
        function(r){
            loadListTable(null, '#tbUsers', r.object, 
                function (row, o){
                    row.append($("<td class='aln-center text-highlight'>" + (posicao++) + "</td>"));

                    row.append($("<td class='aln-center'>" + o.membro_login + "</td>"));

                    row.append($("<td class='aln-center' data-order='" + 
                            o.membro_desde.replace(/-/g, '') + "'>" + 
                            sqlDateToDate(o.membro_desde) + "</td>"));

                    row.append($("<td class='aln-center'>" + o.pontos_max + "</td>"));
                    row.append($("<td class='aln-center' data-order='" + 
                            o.dthr_pontos_max.replace(/-/g, '') + "'>" + 
                            sqlDateToDate(o.dthr_pontos_max) + "</td>"));

                    row.append($("<td class='aln-center'>" + o.nivel_max + "</td>"));
                    row.append($("<td class='aln-center' data-order='" + 
                            o.dthr_nivel_max.replace(/-/g, '') + "'>" + 
                            sqlDateToDate(o.dthr_nivel_max) + "</td>"));

                    row.append($("<td class='aln-center'><a href='view-grupo.php?id=" + o.grupo_id + 
                                    "' class='btn btn-primary' title='Visualizar'><i class='glyphicon glyphicon-search'></i>" +
                                "</td>"));
                }
            );

            dataTableUsers = toDataTable('#tbUsers', {orderable: false, "targets": 7}, [ 0, "asc" ]);

            hideLoad();
        },
        function (){}
    );
}
$(document).ready(function (){
    var usuario_id = $('#usuario_id').val();
    var grupo_id = $('#grupo_id').val();
    showLoad("Carregando...");
    loadTbUsers(usuario_id, grupo_id);
    loadTbRequests(grupo_id);
    hideLoad();
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

                    row.append($("<td class='aln-center'><img class='foto-usuario' src='../../" + 
                            o.membro_foto + "'></td>"));
                    
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

            dataTableUsers = toDataTable('#tbUsers', {orderable: false, "targets": [1,8]}, [ 0, "asc" ]);
        },
        function (){}
    );
}

var dataTableRequests;
function loadTbRequests(grupo_id){
    var object = {grupo_id: grupo_id};

    sendPostService(
        '../Receiver.php',
        'Solicitacoes', 'listByGroup', object,
        function(r){
            loadListTable(null, '#tbRequests', r.object, 
                function (row, o){
                    row.append($("<td class='aln-center'><img class='foto-usuario' src='../../" + 
                            o.foto + "'></td>"));
                    row.append($("<td class='aln-center text-highlight'>" + o.nome + "</td>"));
                    row.append($("<td class='aln-center text-highlight'>" + o.login + "</td>"));

                    row.append($("<td class='aln-center' data-order='" + 
                            o.dt_solicitacao.replace(/-/g, '') + "'>" + 
                            sqlDateToDate(o.dt_solicitacao) + "</td>"));

                    var btnAccept = "<button type='button' " + 
                            "class='btn btn-primary' title='Aceitar' accept=" + o.id + ">" + 
                            '<i class="glyphicon glyphicon-thumbs-up"></i>';
                    
                    var btnReject = "<button type='button' " + 
                            "class='btn btn-danger' title='Rejeitar' reject=" + o.id + ">" + 
                            '<i class="glyphicon glyphicon-thumbs-down"></i>';

                    row.append($("<td class='aln-center nowrap' style='width: 50px;'>" + btnReject + btnAccept + "</td>"));
                }
            );

            dataTableRequests = toDataTable('#tbRequests', {orderable: false, "targets": [0,4]}, [ 2, "asc" ]);
            
            $("[accept]").click(function (){
                confirmActionRequest("Aceitar a solicitação desse usuário?", "accept",
                        $(this).attr('accept'));
                return false;
            });
            
            $("[reject]").click(function (){
                confirmActionRequest("Rejeitar a solicitação desse usuário?", "reject",
                        $(this).attr('reject'));
                return false;
            });

        },
        function (){}
    );
}

function confirmActionRequest(msg, operation, usuario_id){
    showConfirm(msg, "Sim",  
            function (){ 
                sendOperation(operation, 
                    {usuario_id: usuario_id, grupo_id: $('#grupo_id').val()});
            },
            "Não", function (){});
}

function sendOperation(operation, object){
    showLoad("Processando...");

    sendPostService(
        '../Receiver.php',
        'Solicitacoes', operation, object,
        function(r){
            window.location = r.object.link;
        },
        function (){}
    );
}
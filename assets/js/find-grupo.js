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
        'Grupos', 'listAllVisible', object,
        function(r){
            loadListTable(null, '#listTable', r.object, 
                function (row, o){
                    row.append($("<td class='aln-center text-highlight'>" + o.grupo_nome + "</td>"));

                    var tipo = parseInt(o.grupo_tipo);
                    row.append($("<td class='aln-center' data-order='" + tipo + "'><i class='fa-2x " + 
                            DESCRIPTIONS.getGroupIcon(parseInt(o.grupo_tipo)) + "'></i></td>"));

                    var isOwner = (o.administrador_id === usuario_id);
                    row.append($("<td class='aln-center'>" + 
                            (isOwner ? 'Você': o.administrador_login) + 
                            "</td>"));

                    row.append($("<td class='aln-center text-highlight'>" + o.grupo_membros + "</td>"));

                    var htmlAction = "";
                    if(!isOwner){
                        if(tipo === 1){
                            // Privado
                            htmlAction = "<button class='btn btn-warning' group-request='" + o.grupo_id + "'>" +
                                    '<i class="fa fa-paper-plane"></i>' +
                                    " Solicitar entrada</button>";
                        }
                        else{
                            // Público
                            htmlAction = "<button class='btn btn-primary' group-enter='" + o.grupo_id + "'>" +
                                    '<i class="fa fa-sign-in"></i>' +
                                    " Entrar no grupo</button>";
                        }
                    }

                    row.append($("<td class='aln-center' style='width: 100px;'>" + htmlAction + "</td>"));
                }
            );

            dataTable = toDataTable('#listTable', {orderable: false, "targets": 4}, [ 0, "asc" ]);

            $("[group-request]").click(function (){
                confirmRequest($(this).attr('group-request'));
                return false;
            });

            $("[group-enter]").click(function (){
                confirmEnter($(this).attr('group-enter'));
                return false;
            });

            hideLoad();
        },
        function (){}
    );
}

function confirmAction(msg, func, grupo_id){
    showConfirm(msg, "Sim",  
            function (){ 
                func({grupo_id: grupo_id, usuario_id: $('#usuario_id').val()});
            },
            "Não", function (){});
}

function confirmRequest(grupo_id){
    confirmAction("Você confirma a solicitação de entrada no grupo?",
        sendRequest, grupo_id);
}

function sendRequest(object){
    showLoad("Enviando Solicitação...");

    sendPostService(
        '../Receiver.php',
        'Solicitacoes', 'insert', object,
        function(){},
        function(){}
    );
}

function confirmEnter(grupo_id){
    confirmAction("Você confirma a entrada nesse grupo?", 
        sendEnter, grupo_id);
}

function sendEnter(object){
    showLoad("Entrando no Grupo...");

    sendPostService(
        '../Receiver.php',
        'Grupos', 'addMember', object,
        function(){},
        function(){}
    );
}
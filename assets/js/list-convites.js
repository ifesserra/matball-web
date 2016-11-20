$(document).ready(function (){
    showLoad("Carregando...");
    loadTable();

});

var dataTable;
function loadTable(){
    var object = {usuario_id: $('#usuario_id').val()};

    sendPostService(
        '../Receiver.php',
        'Convites', 'listByUser', object,
        function(r){
            loadListTable(null, '#listTable', r.object, 
                function (row, o){
                    row.append($("<td class='aln-center text-highlight'>" + o.grupo_nome + "</td>"));

                    row.append($("<td class='aln-center' data-order='" + o.grupo_tipo + "'><i class='fa-2x " + 
                            DESCRIPTIONS.getGroupIcon(parseInt(o.grupo_tipo)) + "'></i></td>"));

                    row.append($("<td class='aln-center'>" + o.administrador_login + "</td>"));

                    row.append($("<td class='aln-center' data-order='" + 
                            o.dt_convite.replace(/-/g, '') + "'>" + 
                            sqlDateToDate(o.dt_convite) + "</td>"));
                    
                    var btnAccept = "<button type='button' " + 
                            "class='btn btn-primary' title='Aceitar' accept=" + o.grupo_id + ">" + 
                            '<i class="glyphicon glyphicon-thumbs-up"></i>';
                    
                    var btnReject = "<button type='button' " + 
                            "class='btn btn-danger' title='Rejeitar' reject=" + o.grupo_id + ">" + 
                            '<i class="glyphicon glyphicon-thumbs-down"></i>';

                    row.append($("<td class='aln-center nowrap' style='width: 50px;'>" + btnReject + btnAccept + "</td>"));
                }
            );

            dataTable = toDataTable('#listTable', {orderable: false, "targets": 4}, [ 0, "asc" ]);

            $("[accept]").click(function (){
                confirmAction("Aceitar o convite desse grupo?", "accept",
                        $(this).attr('accept'));
                return false;
            });
            
            $("[reject]").click(function (){
                confirmAction("Rejeitar o convite desse grupo?", "reject",
                        $(this).attr('reject'));
                return false;
            });

            hideLoad();
        },
        function (){}
    );
}

function confirmAction(msg, operation, grupo_id){
    showConfirm(msg, "Sim",  
            function (){ 
                sendOperation(operation, 
                    {grupo_id: grupo_id, usuario_id: $('#usuario_id').val()});
            },
            "Não", function (){});
}

function sendOperation(operation, object){
    showLoad("Processando...");

    sendPostService(
        '../Receiver.php',
        'Convites', operation, object,
        function(r){
            hideLoad();
            $("[" + operation + "='" + object.grupo_id + "']").parent().parent().remove();
        },
        function (){}
    );
}

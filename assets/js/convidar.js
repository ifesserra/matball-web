$(document).ready(function (){
    $('#btnBuscar').click(function (){
        buscar();
    });
});

function buscar(){
    showLoad('Buscando usuário...');
    var object = serializeForm('cmp-post');
    sendPostService(
        '../Receiver.php',
        'Usuarios', 'findByLogin', object,
        function (r){
            debugger;
            if(r.cd_message === 0){
                showConfirm("Convidar " + r.object.nome + " para o grupo?",
                "Sim", function (){convidar(object.grupo_id, r.object);}, 
                "Não", function (){});
            }
        },
        function (){}
    );
}

function convidar(grupo_id, user){
    showLoad('Enviando convite...');
    var object = {
        grupo_id: grupo_id,
        usuario_id: user.id
    };
    
    sendPostService(
        '../Receiver.php',
        'Convites', 'insert', object,
        function (r){
            window.location = r.object.link;
        },
        function (){}
    );
}

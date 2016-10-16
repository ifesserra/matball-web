$(window).ready(function(){
    $('form').submit(function (){
        var object = serializeForm('cmp-post');
        submit(object);

        return false;
    });
});

function submit(object){
    showLoad('Criando Grupo...');
    sendPostService(
        '../Receiver.php',
        'Grupos', 'insert', object,
        function (r){
            window.location = r.object.link;
        },
        function (){}
    );
}
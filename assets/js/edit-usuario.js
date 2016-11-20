var base64Img = null;
var uploadCrop;
var selectImg = false;

$(window).ready(function(){
    showLoad("Carregando dados do Usuário...");

    loadCurrentData();

    toDatepicker('.date', true);

    uploadCrop = initCroppie({
        width:130,
        height:130,
        b_width:150,
        b_height:150,
        type:'circle',
        funcOnLoad: function (){
            selectImg = true;
        }
    }, '#divImgPerfil', '#croppie');

    $('form').submit(function (){
        var object = serializeForm('cmp-post');
        object.base64Img = "";

        if(object.senha_nova !== $('#senha_nova2').val()){
            showMessage('As senhas não conferem.', 'danger');
            return false;
        }

        if(selectImg){
            uploadCrop.result({
                 type: 'canvas',
                 size: 'viewport',
                 format: 'png'
             }).then(function(src){
                 object.base64Img = src;
                 submit(object);
             });
        }
        else{
            submit(object);
        }

        return false;
    });
});

function submit(object){
    showLoad('Salvando as alterações...');
    sendPostService(
        '../Receiver.php',
        'Usuarios', 'update', object,
        function (r){
            window.location = r.object.link;
        },
        function (){}
    );
}

function loadCurrentData(){
    var object = {};
    object.id = $('#id').val();

    sendPostService(
        '../Receiver.php',
        'Usuarios', 'findById', object,
        function (r){
            setFormField(r.object);
            hideLoad();
        },
        function (){}
    );
}

function setFormField(o){
    $('#imgPerfil').attr('src', '../../' + o.url_foto);
    $('#nome').val(o.nome);
    $('#dt_nascimento').val(o.dt_nascimento);
    $('#pais').val(o.pais);
    $('#estado').val(o.estado);
    $('#cidade').val(o.cidade);
    $('#escola').val(o.escola);

    if(o.tipo_escola !== ""){
        $('#tipo_escola').selectpicker('val', o.tipo_escola);
    }

    $('#email').val(o.email);
    $('#email').prop('disabled', true);

    $('#login').val(o.login);
    $('#login').prop('disabled', true);
}